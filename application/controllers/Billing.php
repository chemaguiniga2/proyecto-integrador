<?php
defined('BASEPATH') or exit('No direct script access allowed');


/*
 * Clase Billing
 * Super Clase:
 * CI_Controller (Codeigniter)
 *
 * Funciones (termindas):
 * accountBilling()
 * paymentMethodRegister()
 * confirmMonthlyPlanChange() -> Modular
 * confirmAnnualPlanChange() -> Modular
 * createSubscription()
 * registerSuccses()
 * cancelSubscription()
 *
 * Librerias:
 * Stripe (vendor/autoload.php)
 *
 */

require 'vendor/autoload.php';
require 'vendor/stripe/stripe-php/init.php';



class Billing extends CI_Controller
{

    public function index()
    {}

    /*
     *
     * Funcion accountBilling()
     * Activa la pantalla principal para account billing en donde se puede ver el plan seleccionado
     * con la opci�n de cambiarlo o cancelarlos. A su vez, se puede observar la infomraci�n de pago
     * actual del usario.
     * Se activa por desde el submenu del perfil, con la sesi�n iniciada.
     * Despliga la vista v/d/accountBilling
     *
     */


    public function accountBilling()
    {
        $this->load->model('Billing_model');
        $model['current_user'] = $this->Billing_model->getCurrentUser();
        $user = $this->Billing_model->getCurrentUser();
        $model['current_payment_plan'] = $this->Billing_model->getUserPlanFromStatus($user, 'a');

        if ($model['current_payment_plan'] == NULL) {
            $model['current_payment_plan'] = false;
        }

        $model['current_payment_plan_trial'] = $this->Billing_model->getUserPlanFromStatus($user, 't');
        if ($model['current_payment_plan_trial'] == NULL) {
            $model['current_payment_plan_trial'] = false;
        }

        $model['payment_plans'] = $this->Billing_model->getPlans();

        $model['feature_current_plan'] = $this->Billing_model->getFeaturePlan();
        $model['monthly_price_user'] = $this->Billing_model->getMonthlyPrice($user);

        $model['last_payment_user'] = $this->Billing_model->lastPayByUser($user);       
        
        
        $model['ptitle'] = 'Account Billing';
        $model['ptitlePlans'] = 'Membership Plans';
        $model['contentPlans'] = $this->load->view('dashboard/accountUserPlans', $model, true);
        $model['ptitlePayment'] = 'Payment';
        //$model['last4'] = '4444';
        $model['last4'] = $this->getCustomerPaymentMethod();
        $model['username'] =  $this->Billing_model->getUserName($user);
        $model['contentPaymentInfo'] = $this->load->view('dashboard/accountUserPaymentInfo', $model, true);
        $model['ptitleOptions'] = 'Options';
        $model['contentOptions'] = $this->load->view('dashboard/accountCancelMembership', $model, true);

        $model['mssg'] = isset($_GET['mssg']) ? implode(explode('%20', $_GET['mssg'])) : '' ; 
        //agregarlo a variable, OJO ESTA VARIABLE NO LLEGA A LA VISTA USERPAYMENTINFO.PHP

        $data['content'] = $this->load->view('dashboard/accountBilling', $model, true);
        $this->load->view('template', $data);
    }

    public function getCustomerPaymentMethod() {
        $this->load->model('Billing_model');
        $user = $this->Billing_model->getCurrentUser();
        
        $stripeId = $this->Billing_model->getIdCustomerStripe($user);

        $stripe = new \Stripe\StripeClient('sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q');
        $methods = $stripe->paymentMethods->all([
            'customer' => $stripeId,
            'type' => 'card',
        ]);

        
        return $methods['data'][0]['card']['last4'];

    }

    /*
     *
     * Funcion paymentMethodRegister()
     * Despliega el formulario para introducir los datos de la tarjeta para Stripe
     * Se activa a partir de c/s/register con el id del usuario como parametro
     * Despliega la vista v/d/userPaymentMethod
     *
     */
    public function paymentMethodRegister()
    {
        $user = $this->input->get('id_user');
        // $user = 30;
        $this->load->model('Billing_model');
        $model['id_user'] = $user;
        $model['ptitle'] = 'Payment Method';
        $data['content'] = $this->load->view('registerPaymentMethod', $model, true);
        $this->load->view('registerPaymentMethod', $data);
    }

