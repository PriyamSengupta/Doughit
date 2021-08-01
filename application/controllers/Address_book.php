<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address_book extends CI_Controller {

	/**
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
		$this->load->helper('date');
		$this->load->helper('string');

		$this->load->model('front/address_model','address_model');
		$this->load->model('main_model');

		$this->load->library('email');
		$this->load->library('layout_front');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('session');

		$config['protocol'] = 'mail';
		$config['wordwrap'] = TRUE;
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$this->email->initialize($config);
	}

	public function add_address()
	{
        $details = $this->address_model->add_address($this->input->post());
        $viewdata['address']=$details;
		if(!empty($details))
		{
			$viewdata=$this->load->view('/front/checkout/ajaxDeliveryAddress',$viewdata);
			return $viewdata;

		}else{

			return 0;
		}
    }

	public function get_address()
	{
		$user_id = $this->input->post('id');
		$getdata = array();
		$getdata['table_name'] = 'address_book';
		$getdata['field_name'] = '*';
		$getdata['condition'] = array('user_id'=> $user_id, 'is_delete'=>'0');
		$getdata['sortorder'] = array();
		$getdata['groupbyorder'] = array();
		$getdata['searchvalue'] = array();
		$getdata['getvalue'] = 1;
		$getdata['limit'] = 0;
		$getdata['start'] = 0;
		$getdata['join'] = array();
		$details = $this->main_model->get_full_details($getdata);

		$viewdata['addresses']=$details;
		if(!empty($details))
		{
			$viewdata=$this->load->view('/front/checkout/ajaxAddressBook',$viewdata);
			return $viewdata;

		}else{

			return 0;
		}
	}

	public function change_default_address()
	{
		$address_id = $this->input->post('id');
		$user_id = $this->input->post('user_id');
		$details = $this->address_model->change_default_address($address_id,$user_id);
        $viewdata['address']=$details;
		if(!empty($details))
		{
			$viewdata=$this->load->view('/front/checkout/ajaxDeliveryAddress',$viewdata);
			return $viewdata;

		}else{

			return 0;
		}
	}
}
?>