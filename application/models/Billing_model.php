<?php

class Billing_model extends CI_Model
{
    
    public function getPaymentPlans() {
        $query = 'SELECT * FROM `plan`'; 
        return $this->db->query($query)->result();
    }
    
    public function getPlans(){
        
        $response = array();
        
        //Select record
        $this->db->select('*');
        $query = $this->db->get('plan');
        $response = $query->result_array();
        
        return $response;
        
    }
    
    //Regresa todos los planes, tiene que discriminar el plan al aque está asociado el usuario
    public function getPlansAvailable($username){
        
        $response = array();
        
        //Select record
        $this->db->select('*');
        $query = $this->db->get('plan');
        $response = $query->result_array();
        
        return $response;
        
    }
    
    public function getUserPlan($user){
        
        $response = array();
        
        
        $query = $this->db->select('*')
        ->from('plan')
        ->join('record_user_plan', 'record_user_plan.id_plan = plan.id')
        ->where('id_user', $user)
        ->where('status', 'a')
        ->get();
        
        $response = $query->result_array();
        
        return $response;        
        
    }
    
    public function insertUserPlan($user, $plan){
        
        $toinsert = array(
            'id_user' => $user,
            'id_plan' => $plan
        );
        
        $this->db->insert('record_user_plan', $toinsert);
        
    }
    

}