    public function confirmMonthlyPlanChange()
    {
        $this->load->model('Billing_model');
        $model['current_user'] = $this->Billing_model->getCurrentUser();
        
        $id_user = $this->Billing_model->getCurrentUser();
        
        
        $id_plan = $this->input->get('id_plan');
        $pay_freq = 'm';        

		$model['selected_plan'] = $this->Billing_model->getSelectedPlan($id_plan);
        
		$stripe = new \Stripe\StripeClient(
			'sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q'
        );
        
        try {

            $id_plan_stripe = $model['selected_plan']['0']['id_plan_stripe'];
            $active_sub = $this->Billing_model->getSubscription($id_user, 'a');
            $sub = $stripe->subscriptions->retrieve($active_sub);
            $stripe->subscriptions->update(
                $active_sub, [
                    'cancel_at_period_end' => false,
                    'proration_behavior' => 'create_prorations',
                    'items' => [
                    [
                        'id' => $sub->items->data[0]->id,
                        'plan' => $id_plan_stripe,
                    ],
                ],
            ]);
            $current_subscription = $sub['id'];
            $this->Billing_model->insertRecordUserPlan($id_user, $id_plan, $pay_freq, 'a', $current_subscription);
            $model['selected_plan'] = $this->Billing_model->getSelectedPlan($id_plan);
        
			$model['feature_current_plan'] = $this->Billing_model->getFeatureCurrentPlan($id_plan);
        
			$model['type'] = 'Monthly';
			$model['ptitle'] = 'Membership Plan Updated';
			$data['content'] = $this->load->view('dashboard/accountChangeConfirmationPlan', $model, true);
			$this->load->view('template', $data);
		
		
		}catch (Exception $e) {
            redirect(base_url() . 'billing/accountBilling');
        }

    }

    public function confirmAnnualPlanChange()
    {
        $this->load->model('Billing_model');
        $model['current_user'] = $this->Billing_model->getCurrentUser();
        
        $id_user = $this->Billing_model->getCurrentUser();
        
        $id_plan = $this->input->get('id_plan');
        $pay_freq = 'a';
        
        $model['selected_plan'] = $this->Billing_model->getSelectedPlan($id_plan);
        
        $stripe = new \Stripe\StripeClient(
            'sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q'
            );
        
        try {
            
            $id_plan_stripe = $model['selected_plan']['0']['id_plan_stripe'];
            $active_sub = $this->Billing_model->getSubscription($id_user, 'a');
            $sub = $stripe->subscriptions->retrieve($active_sub);
            $stripe->subscriptions->update(
                $active_sub, [
                    'cancel_at_period_end' => false,
                    'proration_behavior' => 'create_prorations',
                    'items' => [
                        [
                            'id' => $sub->items->data[0]->id,
                            'plan' => $id_plan_stripe,
                        ],
                    ],
                ]);
            $current_subscription = $sub['id'];
            $this->Billing_model->insertRecordUserPlan($id_user, $id_plan, $pay_freq, 'a', $current_subscription);
            $model['selected_plan'] = $this->Billing_model->getSelectedPlan($id_plan);
            
            $model['feature_current_plan'] = $this->Billing_model->getFeatureCurrentPlan($id_plan);
            
            $model['type'] = 'Monthly';
            $model['ptitle'] = 'Membership Plan Updated';
            $data['content'] = $this->load->view('dashboard/accountChangeConfirmationPlan', $model, true);
            $this->load->view('template', $data);
            
            
        }catch (Exception $e) {
            redirect(base_url() . 'billing/accountBilling');
        }
        
    }

