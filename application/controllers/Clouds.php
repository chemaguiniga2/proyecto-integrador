<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clouds extends CI_Controller {


  public function index()
	{
    
    $this->load->model('account_model');
    $model['accounts'] = $this->account_model->getallaccounts();
    $model['ptitle'] = 'Clouds';
    $data['content'] = $this->load->view('dashboard/clouds', $model, true);
    $this->load->view('template', $data);
    
  }
  
  public function accountwizzard() {
    $model['ptitle'] = 'Clouds';
    $data['content'] = $this->load->view('clouds/accountwizzard', $model, true);
    $this->load->view('template', $data);
  }

  public function addaws() {
    $this->load->model('account_model');
    $model['regions'] = $this->account_model->getregions(1);
    $model['ptitle'] = 'Clouds - Add AWS Account';
    $data['content'] = $this->load->view('dashboard/addaws', $model, true);
    $this->load->view('template', $data);
  }

  public function addazure() {
    $this->load->model('account_model');
    $model['regions'] = $this->account_model->getregions(2);
    $model['ptitle'] = 'Clouds - Add Azure Account';
    $data['content'] = $this->load->view('dashboard/addazure', $model, true);
    $this->load->view('template', $data);
  }

  public function saveazure() {
    $username = $this->input->post('username');
    $password = $this->input->post('cpassword');
    $name = $this->input->post('name');
    $subscriptionid = $this->input->post('subscriptionid');
    $cloud = 2;
    $credentials = json_encode(array(
      'username'=>$username,
      'password'=>$password,
      'subscriptionid'=>$subscriptionid
    ));
    $this->load->model('account_model');
    $this->account_model->saveaccount($cloud, $name, $credentials);
    redirect(base_url() . 'clouds');
  }

  public function saveaws() {
    $keyid = $this->input->post('keyid');
    $keysecret = $this->input->post('ckeysecret');
    $name = $this->input->post('name');
    $cloud = 1;
    $credentials = json_encode(array(
      'keyid'=>$keyid,
      'keysecret'=>$keysecret
    ));
    $this->load->model('account_model');
    $this->account_model->saveaccount($cloud, $name, $credentials);
    redirect(base_url() . 'clouds');
  }

  public function remove() {
    $this->load->model('account_model');
    $this->account_model->removeaccount($this->input->get('id'));
    redirect(base_url() . 'clouds');
  }

  public function resources() {

    $this->load->model('resource_model');
    $model['resources'] = $this->resource_model->getallresources();

    $model['ptitle'] = 'Resources';
    $data['content'] = $this->load->view('dashboard/resources', $model, true);
    $this->load->view('template', $data);
  }

  public function getresourcedetails() {
    $id = $this->input->get('id');
    $this->load->model('resource_model');
    $resource = $this->resource_model->getdetails($id);
    if ($resource) {
      echo json_encode(array('success'=>true, 'details'=>json_decode($resource->details)));
    } else {
      echo json_encode(array('success'=>false));
    }
  }

 
  public function insertazvm() {
    $userid = $this->input->post('id_user');
    $accountid = $this->input->post('id_account');
    $regioncode = $this->input->post('region');
    $data = json_decode($this->input->post('vmdata'), true);
    $cloud = 2;
    $this->load->model('account_model');
    $region = $this->account_model->getregionidbycode($regioncode);
    $this->load->model('resource_model');
    $this->resource_model->updatelistmbeta($userid, $accountid, $region->id, $cloud, $data);

    echo("{'success':true}");

  }


  public function insertawsvm() {
    $userid = $this->input->post('id_user');
    $accountid = $this->input->post('id_account');
    $regioncode = $this->input->post('region');
    $data = json_decode($this->input->post('vmdata'));
    $cloud = 1;
    $this->load->model('account_model');
    $region = $this->account_model->getregionbycode($regioncode);
    $this->load->model('resource_model');
    $this->resource_model->updatelistmbeta($userid, $accountid, $region->id, $cloud, $data);

    echo("{'success':true}");

  }

  public function inserts3() {
    $userid = $this->input->post('id_user');
    $accountid = $this->input->post('id_account');
    $data = json_decode($this->input->post('list'));
    $cloud = 1;
    $this->load->model('account_model');
    //$region = $this->account_model->getregionbycode($regioncode);
    $this->load->model('resource_model');
    $this->resource_model->updates3list($userid, $accountid, $cloud, $data);

    echo("{'success':true}");

  }

  public function newawsvm() {
    $model['vmtype'] = $this->db->select('*')->from('aws_machine_type')->get()->result();
    $model['ptitle'] = 'Add AWS Virtual Machine';
    $data['content'] = $this->load->view('clouds/newawsvm', $model);
    $this->load->view('template', $data);
  }


  public function createresource() {
    if ($this->input->post('cloud') == "AWS") {
      $durl = cloudServiceURL() . "/aws/vm/createvm?userid=" . $this->session->userdata('id');
    } else {
      $durl = cloudServiceURL() . "/azure/vm/createvm?userid=" . $this->session->userdata('id');
    }


    $ac = $this->input->post('acid');
    $vmtype = $this->input->post('type');
    $hdd = $this->input->post('hdd');
    $vmname = urlencode($this->input->post('name'));

    $curlurl = $durl . "&acid=" . $ac . "&vmname=" . $vmname . "&vmtype=" . $vmtype . "&diskz=" . $hdd ;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$curlurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $obj = json_decode($result, true);
    curl_close($ch);
    $deployok = false;
    $pkey = "";

    if ($obj['success']) {
      echo $result;
    } else {
      echo json_encode(array('success'=>false));
    }
  }



  public function getvmprices() {
    $cpu = $this->input->get('cpu');
    $ram = $this->input->get('ram');
    $region = $this->input->get('region');

    $available = $this->db->query('select prices_vm.*, clouds.name from prices_vm, clouds where prices_vm.id_cloud = clouds.id and prices_vm.id_region_group = ' . $region . ' and prices_vm.cpu = ' . $cpu .' and prices_vm.ram = ' . $ram )->result();

    echo json_encode(array('success'=>true, 'vmlist'=>$available));
  }

  public function flushregionvm() {
    $iduser = $this->input->post('id_user');
    $idaccount = $this->input->post('id_account');
    $region = $this->input->post('region');

    $toreturn = array(
      'success' => true
    );
    echo json_encode($toreturn);
    if ($this->input->post('cloud') == "AWS") {
      $this->db->where('id_user', $iduser)->where('location', $region)->where('id_account', $idaccount)->delete('aws_vm');
    } else {
      $this->db->where('id_user', $iduser)->where('location', $region)->where('id_account', $idaccount)->delete('azure_vm');
    }
  }


  public function services() {
    $sresources = [];
    $servicestable = [];
    $services = $this->db->select('*')->from('services')->where('id_user', $this->session->userdata('id'))->get()->result();
    foreach ($services as $service) {
      $query = '
      SELECT sv.id, sv.name, res.name as resourcename, res.cloud_given_id as cloudid, res.id as idresource, res.id_account as accountid, 
      cl.name as cloudname, cl.id as cloudid,
      rt.type as type,
      reg.name as location, reg.code as regcode
  
      FROM `services` sv
      inner join `service_resource` sr 
      on sv.id = sr.id_service
      inner join `resources` res
      on sr.id_resource = res.id
      inner join `regions` reg
      on res.id_region = reg.id
      inner join `clouds` cl
      on res.id_cloud = cl.id
      inner join `resource_type` rt 
      on res.id_type = rt.id
      where sv.id = ' . $service->id;
      $resources = $this->db->query($query)->result();
      $sresources = [];
      foreach ($resources as $resource) {
        $resinfo = array(
          'display' => $resource->type . " " . $resource->resourcename,
          'name' => $resource->resourcename,
          'resid' => $resource->cloudid,
          'id_account' => $resource->accountid,
          'location' => $resource->location,
          'id' => $resource->idresource,
          'cloud' => $resource->cloudname
        );
        array_push($sresources,$resinfo);
      }
      array_push($servicestable, array('id'=> $service->id,'name'=>$service->name,'resources'=>$sresources,'status'=>'OK','manager'=>$service->manager));
    }
   
    $model['servicestable'] = $servicestable;

    $model['ptitle'] = 'Resource Groups';
    $data['content'] = $this->load->view('dashboard/services', $model, true);
    $this->load->view('template', $data);

  }

  public function saveservice() {
    $toinsert = array (
      'name'=>$this->input->post('servicename'),
      'id_user' => $this->session->userdata('id'),
      'description' => $this->input->post('description'),
      'manager' => $this->input->post('manager'),
      'manager_email' => $this->input->post('email'),
      'manager_phone' => $this->input->post('phone')
    );
    if ($this->input->post('prev') != "") {
      $service = $this->db->select('*')->from('services')->where('id', $this->input->post('prev'))->get()->row();
      $this->db->where('id', $service->id);
      $this->db->update('services', $toinsert);
      redirect(base_url() . 'services');
    } else {
      $this->db->insert('services', $toinsert);
      redirect(base_url() . 'services');
    }


  }

  public function createservice() {
    $model['ptitle'] = 'New service';
    $data['content'] = $this->load->view('dashboard/createservice', $model, true);
    $this->load->view('template', $data);
  }

  public function modifyservice() {
    $sid = $this->input->get('sid');
    $service = $this->db->select('*')->from('services')->where('id', $sid)->get()->row();
    if ($service) {
      $model['service'] = $service;
    }
    
    $model['ptitle'] = 'Modify service';
    $data['content'] = $this->load->view('dashboard/createservice', $model, true);
    $this->load->view('template', $data);
  }

  public function getservices() {
    $resid = $this->input->get('resid');
    $services = $this->db->select('*')->from('services')->where('id_user', $this->session->userdata('id'))->get()->result();
    $servicelist = [];
    foreach ($services as $value) {
      
      array_push($servicelist, array('id'=>$value->id,'name'=>$value->name,'member'=>false));
      
    }
    echo (json_encode(array('success'=>true,'servicelist'=>$servicelist)));
  }

  public function setservices() {
    $servicelist = explode("-----",($this->input->get('slist') . ""));
    $resid = $this->input->get('resid');
    $this->db->delete('service_resource', array('id_resource' => $resid));
    if ($servicelist[0] != 'unlink') {
      foreach ($servicelist as $value) {
        $toinsert = array(
          'id_service' => $value,
          'id_resource' => $resid
        );
        $this->db->insert('service_resource', $toinsert);
        $this->insertfeed('Service configuration changed', 'bg-info', 'OMP');
      }
    }
    echo (json_encode(array('success'=>true)));
  }

  
  private function insertfeed($feed, $color, $initials) {
    $this->db->insert('user_feed', array(
    'id_user' => $this->session->userdata('id'),
    'initials'=> $initials,
    'feed'=> $feed,
    'color'=> $color,
    'time'=>time()));
  }


}
