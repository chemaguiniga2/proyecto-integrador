<?php
class User_model extends CI_Model {

  public function verifylogin($username, $password) {
    $response = array(
      'success'=>false,
      'found'=>false,
      'active'=>false,
    );
    $user = $this->db->select('*')->from('users')->where('username', $username)->get()->row();
    if ($user) {
      $response['found'] = true;
      $response['active'] = ($user->securitylevel < 1) ? false : true;
      if (!password_verify($password, $user->password)) {
        return $response;
      } else {
        if ($user->securitylevel < 1) {
          return $response;
        } else {
          $response['success'] = true;
          $response['username'] = $user->username;
          $response['name'] = ($user->fname == NULL || $user->fname == '') ? $user->username : $user->fname;
          $response['id'] = $user->id;
          $response['securitylevel'] = $user->securitylevel;
          $response['otpactive'] = (($user->otpactive != NULL) && ($user->otpactive != false)) ? true : false;
          $response['username'] = $user->username;
          
          $company = $this->db->select('*')->from('companies')->where('id', $user->id_company)->get()->row();
          $response['companylogo'] = '';
          if ($company) {
            if ($company->logolink != NULL) {
              $response['companylogo'] = $company->logolink;
            }
          }

          return $response;
            
        }
      }

    } else {
      return $response;
    }
  }

}