<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type extends CI_Controller {

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

		$this->load->model('admin/type_model','type_model');
		// $this->load->model('emailtemplate_model');
		$this->load->model('main_model');
		// $this->load->model('settings_model');

		$this->load->library('email');
		$this->load->library('layout_admin');
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
        $viewdata['mainheader']='Add-ons';
		$details=$this->main_model->get_full_details_table("type");   
        $viewdata['details']=$details;
        // print_r($details); die();
		$this->layout_admin->view('/admin/type/index',$viewdata);
    }
 
    public function addedit($id='')
	{
		if($id== '')
		{		   	
            $viewdata['mainheader']='Create Add-on';
			$details=$this->type_model->get_type_details(0);   
            $viewdata['details']=$details;
			$this->layout_admin->view('/admin/type/addedit',$viewdata);
		}
		else
		{
		    $viewdata['mainheader']='Edit Add-on';    
    		$details=$this->type_model->get_type_details($id);

    		$viewdata['details']=$details;
			$this->layout_admin->view('/admin/type/addedit',$viewdata);
		}
	}

    function addedit_type()
	{
		// echo "<pre>";
		// print_r($_FILES);
		// print_r($this->input->post());
		// die();
        $error1url=$this->input->post('id')!='' ? "/".$this->input->post('id') : "";
        $errorurl=$this->input->post('url_segment')!='' ? '/'.$this->input->post('id').'/'.$this->input->post('url_segment') : $error1url;
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_userdata('error_msg', "Enter all required details.");
            redirect($this->config->item('base_url').'admin/type/addedit'.$errorurl);
        } else {
            $return=$this->type_model->addedit_type($this->input->post());
            if($return > 0)
            {
                $success_msg=$this->input->post('id')!='' ? "Add-on edited successfully." : "Add-on added successfully.";
                $this->session->set_userdata('success_msg', $success_msg);
                redirect($this->config->item('base_url').'admin/type');
            }
            else
            {
                $this->session->set_userdata('error_msg', "Error occurs.");
                redirect($this->config->item('base_url').'admin/type/addedit'.$errorurl);
            }
        }
	}

    public function change_status()
	{
	    $id=$_REQUEST['type_id'];
	    
	    $details=$this->type_model->change_status($id, "type");
	    
	    $viewdata['details']=$details;
		if(!empty($details))
		{
			$viewdata=$this->load->view('/admin/type/ajaxdata',$viewdata);
			return $viewdata;

		}else{

			return 0;
		}
	}
}?>