<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Site extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * http://example.com/index.php/welcome
     * - or -
     * http://example.com/index.php/welcome/index
     * - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     *
     * @see https://codeigniter.com/user_guide/general/urls.html
     *
     */
    public function logout()
    {
        $this->session->unset_userdata('isLogIn');
        $this->session->unset_userdata('id');
        redirect(base_url());
    }

    public function register()
    {
        $this->load->model('Billing_model');
        $model['payment_plans'] = $this->Billing_model->getPlans();
        $model['feature_current_plan'] = $this->Billing_model->getFeaturePlan();
        //$model['ptitle'] = 'Membership Plan';
        //$data['content'] = $this->load->view('dashboard/plans', $model, true);
        //$this->load->view('dashboard/plans', $data);
        if (($this->input->post('username') == NULL) || ($this->input->post('pass') == NULL) || ($this->input->post('email')) == NULL) {
            
            $this->load->view('register', $model);
        } else {
            $username = $this->input->post('username');
            $password = password_hash($this->input->post('pass'), PASSWORD_DEFAULT);
            $email = $this->input->post('email');

            $user = $this->db->select('*')
                ->from('users')
                ->where('username', $username)
                ->where('email', $email)
                ->get()
                ->row();
            if ($user) {
                $model['message'] = "Username or email already in use";
                // redirect(base_url() . 'register');
                $this->load->view('register', $model);
            } else {
                $str = rand();
                $linkstr = md5($str);
                $recoverylink = '<a href="https://omp.onecloudops.com/mconfirm?key=' . $linkstr . '">Here</a>';

                $mailmessage = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>';
                $mailmessage .= '<p>Hello, <em>' . $username . '</em></p><br>';
                $mailmessage .= '<p>Welcome to the OneCloud Management Platform. Please verify your account to continue.</p>';
                $mailmessage .= '<h2>To verify your account, click ' . $recoverylink . '</h2>';
                $mailmessage .= '<p>User guide download.</p><br><img src="https://uploads-ssl.webflow.com/5b8ebb9cd1ecf52711f5a560/5d6583ea1cb0789083bdde51_CaaS%20logo-p-500.png"></body></html>';
                echo $username;
                echo $password;
                echo $email;
                $toinsert = array(
                    'username' => $username,
                    'password' => $password,
                    'email' => $email,
                    'mailconfirm' => $linkstr
                );

                $this->db->insert('users', $toinsert);
                $id_user = $this->db->insert_id();
                $this->email->from('noreply@onecloudops.com', 'OneCloud Management Platform');
                $this->email->to($email);
                $this->email->subject('Email confirmation');
                $this->email->message($mailmessage);
                $this->email->send();
    
                //redirect(base_url() . 'billing/createSubscription?id_user=' . $id_user);
                //redirect(base_url() . 'billing/checkmail);
                redirect(base_url() . 'billing/createSubscription?id_user=' . $id_user);
                
            }
        }
    }

    public function login()
    {
        if ($this->session->userdata('isLogIn'))
            redirect(base_url() . 'dashboard');
        if (($this->input->post('username') == NULL) || ($this->input->post('pass') == NULL)) {
            $this->load->view('login');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('pass');
            $this->load->model('user_model');
            $loginresult = $this->user_model->verifylogin($username, $password);
            if ($loginresult['success']) {
                $this->session->set_userdata('id', $loginresult['id']);
                $this->session->set_userdata('name', $loginresult['name']);
                $this->session->set_userdata('username', $loginresult['username']);
                $this->session->set_userdata('securitylevel', $loginresult['securitylevel']);
                $this->session->set_userdata('otpactive', $loginresult['otpactive']);
                $this->session->set_userdata('otpcheck', $loginresult['otpactive']);
                $this->session->set_userdata('isLogIn', true);
                $this->session->set_userdata('otpback', '');
                if ($loginresult['otpactive']) {
                    $this->session->set_userdata('isLogIn', false);
                    $this->session->set_userdata('otpjump', 'dashboard');
                    redirect(base_url() . 'security/otpauth');
                } else {
                    $this->session->set_userdata('isLogIn', true);
                    $this->session->set_userdata('otpjump', '');
                    redirect(base_url() . 'dashboard');
                }
            } else {
                if ($loginresult['found']) {
                    if (! $loginresult['active']) {
                        $model['message'] = "Please activate your account, check the verification link in your inbox";
                    } else {
                        $model['message'] = "Invalid credentials";
                    }
                } else {
                    $model['message'] = "User not registered";
                }
                $this->load->view('login', $model);
            }
        }
    }

    public function passwordrecovery()
    {
        if ($this->input->post('email') == NULL) {
            $this->load->view('passwordrecovery');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->select('*')
                ->from('users')
                ->where('email', $email)
                ->get()
                ->row();
            if ($user) {
                $str = rand();
                $linkstr = md5($str);
                $toinsert = array(
                    'pwrecovery' => $linkstr
                );
                $recoverylink = '<a href="https://omp.onecloudops.com/recovery?key=' . $linkstr . '">Here</a>';
                $mailmessage = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>To recover tour password, click ' . $recoverylink . '</body></html>';
                $this->db->where('id', $user->id);
                $this->db->update('users', $toinsert);
                $this->email->from('noreply@onecloudops.com', 'OneCloud Management Platform');
                $this->email->to($user->email);
                $this->email->subject('Password Recovery');
                $this->email->message($mailmessage);
                $this->email->send();
                $model['message'] = "Check your email to complete the recovery process";
                $this->load->view('passwordrecovery', $model);
            } else {
                $model['message'] = "This email is not registered";
                $this->load->view('passwordrecovery', $model);
            }
        }
    }

    public function recover()
    {
        if (($this->input->post('uid') != NULL) && ($this->input->post('pass') != NULL) && ($this->input->post('sresponse') != NULL)) {
            $uid = $this->input->post('uid');
            $qid = $this->input->post('qid');
            $sresponse = $this->input->post('sresponse');
            $response = $this->db->select('*')
                ->from('sresponses')
                ->where('id', $qid)
                ->where('id_user', $uid)
                ->get()
                ->row();
            if ($response) {
                if (password_verify($sresponse, $response->response)) {
                    $password = password_hash($this->input->post('pass'), PASSWORD_DEFAULT);
                    $toinsert = array(
                        'password' => $password,
                        'pwrecovery' => ''
                    );
                    $user = $this->db->select('*')
                        ->from('users')
                        ->where('id', $uid)
                        ->get()
                        ->row();

                    if ($user->otpactive) {
                        $this->session->set_userdata('otpcheck', true);
                        $this->session->set_userdata('otpjump', 'security/savepassotp');
                        $this->session->set_userdata('otpdata', $toinsert);
                        $this->session->set_userdata('id', $uid);
                        redirect(base_url() . 'security/otpauth');
                    } else {
                        $this->db->where('id', $uid);
                        $this->db->update('users', $toinsert);
                        redirect(base_url() . 'login');
                    }
                } else {
                    $query = 'SELECT squestions.*, (sresponses.id) as quid, (sresponses.id_question) as iquid FROM squestions, sresponses WHERE sresponses.id_user = ' . $uid . ' and squestions.id = sresponses.id_question';
                    $questions = $this->db->query($query);
                    $question = $questions->row(rand(0, 3));
                    $model['qid'] = $question->quid;
                    $model['qtext'] = $question->question;
                    $model['uid'] = $uid;
                    $model['message'] = "Invalid answer.";
                    $this->load->view('recover', $model);
                }
            } else {
                redirect(base_url() . 'passwordrecovery');
            }
        } else {
            $key = $this->input->get('key');
            $user = $this->db->select('*')
                ->from('users')
                ->where('pwrecovery', $key)
                ->get()
                ->row();
            if ($user) {
                $query = 'SELECT squestions.*, (sresponses.id) as quid, (sresponses.id_question) as iquid FROM squestions, sresponses WHERE sresponses.id_user = ' . $user->id . ' and squestions.id = sresponses.id_question';
                $questions = $this->db->query($query);
                if ($questions->num_rows() < 4) {
                    $model['qid'] = 0;
                    $model['qtext'] = "No questions found";
                    $model['uid'] = 0;
                    $model['message'] = "Your security questions are not set, please contact support.";
                    $model['disableb'] = true;
                    $this->load->view('recover', $model);
                } else {
                    $question = $questions->row(rand(0, 3));
                    $model['qid'] = $question->quid;
                    $model['qtext'] = $question->question;
                    $model['uid'] = $user->id;
                    $this->load->view('recover', $model);
                }
            } else {
                redirect(base_url() . 'passwordrecovery');
            }
        }
    }

    public function mconfirm()
    {
        $key = $this->input->get('key');
        $user = $this->db->select('*')
            ->from('users')
            ->where('mailconfirm', $key)
            ->get()
            ->row();
        if ($user) {
            $toupdate = array(
                'mailconfirm' => '',
                'securitylevel' => 1
            );
            $this->db->where('id', $user->id);
            $this->db->update('users', $toupdate);
            redirect(base_url() . 'login');
        } else {
            redirect(base_url() . 'passwordrecovery');
        }
    }

    public function checkmail()
    {
        $this->load->view('checkmail', '');
    }

    public function getmessages()
    {
        $messages = $this->db->select('*')
            ->from('messages')
            ->where('id_user', $this->session->userdata('id'))
            ->get()
            ->result();
        $notifications = [];
        foreach ($messages as $message) {
            array_push($notifications, array(
                'id' => $message->id,
                'message' => $message->message
            ));
        }
        echo json_encode(array(
            'success' => true,
            'notifications' => $notifications
        ));
    }

    public function dispatchmessage()
    {
        $this->db->delete('messages', array(
            'id' => $this->input->get('id')
        ));
        echo json_encode(array(
            'success' => true
        ));
    }

    public function insertmessage()
    {
        $data = array(
            'id_user' => $this->input->post('user_id'),
            'message' => $this->input->post('message')
        );
        $this->db->insert('messages', $data);
        echo json_encode(array(
            'success' => true
        ));
    }

    public function insertfeed()
    {
        $this->insertfeedp($this->input->post('user_id'), $this->input->post('initials'), $this->input->post('color'), $this->input->post('feed'));
        echo json_encode(array(
            'success' => true
        ));
    }

    public function getfeed()
    {
        $feed = $this->db->query('select * from `user_feed` where id_user=' . $this->session->userdata('id') . ' order by id desc limit 20')
            ->result();
        $pfeed = [];
        foreach ($feed as $row) {
            $ddif = time() - $row->time;
            $sdif = "";
            if ($ddif < 60) {
                $sdif = "Seconds ago";
            } else if ($ddif < (60 * 60)) {
                $sdif = floor($ddif / 60) . " minutes ago";
            } else {
                $sdif = floor($ddif / (60 * 60)) . " hours ago";
            }
            $line = array(
                'initials' => $row->initials,
                'color' => $row->color,
                'feed' => $row->feed,
                'time' => $sdif
            );
            array_push($pfeed, $line);
        }
        echo (json_encode(array(
            'success' => true,
            'feed' => $pfeed
        )));
    }

    private function insertfeedp($feed, $color, $initials)
    {
        $this->db->insert('user_feed', array(
            'id_user' => $this->session->userdata('id'),
            'initials' => $initials,
            'feed' => $feed,
            'color' => $color,
            'time' => time()
        ));
    }

    public function testmail()
    {
        $mailmessage = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>';
        $mailmessage .= '<p>Hello, <em>fjhgjghj</em></p><br>';
        $mailmessage .= '<p>Welcome to the OneCloud Management Platform. Please verify your account to continue.</p>';
        $mailmessage .= '<h2>To verify your account, click ghjghjg</h2>';
        $mailmessage .= '<p>User guide download.</p><br><img src="https://uploads-ssl.webflow.com/5b8ebb9cd1ecf52711f5a560/5d6583ea1cb0789083bdde51_CaaS%20logo-p-500.png"></body></html>';
        echo $mailmessage;
    }
}
