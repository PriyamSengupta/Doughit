<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

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
		if($this->session->userdata('doughit_userid')!='')
		{
			$this->session->set_userdata('doughit_userid', '');
			$this->session->set_userdata('doughit_username', '');
			redirect($this->config->item('base_url'));
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/admin/index.php */
?>