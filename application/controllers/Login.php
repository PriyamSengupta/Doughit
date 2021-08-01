<?php error_reporting(0);if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * @author	Priyam SenGupta
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->database();

		$this->load->helper('form');
		$this->load->helper('html');
        $this->load->helper('url');
		$this->load->helper('cookie');
		
		$this->load->model('front/index_model','index_model');
		$this->load->model('front/login_model','login_model');
		$this->load->model('main_model','main_model');

		$this->load->library('email');
		$this->load->library('layout_front_home');
		$this->load->library('layout_front');
		$this->load->library('form_validation');
		//$this->load->library('pagination');
		$this->load->library('session');
		//$this->load->library('converttime');

		$config['protocol'] = 'mail';
		$config['wordwrap'] = TRUE;
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$this->email->initialize($config);
	}
 
	public function index()
	{
	    if($this->session->userdata('doughit_userid')) {
	        redirect($this->config->item('base_url'));
	    }
	    else
	    {
	        $viewdata['mainheader']='Login/Sign up';
    		$this->layout_front->view('/front/login/index',$viewdata);
	    }
	}
	// For checking email is exist or not in the time of providing in registration form
    public function check_email() {
        if($this->input->post('email') != '') {
            // Check if username is exist or not
            $getdata = array();
            $getdata['table_name'] = 'business_user';
            $getdata['condition'] = array('email' => $this->input->post('email'));
            $getdata['groupbyorder'] = array();
            $getdata['searchvalue'] = array();
            $getdata['join'] = array();
            $email_count = $this->main_model->record_count($getdata);
            $return = ($email_count > 0) ? 'false' : 'true';
        } else {
            $return = 'false';
        }
        echo $return;
        die();
    }
	// To save user resgitration details
    public function save_user() {
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone number', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

		$return_msg = array();
        if ($this->form_validation->run() === FALSE) {
			$return_msg['message'] = "Enter all required details.";
			$return_msg['user_id'] = "";
			$return_msg['error_code'] = "Error";
        } else {
            $error = 'Inactive';
            // Get admin details count
			$getdata = array();
			$getdata['table_name'] = 'business_user';
			$getdata['condition'] = array('email' => $this->input->post('email'));
			$getdata['groupbyorder'] = array();
			$getdata['searchvalue'] = array();
			$getdata['join'] = array();
			$returnlogin = $this->main_model->record_count($getdata);
            if($returnlogin > 0) {
				$return_msg['message'] = "Email already exists.";
				$return_msg['user_id'] = "";
				$return_msg['error_code'] = "Error";
            } else {
				$return = $this->login_model->save_user($this->input->post());
				if ($return > 0) {
					// Check if email is exist or not
					$getdata = array();
					$getdata['table_name'] = 'business_user';
					$getdata['field_name'] = '*';
					$getdata['condition'] = array('id' => $return);
					$getdata['sortorder'] = array();
					$getdata['groupbyorder'] = array();
					$getdata['searchvalue'] = array();
					$getdata['getvalue'] = 0;
					$getdata['limit'] = 0;
					$getdata['start'] = 0;
					$getdata['join'] = array();
					$user_details = $this->main_model->get_full_details($getdata);
					if (isset($user_details)) {
						$message = "<p>Hello ".$user_details->fname."</p>";
						$message .= "<p>Your account have been created successfully. Your login details are given below.</p>";
						$message .= "<p><b>Name : </b>".$user_details->fname." ".$user_details->lname."</p>";
						$message .= "<p><b>Email : </b>".$user_details->email."</p>";
						$message .= "<p><b>Password : </b>What you have chosen</p>";
						$this->email->from("support@readystaging.us","Team Doughit");
						// $this->email->from("dev.sirchend@gmail.com","Team Doughit");
						$this->email->to($this->input->post('email'));
						$this->email->subject('Welcome to Doughit');
						$this->email->message($message);
						$send = $this->email->send();
						$this->email->clear(TRUE);
						if($send) {
							$return_msg['message'] = "Your account have been created successfully. One success email has been sent to your email address.";
							$return_msg['user_id'] = $user_details->id;
							$return_msg['error_code'] = "Success";
						} else {
							$return_msg['message'] = "Your account have been created successfully. But unable to send email.";
							$return_msg['user_id'] = $user_details->id;
							$return_msg['error_code'] = "Error";
						}
					} else {
						$return_msg['message'] = "Error occurs.";
						$return_msg['user_id'] = "";
						$return_msg['error_code'] = "Error";
					}
				} else {
					$return_msg['message'] = "Error occurs.";
					$return_msg['user_id'] = "";
					$return_msg['error_code'] = "Error";
				}
            }
        }
		$return_msg = json_encode($return_msg);
		echo $return_msg;
		die();
    }
	public function check_login() {
        $this->form_validation->set_rules('login_email', 'Email', 'trim|required');
        $this->form_validation->set_rules('login_password', 'Password', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            $return_msg['message'] = "Enter all required details.";
			$return_msg['error_code'] = "Error";
        } else {
            // Check username or email and password is exist or not in users table
            $savedata = array();
            $return = $this->login_model->check_login($this->input->post());
            if (isset($return) && $return->id != '') {
                if($return->error_code == 'Success') {
                    $this->session->set_userdata('doughit_userid', $return->id);
                    $this->session->set_userdata('doughit_username', $return->name);
					
					$return_msg['message'] = $return->message;
					$return_msg['error_code'] = "Success";
                } else {
                    $this->session->set_flashdata('error_msg', $return->message);
					$return_msg['message'] = $return->message;
					$return_msg['error_code'] = "Error";
                }
            } else {
				$return_msg['message'] = "Email or password doesnot match.";
				$return_msg['error_code'] = "Error";
            }
        }
		$return_msg = json_encode($return_msg);
		echo $return_msg;
		die();
    }
    
    public function checkforgotpassword()
	{
	   // echo $this->input->post('useremail'); die();
		$this->form_validation->set_rules('useremail', 'Email', 'trim|required|valid_email');

		if($this->form_validation->run() === FALSE)
		{
			$return_msg['message'] = "Enter all required details.";
			$return_msg['error_code'] = "Error";
		}
		else
		{
		    $getdata = array();
			$getdata['table_name'] = 'business_user';
			$getdata['condition'] = array('email' => $this->input->post('useremail'), 'is_active' => '1');
			$getdata['groupbyorder'] = array();
			$getdata['searchvalue'] = array();
			$getdata['join'] = array();
			$returnlogin = $this->main_model->record_count($getdata);
			
			if($returnlogin > 0)
			{
			    $getdata = array();
				$getdata['table_name'] = 'business_user';
				$getdata['field_name'] = '*';
				$getdata['condition'] = array('email' => $this->input->post('useremail') , 'is_active' => '1');
				$getdata['sortorder'] = array();
				$getdata['groupbyorder'] = array();
				$getdata['searchvalue'] = array();
				$getdata['getvalue'] = 0;
				$getdata['limit'] = 0;
				$getdata['start'] = 0;
				$getdata['join'] = array();
				$user_details = $this->main_model->get_full_details($getdata);
					
				$verificationcode=md5(uniqid(rand(), true));
				$saveverificationcode=$this->login_model->save_verification($user_details->id,$verificationcode);
				if($saveverificationcode > 0)
				{
				    $verificationlink=$this->config->item('base_url').'login/changepassword/'.$verificationcode;
					$site_link = "<a href='$verificationlink'>".$verificationlink."</a>";
					
				    $message = "<p>Hello ".$user_details->fname."</p>";
					$message .= "<p>Click on the link below to reset your password.</p>";
					$message .= "<p>".$site_link."</p>";
					
					// $this->email->from("dev.sirchend@gmail.com","Reset Password");
					$this->email->from("support@readystaging.us","Reset Password");

					$this->email->to($this->input->post('useremail'));
					$this->email->subject('Reset Password');
					$this->email->message($message);
					$send = $this->email->send();
					$this->email->clear(TRUE);
					if($send) {
						$return_msg['message'] = "An email has been sent to your email address to reset your password.";
						$return_msg['error_code'] = "Success";
					} else {
						$return_msg['message'] = "Error sending email.";
						$return_msg['error_code'] = "Error";
					}
				}
				else
				{
					$return_msg['message'] = "Error occured.";
					$return_msg['error_code'] = "Error";
				}
			}
			else
			{
				$return_msg['message'] = "User not found";
			    $return_msg['error_code'] = "Error";
			}
		}
		$return_msg = json_encode($return_msg);
		echo $return_msg;
		die();
	}

    function changepassword()
    {
        
        $getdata = array();
        $getdata['table_name'] = 'business_user';
        $getdata['field_name'] = '*';
        $getdata['condition'] = array('verification_code' => $this->uri->segment(3));
        $getdata['sortorder'] = array();
        $getdata['groupbyorder'] = array();
        $getdata['searchvalue'] = array();
        $getdata['getvalue'] = 0;
        $getdata['limit'] = 0;
        $getdata['start'] = 0;
        $getdata['join'] = array();
        $user_details = $this->main_model->get_full_details($getdata);
        if(count($user_details) > 0)
		{
            $viewdata['mainheader']='Reset Password';
            $viewdata['verification_code'] = $user_details->verification_code;
            $this->layout_front->view('/front/login/changepassword',$viewdata);
		}
		else
		{
		    redirect($this->config->item('base_url'));
		}
    }
    public function change_password_details()
	{
	   // echo "<pre>";
	   // print_r($this->input->post());
	   // die();
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('retype_password', 'Retype Password', 'trim|required|matches[password]');

		if($this->form_validation->run() === FALSE)
		{
		    $return_msg['message'] = "Password and retype password doesn't match.";
			$return_msg['error_code'] = "Error";
		}
		else
		{
			$returnlogin=$this->login_model->change_password($this->input->post());

			if($returnlogin > 0)
			{
				$return_msg['message'] = "Password changed successfully.";
				$return_msg['error_code'] = "Success";
			}
			else
			{
			    $return_msg['message'] = "Error changing password.";
				$return_msg['error_code'] = "Success";
			}
		}
		$return_msg = json_encode($return_msg);
		echo $return_msg;
		die();
	}
}
?>