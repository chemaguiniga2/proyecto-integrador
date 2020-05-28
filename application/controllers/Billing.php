<?php
defined('BASEPATH') or exit('No direct script access allowed');

//require 'vendor/autoload.php';

class Billing extends CI_Controller
{

    public function index()
    {

    }

    public function bill()
    {
        $this->load->model('Billing_model');
        $model['payment_plans'] = $this->Billing_model->getPlans();
        $model['ptitle'] = 'Membership Plan';
        $data['content'] = $this->load->view('dashboard/billing', $model, true);
        $this->load->view('template', $data);
    }

    public function membershipPlans()
    {
        $this->load->model('Billing_model');
        $model['current_user'] = $this->Billing_model->getCurrentUser();
        $user = $this->Billing_model->getCurrentUser();
        $model['current_payment_plan'] = $this->Billing_model->getUserPlan($user);

        $current_plan = $this->Billing_model->getUserIDPlan($user)[0]['id'];
        $model['current_payment_ID_plan'] = $this->Billing_model->getUserIDPlan($current_plan);
        $model['payment_plans'] = $this->Billing_model->getPlans();

        $model['feature_current_plan'] = $this->Billing_model->getFeaturePlan();
        $model['monthly_price_user'] = $this->Billing_model->getMonthlyPrice($user);

        $model['ptitle'] = 'Membership Plan';
        $data['content'] = $this->load->view('dashboard/userPlans', $model, true);
        $this->load->view('template', $data);
    }

    public function accountBilling()
    {
        $this->load->model('Billing_model');
        $model['current_user'] = $this->Billing_model->getCurrentUser();
        $user = $this->Billing_model->getCurrentUser();
        $model['current_payment_plan'] = $this->Billing_model->getUserPlan($user);


        if($model['current_payment_plan'] == NULL){
          $model['current_payment_plan'] = 'empty';
        }
        //$current_plan = $this->Billing_model->getUserIDPlan($user)[0]['id'];
        //$model['current_payment_ID_plan'] = $this->Billing_model->getUserIDPlan($current_plan);
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
        //$model['current_user'] = $this->Billing_model->getCurrentUser();
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
    
    public function genereate

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



    public function chargeTest()
    {
        // echo "holaaaaa";
        \Stripe\Stripe::setApiKey("sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q");
        // $token = $_POST["stripeToken"];


        //Creacion usuario Stripe
        $token = $this->input->post('stripeToken');

        $customer = \Stripe\Customer::create([
            'source' => $token,
            'email' => 'chemaguiniga2@gmail.com',
            //'payment_method' => $intent->'{{PAYMENT_METHOD_ID}}'
        ]);

        // $charge = \Stripe\Charge::create([
        //     "amount" => 1500,
        //     "currency" => "usd",
        //     "description" => "Pago OneCloud",
        //     "source" => $token
        // ]);

        //test charge
        // $charge = \Stripe\Charge::create([
        //     'amount' => 1000,
        //     'currency' => 'usd',
        //     'customer' => $customer->id,
        // ]);

        // YOUR CODE: Save the customer ID and other info in a database for later.

        // When it's time to charge the customer again, retrieve the customer ID.
        // $charge = \Stripe\Charge::create([
        //     'amount' => 1500, // $15.00 this time
        //     'currency' => 'usd',
        //     'customer' => $customer_id, // Previously stored, then retrieved
        // ]);

        echo "<pre>", print_r($customer), "</pre>";
        
        $user = $this->Billing_model->getCurrentUser();
        $id_stripe = 5000;
        $this->Billing_model->insertIdStripe($user, $id_stripe);
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


    public function chargeWithObject()
    {



        $data = array(
            'card_number' => $this->input->post('card_number'),
            'cvv' => $this->input->post('cvv'),
            'exp_month' => $this->input->post('mm'),
            'exp_year' => $this->input->post('aa')
        );


        \Stripe\Stripe::setApiKey("sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q");

        $customer = \Stripe\Customer::create([
            'email' => 'paying.user@example.com',
            ['source' => [
                'object' => 'card',
                'number' => $data['card_number'],
                'exp_month' => $data['exp_month'],
                'exp_year' => $data['exp_year'],
                'cvc' => $data['cvv']
            ]]
            //'payment_method' => $intent->'{{PAYMENT_METHOD_ID}}'
        ]);

        echo "<pre>", print_r($customer), "</pre>";
        //var_dump($customer);


        //exit();

        // \Stripe\Stripe::setApiKey("sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q");

        // $customer_id = 'cus_H8pYi3j5cT50351';

        // $charge = \Stripe\Charge::create([
        //     'amount' => 1500, // $15.00 this time
        //     'currency' => 'usd',
        //     'customer' => $customer_id, // Previously stored, then retrieved
        // ]);

        // echo "<pre>", print_r($charge), "</pre>";

    }


    public function createSubscription()
    {
        \Stripe\Stripe::setApiKey("sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q");

        $subscription = \Stripe\Subscription::create([
            'customer' => 'cus_H9FVh05dW32b7X',
            'items' => [
              [
                'plan' => 'plan_H9EyoXgkZhOa5b',
                'quantity' => 1,
              ],
            ],
        ]);

        $start_date = $subscription['current_period_start'];
        $end_date = $subscription['current_period_end'];
        $status = $subscription['status'];
        // $fecha = new DateTime();
        // $fecha->setTimestamp($subscription['start_date']);
        // echo $fecha->format('U = Y-m-d H:i:s') . "\n";
        //echo "<pre>", print_r($start_date, $end_date, $status), "</pre>";

    }

    public function cancelSubscription(){
        $this->load->model('Billing_model');
        $user = $this->Billing_model->getCurrentUser();

        $this->Billing_model->updatePlanToCancel($user);
        //Todo se copio de la funcion accoutnBilling
        $model['current_payment_plan'] = $this->Billing_model->getUserPlan($user);

        if($model['current_payment_plan']==NULL){
          $model['current_payment_plan'] = 'empty';
        }

        //$current_plan = $this->Billing_model->getUserIDPlan($user)[0]['id'];
        //$model['current_payment_ID_plan'] = $this->Billing_model->getUserIDPlan($current_plan);
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

}
