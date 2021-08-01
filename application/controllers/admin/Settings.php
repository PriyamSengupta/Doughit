<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

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

		$this->load->model('admin/login_model','login_model');
		// $this->load->model('emailtemplate_model');
		$this->load->model('admin/setting_model','setting_model');
		// $this->load->model('settings_model');

		$this->load->library('email');
		$this->load->library('layout_admin');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('session');

	}

	public function index()
	{

		$admin_id 				=	$this->session->userdata('pz_admin_userid');
		$viewdata['mainheader']='Settings';
		$viewdata['admin_id']=$admin_id;
		$details=$this->setting_model->get_details();   
        $viewdata['details']=$details;
        // print_r($details); die();
		$this->layout_admin->view('/admin/settings/index',$viewdata);
	}

	public function addedit_setting()
	{
		// echo "<pre>"; print_r($_POST); die();
		$successurl=$this->input->post('url_segment')!='' ? '/index/'.$this->input->post('url_segment') : "";
		$error1url=$this->input->post('id')!='' ? "/".$this->input->post('id') : "";
		$errorurl=$this->input->post('url_segment')!='' ? '/'.$this->input->post('id').'/'.$this->input->post('url_segment') : $error1url;
		
		if($_FILES['image']['name']!='')
		{
			$image_name = $_FILES['image']['name'];
			//echo $image_name; die();
			$actual_name = pathinfo($image_name,PATHINFO_FILENAME);
			$original_name = $actual_name;
			$extension = pathinfo($image_name, PATHINFO_EXTENSION);

			$i = 1;
			while(file_exists($this->config->item('server_absolute_path').'upload/logo/'.$actual_name.".".$extension))
			{           
			    $actual_name = (string)$original_name.'_'.$i;
			    $image_name = $actual_name.".".$extension;
			    $i++;
			}
			
			$config['upload_path'] = $this->config->item('server_absolute_path').'upload/logo/';
			$config['allowed_types'] = 'gif|jpg|png';
		    // $config['max_size'] = '500';
		    // $config['max_width']  = '1024';
		    // $config['max_height']  = '768';
			$config['overwrite'] = TRUE;
			$config['file_name'] = $image_name;
			// print_r($config);
			$this->load->library('upload', $config);
			// $file_name=$image_name;
			if ( ! $this->upload->do_upload('image'))
			{
				$file_name='no_image.jpg';				
			}
			else
			{
				$file_name=$image_name;
				// echo $file_name;
			}

		}
		else
		{
		    $file_name='';  
		    // echo $file_name; die();  
		}
		
		$return=$this->setting_model->addedit_setting($this->input->post(),$file_name);
		// echo $return; die();
		if($return > 0)
		{
			$success_msg=$this->input->post('id')!='' ? "Settings edited successfully." : "Settings added successfully.";
			$this->session->set_userdata('success_msg', $success_msg);
			redirect($this->config->item('base_url').'admin/settings'.$successurl);
		}
		else
		{
			$this->session->set_userdata('error_msg', "Error occurs.");
			redirect($this->config->item('base_url').'admin/settings/addedit'.$errorurl);
		}
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */