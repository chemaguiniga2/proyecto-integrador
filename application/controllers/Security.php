<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security extends CI_Controller {


	public function squestions()
	{
    $model['questions'] = $this->db->select('*')->from('squestions')->get()->result();
    $model['ptitle'] = 'Security Questions';
    $data['content'] = $this->load->view('security/squestions', $model, true);
		$this->load->view('template', $data);
  }
  
  public function validatesq() {
    $q1 = $this->input->post('question1');
    $q2 = $this->input->post('question2');
    $q3 = $this->input->post('question3');
    $q4 = $this->input->post('question4');

    $r1 = password_hash($this->input->post('response1'), PASSWORD_DEFAULT);
    $r2 = password_hash($this->input->post('response2'), PASSWORD_DEFAULT);
    $r3 = password_hash($this->input->post('response3'), PASSWORD_DEFAULT);
    $r4 = password_hash($this->input->post('response4'), PASSWORD_DEFAULT);

    $uid = $this->session->userdata('id');

    $this->db->where('id_user', $uid);
    $this->db->delete('sresponses');

    $toinsert = array(
      array(
        'id_user' => $uid,
        'id_question' => $q1,
        'response' => $r1,
      ),
      array(
        'id_user' => $uid,
        'id_question' => $q2,
        'response' => $r2,
      ),
      array(
        'id_user' => $uid,
        'id_question' => $q3,
        'response' => $r3,
      ),
      array(
        'id_user' => $uid,
        'id_question' => $q4,
        'response' => $r4,
      )
    );
    $this->db->insert_batch('sresponses', $toinsert);
    $user = $this->db->select('*')->from('users')->where('id', $uid)->get()->row();
    if ($user->securitylevel < 2) {
      $this->db->where('id', $uid);
      $this->db->update('users', array('securitylevel'=>2));
    }
    if ($this->session->userdata('securitylevel')<2) {
      $this->session->set_userdata('securitylevel', 2);
    }
    
    redirect(base_url());
  }

  public function enable2fa() {

    $user = $this->db->select('*')->from('users')->where('id', $this->session->userdata('id'))->get()->row();
    if ($user->gauth != NULL && $user->gauth != "") {
      redirect(base_url() . 'security/activateotp');
    }
    $this->load->library('GoogleAuthenticator');
    $ga = new GoogleAuthenticator();
    $newga = false;
    $disablega = false;
    $secret = "";

    if (($this->input->post('token') == NULL) || ($this->input->post('token') == "")) {
      $secret = $ga->createSecret();
      $newga = true;
      $qrCodeUrl = $ga->getQRCodeGoogleUrl('omp.onecloudops.com', $secret);
      $model['newga'] = true;
      $model['qrcode'] = $qrCodeUrl;
      $model['ptitle'] = '2 Factor Authentication';
      $model['secret'] = $secret;
      $data['content'] = $this->load->view('dashboard/enable2fa', $model, true);
      $this->load->view('template', $data);
    } else {
      $oneCode = $this->input->post('token');
      $secret = $this->input->post('secret');
      $checkResult = $ga->verifyCode($secret, $oneCode, 2);    // 2 = 2*30sec clock tolerance

      if ($checkResult) { 
        $toupdate = array(
          'gauth' => $secret
        );
        $this->db->where('id', $this->session->userdata('id'));
        $this->db->update('users', $toupdate);
        redirect(base_url() . 'activateotp');

      } else {
        $qrCodeUrl = $ga->getQRCodeGoogleUrl('omp.onecloudops.com', $secret);
        $model['newga'] = true;
        $model['qrcode'] = $qrCodeUrl;
        $model['ptitle'] = '2FA';
        $model['secret'] = $secret;
        $model['message'] = "Invalid token, please verify and try again";
        $data['content'] = $this->load->view('dashboard/enable2fa', $model, true);
        $this->load->view('template', $data);
      }

    }


  }

  public function changepassword() {
    if ($this->input->post('pass') != NULL) {
      $pass = $this->input->post('pass');
      $oldpass = $this->input->post('oldpass');
      $user = $this->db->select('*')->from('users')->where('id', $this->session->userdata('id'))->get()->row();
      if (password_verify($oldpass, $user->password)) {
        $toupdate = array(
          'password' => password_hash($pass, PASSWORD_DEFAULT),
        );
        $this->db->where('id', $this->session->userdata('id'));
        $this->db->update('users', $toupdate);

        redirect(base_url() . 'dashboard');
      } else {
        if ($this->session->userdata('otpactive')) {
          $model['active'] = true;
        } else {
          $model['active'] = false;
        }
        $model['ptitle'] = 'Security';
        $model['message'] = 'Your current password is invalid';
        $data['content'] = $this->load->view('dashboard/changepassword', $model, true);
        $this->load->view('template', $data);
      }
    } else {
      $user = $this->db->select('*')->from('users')->where('id', $this->session->userdata('id'))->get()->row();
      if ($user->gauth != NULL && $user->gauth != "") {
        $model['haveauth'] = true;
      } else {
        $model['haveauth'] = false;
      }
      if ($this->session->userdata('otpactive')) {
        $model['active'] = true;
      } else {
        $model['active'] = false;
      }
      $model['ptitle'] = 'Security';
      $data['content'] = $this->load->view('dashboard/changepassword', $model, true);
      $this->load->view('template', $data);
    }

  }

  public function otpauth() {
    if ($this->input->post('token') != NULL) {
      $user = $this->db->select('*')->from('users')->where('id', $this->session->userdata('id'))->get()->row();
      $oneCode = $this->input->post('token');
      $secret = $user->gauth;
      $this->load->library('GoogleAuthenticator');
      $ga = new GoogleAuthenticator();
      $checkResult = $ga->verifyCode($secret, $oneCode, 2);    // 2 = 2*30sec clock tolerance
      if ($checkResult) {
        $nextpage = $this->session->userdata('otpjump');
        $this->session->set_userdata('otpcheck', false);
        $this->session->set_userdata('otpjump', '');
        $this->session->set_userdata('isLogIn', true);
        redirect(base_url() . $nextpage);
      } else {
        $model['message'] = 'Invalid code';
        $this->load->view('otpauth', $model);
        //$this->load->view('template', $data);
      }
    } else {
      $this->load->view('otpauth', "");
      //$this->load->view('template', $data);
    }

  }

  public function otpcancel() {
    $prevpage = $this->session->userdata('otpback');
    $this->session->set_userdata('otpcheck', false);
    $this->session->set_userdata('otpjump', '');
    $this->session->set_userdata('otpback', '');
    redirect(base_url() . $prevpage);
  }

  public function savepassotp() {
    $this->db->where('id', $this->session->userdata('id'));
    $this->db->update('users', $this->session->userdata('otpdata'));
    $this->session->set_userdata('otpcheck', false);
    $this->session->set_userdata('otpjump', '');
    $this->session->set_userdata('otpdata', '');
    redirect(base_url() . 'login');
  }


  public function activateotp() {

    if (($this->input->post('token') != NULL)) {
      
      $user = $this->db->select('*')->from('users')->where('id', $this->session->userdata('id'))->get()->row();
      $oneCode = $this->input->post('token');
      $secret = $user->gauth;
      $this->load->library('GoogleAuthenticator');
      $ga = new GoogleAuthenticator();
      $checkResult = $ga->verifyCode($secret, $oneCode, 2);    // 2 = 2*30sec clock tolerance
      if ($checkResult) { 
        if ($user->otpactive) {
          $setotp = false;
        } else {
          $setotp = true;
        }
        $this->db->where('id', $this->session->userdata('id'));
        $this->db->update('users', array('otpactive'=>$setotp));
        $this->session->set_userdata('otpactive', true);
        redirect(base_url());
      } else {
        if ($this->session->userdata('otpactive')) {
          $model['active'] = true;
        } else {
          $model['active'] = false;
        }
        $model['message'] = 'Invalid OTP code';
        $model['ptitle'] = 'Security';
        $data['content'] = $this->load->view('dashboard/changepassword', $model, true);
        $this->load->view('template', $data);
      }

    } else {
      if ($this->session->userdata('otpactive')) {
        $model['active'] = true;
      } else {
        $model['active'] = false;
      }
      $model['ptitle'] = 'Security';
      $data['content'] = $this->load->view('dashboard/changepassword', $model, true);
      $this->load->view('template', $data);
    }
  }

  public function cloudCredentials() {
    $accountid = $this->input->get('accountid');
    $this->load->model('account_model');
    $account = $this->account_model->getaccount($accountid);

    if ($account) {
      $credentials = json_decode($account->credentials);
      if ($account->id_cloud == 2) {
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array('success' => true, 
        'username' => $credentials->username, 
        'password' => $credentials->password,
        'subid' => $credentials->subscriptionid
         )));
      } else {
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array('success' => true, 
        'keyid' => $credentials->keyid, 
        'secret'=> $credentials->keysecret)));
      }
    }
   
  }


}
