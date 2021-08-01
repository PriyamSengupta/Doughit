<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller {

	/**
	 * Index Page for this controller.
	 * @author	Priyam SenGupta
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

		$this->load->model('admin/order_model', 'order_model');
		$this->load->model('main_model');
		$this->load->library('email');
		$this->load->library('layout_admin');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('session');

	}

	public function index()
	{

		$admin_id 				=	$this->session->userdata('pz_admin_userid');
		$viewdata['mainheader']='Orders';
		$viewdata['admin_id']=$admin_id;
		$details=$this->order_model->get_order_details();   
        $viewdata['details']=$details;
        // print_r($details); die();
		$this->layout_admin->view('/admin/order/index',$viewdata);
	}

	public function download_invoice($id)
	{
		$getdata = array();
		$getdata['table_name'] = 'order';
		$getdata['field_name'] = '*';
		$getdata['condition'] = array('id' => $id);
		$getdata['sortorder'] = array();
		$getdata['groupbyorder'] = array();
		$getdata['searchvalue'] = array();
		$getdata['getvalue'] = 0;
		$getdata['limit'] = 0;
		$getdata['start'] = 0;
		$getdata['join'] = array();
		$order_details = $this->main_model->get_full_details($getdata);

		$filePath = $this->config->item('server_absolute_path').'dist/invoice_pdfs/'.$order_details->invoice;

		if(file_exists($filePath)) {
			$fileName = basename($filePath);
			$fileSize = filesize($filePath);

			// Output headers.
			header("Cache-Control: private");
			header("Content-Type: application/stream");
			header("Content-Length: ".$fileSize);
			header("Content-Disposition: attachment; filename=".$fileName);

			// Output file.
			readfile ($filePath);                   
			exit();
		}
		else {
			die('The provided file path is not valid.');
		}
	}

	public function change_order_status()
	{
		$details=$this->order_model->change_order_status($this->input->post());
	    
	    $viewdata['details']=$details;
		if(!empty($details))
		{
			$viewdata=$this->load->view('/admin/order/ajaxdata',$viewdata);
			return $viewdata;

		}else{

			return 0;
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */