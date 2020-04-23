<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

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
    
    public function billUser()
    {
        $username = 30;
        $this->load->model('Billing_model');
        $model['payment_plans'] = $this->Billing_model->getPlansAvailable($username);
        $model['current_payment_plan'] = $this->Billing_model->getUserPlan($username);
        $model['ptitle'] = 'Membership Plan';
        $data['content'] = $this->load->view('dashboard/billing', $model, true);
        $this->load->view('template', $data);
    }

    public function createCharge() 
    {
        $username = 30;
        $this->load->model('Billing_model');
        $model['payment_plans'] = $this->Billing_model->getPlansAvailable($username);
        $model['current_payment_plan'] = $this->Billing_model->getUserPlan($username);
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
            'email' => 'paying.shelly@example.com',
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

    
    
}