    /*
     *
     * Funci�n createSubscription()
     * Crea el customer y la suscirpci�n asociada al plan en Stripe. Funciona �nicamente con el registro
     * ya que trae el �nico record user plan que est� asociado al usairo al momento del registro del
     * usuario. Al finalizar la creaci�n de la subscirpic�n asigna el status de trial al record user plan.
     * Se activa a partir de v/d/userPaymentMethod()
     * Redirige a registerSuccess con el id user de parametro
     *
     */
    public function createCustomerSubscription()
    {
        
        $this->load->model('Billing_model');
        $id_user = $this->input->get('id_user');

        $id_plan = $this->Billing_model->getIdPlanFromRecordUserPlan($id_user);
        $id_plan_stripe = $this->Billing_model->getIdPlanStripe($id_plan);
        $email = $this->Billing_model->getUserEmail($id_user);

		$stripe = new \Stripe\StripeClient(
			'sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q'
		);
        try {
    
            $token = $this->input->post('stripeToken');

            $customer = $stripe->customers->create([
                'source' => $token,
                'email' => $email
            ]);

            $id_customer = $customer['id'];
            $this->Billing_model->updateUserIdCusStripe($id_user, $id_customer);
            $subscription = $stripe->subscriptions->create([
                'customer' => $customer['id'],

                'items' => [
                    [
                        'plan' => $id_plan_stripe,
                    ],
                ],
				'trial_period_days' => 30,
            ]);
            $id_subscription = $subscription['id'];
            $this->Billing_model->updateIdSubscription($id_user, $id_subscription);
            $this->Billing_model->updatePlanToTrial($id_user, $id_plan);
            redirect(base_url() . 'site/checkmail?id_user=' . $id_user);
			
        } catch (Exception $e) {
            echo 'Exception: ', $e->getMessage(), "\n";
        }
    }
        
    public function paymentMethod()
    {
        $this->load->model('Billing_model');
        $model['mssg'] = isset($_GET['mssg']) ? implode(explode('%20', $_GET['mssg'])) : '' ;
        $model['current_user'] = $this->Billing_model->getCurrentUser();
        $user = $this->Billing_model->getCurrentUser();
        $model['ptitle'] = 'Payment Method';
        $data['content'] = $this->load->view('dashboard/accountChangePaymentMethod', $model, true);
        $this->load->view('template', $data);
    }

    /*
     *
     * Funcion cancelSubscritption()
     * Cancela la suscripci�n del usuario con sesi�n iniciada.
     * Se activa con v/d/accountBilling
     * Redirecci�n a definir
     *
     */
    public function cancelSubscription()
    {
        $this->load->model('Billing_model');
        $stripe = new \Stripe\StripeClient('sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q');
        $user = $this->Billing_model->getCurrentUser();
        //$subscription = \Stripe\Subscription::retrieve('id_bilbi');
        $id_subscription_stripe_active = $this->Billing_model->getSubscription($user, 'a');
        $stripe->subscriptions->cancel(
          $id_subscription_stripe_active,
          []
        );       
        

        $this->Billing_model->updatePlanStatusFromActive($user, 'c');

        redirect(base_url() . 'billing/accountBilling');
    }    
    
    public function plansAdministration()
    {        
        $this->load->model('Billing_model');
        $model['payment_plans'] = $this->Billing_model->getPlans();
        $model['ptitle'] = 'Administration';
        $model['contentPlans'] = $this->load->view('dashboard/administrationShowPlans', $model, true);
        $model['contentAddNewPlan'] = $this->load->view('dashboard/administrationAddPlan', $model, true);
        $data['content'] = $this->load->view('dashboard/administrationPlans', $model, true);
        $this->load->view('template', $data);
    }
    
    public function usersAdministration()
    {
        
        $this->load->model('Billing_model');
        $model['ptitle'] = 'Administration';
        $data['content'] = $this->load->view('dashboard/administrationUsers', $model, true);
        $this->load->view('template', $data);
    }
    
    public function listUsers()
    {        
        $this->load->model('Billing_model');
        $model['ptitle'] = 'Administration';
        $model['ptitleList'] = 'All Users';
        $model['list'] = 'csvReportListUsers';
        $titles = array("id","Username","Email","Id Stripe");
        $columns = array("id","username","email","id_customer_stripe");
        $model['tableTitles'] = $titles;
        $model['tableColumns'] = $columns;
        $model['elements'] = $this->Billing_model->listUsers();
        $data['content'] = $this->load->view('dashboard/administrationListMetrics', $model, true);
        $this->load->view('template', $data);     
    }
    
