<?php

class Billing_model extends CI_Model
{
    
/************************************     Consultas   **************************************** */
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


    public function getUserPlanFromStatus($user, $status){

        $response = array();

        $query = $this->db->select('*')
        ->from('plan')
        ->join('record_user_plan', 'record_user_plan.id_plan = plan.id')
        ->where('id_user', $user)
        ->where('status', $status)
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

    public function getCurrentEmail(){
        $user = $this->db->select('*')->from('users')->where('id', $this->session->userdata('id'))->get()->row();
        $email = $user->email;
        return $email;
    }
    
    public function getUserEmail($id_user){
        
        $response = array();
        
        $query = $this->db->select('email')
        ->from('users')
        ->where('id', $id_user)
        ->get()
        ->row();
        
        $email = $query->email;
        return $email;
        
    }
    
    public function getUserIdStripe($id_user){
        
        $response = array();
        
        $query = $this->db->select('id_customer_stripe')
        ->from('users')
        ->where('id', $id_user)
        ->get()
        ->row();
        
        $response = $query->id_customer_stripe;
        return $response;
        
    }

    public function getStripeId(){
        $user = $this->db->select('*')->from('users')->where('id', $this->session->userdata('id'))->get()->row();
        $id_stripe = $user->id_stripe;
        return $id_stripe;
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
    
    public function getActualRecordUserPlan($user, $id_plan){
        $record_u_p = $this->db->select('id')
        ->from('record_user_plan')
        ->where('id_user', $user)
        ->where('id_plan', $id_plan)
        ->group_start()
        ->where('status', 'a')
        ->or_where('status', 't')
        ->group_end()
        ->get()->row();
        
        $id = $record_u_p->id;
        return $id;
        
    }
    
    public function getIdPlanFromRecordUserPlan($id_user){
        
        $query = $this->db->select('id_plan')
        ->from('record_user_plan')
        ->where('id_user', $id_user)
        ->get()
        ->row();
        
        $id = $query->id_plan;
        
        return $id;
        
    }
    
    public function getIdPlanStripe($id_plan){
        
        $query = $this->db->select('id_plan_stripe')
        ->from('plan')
        ->where('id', $id_plan)
        ->get()
        ->row();
        
        $id = $query->id_plan_stripe;
        
        return $id;
        
    }
    
    //Cambiar por id scubscription cunado este el cambio de plan
    public function getTrialIdSubscriptionStripe($id_user){
        
        $query = $this->db->select('id')
        ->from('record_user_plan')
        ->where('id_user', $id_user)
        ->where('status', 't')
        ->get()
        ->row();
        if($query){
            $id = $query->id;            
            return $id;
        }else{
           return $query;
        }
        
    }
    
    public function getIdSubscriptionStripe($id_user){
        
        $query = $this->db->select('id')
        ->from('record_user_plan')
        ->where('id_user', $id_user)
        ->where('status', 'a')
        ->get()
        ->row();
        
       if($query){
            $id = $query->id;
            return $id;
        }else{
            return $query;
        }
        
    }
    
    public function getIdCustomerStripe($id_user){
        
        $query = $this->db->select('id_customer_stripe')
        ->from('users')
        ->where('id', $id_user)
        ->get()
        ->row();
        
        $id = $query->id_customer_stripe;
        
        return $id;
        
    }
    
    public function listUsers(){
        $response = array();
        
        $query = $this->db->select('*')
        ->from('users')
        ->get();
        $response = $query->result_array();
        //$response['num']= $query->num_rows() ;
        return $response;
    }
    
    
    
    public function listUsersInTrial(){
        $response = array();
        
        $query = $this->db->select('*')
        ->from('users u')
        ->join('record_user_plan r', 'r.id_user = u.id')
        ->where('r.status', 't')
        ->get();
        $response = $query->result_array();
        //$response['num']= $query->num_rows() ;
        return $response;
    }
    
    public function listUsersInPlan(){
        $response = array();
        
        $query = $this->db->select('u.*')
        ->from('users u')
        ->join('record_user_plan r', 'r.id_user = u.id')
        ->join('plan p', 'r.id_plan = p.id')
        ->where('r.status', 'a')
        ->get();
        $response = $query->result_array();
        
        return $response;
    }
    
    public function listIdleUsers(){
        $response = array();
        
        $query = $this->db->select('*')
        ->from('users u')
        ->join('record_user_plan r', 'r.id_user = u.id')
        ->where('r.status', 'd')
        ->get();
        $response = $query->result_array();
        //$response['num']= $query->num_rows() ;
        return $response;
    }
    
    // Ganancias por plan al mes
    public function profitPerPlan(){
        $response = array();
        
        $query = $this->db->select('p.name, SUM(p.monthly_price) as profitPlanMonthly')
        ->from('plan p')
        ->join('record_user_plan r', 'r.id_plan = p.id')
        ->where('r.status', 'a')
        ->group_by('p.id')
        ->get();
        $response = $query->result_array();
        
        return $response;
    }
    
    // facturación mensual. Si se decidió pagar al año se incluye aquí??
    public function monthlyBilling(){
        $response = array();
        
        $query = $this->db->select('SUM(p.monthly_price) as profitPlanMonthly')
        ->from('plan p')
        ->join('record_user_plan r', 'r.id_plan = p.id')
        ->where('r.status', 'a')
        ->get();
        $response = $query->result_array();
        
        return $response;
    }
    
    

 /************************************     Inserts   **************************************** */
    
    public function insertUserPlan($user, $plan){

        $toinsert = array(
            'id_user' => $user,
            'id_plan' => $plan
        );

        $this->db->insert('record_user_plan', $toinsert);

    }
    
    public function insertFirstRecordUserPlan($user, $plan, $pay_freq){
        
        $toinsert = array(
            'id_user' => $user,
            'id_plan' => $plan,
            'start_date' => date('Y-m-d'),
            'status' => 'i',
            'payment_frequency' => $pay_freq
        );
        
        $this->db->insert('record_user_plan', $toinsert);
        
    }

    public function insertRecordUserPlan($user, $id_plan, $pay_freq, $status){
        // update previous status record_user_plan
        $this->Billing_model->updatePlanToInactive($user);

        // insert record_user_plan
        $toinsert = array(
            'id_user' => $user,
            'id_plan' => $id_plan,
            'start_date' => date('Y-m-d'),
            'status' => $status,
            'payment_frequency' => $pay_freq
        );
        $this->db->insert('record_user_plan', $toinsert);

        $idRecordUserPlan = $this->Billing_model->getActualRecordUserPlan($user, $id_plan);

        // insert payment_user_plan
        $this->Billing_model->insertPaymentUserPlan($idRecordUserPlan);

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
    
    public function insertPlan($name, $monthly_price, $annual_price, $allowed_users, $allowed_clouds){
        $toinsert = array(
            'name' => $name,
            'monthly_price' => $monthly_price,
            'annual_price' => $annual_price,
            'allowed_users' => $allowed_users,
            'allowed_clouds' => $allowed_clouds
        );
        $this->db->insert('plan', $toinsert);
    }
    
/************************************     Updates   **************************************** */
    
    public function updateRecordUserPlanStatus($id_record_user_plan, $status){        
        $toupdate = array(
            'status'=>$status
        );
        $this->db->where('id', $id_record_user_plan);
        $this->db->update('record_user_plan', $toupdate);
    }
    
    public function updatePlanToTrial($user, $id_plan){
        $toupdate = array(
            'status'=>'t'
        );
        $this->db->where('id_user', $user);
        $this->db->where('id_user', $user);
        $this->db->update('record_user_plan', $toupdate);
    }
    
    public function updatePlanToInactive($user){
        $toupdate = array(
            'status'=>'i',
            'end_date'=>date('Y-m-d')
        );
        $this->db->where('id_user', $user);
        $this->db->where('status', 'a');
        $this->db->or_where('status', 't');
        $this->db->update('record_user_plan', $toupdate);
    }
    

    public function updatePlanToCancel($user){
      $toupdate = array(
          'status'=>'c',
          'end_date'=>date('Y-m-d')
        );
      $this->db->where('id_user', $user);
      $this->db->where('status', 'a');
      $this->db->update('record_user_plan', $toupdate);
        
    }
    
    public function updateIdStripe($user, $id_stripe){
        $toupdate = array(            
            'id_stripe'=>$id_stripe
        );
        $this->db->where('id_user', $user);
        $this->db->where('status', 'a');
        $this->db->update('record_user_plan', $toupdate);
        
    }
    
    public function updateIdSubscription($user, $id_subscription){
        $toupdate = array(
            'id_subscription'=>$id_subscription
        );
        $this->db->where('id_user', $user);
        $this->db->where('status', 'a');
        $this->db->update('record_user_plan', $toupdate);
        
    }   
    
    public function updateUserIdCusStripe($user, $id_customer){
        $toupdate = array(
            'id_customer_stripe'=>$id_customer
        );
        $this->db->where('id', $user);
        $this->db->update('users', $toupdate);
        
    }


    
    

}
