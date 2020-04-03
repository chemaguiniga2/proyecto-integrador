<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Billing extends CI_Controller
{
    
    public function index()
    {
        
    }
    
    public function bill()
    {
        $this->load->model('Billing_model');
        $model['resources'] = $this->Billing_model->getResources();
        $model['ptitle'] = 'Billing';
        $data['content'] = $this->load->view('dashboard/billing', $model, true);
        $this->load->view('template', $data);
    }
    
}

