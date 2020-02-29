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
    $this->db->delete('accounts', array('id' => $this->input->get($accountid), 'id_user' => $this->session->userdata('id')));
  }

  public function getaccount($id) {
    return $this->db->select('*')->from('accounts')->where('id', $id)->get()->row();
  }

  public function getregions($cloud) {
    return $this->db->select('*')->from('regions')->where('id_cloud', $cloud)->get()->result();
  }

  public function getregionbycode($code) {
    return $this->db->select('*')->from('regions')->where('code', $code)->get()->row();
  }

  public function newupdate($id) {
    $this->db->where('id', $id);
    $this->db->update('accounts', array('lastupdate'=> time()));
  }
}