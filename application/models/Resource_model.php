<?php
class Resource_model extends CI_Model {

  public function getallresources() {
    $query = 'select re.*, cl.name as clname, cl.code as clcode, rg.name as rgname, rg.code as rgcode, ty.type as tyname 
    from `resources` re 
    inner join `clouds` cl
    on re.id_cloud = cl.id
    inner join `regions` rg
    on re.id_region = rg.id
    inner join `resource_type` ty
    on re.id_type = ty.id
    where id_user = ' . $this->session->userdata('id');

    return $this->db->query($query)->result();
  }

  public function getdetails($id) {
    return $this->db->select('*')->from('resources')->where('id', $id)->where('id_user', $this->session->userdata('id'))->get()->row();
  }

  public function updatelistmbeta($user, $account, $region, $cloud, $data) {
    $liveresources = [];
    foreach ($data as $item) {
      $resource = $this->db->select('*')->from('resources')
      ->where('cloud_given_id', $item->vm_id)
      ->where('id_user', $user)
      ->where('id_account', $account)
      ->get()->row();
      $rdetails = json_encode(array('Property1'=>'Property 1', 'Property2'=>'Property 2','Property3'=>'Property 3'));
      $rstatus = $item->status;
      if ($resource) {
        $toupdate = array(
          'details'=>$rdetails,
          'status'=>$rstatus
        );
        $this->db->where('id', $resource->id);
        $this->db->update('resources', $toupdate);
        array_push($liveresources, $resource->id);
      } else {
        $toinsert = array(
          'id_user'=>$user,
          'id_account'=>$account,
          'id_cloud'=>$cloud,
          'id_region'=>$region,
          'id_type'=>1,
          'name'=>$item->vm_name,
          'cloud_given_id'=>$item->vm_id,
          'details'=>$rdetails,
          'status'=>$rstatus
        );
        $this->db->insert('resources', $toinsert);
        array_push($liveresources, $this->db->insert_id());
      }
    }

    $resources = $this->db->select('*')->from('resources')
    ->where('id_user', $user)->where('id_account', $account)
    ->where('id_cloud', $cloud)->where('id_region', $region)->get()->result();

    foreach ($resources as $resource) {
      if (!in_array($resource->id, $liveresources)) {
        $this->db->where('id', $resource->id)->delete('resources');
      }
    }
    
    //$this->db->where_not_in($liveresources)->where('id_user', $user)->where('id_account', $account)->where('id_type', 1);
    //echo $this->db->get_compiled_delete('resources');
    //$this->db->delete('resources');
  }

  public function updates3list($user, $account, $cloud, $list) {
    $liveresources = [];
    foreach ($list as $item) {
      $resource = $this->db->select('*')->from('resources')
      ->where('cloud_given_id', $item->name)
      ->where('id_user', $user)
      ->where('id_account', $account)
      ->get()->row();
      $rdetails = json_encode(array('Property1'=>'Property 1', 'Property2'=>'Property 2','Property3'=>'Property 3'));
      $rstatus = $item->status;
      if ($resource) {
        $toupdate = array(
          'details'=>$rdetails,
          'status'=>$rstatus
        );
        $this->db->where('id', $resource->id);
        $this->db->update('resources', $toupdate);
        array_push($liveresources, $resource->id);
      } else {
        $toinsert = array(
          'id_user'=>$user,
          'id_account'=>$account,
          'id_cloud'=>$cloud,
          'id_region'=>16, //hard c region
          'id_type'=>2,
          'name'=>$item->name,
          'cloud_given_id'=>$item->name,
          'details'=>$rdetails,
          'status'=>$rstatus
        );
        $this->db->insert('resources', $toinsert);
        array_push($liveresources, $this->db->insert_id());
      }
    }

    $resources = $this->db->select('*')->from('resources')
    ->where('id_user', $user)->where('id_account', $account)
    ->where('id_cloud', $cloud)->where('id_region', 16)->get()->result(); //hard c region

    foreach ($resources as $resource) {
      if (!in_array($resource->id, $liveresources)) {
        $this->db->where('id', $resource->id)->delete('resources');
      }
    }
  }

}