    public function listUsersInTrial()
    {
        $this->load->model('Billing_model');
        $model['ptitle'] = 'Administration';
        $model['ptitleList'] = 'Users in Trial';
        $model['list'] = 'csvReportListUsersInTrial';
        $titles = array("id","Username","Email","Id Stripe");
        $columns = array("id","username","email","id_customer_stripe");
        $model['tableTitles'] = $titles;
        $model['tableColumns'] = $columns;
        $model['elements'] = $this->Billing_model->listUsersInTrial();
        $data['content'] = $this->load->view('dashboard/administrationListMetrics', $model, true);
        $this->load->view('template', $data);
    }
    
    public function listUsersInPlan()
    {
        $this->load->model('Billing_model');
        $model['ptitle'] = 'Administration';
        $model['ptitleList'] = 'Active Users';
        $model['list'] = 'csvReportListUsersInPlan';
        $titles = array("id","Username","Email","Id Stripe");
        $columns = array("id","username","email","id_customer_stripe");
        $model['tableTitles'] = $titles;
        $model['tableColumns'] = $columns;
        $model['elements'] = $this->Billing_model->listUsersInPlan();
        $data['content'] = $this->load->view('dashboard/administrationListMetrics', $model, true);
        $this->load->view('template', $data);
    }
    
    public function listIdleUsers()
    {
        $this->load->model('Billing_model');
        $model['ptitle'] = 'Administration';
        $model['ptitleList'] = 'Idle Users';
        $model['list'] = 'csvReportListIdleUsers';
        $titles = array("id","Username","Email","Id Stripe");
        $columns = array("id","username","email","id_customer_stripe");
        $model['tableTitles'] = $titles;
        $model['tableColumns'] = $columns;
        $model['elements'] = $this->Billing_model->listIdleUsers();
        $data['content'] = $this->load->view('dashboard/administrationListMetrics', $model, true);
        $this->load->view('template', $data);
    }
    
    public function listMonthyProfitPerPlan()
    {
        $this->load->model('Billing_model');
        $model['ptitle'] = 'Administration';
        $model['ptitleList'] = 'Monthly Profit Per Plan';
        $model['list'] = 'csvReportMonthyProfitPerPlan';
        $titles = array('Plan name',  'Monthy profit');
        $columns = array('name','profitPlanMonthly');
        $model['tableTitles'] = $titles;
        $model['tableColumns'] = $columns;
        $model['elements'] = $this->Billing_model->monthyProfitPerPlan();
        $data['content'] = $this->load->view('dashboard/administrationListMetrics', $model, true);
        $this->load->view('template', $data);
    }
    
    public function listAnnualProfitPerPlan()
    {
        $this->load->model('Billing_model');
        $model['ptitle'] = 'Administration';
        $model['ptitleList'] = 'Annual Profit Per Plan';
        $model['list'] = 'csvReportAnnualProfitPerPlan';
        $titles = array('Plan name',  'Annual profit');
        $columns = array('name','profitPlanAnnual');
        $model['tableTitles'] = $titles;
        $model['tableColumns'] = $columns;
        $model['elements'] = $this->Billing_model->annualProfitPerPlan();
        $data['content'] = $this->load->view('dashboard/administrationListMetrics', $model, true);
        $this->load->view('template', $data);
    }
    
    public function listMonthlyBilling()
    {
        $this->load->model('Billing_model');
        $model['ptitle'] = 'Administration';
        $model['ptitleList'] = 'Monthly Billing';
        $model['list'] = 'csvReportMonthlyBilling';
        $titles = array('Monthy billing');
        $columns = array('profitPlanMonthly');
        $model['tableTitles'] = $titles;
        $model['tableColumns'] = $columns;
        $model['elements'] = $this->Billing_model->monthlyBilling();
        $data['content'] = $this->load->view('dashboard/administrationListMetrics', $model, true);
        $this->load->view('template', $data);
    }
    
    public function listAnnualBilling()
    {
        $this->load->model('Billing_model');
        $model['ptitle'] = 'Administration';
        $model['ptitleList'] = 'Annual Billing';
        $model['list'] = 'csvReportAnnualBilling';
        $titles = array('Annual billing');
        $columns = array('profitPlanAnnual');
        $model['tableTitles'] = $titles;
        $model['tableColumns'] = $columns;
        $model['elements'] = $this->Billing_model->annualBilling();
        $data['content'] = $this->load->view('dashboard/administrationListMetrics', $model, true);
        $this->load->view('template', $data);
    }
    
    
    public function addPlan (){
                
        $stripe = new \Stripe\StripeClient(
            'sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q'
            );
        
        $this->load->model('Billing_model');
        $name = $this->input->post('name');
        $monthly_price = $this->input->post('monthly-price');
        $annual_price = $this->input->post('annual-price');
        $allowed_users = $this->input->post('users');
        $allowed_users = $this->input->post('clouds');
        
        
        try {
            $sub = $stripe->plans->create([
                'amount' => $monthly_price,
                'currency' => 'usd',
                'interval' => 'month',
                'product' => [
                    "name" => $name,
                ],
            ]);
            
            
            $this->Billing_model->insertPlan($name, $monthly_price, $annual_price, $allowed_users, $allowed_users, $sub['id']);
            redirect(base_url() . 'billing/plansAdministration');
        }catch (Exception $e) {
            echo "<pre>", print_r($e->getMessage()), "</pre>";
        }
    }

    /**
     * ************************** Metodos no ocupados ******************************
     */

    public function addPaymentMethod()
    {
        $this->load->model('Billing_model');
        // $model['current_user'] = $this->Billing_model->getCurrentUser();
        $model['ptitle'] = 'Add Payment Method';
        $data['content'] = $this->load->view('dashboard/paymentForm', $model, true);
        $this->load->view('dashboard/paymentForm', $data);
    }

    public function createCharge()
    {
        $username = 30;
        $this->load->model('Billing_model');
        // $model['payment_plans'] = $this->Billing_model->getPlansAvailable($username);
        // $model['current_payment_plan'] = $this->Billing_model->getUserPlan($username);
        $model['ptitle'] = 'Membership Plan';
        $data['content'] = $this->load->view('dashboard/createCharge', $model, true);
        $this->load->view('template', $data);
    }

    /**
     * ****************************Stripe no terminado**********************************
     */
    public function updatePaymentMethod()
    {
        $name = $this->input->post('name');
        $number = $this->input->post('card');
        $exp = preg_split("#/#", $this->input->post('expiry-data'));
        $cvc = $this->input->post('cvc');

        $this->load->model('Billing_model');
        $user = $this->Billing_model->getCurrentUser();
        //OBTENER ID DE STRIPE (CUSTOMER)
        $stripeId = $this->Billing_model->getIdCustomerStripe($user);
        
        try {

            $stripe = new \Stripe\StripeClient('sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q');
            $new = $stripe->paymentMethods->create([
                'type' => 'card',
                'card' => [
                    'number' => $number,
                    'exp_month' => $exp[0],
                    'exp_year' => $exp[1],
                    'cvc' => $cvc
                ]
            ]);
            $attach = $stripe->paymentMethods->attach($new['id'], [
                'customer' => $stripeId
            ]);
            
            $upd = $stripe->paymentMethods->update($new['id']);
            //echo "<pre>", print_r($new['card']['last4']), "</pre>"; GUARDAR ULTIMOS 4 DIGITOS
        } catch (Exception $e) {

            redirect(base_url() . 'billing/paymentMethod?mssg='.$e->getMessage());
        }

        redirect(base_url() . 'billing/accountBilling?mssg=Success!');
      
    }
    


    public function createChargeWithObject()
    {
        // $this->load->view('dashboard/createChargeWithObj');
        $username = 30;
        $this->load->model('Billing_model');
        $model['payment_plans'] = $this->Billing_model->getPlansAvailable($username);
        $model['current_payment_plan'] = $this->Billing_model->getUserPlan($username);
        $model['ptitle'] = 'Membership Plan';
        $data['content'] = $this->load->view('dashboard/createChargeWithObj', $model, true);
        $this->load->view('template', $data);
    }

    public function chargeWithObject($stripe_id)
    {

        // $data = array(
        // 'card_number' => $this->input->post('card_number'),
        // 'cvv' => $this->input->post('cvv'),
        // 'exp_month' => $this->input->post('mm'),
        // 'exp_year' => $this->input->post('aa')
        // );

        // \Stripe\Stripe::setApiKey("sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q");

        // $customer = \Stripe\Customer::create([
        // 'email' => 'paying.user@example.com',
        // ['source' => [
        // 'object' => 'card',
        // 'number' => $data['card_number'],
        // 'exp_month' => $data['exp_month'],
        // 'exp_year' => $data['exp_year'],
        // 'cvc' => $data['cvv']
        // ]]
        // //'payment_method' => $intent->'{{PAYMENT_METHOD_ID}}'
        // ]);

        // echo "<pre>", print_r($customer), "</pre>";
        // var_dump($customer);

        // exit();
        try {
            #\Stripe\Stripe::setApiKey("sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q");

            $customer_id = $stripe_id;

            $charge = \Stripe\Charge::create([
                'amount' => 1000, // $15.00 this time
                'currency' => 'usd',
                'customer' => $customer_id // Previously stored, then retrieved
            ]);
        } catch (Exception $e) {

            echo "<pre>", print_r($e->getMessage()), "</pre>";
            redirect(base_url() . 'billing/paymentMethod');
        }

        // echo "<pre>", print_r($charge['outcome']['type']), "</pre>";
        echo "<pre>", print_r($charge), "</pre>";

        // Cachar exepcion de error cuando fondos insuficientes

        // exit();

        // \Stripe\Stripe::setApiKey("sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q");

        // $customer_id = 'cus_H8pYi3j5cT50351';

        // authorized1 es el bueno!!

        // If success
        // redirect(base_url() . 'billing/accountBilling');
        // //If not success
        // redirect(base_url() . 'billing/paymentMethod');

        // echo "<pre>", print_r($charge), "</pre>";
    }

    /**
     * *********************Reportes*****************************************************
     */

    public function pdfReportListUsers()
    {
        $this->load->model('Billing_model');
        $mpdf = new \Mpdf\Mpdf();
        $query = $this->Billing_model->listUsers();
        $cant = sizeof($query);
        $mpdf->WriteHTML("Amount of users: " . $cant);
        $mpdf->WriteHTML("List of users");
        $mpdf->WriteHTML('Id' . ' | ' .'Username' . ' | ' . 'Email' . '    |    ' . 'Id_customer_stripe');
        foreach ($query as $l) {
            $mpdf->WriteHTML($l['id'] . ' | ' . $l['username'] . ' | ' . $l['email'] . ' | ' . $l['id_customer_stripe']);
        }

        $mpdf->Output();
    }

    public function pdfReportListUsersInTrial()
    {
        $this->load->model('Billing_model');
        $mpdf = new \Mpdf\Mpdf();
        $query = $this->Billing_model->listUsersInTrial();
        $cant = sizeof($query);
        $mpdf->WriteHTML("Amount of users in trial: " . $cant);
        $mpdf->WriteHTML("List of users in trial");
        $mpdf->WriteHTML('Id' . ' | ' .'Username' . ' | ' . 'Email' . ' | ' . 'Id_customer_stripe');
        foreach ($query as $l) {
            $mpdf->WriteHTML($l['id'] . ' | ' . $l['username'] . ' | ' . $l['email'] . ' | ' . $l['id_customer_stripe']);
        }

        $mpdf->Output();
    }

    public function pdfReportListUsersInPlan()
    {
        $this->load->model('Billing_model');
        $mpdf = new \Mpdf\Mpdf();
        $query = $this->Billing_model->listUsersInPlan();
        $cant = sizeof($query);
        $mpdf->WriteHTML("Amount of users in plan: " . $cant);
        $mpdf->WriteHTML("List of users in plan");
        foreach ($query as $l) {
            $mpdf->WriteHTML($l['username']);
        }

        $mpdf->Output();
    }

