<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

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
		
		$this->load->model('admin/login_model','login_model');
		
		$this->load->library('email');
		$this->load->library('layout_adminlogin');
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
		$viewdata['mainheader']='Signin Now';
		$this->layout_adminlogin->view('/admin/login/index',$viewdata);
	}

	public function checklogin()
	{
		// echo "<pre>"; print_r($this->input->post()); die();
		$this->form_validation->set_rules('loginemail', 'Email', 'trim|required');
		$this->form_validation->set_rules('loginpassword', 'Password', 'trim|required');

		if($this->form_validation->run() === FALSE)
		{
			$this->session->set_flashdata('error_msg', "Login information is incorrect.");
			redirect($this->config->item('base_url').'admin');
		}
		else
		{
			$returnlogin=$this->login_model->check_login($this->input->post());
			// print '<pre>';print_r($returnlogin);die();
			if($returnlogin=='0')
			{
				$this->session->set_flashdata('error_msg', "Email or password doesn't match.");
				redirect($this->config->item('base_url').'admin');
			}
			else
			{

				$this->session->set_userdata('pz_admin_userid', $returnlogin);
				$admin_id 	=	$this->session->userdata('pz_admin_userid');
				$admin_name	=	$this->login_model->get_admin_info($admin_id);
				
				$this->session->set_userdata('pz_admin_name', $admin_name);

				if($this->input->post('remember_me') == 'CHECKED')
				{
					$this->input->set_cookie('bloom_admin_remember_me',$this->input->post('remember_me'),86500);
					$this->input->set_cookie('bloom_admin_cookieemail',$this->input->post('loginemail'),86500);
					$this->input->set_cookie('bloom_admin_cookiepassword',$this->input->post('loginpassword'),86500);
				}
				else
				{
					$this->input->set_cookie('bloom_admin_remember_me');
					$this->input->set_cookie('bloom_admin_cookieemail');
					$this->input->set_cookie('bloom_admin_cookiepassword');
				}

				redirect($this->config->item('base_url').'admin/dashboard');
			}
		}
	}


	/*public function forgotpassword()
	{
		$viewdata['mainheader']='Forgot Password';
		$this->layout_adminlogin->view('/admin/login/forgotpassword',$viewdata);
	}

	public function checkforgotpassword()
	{
		$this->form_validation->set_rules('useremail', 'Email', 'trim|required|valid_email');

		if($this->form_validation->run() === FALSE)
		{
			$this->session->set_userdata('error_msg', "Enter currect email.");
			redirect($this->config->item('base_url').'admin/index/forgotpassword');
		}
		else
		{
			$returnlogin=$this->main_model->record_count('admin',array('email' => $this->input->post('useremail')),array(),array());

			if($returnlogin > 0)
			{
				$admin_details=$this->main_model->get_full_details('admin','admin_id,email',array(),array(),array(),array(),0,0,0);
				$verificationcode=md5(uniqid(rand(), true));
				$saveverificationcode=$this->login_model->save_verification($admin_details->admin_id,$verificationcode);
				if($saveverificationcode > 0)
				{
					$email_contant=$this->emailtemplate_model->get_email_template(1);
					$sitedetails=$this->main_model->get_full_details('settings','*',array(),array(),array(),array(),0,0,0);

					$admin_logo_url = ($sitedetails->admin_logo!='') ? $this->config->item('file_upload_base_url').'logo/thumb/'.$sitedetails->admin_logo : $this->config->item('css_images_js_base_url').'images/logo.gif';
					$admin_logo='<img src="'.$admin_logo_url.'" alt="">';
					$site_name = ($sitedetails->site_name!='') ?  $sitedetails->site_name : 'ScoopLocal';
					$verificationlink=$this->config->item('base_url').'admin/index/changepassword/'.$verificationcode;
					$site_link = "<a href='$verificationlink'>".$verificationlink."</a>";

					$message = str_replace("@SITELOGO@",$admin_logo,$email_contant->content);
					$message = str_replace("@SITENAME@",$site_name,$message);
					$message = str_replace("@VERIFICATIONPAGELINK@",$site_link,$message);
					$message = str_replace("@COPYRIGHTTEXT@",$sitedetails->copyright_text,$message);

					$this->email->from($admin_details->email);
					$this->email->to($this->input->post('useremail'));
					$this->email->subject('Password Verification');
					$this->email->message($message);
					$this->email->send();
					$this->email->clear(TRUE);

					$this->session->set_flashdata('success_msg', "Verification code send to your email.");
					redirect($this->config->item('base_url').'admin');
				}
				else
				{
					$this->session->set_flashdata('error_msg', "Error in saving.");
					redirect($this->config->item('base_url').'admin/index/forgotpassword');
				}
			}
			else
			{
				$this->session->set_flashdata('error_msg', "Email doesnot match.");
				redirect($this->config->item('base_url').'admin/index/forgotpassword');
			}
		}
	}

	public function changepassword()
	{
		$returnlogin=$this->main_model->get_full_details('admin','admin_id',array('verification_code' => $this->uri->segment(4)),array(),array(),array(),0,0,0);

		if(count($returnlogin) > 0)
		{
			$viewdata['mainheader']='Change Password';
			$viewdata['verification_code'] = $this->uri->segment(4);
			$this->layout_adminlogin->view('/admin/login/changepassword',$viewdata);
		}
		else
		{
			$this->session->set_userdata('error_msg', "Verification code doesnot match.");
			redirect($this->config->item('base_url').'admin');
		}
	}

	public function change_password_details()
	{
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('retype_password', 'Retype Password', 'trim|required|matches[password]');

		if($this->form_validation->run() === FALSE)
		{
			$this->session->set_userdata('error_msg', "Password and retype password doesn't match.");
			redirect($this->config->item('base_url').'admin/index/changepassword');
		}
		else
		{
			$returnlogin=$this->login_model->change_password($this->input->post());

			if($returnlogin > 0)
			{
				$this->session->set_userdata('success_msg', "Password changed successfully.");
				redirect($this->config->item('base_url').'admin');
			}
			else
			{
				$this->session->set_userdata('error_msg', "Error in password change.");
				redirect($this->config->item('base_url').'admin/index/changepassword');
			}
		}
	}*/

	public function logout()
	{
		if($this->session->userdata('pz_admin_userid')!='')
		{
			$this->session->set_userdata('pz_admin_userid', '');
			$this->session->set_userdata('bloom_admin_name', '');
			$this->session->set_flashdata('success_msg', "Loggedout successfully.");
			redirect($this->config->item('base_url').'admin');
		}
		else
		{
			$this->session->set_flashdata('error_msg', "Please login first");
			redirect($this->config->item('base_url').'admin');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/admin/index.php */
?>