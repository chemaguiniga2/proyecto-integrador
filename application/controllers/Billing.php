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
        $model['ptitle'] = 'Billing';
        $data['content'] = $this->load->view('dashboard/billing', $model, true);
        $this->load->view('template', $data);
    }

    public function createCharge() 
    {
        $this->load->view('dashboard/createCharge');
    }


    public function chargeTest()
    {
        // echo "holaaaaa";
        \Stripe\Stripe::setApiKey("sk_test_nI9j5uAwf5DtiF6spzejxTsV00wWHeLg9Q");
        $token = $_POST["stripeToken"];

        $charge = \Stripe\Charge::create([
            "amount" => 1500,
            "currency" => "usd",
            "description" => "Pago OneCloud",
            "source" => $token
        ]);

        echo "<pre>", print_r($charge), "</pre>";

    }
    
}

