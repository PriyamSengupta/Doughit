<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_online extends CI_Controller {

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

		$this->load->model('front/search_model','search_model');
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
		$viewdata['mainheader']='Order Online';
		$this->layout_front->view('/front/order_online/index',$viewdata);
	}
 
	public function get_products($id)
	{
		if($id == '')
		{
			$this->session->set_userdata('error_msg', "Product not found.");
            redirect($this->config->item('base_url').'order_online');
		}
		else
		{
			$getdata = array();
			$getdata['table_name'] = 'products';
			$getdata['field_name'] = '*';
			$getdata['condition'] = array('category_id'=>$id ,'is_active'=> '1');
			$getdata['sortorder'] = array();
			$getdata['groupbyorder'] = array();
			$getdata['searchvalue'] = array();
			$getdata['getvalue'] = 1;
			$getdata['limit'] = 0;
			$getdata['start'] = 0;
			$getdata['join'] = array();
			$details = $this->main_model->get_full_details($getdata);
			if($details != [])
			{
				$viewdata['details'] = $details;
				$get_category_data = array();
				$get_category_data['table_name'] = 'categories';
				$get_category_data['field_name'] = '*';
				$get_category_data['condition'] = array('id'=>$id);
				$get_category_data['sortorder'] = array();
				$get_category_data['groupbyorder'] = array();
				$get_category_data['searchvalue'] = array();
				$get_category_data['getvalue'] = 0;
				$get_category_data['limit'] = 0;
				$get_category_data['start'] = 0;
				$get_category_data['join'] = array();
				$category_details = $this->main_model->get_full_details($get_category_data);

				$viewdata['mainheader']= $category_details->name;
				$viewdata['category_id'] = $id;
				$this->layout_front->view('/front/order_online/products',$viewdata);
			}
			else
			{
				$this->session->set_userdata('error_msg', "No product found.");
            	redirect($this->config->item('base_url').'order_online');
			}	
		}
	}

	public function filter_product()
	{
		// echo "<pre>";
		// echo $_POST['category_id'];
		$details        		=   $this->search_model->filter_product($this->input->post());
        $viewdata['details']	=	$details;
		
		//echo $details;
        // echo "<pre>"; print_r($details);

		$viewdata=$this->load->view('/front/order_online/ajax_filter_search',$viewdata);
		return $viewdata;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */