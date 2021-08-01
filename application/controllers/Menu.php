<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {

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

		$this->load->model('front/index_model','index_model');
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

	public function index()
	{
		$viewdata['mainheader']='Menu';
		$this->layout_front->view('/front/menu/index',$viewdata);
	}
 
	public function get_products()
	{
		$getdata = array();
		$details = array();
		if($this->input->post('category_id') == 0){
			$getdata['table_name'] = 'products';
			$getdata['field_name'] = '*';
			$getdata['condition'] = array('is_active'=> '1');
			$getdata['sortorder'] = array();
			$getdata['groupbyorder'] = array();
			$getdata['searchvalue'] = array();
			$getdata['getvalue'] = 1;
			$getdata['limit'] = 0;
			$getdata['start'] = 0;
			$getdata['join'] = array();
			$details = $this->main_model->get_full_details($getdata);
		} else {
			$getdata['table_name'] = 'products';
			$getdata['field_name'] = '*';
			$getdata['condition'] = array('category_id'=>$this->input->post('category_id') ,'is_active'=> '1');
			$getdata['sortorder'] = array();
			$getdata['groupbyorder'] = array();
			$getdata['searchvalue'] = array();
			$getdata['getvalue'] = 1;
			$getdata['limit'] = 0;
			$getdata['start'] = 0;
			$getdata['join'] = array();
			$details = $this->main_model->get_full_details($getdata);
		}
		$viewdata['get_all_products']=$details;
		$viewdata=$this->load->view('/front/menu/ajaxproducts',$viewdata);
		return $viewdata;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */