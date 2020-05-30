<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

class Billing extends CI_Controller
// Pedirle a Furby que nos regrese el usuario de stripe
// Igual id suscripción

{

    public function index()
    {}

    public function accountBilling()
    {
        $this->load->model('Billing_model');
        $model['current_user'] = $this->Billing_model->getCurrentUser();
        $user = $this->Billing_model->getCurrentUser();
        $model['current_payment_plan'] = $this->Billing_model->getUserPlan($user);

        if ($model['current_payment_plan'] == NULL) {
            $model['current_payment_plan'] = 'empty';
        }
        // $current_plan = $this->Billing_model->getUserIDPlan($user)[0]['id'];
        // $model['current_payment_ID_plan'] = $this->Billing_model->getUserIDPlan($current_plan);
        $model['payment_plans'] = $this->Billing_model->getPlans();

        $model['feature_current_plan'] = $this->Billing_model->getFeaturePlan();
        $model['monthly_price_user'] = $this->Billing_model->getMonthlyPrice($user);

        $model['last_payment_user'] = $this->Billing_model->lastPayByUser($user);

        $model['ptitle'] = 'Account Billing';
        $model['ptitlePlans'] = 'Membership Plans';
        $model['ptitlePayment'] = 'Payment';
        $model['contentPlans'] = $this->load->view('dashboard/userPlans', $model, true);
        $model['contentPaymentInfo'] = $this->load->view('dashboard/userpaymentinfo', $model, true);

        $data['content'] = $this->load->view('dashboard/accountbilling', $model, true);
        $this->load->view('template', $data);
    }

    public function showPlans()
    {
        $this->load->model('Billing_model');
        $model['payment_plans'] = $this->Billing_model->getPlans();
        $model['feature_current_plan'] = $this->Billing_model->getFeaturePlan();
        $model['ptitle'] = 'Membership Plan';
        $data['content'] = $this->load->view('dashboard/plans', $model, true);
        $this->load->view('dashboard/plans', $data);
    }

    public function addPaymentMethod()
    {
        $this->load->model('Billing_model');
        // $model['current_user'] = $this->Billing_model->getCurrentUser();
        $model['ptitle'] = 'Add Payment Method';
        $data['content'] = $this->load->view('dashboard/paymentForm', $model, true);
        $this->load->view('dashboard/paymentForm', $data);
    }

    public function paymentMethod()
    {
        $this->load->model('Billing_model');
        $model['current_user'] = $this->Billing_model->getCurrentUser();
        $user = $this->Billing_model->getCurrentUser();
        $model['current_payment_method'] = $this->Billing_model->getUserPaymentMethod($user);
        $model['ptitle'] = 'Payment Method';
        $data['content'] = $this->load->view('dashboard/userPaymentMethod', $model, true);
        $this->load->view('template', $data);
    }

    public function paymentMethodRegister()
    {        
        //$user = $this->input->get('id_user');
        $user = 30;
        $this->load->model('Billing_model');
        $user = $this->input->get('id_user');
        $model['ptitle'] = 'Payment Method';
        $data['content'] = $this->load->view('dashboard/userPaymentMethod', $model, true);
        $this->load->view('dashboard/userPaymentMethod', $data);
    }
    
    public function confirmMonthlyPlanChange()
    {
        $this->load->model('Billing_model');
        $model['current_user'] = $this->Billing_model->getCurrentUser();

        $type = "monthly";

        $user = $this->Billing_model->getCurrentUser();

        $id_plan = $this->input->get('id_plan');
        $model['selected_plan'] = $this->Billing_model->getSelectedPlan($id_plan);

        $model['feature_current_plan'] = $this->Billing_model->getFeatureCurrentPlan($id_plan);
        $model['current_payment_method'] = $this->Billing_model->getUserPaymentMethod($user);

        $pay_freq = 'm';
        $this->Billing_model->insertRecordUserPlan($user, $id_plan, $pay_freq);

        $model['type'] = 'Monthly';
        $model['ptitle'] = 'Membership Plan Updated';
        $data['content'] = $this->load->view('dashboard/confirmationPlan', $model, true);
        $this->load->view('template', $data);
    }

    public function confirmAnnualPlanChange()
    {
        $this->load->model('Billing_model');
        $model['current_user'] = $this->Billing_model->getCurrentUser();
        $user = $this->Billing_model->getCurrentUser();

        $id_plan = $this->input->get('id_plan');
        $model['selected_plan'] = $this->Billing_model->getSelectedPlan($id_plan);

        $model['feature_current_plan'] = $this->Billing_model->getFeatureCurrentPlan($id_plan);
        $model['current_payment_method'] = $this->Billing_model->getUserPaymentMethod($user);

        $pay_freq = 'a';
        $this->Billing_model->insertRecordUserPlan($user, $id_plan, $pay_freq);

        $model['type'] = 'Annual';
        $model['ptitle'] = 'Membership Plan Updated';
        $data['content'] = $this->load->view('dashboard/confirmationPlan', $model, true);
        $this->load->view('template', $data);
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

    public function createStripeUser()
    {
        
        $this->load->model('Billing_model');
        $email = 'jarss96@hotmail.com';

        try {

            \Stripe\Stripe::setApiKey("sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q");
            
            
            //Creacion usuario Stripe
            $token = $this->input->post('stripeToken');
            
    
            $customer = \Stripe\Customer::create([
                'source' => $token,
                'email' => $email,
            ]);
            
            
            
            
            //Guardar id stripe en BD
            
            $user = $this->Billing_model->getCurrentUser();
            $id_stripe = $customer['id'];
            $this->Billing_model->updateIdStripe($user, $id_stripe);
            
            //$this->chargeWithObject($id_stripe);
        } catch (Exception $e) {

            //echo "<pre>", print_r($e->getMessage()), "</pre>";
            redirect(base_url() . 'billing/paymentMethod');
        }

        redirect(base_url() . 'billing/accountBilling');
        
        redirect(base_url() . 'billing/registerSuccses?id_customer=' . $customer['id']);
    }
    
    public function registerSuccses(){        
        $email = 'jarss96@hotmail.com';
        $model['email'] = $email;
        $model['customer'] = $this->input->get('id_customer');
        $model['ptitle'] = 'Membership Plan';
        $data['content'] = $this->load->view('dashboard/temp_view', $model, true);
        $this->load->view('dashboard/temp_view', $data);
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
        //     'card_number' => $this->input->post('card_number'),
        //     'cvv' => $this->input->post('cvv'),
        //     'exp_month' => $this->input->post('mm'),
        //     'exp_year' => $this->input->post('aa')
        // );
        
        
        //\Stripe\Stripe::setApiKey("sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q");
        
        // $customer = \Stripe\Customer::create([
        //     'email' => 'paying.user@example.com',
        //     ['source' => [
        //         'object' => 'card',
        //         'number' => $data['card_number'],
        //         'exp_month' => $data['exp_month'],
        //         'exp_year' => $data['exp_year'],
        //         'cvc' => $data['cvv']
        //     ]]
        //     //'payment_method' => $intent->'{{PAYMENT_METHOD_ID}}'
        // ]);
        
        // echo "<pre>", print_r($customer), "</pre>";
        //var_dump($customer);
        
        
        //exit();
        try {
            \Stripe\Stripe::setApiKey("sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q");
            
            $customer_id = $stripe_id;
            
            $charge = \Stripe\Charge::create([
                'amount' => 1000, // $15.00 this time
                'currency' => 'usd',
                'customer' => $customer_id, // Previously stored, then retrieved
            ]);
        } catch (Exception $e) {

            echo "<pre>", print_r($e->getMessage()), "</pre>";
            redirect(base_url() . 'billing/paymentMethod');
        }

        //echo "<pre>", print_r($charge['outcome']['type']), "</pre>";
        echo "<pre>", print_r($charge), "</pre>";

        //Cachar exepcion de error cuando fondos insuficientes

        // exit();

        // \Stripe\Stripe::setApiKey("sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q");

        // $customer_id = 'cus_H8pYi3j5cT50351';

        //authorized1 es el bueno!!

         //If success
        //  redirect(base_url() . 'billing/accountBilling');
        //  //If not success
        //  redirect(base_url() . 'billing/paymentMethod');
         

        
        //echo "<pre>", print_r($charge), "</pre>";
        
    }
    
    
    public function createSubscription()
    {
        
        $this->load->model('Billing_model');
        $id_user = $this->input->get('id_user');
        
		try {
        
			// API KEY
		    \Stripe\Stripe::setApiKey("sk_test_bXdEP17tdmIqySk2H0vMfmrv00plrCFFXb");

		    // $token = $_POST['stripeToken'];
		    $email = $this->Billing_model->getUserEmail($id_user);

		    $data = array(
		        'card_number' => '4242424242424242',
		        'cvv' => '199',
		        'exp_month' => '11',
		        'exp_year' => '20'
		    );

		    $token = \Stripe\Token::create(array(
		        "card" => array(
		            "number" => "4242424242424242",
		            "exp_month" => 1,
		            "exp_year" => 2021,
		            "cvc" => "314"
		        )
		    ));

		    $customer = \Stripe\Customer::create([
		        'email' => $email,
		        'source' => $token
		    ]);
		    $id_customer = $customer['id'];
		    $this->Billing_model->updateUserIdCusStripe($id_user, $id_customer);

		    $id_subscription = \Stripe\Subscription::create([
		        'customer' => $customer['id'], // Pedir id stripe para crear subscripción

		        'items' => [
		            [
		                'plan' => 'plan_H9miMgrIBzzJlV'
		            ]
		        ]
		    ]);
		    $id_subscription = $subscription['id'];
		    $this->Billing_model->updateIdSubscription($id_user, $id_subscription);
		} catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
        
        redirect(base_url() . 'billing/checkmail');

        // $start_date = $subscription['current_period_start'];
        // $end_date = $subscription['current_period_end'];
        // $status = $subscription['status'];
        // $fecha = new DateTime();
        // $fecha->setTimestamp($subscription['start_date']);
        // echo $fecha->format('U = Y-m-d H:i:s') . "\n";
        // echo "<pre>", print_r($start_date, $end_date, $status), "</pre>";
    }

    public function cancelSubscription()
    {

        // cancel subscription

        // Get id subcription, furby nos hará el método
        \Stripe\Stripe::setApiKey('sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q');

        $subscription = \Stripe\Subscription::retrieve('id_bilbi');
        $subscription->delete();

        $this->load->model('Billing_model');
        $user = $this->Billing_model->getCurrentUser();

        $this->Billing_model->updatePlanToCancel($user);
        // Todo se copio de la funcion accoutnBilling
        redirect(base_url() . 'billing/accountBilling');
        
    }

    public function administration()
    {
        $this->load->model('Billing_model');
        $model['ptitle'] = 'Administration';
        $data['content'] = $this->load->view('dashboard/administration', $model, true);
        $this->load->view('template', $data);
      }

      public function pdfReportListUsers(){
        $this->load->model('Billing_model');
        $mpdf = new \Mpdf\Mpdf();
        $query = $this->Billing_model->listUsers();
        $cant = sizeof($query);
        $mpdf->WriteHTML("Amount of users: " . $cant);
        $mpdf->WriteHTML("List of users");
        foreach ($query as $l){
            $mpdf->WriteHTML($l['username']);
        }
        
        $mpdf->Output(); 
    }

    public function pdfReportListUsersInTrial(){
        $this->load->model('Billing_model');
        $mpdf = new \Mpdf\Mpdf();
        $query = $this->Billing_model->listUsersInTrial();
        $cant = sizeof($query);
        $mpdf->WriteHTML("Amount of users in trial: " . $cant);
        $mpdf->WriteHTML("List of users in trial");
        foreach ($query as $l){
            $mpdf->WriteHTML($l['username']);
        }
        
        $mpdf->Output(); 
    }

    public function pdfReportListUsersInPlan(){
        $this->load->model('Billing_model');
        $mpdf = new \Mpdf\Mpdf();
        $query = $this->Billing_model->listUsersInPlan();
        $cant = sizeof($query);
        $mpdf->WriteHTML("Amount of users in plan: " . $cant);
        $mpdf->WriteHTML("List of users in plan");
        foreach ($query as $l){
            $mpdf->WriteHTML($l['username']);
        }
        
        $mpdf->Output(); 
    }

    public function pdfReportListIdleUsers(){

        $this->load->model('Billing_model');
        $mpdf = new \Mpdf\Mpdf();
        $query = $this->Billing_model->listIdleUsers();
        $cant = sizeof($query);
        $mpdf->WriteHTML("Amount of idle users: " . $cant);
        $mpdf->WriteHTML("List of idle users");
        foreach ($query as $l){
            $mpdf->WriteHTML($l['username']);
        }        
        $mpdf->Output(); 
    }

    public function pdfReportProfitPerPlan(){

        $this->load->model('Billing_model');
        $mpdf = new \Mpdf\Mpdf();
        $query = $this->Billing_model->profitPerPlan();
        $mpdf->WriteHTML("Profit per plan");
        $mpdf->WriteHTML("     ");
        foreach ($query as $l){
            //array_push($html, $l['username'])  ;
            $line = $l['name'] . '  ' .$l['profitPlanMonthly'];
            $mpdf->WriteHTML($line);
        }        
        //$mpdf->WriteHTML($html);
        $mpdf->Output(); // opens in browser
    }

    public function pdfReportMonthlyBilling(){
        
        $this->load->model('Billing_model');
        $query = $this->Billing_model->monthlyBilling();
        $mpdf = new \Mpdf\Mpdf();        
        $mpdf->WriteHTML("     ");
        foreach ($query as $l){
            //array_push($html, $l['username'])  ;
            $line = "Monthy billing" . ':' .$l['profitPlanMonthly'];
            $mpdf->WriteHTML($line);
        }        
        //$mpdf->WriteHTML($html);
        $mpdf->Output(); // opens in browser
    }

    public function pdfReportProfitPerPlan2(){
        $this->load->model('Billing_model');
        $text = $this->input->get('text');
        print_r($text);
        //$mpdf->WriteHTML($html);
        $text->Output(); // opens in browser

        /*href="<?php echo base_url() . 'billing/pdfReportProfitPerPlan'?>">Prueba</a>*/
    }
    
}