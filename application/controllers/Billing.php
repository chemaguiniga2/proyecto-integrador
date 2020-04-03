<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Billing extends CI_Controller
{

    public function index()
    {
        $this->load->model('Billing_model');
        $model['accounts'] = $this->account_model->getallaccounts();
        $model['ptitle'] = 'Billing';
        $data['content'] = $this->load->view('dashboard/clouds', $model, true);
        $this->load->view('template', $data);
    }
    
        
    
}

