<?php
class Account_model extends CI_Model {

  public function getallaccounts() {
    $query = "SELECT a.id, a.id_cloud, a.name, b.code, b.logo FROM accounts a INNER JOIN clouds b ON a.id_cloud = b.id where a.id_user = " . $this->session->userdata('id');
    return $this->db->query($query)->result();
  }

  public function saveaccount($cloud, $name, $credentials) {
    $toinsert = array(
      'id_cloud' => $cloud,
      'id_user' => $this->session->userdata('id'),
      'credentials' => $credentials,
      'name' => $name
    );
    $this->db->insert('accounts', $toinsert);
  }

  public function removeaccount($accountid) {
    $this->db->delete('accounts', array('id' => ($accountid), 'id_user' => $this->session->userdata('id')));
    $query = "select service_resource.id from service_resource, resources where resources.id = service_resource.id_resource";
    $active = $this->db->query($query)->result();
    $todelete = "";
    foreach ($active as $value) {
      $todelete .= '' . $value->id . ',';
    }
    $todelete .= '0';
    $query = "delete from service_resource where id not in (" . $todelete . ")";
    $this->db->query($query);
    $this->db->delete('resources', array('id_account' => ($accountid), 'id_user' => $this->session->userdata('id')));
  }

  public function getaccount($id) {
    return $this->db->select('*')->from('accounts')->where('id', $id)->get()->row();
  }

  public function getregions($cloud) {
    return $this->db->select('*')->from('regions')->where('id_cloud', $cloud)->where('code <> "NA"')->get()->result();
  }

  public function getregionidbycode($code) {
    return $this->db->select('*')->from('regions')->where('code', $code)->get()->row();
  }

  public function newupdate($id) {
    $this->db->where('id', $id);
    $this->db->update('accounts', array('lastupdate'=> time()));
  }

  
}