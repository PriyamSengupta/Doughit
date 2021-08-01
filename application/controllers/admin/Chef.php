<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chef extends CI_Controller {

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

		$this->load->model('admin/chef_model','chef_model');
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
        $viewdata['mainheader']='Chefs';
		$details=$this->main_model->get_full_details_table("chef");   
        $viewdata['details']=$details;
        // print_r($details); die();
		$this->layout_admin->view('/admin/chef/index',$viewdata);
    }

    public function addedit($id='')
	{

		if($id== '')
		{		   	
            $viewdata['mainheader']='Add Chef';
			$details=$this->chef_model->get_chef_details(0);   
            $viewdata['details']=$details;
			$this->layout_admin->view('/admin/chef/addedit',$viewdata);
		}
		else
		{
		    $viewdata['mainheader']='Edit Chef';    
    		$details=$this->chef_model->get_chef_details($id);
    		$viewdata['details']=$details;
			$this->layout_admin->view('/admin/chef/addedit',$viewdata);
		}
	}

    function addedit_chef()
	{
		// echo "<pre>";
		// print_r($_FILES);
		// print_r($this->input->post());
		// die();
        $error1url=$this->input->post('id')!='' ? "/".$this->input->post('id') : "";
        $errorurl=$this->input->post('url_segment')!='' ? '/'.$this->input->post('id').'/'.$this->input->post('url_segment') : $error1url;
        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('expertise', 'Expertise', 'trim|required');
    
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_userdata('error_msg', "Enter all required details.");
            redirect($this->config->item('base_url').'admin/chef/addedit'.$errorurl);
        } else {

            if($_FILES['image']['name']!='')
            {
                $image_name = $_FILES['image']['name'];
                //echo $image_name; die();
                $actual_name = pathinfo($image_name,PATHINFO_FILENAME);
                $original_name = $actual_name;
                $extension = pathinfo($image_name, PATHINFO_EXTENSION);
                $i = 1;
                while(file_exists($this->config->item('server_absolute_path').'upload/chef/normal/'.$actual_name.".".$extension))
                {           
                    $actual_name = (string)$original_name.'_'.$i;
                    $image_name = $actual_name.".".$extension;
                    $i++;
                }
                
                $config['upload_path'] = $this->config->item('server_absolute_path').'upload/chef/normal/';
                $config['allowed_types'] = 'gif|jpg|png';
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
                    list($width, $height, $type, $attr) = getimagesize($_FILES['image']['tmp_name']);		
                    $config['source_image'] = $this->config->item('server_absolute_path').'upload/chef/normal/'.$image_name;
                    $config['new_image'] = $this->config->item('server_absolute_path').'upload/chef/thumb/';
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = ($width < 70) ? $width : 70;
                    $config['height'] = ($height < 70) ? $height : 70;
            
                    $this->load->library('image_lib',$config);
                    $resizeimage=$this->image_lib->resize();

                    $filesize = filesize($this->config->item('server_absolute_path').'upload/chef/normal/'.$image_name);
                    $src = $this->config->item('file_upload_base_url').'chef/thumb/'.$image_name;
                    //$return = array("name" => $image_name,"size" => $filesize, "src"=> $src);
                    $file_name=$image_name;
                    // echo $file_name;
                }
            }
            else
            {
                $file_name='';
            }

            $return=$this->chef_model->addedit_chef($file_name, $this->input->post());
            if($return > 0)
            {
                $success_msg=$this->input->post('id')!='' ? "Chef edited successfully." : "Chef added successfully.";
                $this->session->set_userdata('success_msg', $success_msg);
                redirect($this->config->item('base_url').'admin/chef');
            }
            else
            {
                $this->session->set_userdata('error_msg', "Error occurs.");
                redirect($this->config->item('base_url').'admin/chef/addedit'.$errorurl);
            }
        }
	}

    public function change_status()
	{
	    $id=$_REQUEST['chef_id'];
	    
	    $details=$this->chef_model->change_status($id, "chef");
	    
	    $viewdata['details']=$details;
		if(!empty($details))
		{
			$viewdata=$this->load->view('/admin/chef/ajaxdata',$viewdata);
			return $viewdata;

		}else{

			return 0;
		}
	}
	
}

/* End of file chef.php */
/* Location: ./application/controllers/admin/chef.php */