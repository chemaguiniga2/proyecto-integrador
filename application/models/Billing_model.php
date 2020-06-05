<?php

class Billing_model extends CI_Model
{
    
/************************************     Consultas   **************************************** */


    // Consulta que devuelve todos los planes que se encuentran en la base de datos
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

    // Consulta que devuelve las características del record_user_plan y del plan asociado a un usuario dado
    // y que además tenga un estatus dado en el record_user_plan
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

    // Devuelve el id del usuario que se encuentra actualmente logueado en la aplicación
    public function getCurrentUser(){
        $user = $this->db->select('*')->from('users')->where('id', $this->session->userdata('id'))->get()->row();
        $id = $user->id;
        return $id;
    }
    
    // Devuelve el email de un usuario dado
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
    
    // Devuelve el id_customer_stripe (id del usuario en stripe) de un usuario dado
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

    // *********************** obsoleto, hay que cambiarlo
    // Devuelve las características de un plan
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

    // Devuelve el plan que conincide con el id pasado por parámetros
    public function getSelectedPlan($plan){

        $response = array();

        $query = $this->db->select( '*')
        ->from('plan')
        ->where('plan.id', $plan)
        ->get();

        $response = $query->result_array();

        return $response;
    }

    // ****************** obsolte
    // Devuelve todos los planes con sus características
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

    // Devuelve lo que debe pagar cierto usuario al mes de acuerdo al plan que tiene activado
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
    
    // Devuelve el id del record_user_plan donde cierto usuario está activo o en trial
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
    

    // Devuelve el id del plan asociado al primer record_user_plan creado del usuario
    public function getIdPlanFromRecordUserPlan($id_user){
        
        $query = $this->db->select('id_plan')
        ->from('record_user_plan')
        ->where('id_user', $id_user)
        ->get()
        ->row();
        
        $id = $query->id_plan;
        
        return $id;
        
    }
    
    // Devuelve el id_plan_stripe (id de un plan en stripe) de un plan dado
    public function getIdPlanStripe($id_plan){
        
        $query = $this->db->select('id_plan_stripe')
        ->from('plan')
        ->where('id', $id_plan)
        ->get()
        ->row();
        
        $id = $query->id_plan_stripe;
        
        return $id;
        
    }
    
    
    // Devuelve el id de un record_user_plan que conincida con el id de un usuario y que  tenga cierto status
    public function getIdSubscriptionStripe($id_user, $status){
        
        $query = $this->db->select('id')
        ->from('record_user_plan')
        ->where('id_user', $id_user)
        ->where('status', $status)
        ->get()
        ->row();
        
       if($query){
            $id = $query->id;
            return $id;
        }else{
            return $query;
        }
        
    }

	public function getSubscription($id_user){
        
        $query = $this->db->select('id_subscription')
        ->from('record_user_plan')
        ->where('id_user', $id_user)
        ->get()
        ->row();
        
       if($query){
            $id = $query->id_subscription;
            return $id;
        }else{
            return $query;
        }
        
    }
    
    // Devuelve el id de stripe de un usuario dado
    public function getIdCustomerStripe($id_user){
        
        $query = $this->db->select('id_customer_stripe')
        ->from('users')
        ->where('id', $id_user)
        ->get()
        ->row();
        
        $id = $query->id_customer_stripe;
        
        return $id;
        
    }
    
    // Devuelve el listado de todos los usuarios que se encuentran en la base de datos
    public function listUsers(){
        $response = array();
        
        $query = $this->db->select('*')
        ->from('users')
        ->get();
        $response = $query->result_array();
        //$response['num']= $query->num_rows() ;
        return $response;
    }
    
    
    // Devuelve el listado de todos los usuarios que se encuentran en trial
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
    
    // Devuelve el listado de todos los usuarios que se encuentran activos en un plan
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
    
    // Pensar!!!!
    // Devuelve el listado de todos los usuarios que se encuentran idle (cuando no pagan la mensualidad o anualidad de su plan)
    public function listIdleUsers(){
        $response = array();
        
        $query = $this->db->select('*')
        ->from('users u')
        ->join('record_user_plan r', 'r.id_user = u.id')
        ->where('r.status', 'c')
        ->get();
        $response = $query->result_array();
        //$response['num']= $query->num_rows() ;
        return $response;
    }

    // *************** nos quedamos aquí    
    // Ganancias por plan al mes, 
    public function profitMonthyPerPlan(){
        $response = array();
        
        $query = $this->db->select('p.name, SUM(p.monthly_price) as profitPlanMonthly')
        ->from('plan p')
        ->join('record_user_plan r', 'r.id_plan = p.id')
        ->where('r.status', 'a')
        ->where('r.payment_frequency', 'm')
        ->group_by('p.id')
        ->get();
        $response = $query->result_array();
        
        return $response;
    }
    
