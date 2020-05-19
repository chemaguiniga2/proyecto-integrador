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
    
    
    //Regresa todos los planes, tiene que discriminar el plan al aque est� asociado el usuario
    public function getPlansAvailable($username, $current_plan){
        
        $response = array();
        
        //Select record
        $this->db->select('*');
        //$query = $this->db->get('plan');
        $query = $this->db->get_where('plan', array('id !=' => $current_plan));
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

    public function getUserIDPlan($user){
        
        $response = array();        
        
        $query = $this->db->select('plan.id')
        ->from('plan')
        ->join('record_user_plan', 'record_user_plan.id_plan = plan.id')
        ->where('id_user', $user)
        ->where('status', 'a')
        ->get();
        
        $response = $query->result_array();
        
        return $response;        
        
    }

    public function getCurrentUser(){
        $user = $this->db->select('*')->from('users')->where('id', $this->session->userdata('id'))->get()->row();
        $id = $user->id;
        return $id;
    }

    public function getFeatureCurrentPlan($plan){
        
        $response = array();

        $query = $this->db->select('plan.id, feature.name')
        ->from('plan')
        ->join('plan_feature', 'plan.id = plan_feature.id_plan')
        ->join('feature', 'plan_feature.id_feature = feature.id')        
        ->where('plan.id', $plan)
        ->get();

        $response = $query->result_array();

        return $response;
    }

    public function getSelectedPlan($plan){
        
        $response = array();

        $query = $this->db->select( '*')
        ->from('plan')     
        ->where('plan.id', $plan)
        ->get();

        $response = $query->result_array();

        return $response;
    }

    public function getFeaturePlan(){
        $response = array();

        $query = $this->db->select( 'plan.id, feature.name')
        ->from('feature')
        ->join('plan_feature', 'plan_feature.id_feature = feature.id')
        ->join('plan', 'plan.id = plan_feature.id_plan')
        ->get();

        $response = $query->result_array();

        return $response;
    }

    public function getMonthlyPrice($user){
        $response = array();

        $query = $this->db->select( 'plan.monthly_price, plan.id')
        ->from('plan')
        ->join('record_user_plan', 'record_user_plan.id_plan = plan.id')
        ->join('users', 'users.id = record_user_plan.id_user')
        ->where('users.id', $user)
        ->where('status', 'a')
        ->get();

        $response = $query->result_array();

        return $response;
    }
    
    public function getUserPaymentMethod($user){
        $response = array();
        
        $query = $this->db->select('plan.id')
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

    public function insertRecordUserPlan($user, $id_plan, $pay_freq){
        // update previous status record_user_plan
        $this->Billing_model->updatePrevStatusRUserPlan($user);

        // insert record_user_plan
        $toinsert = array(
            'id_user' => $user,
            'id_plan' => $id_plan,
            'start_date' => date('Y-m-d'),
            'status' => 'a',
            'payment_frequency' => $pay_freq
        );        
        $this->db->insert('record_user_plan', $toinsert);

        $idRecordUserPlan = $this->Billing_model->getActualRecordUserPlan($user, $id_plan);

        // insert payment_user_plan
        $this->Billing_model->insertPaymentUserPlan($idRecordUserPlan);
        
    }

    public function updatePrevStatusRUserPlan($user){
        $toupdate = array(
            'status'=>'i',
            'end_date'=>date('Y-m-d')
          );
        $this->db->where('id_user', $user);
        $this->db->where('status', 'a');
        $this->db->update('record_user_plan', $toupdate);
    }

    public function getActualRecordUserPlan($user, $id_plan){
        $record_u_p = $this->db->select('id')->from('record_user_plan')->where('id_user', $user)->where('id_plan', $id_plan)->where('status', 'a')->get()->row();
        $id = $record_u_p->id;
        return $id;
        
    }

    public function insertPaymentUserPlan($id_record_user_plan){
        $toinsertPayUserPlan = array(
            'id_record_user_plan' => $id_record_user_plan,
            'payment_date' => date('Y-m-d')
        );        
        $this->db->insert('payment_user_plan', $toinsertPayUserPlan);
    }

    
    public function lastPayByUser($id_user){
        $response = array();

        $query = $this->db->select_max('payment_date')
        ->from('payment_user_plan')     
        ->join('record_user_plan', 'record_user_plan.id = payment_user_plan.id_record_user_plan')
        ->where('record_user_plan.id_user', $id_user)
        ->where('record_user_plan.status', 'a')
        ->get();
        $response = $query->result_array();

        return $response;

    }

}

