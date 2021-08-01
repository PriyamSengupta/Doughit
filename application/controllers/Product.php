<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

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

	public function index($id)
	{
        if($id == '' )
        {
            $this->session->set_userdata('error_msg', "Product not found.");
            redirect($this->config->item('base_url').'order_online');
        }
        else
        {
            $getdata['table_name'] = 'products';
			$getdata['field_name'] = '*';
			$getdata['condition'] = array('id'=>$id ,'is_active'=> '1');
			$getdata['sortorder'] = array();
			$getdata['groupbyorder'] = array();
			$getdata['searchvalue'] = array();
			$getdata['getvalue'] = 0;
			$getdata['limit'] = 0;
			$getdata['start'] = 0;
			$getdata['join'] = array();
			$details = $this->main_model->get_full_details($getdata);
            $viewdata['details'] = $details;

			if($details == [])
			{
				$this->session->set_userdata('error_msg', "Product not found.");
            	redirect($this->config->item('base_url').'order_online');
			}
			else
			{
				$viewdata['mainheader']= $details->name;
			    $this->layout_front->view('/front/product_details/index',$viewdata);
			}
        }
	}
 
	public function get_products()
	{
		$getdata = array();
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
		if(!empty($details))
		{
			$viewdata=$this->load->view('/front/menu/ajaxproducts',$viewdata);
			return $viewdata;

		}else{

			return 0;
		}
	}
}

/* End of file product.php */
/* Location: ./application/controllers/welcome.php */