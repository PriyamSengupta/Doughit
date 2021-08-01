<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_page extends CI_Controller {

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

		$this->load->model('admin/app_model','app_model');
		$this->load->model('main_model');
		// $this->load->model('settings_model');

		$this->load->library('email');
		$this->load->library('layout_admin');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('session');
	}

	public function index()
	{
        $viewdata['mainheader']='App Pages';
        $getdata = array();
        $getdata['table_name'] = 'pages';
        $getdata['field_name'] = '*';
        $getdata['condition'] = array('type'=> 'app');
        $getdata['sortorder'] = array();
        $getdata['groupbyorder'] = array();
        $getdata['searchvalue'] = array();
        $getdata['getvalue'] = 1;
        $getdata['limit'] = 0;
        $getdata['start'] = 0;
        $getdata['join'] = array();
        $details = $this->main_model->get_full_details($getdata);
        $viewdata['details']=$details;
        // print_r($details); die();
		$this->layout_admin->view('/admin/app_page/index',$viewdata);
    }

    public function addedit($id='')
	{

		if($id== '')
		{		   	
            $viewdata['mainheader']='Add App Page';
			$details=$this->app_model->get_page_details(0);   
            $viewdata['details']=$details;
			$this->layout_admin->view('/admin/app_page/addedit',$viewdata);
		}
		else
		{
		    $viewdata['mainheader']='Edit App Page';    
    		$details=$this->app_model->get_page_details($id);
    		$viewdata['details']=$details;
			$this->layout_admin->view('/admin/app_page/addedit',$viewdata);
		}
	}

    function addedit_page()
	{
		// echo "<pre>";
		// print_r($_FILES);
		// print_r($this->input->post());
		// die();
        $error1url=$this->input->post('id')!='' ? "/".$this->input->post('id') : "";
        $errorurl=$this->input->post('url_segment')!='' ? '/'.$this->input->post('id').'/'.$this->input->post('url_segment') : $error1url;
        $this->form_validation->set_rules('name', 'Page Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
    
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_userdata('error_msg', "Enter all required details.");
            redirect($this->config->item('base_url').'admin/app_page/addedit'.$errorurl);
        } else {

            $return=$this->app_model->addedit_page($this->input->post());
            if($return > 0)
            {
                $success_msg=$this->input->post('id')!='' ? "Page edited successfully." : "Page added successfully.";
                $this->session->set_userdata('success_msg', $success_msg);
                redirect($this->config->item('base_url').'admin/app_page');
            }
            else
            {
                $this->session->set_userdata('error_msg', "Error occurs.");
                redirect($this->config->item('base_url').'admin/app_page/addedit'.$errorurl);
            }
        }
	}

    public function change_status()
	{
	    $id=$_REQUEST['page_id'];
	    
	    $details=$this->app_model->change_status($id, "pages", 'app');
	    
	    $viewdata['details']=$details;
		if(!empty($details))
		{
			$viewdata=$this->load->view('/admin/app_page/ajaxdata',$viewdata);
			return $viewdata;

		}else{

			return 0;
		}
	}
	
}

/* End of file chef.php */
/* Location: ./application/controllers/admin/chef.php */