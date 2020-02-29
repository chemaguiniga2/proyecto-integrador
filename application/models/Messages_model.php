<?php
class Messages_model extends CI_Model {

  public function insertfeed($initials, $color, $feed) {

    $toinsert = array(
      'id_user' => $this->session->userdata('id'),
      'initials' => $initials,
      'color' => $color,
      'feed' => $feed
    );
    $this->db->insert('company', $toinsert);
  }
}