    public function pdfReportListIdleUsers()
    {
        $this->load->model('Billing_model');
        $mpdf = new \Mpdf\Mpdf();
        $query = $this->Billing_model->listIdleUsers();
        $cant = sizeof($query);
        $mpdf->WriteHTML("Amount of idle users: " . $cant);
        $mpdf->WriteHTML("List of idle users");
        foreach ($query as $l) {
            $mpdf->WriteHTML($l['username']);
        }
        $mpdf->Output();
    }

    public function pdfReportMonthyProfitPerPlan()
    {
        $this->load->model('Billing_model');
        $mpdf = new \Mpdf\Mpdf();
        $query = $this->Billing_model->monthyProfitPerPlan();
        $mpdf->WriteHTML("Monthy profit per plan");
        $mpdf->WriteHTML("     ");
        foreach ($query as $l) {
            // array_push($html, $l['username']) ;
            $line = $l['name'] . '  ' . $l['profitPlanMonthly'];
            $mpdf->WriteHTML($line);
        }
        // $mpdf->WriteHTML($html);
        $mpdf->Output(); // opens in browser
    }

    public function pdfReportAnnualProfitPerPlan()
    {
        $this->load->model('Billing_model');
        $mpdf = new \Mpdf\Mpdf();
        $query = $this->Billing_model->annualProfitPerPlan();
        $mpdf->WriteHTML("Annual profit per plan");
        $mpdf->WriteHTML("     ");
        foreach ($query as $l) {
            // array_push($html, $l['username']) ;
            $line = $l['name'] . '  ' . $l['profitPlanAnnual'];
            $mpdf->WriteHTML($line);
        }
        // $mpdf->WriteHTML($html);
        $mpdf->Output(); // opens in browser
    }

    public function pdfReportMonthlyBilling()
    {
        $this->load->model('Billing_model');
        $query = $this->Billing_model->monthlyBilling();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML("     ");
        foreach ($query as $l) {
            // array_push($html, $l['username']) ;
            $line = "Monthy billing" . ':' . $l['profitPlanMonthly'];
            $mpdf->WriteHTML($line);
        }
        // $mpdf->WriteHTML($html);
        $mpdf->Output(); // opens in browser
    }

    public function pdfReportAnnualBilling()
    {
        $this->load->model('Billing_model');
        $query = $this->Billing_model->annualBilling();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML("     ");
        foreach ($query as $l) {
            // array_push($html, $l['username']) ;
            $line = "Monthy billing" . ':' . $l['profitPlanAnnual'];
            $mpdf->WriteHTML($line);
        }
        // $mpdf->WriteHTML($html);
        $mpdf->Output(); // opens in browser
    }

    public function csvReportListUsers()
    {        
         
        $this->load->model('Billing_model');

        // file name 
        $filename = 'users_'.date('Ymd').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
        
        // get data 
        $query = $this->Billing_model->listUsers();

        // file creation 
        $file = fopen('php://output', 'w');
        
        $header = array('Id', 'Username', 'Email', 'Id Stripe'); 
        fputcsv($file, $header);
        foreach ($query as $key=>$line){ 
            fputcsv($file,$line); 
        }
        fclose($file); 
        exit;   
    }

    public function csvReportListUsersInTrial()
    {       
         
        $this->load->model('Billing_model');

        // file name 
        $filename = 'users_in_trial_'.date('Ymd').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
        
        // get data 
        $query = $this->Billing_model->listUsersInTrial();

        // file creation 
        $file = fopen('php://output', 'w');
        
        $header = array('Id', 'Username', 'Email', 'Id Stripe'); 
        fputcsv($file, $header);
        foreach ($query as $key=>$line){ 
            fputcsv($file,$line); 
        }
        fclose($file); 
        exit;  
    }

