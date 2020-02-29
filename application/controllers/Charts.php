<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Charts extends CI_Controller {
  
  public function getservices()
	{
    $slist = array();
    $services = $this->db->select('*')->from('services')->where('id_user', $this->session->userdata('id'))->get()->result();

    foreach ($services as $service) {
      $this->db->where('id_service', $service->id);
      $num_rows = $this->db->count_all_results('service_resource');
      array_push($slist, array("id"=>($service->id), "id_service"=>($service->id),"name"=>$service->name, "resources"=>$num_rows));
    }

    if (count($slist) > 0) {
      echo json_encode(array("success"=>true, "services"=>$slist));
    } else {
      echo json_encode(array("success"=>false));
    }
    //echo json_encode($response);
  }
  
    
  public function getresources()
	{
    $rlist = array();
    $query = '
    select count(r.name) as rcount, r.id_type as rtid, t.type as rtype
    from resources r, resource_type t 
    where r.id_type = t.id
    and r.id_user = ' . $this->session->userdata('id') . '
    group by rtid, rtype';
    $resources = $this->db->query($query)->result();
    echo json_encode(array("success"=>true, "resources"=>$resources));
  }
  
  public function getresourcesav() {
    $allresources = array();
    $query = '
    SELECT resources.*, resource_type.type, clouds.name as cloudname FROM `resources`, resource_type, clouds 
    WHERE resources.id_type = resource_type.id
    and resources.id_cloud = clouds.id
    and resources.id_user = ' . $this->session->userdata('id');
    $resources = $this->db->query($query)->result();
    //$awsvm = $this->db->select('*')->from('aws_vm')->where('id_user', $this->session->userdata('id'))->get()->result();
    foreach ($resources as $resource) {
      $av = 100; //rand(40,100);
      $pr = 100; rand(30,150);
      $resserv = $this->db->select('*')->from('service_resource')->where('id_resource', $resource->id)->get()->row();
      $resid = "";
      if ($resserv) {
        $resid = $resserv->id_service;
      } else {
        $resid = 'none';
      }

      array_push($allresources, array('cloud' => $resource->cloudname, 'cloudid' => $resource->id_cloud, 'id' => 'id' . $resource->id, 'service'=>$resid ,'type' => $resource->id_type,'typename' => $resource->type,'name'=>$resource->name, "availability"=> $av));
    }

    echo json_encode(array("success"=>true, "resources"=>$allresources));
  }

  public function getclouds() {
    $clouds = $this->db->select('*')->from('clouds')->get()->result();
    echo json_encode(array("success"=>true, "clouds"=>$clouds));
  }
}
