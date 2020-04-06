<?php

class Billing_model extends CI_Model
{
    
    public function getPaymentPlans() {
        $query = 'SELECT * FROM `plan`'; 
        return $this->db->query($query)->result();
    }
    
    function getPlans(){
        
        $response = array();
        
        //Select record
        $this->db->select('*');
        $query = $this->db->get('plan');
        $response = $query->result_array();
        
        return $response;
    }
    
}