    public function csvReportListUsersInPlan()
    {        
         
        $this->load->model('Billing_model');

        // file name 
        $filename = 'users_in_plan_'.date('Ymd').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
        
        // get data 
        $query = $this->Billing_model->listUsersInPlan();

        // file creation 
        $file = fopen('php://output', 'w');
        
        $header = array('Id', 'Username', 'Email', 'Id Stripe'); 
        fputcsv($file, $header);
        foreach ($query as $key=>$line){ 
            fputcsv($file,$line); 
        }
        fclose($file); 
        exit;  
    }

    public function csvReportListIdleUsers()
    {        
         
        $this->load->model('Billing_model');

        // file name 
        $filename = 'users_idle_'.date('Ymd').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
        
        // get data 
        $query = $this->Billing_model->listIdleUsers();

        // file creation 
        $file = fopen('php://output', 'w');
        
        $header = array('Id', 'Username', 'Email', 'Id Stripe'); 
        fputcsv($file, $header);
        foreach ($query as $key=>$line){ 
            fputcsv($file,$line); 
        }
        fclose($file); 
        exit;  
    }

    public function csvReportMonthyProfitPerPlan()
    {        
        $this->load->model('Billing_model');

        // file name 
        $filename = 'monthy_profit_plan_'.date('Ymd').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
        
        // get data 
        $query = $this->Billing_model->monthyProfitPerPlan();

        // file creation 
        $file = fopen('php://output', 'w');
        
        $header = array('Plan name',  'Monthy profit'); 
        fputcsv($file, $header);
        foreach ($query as $key=>$line){ 
            fputcsv($file,$line); 
        }
        fclose($file); 
        exit;  
    }

    public function csvReportAnnualProfitPerPlan()
    {        
        $this->load->model('Billing_model');

        // file name 
        $filename = 'annual_profit_plan_'.date('Ymd').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
        
        // get data 
        $query = $this->Billing_model->annualProfitPerPlan();

        // file creation 
        $file = fopen('php://output', 'w');
        
        $header = array('Plan name',  'Annual profit'); 
        fputcsv($file, $header);
        foreach ($query as $key=>$line){ 
            fputcsv($file,$line); 
        }
        fclose($file); 
        exit;  
    }

    public function csvReportMonthlyBilling()
    {        
        $this->load->model('Billing_model');

        // file name 
        $filename = 'monthy_billing_'.date('Ymd').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
        
        // get data 
        $query = $this->Billing_model->monthlyBilling();

        // file creation 
        $file = fopen('php://output', 'w');
        
        $header = array('Monthy billing'); 
        fputcsv($file, $header);
        foreach ($query as $key=>$line){ 
            fputcsv($file,$line); 
        }
        fclose($file); 
        exit;  
    }

    public function csvReportAnnualBilling()
    {        
        $this->load->model('Billing_model');

        // file name 
        $filename = 'annual_billing_'.date('Ymd').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
        
        // get data 
        $query = $this->Billing_model->annualBilling();

        // file creation 
        $file = fopen('php://output', 'w');
        
        $header = array('Annual billing'); 
        fputcsv($file, $header);
        foreach ($query as $key=>$line){ 
            fputcsv($file,$line); 
        }
        fclose($file); 
        exit;  
    }

    // No funcionaaa
    public function pruebaPDF(){
        $this->load->model('Billing_model');
        $this->load->view('dashboard/listMetrics');
        //$model['ptitle'] = $ptitle;

        ////
        $model['ptitle'] = 'Administration';
        $model['ptitleList'] = 'Administration';
        $titles = array("id","Username","Email","Id Stripe");
        $model['tableTitles'] = $titles;
        $model['users'] = $this->Billing_model->listUsersInTrial();
        //$data['content'] = $this->load->view('dashboard/listMetrics', $model, true);
        //$this->load->view('template', $data);
        ////
        
        $html = $this->output->get_output();
        
        //$data['content'] = $this->load->view('dashboard/listMetrics', $model, true);
        // Cargamos la librería
        $this->load->library('pdf');
        // Load HTML content
        $this->dompdf->loadHtml($html);
        // Render the HTML as PDF
        $this->dompdf->render();
        
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("welcome.pdf", array("Attachment"=>0));
        
    }

    
}