    // **************** Si se decidió pagar al año se incluye aquí??
    // Facturación mensual. 
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
    // ******************* no se usa
    // Inserta un record_user_plan
    public function insertUserPlan($user, $plan){

        $toinsert = array(
            'id_user' => $user,
            'id_plan' => $plan
        );

        $this->db->insert('record_user_plan', $toinsert);

    }
    
    // *********************** ¿por que lo inicializa en inactivo?
    // Inserta un recors_user_plan
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

    // Insertar un record_user_plan con un status dado
    public function insertRecordUserPlan($user, $id_plan, $pay_freq, $status){
        // Update previous status record_user_plan a inactivo
        $this->Billing_model->updatePlanToInactive($user);

        // Insert record_user_plan
        $toinsert = array(
            'id_user' => $user,
            'id_plan' => $id_plan,
            'start_date' => date('Y-m-d'),
            'status' => $status,
            'payment_frequency' => $pay_freq
        );
        $this->db->insert('record_user_plan', $toinsert);

        $idRecordUserPlan = $this->Billing_model->getActualRecordUserPlan($user, $id_plan);

        // Insert payment_user_plan
        $this->Billing_model->insertPaymentUserPlan($idRecordUserPlan);

    }

    // Inserta un nuevo paymentUserPlan a un recod_user_plan
    public function insertPaymentUserPlan($id_record_user_plan){
        $toinsertPayUserPlan = array(
            'id_record_user_plan' => $id_record_user_plan,
            'payment_date' => date('Y-m-d')
        );
        $this->db->insert('payment_user_plan', $toinsertPayUserPlan);
    }


    // Devuelve el último pago de un usuario
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
    
    // Inserta un nuevo plan a la base de datos
    public function insertPlan($name, $monthly_price, $annual_price, $allowed_users, $allowed_clouds, $id_plan_stripe){
        $toinsert = array(
            'name' => $name,
            'monthly_price' => $monthly_price,
            'annual_price' => $annual_price,
            'allowed_users' => $allowed_users,
            'allowed_clouds' => $allowed_clouds,
			'id_plan_stripe' => $id_plan_stripe
        );
        $this->db->insert('plan', $toinsert);
    }
    
/************************************     Updates   **************************************** */
    // Actualiza el status de un record user plan con el status pasado
    public function updateRecordUserPlanStatus($id_record_user_plan, $status){        
        $toupdate = array(
            'status'=>$status
        );
        $this->db->where('id', $id_record_user_plan);
        $this->db->update('record_user_plan', $toupdate);
    }
    
    // ***************** hay que refactorizar
    // Actualiza el status de un record_user_plan a trial
    public function updatePlanToTrial($user, $id_plan){
        $toupdate = array(
            'status'=>'t'
        );
        $this->db->where('id_user', $user);
        $this->db->where('id_user', $user);
        $this->db->update('record_user_plan', $toupdate);
    }
    
    // *************** hay que refactorizar
    // Actualiza el status de un record_user_plan a inactivo
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
    
    // ***************** hay que refactorizar
    // Actualiza el status de un record_user_plan a cancelado
    public function updatePlanToCancel($user){
      $toupdate = array(
          'status'=>'c',
          'end_date'=>date('Y-m-d')
        );
      $this->db->where('id_user', $user);
      $this->db->where('status', 'a');
      $this->db->update('record_user_plan', $toupdate);
        
    }

    // ************* no existe id_stripe en record_user_plan
    // Actualiza el id de stripe en record_user_plan
    public function updateIdStripe($user, $id_stripe){
        $toupdate = array(            
            'id_stripe'=>$id_stripe
        );
        $this->db->where('id_user', $user);
        $this->db->where('status', 'a');
        $this->db->update('record_user_plan', $toupdate);
        
    }
    
    // Actualiza el id de stripe en record_user_plan
    public function updateIdSubscription($user, $id_subscription){
        $toupdate = array(
            'id_subscription'=>$id_subscription
        );
        $this->db->where('id_user', $user);
        //$this->db->where('status', 'a');
        $this->db->update('record_user_plan', $toupdate);
        
    }   
    
    // Actualiza en id del cliente en stripe
    public function updateUserIdCusStripe($user, $id_customer){
        $toupdate = array(
            'id_customer_stripe'=>$id_customer
        );
        $this->db->where('id', $user);
        $this->db->update('users', $toupdate);
        
    }


    
    

}
