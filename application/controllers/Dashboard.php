<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
  function __construct()
  {
      parent::__construct();
      $CI = & get_instance();
      $CI->load->library('session');
      $CI->load->helper('url');
      if (!$this->session->userdata('isLogIn')) {
        redirect(base_url() . 'login'); 
      }
      if ($this->session->userdata('securitylevel') < 2) {
        if (current_url() != (base_url() . 'security/squestions')) {
          redirect(base_url() . 'security/squestions'); 
        }
      }
  }

	public function index()
	{

    $this->load->model('account_model');
    $accounts = $this->account_model->getallaccounts();
    $clouds = $this->db->select('*')->from('clouds')->get()->result();
    $regions = array();
    foreach ($clouds as $cloud) {
      if (!isset($regions[$cloud->id])) 
        $regions[$cloud->id] = "";
      $r = $this->account_model->getregions($cloud->id);
      $i = 0;
      foreach ($r as $sr) {
        if ($i > 0) $regions[$cloud->id] .= "---";
        $regions[$cloud->id] .= $sr->code;
        $i++;
      }
    }
    foreach ($accounts as $account) {
      $this->account_model->newupdate($account->id);
      $endpoint = $account->id_cloud == 1 ? 'aws' : 'azure';
      $curlurl = cloudServiceURL() . "/" . $endpoint . "/vm/updatelist?userid=" . $this->session->userdata('id') . "&accid="  . $account->id . "&regions=" . $regions[$account->id_cloud];
      $ch = curl_init();
      curl_setopt($ch,CURLOPT_URL,$curlurl);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $result = curl_exec($ch);
      $obj = json_decode($result, true);
      curl_close($ch);
    }

      

    $model['ptitle'] = 'Dashboard';
    $data['content'] = $this->load->view('dashboard/welcome', $model, true);
		$this->load->view('template', $data);
  }
  
  public function profile() {
    $company = "";
    $website = "";
    $companyid = 0;
    $fname = "";
    $lname = "";
    $email = "";
    $phone = "";
    $role = "";
    $logo = "";
    $query = '
    SELECT users.*, companies.name as cname, companies.website as cwebsite  
    FROM `users` 
    left join companies on users.id_company = companies.id
    WHERE users.id = ' . $this->session->userdata('id');
    $uquery = $this->db->query($query);

    if ($uquery->num_rows() > 0) {
      $row = $uquery->row();

      $company = $row->cname;
      $website = $row->cwebsite;
      $companyid = $row->id_company;
      $fname = $row->fname;
      $lname = $row->lname;
      $email = $row->email;
      $phone = $row->phone;
      $role = $row->companyrole;
      $logo = "";
    } else {
      $user = $this->db->select('*')->from('users')->where('id', $this->session->userdata('id'))->get()->row();
      $fname = $user->fname;
      $lname = $user->lname;
      $email = $user->email;
      $phone = $user->phone;
      $role = $user->companyrole;
      
    }
    $model['company'] = $company;
    $model['website'] = $website;
    $model['companyid'] = $companyid;
    $model['fname'] = $fname;
    $model['lname'] = $lname;
    $model['email'] = $email;
    $model['phone'] = $phone;
    $model['role'] = $role;
    $model['logo'] = $logo;
    $model['ptitle'] = 'Profile';
    //$data['additionaljs'] = '<script src="../assets/js/dropzone.js"></script>' . '<script src="../assets/js/logoupload.js"></script>';
    $data['content'] = $this->load->view('dashboard/profile', $model, true);
		$this->load->view('template', $data);
  }

  public function updatep() {
    $companyid = $this->input->post('companyid') == 0 ? NULL : $this->input->post('companyid');
    if ($companyid == null) {
      $toinsert = array(
        'name' => $this->input->post('company'),
        'website' => $this->input->post('website'),
        'logolink' => $this->input->post('logo')
      );
      $this->db->insert('company', $toinsert);
      $companyid = $this->db->insert_id();
    } else {
      $companyupdate = array(
        'name' => $this->input->post('company'),
        'website' => $this->input->post('website'),
        'logolink' => $this->input->post('logo')
      );
      $this->db->where('id', $companyid);
      $this->db->update('company', $companyupdate);
    }
    $userupdate = array(
      'id_company' => $companyid,
      'fname' => $this->input->post('fname'),
      'lname' => $this->input->post('lname'),
      'phone' => $this->input->post('phone'),
      'companyrole' => $this->input->post('role')
    );
    $this->db->where('id', $this->session->userdata('id'));
    $this->db->update('users', $userupdate);
    $this->session->set_userdata('companylogo', $this->input->post('logo'));
    redirect(base_url() . 'dashboard');
  }

  public function uploadlogo() {
    $config['upload_path']          = './uploads/';
    $config['allowed_types']        = 'gif|jpg|png';
    $config['max_size']             = 600;
    $config['max_width']            = 1024;
    $config['max_height']           = 768;

    $this->load->library('upload', $config);

    if ( ! $this->upload->do_upload('file'))
    {
      echo "error";
    }
    else
    {
      echo "Good";
    }
  }

}
