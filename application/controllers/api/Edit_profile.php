<?php
require(APPPATH.'/libraries/REST_Controller.php');
class Edit_profile extends REST_Controller {
	public $error = array();
	function __construct() {
				parent::__construct();
                $this->load->driver('session');
				$this->load->helper('form');
				$this->load->helper('html');
				$this->load->helper('url');
				$this->load->model('api_model');		
        		$this->load->database();
	}

	function index_post()
	{
        
        if(isset($_FILES['image']) && $_FILES['image']['name']!='')
		{
			$image_name = $_FILES['image']['name'];
			//echo $image_name; die();
			$actual_name = pathinfo($image_name,PATHINFO_FILENAME);
			$original_name = $actual_name;
			$extension = pathinfo($image_name, PATHINFO_EXTENSION);
			$i = 1;
			while(file_exists($this->config->item('server_absolute_path').'upload/user/normal/'.$actual_name.".".$extension))
			{           
				$actual_name = (string)$original_name.'_'.$i;
				$image_name = $actual_name.".".$extension;
				$i++;
			}
			
			$config['upload_path'] = $this->config->item('server_absolute_path').'upload/user/normal/';
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
				$config['source_image'] = $this->config->item('server_absolute_path').'upload/user/normal/'.$image_name;
				$config['new_image'] = $this->config->item('server_absolute_path').'upload/user/thumb/';
				$config['maintain_ratio'] = TRUE;
				$config['width'] = ($width < 70) ? $width : 70;
				$config['height'] = ($height < 70) ? $height : 70;
		
				$this->load->library('image_lib',$config);
				$resizeimage=$this->image_lib->resize();

				$filesize = filesize($this->config->item('server_absolute_path').'upload/user/normal/'.$image_name);
				$src = $this->config->item('file_upload_base_url').'user/thumb/'.$image_name;
				$file_name=$image_name;
				// echo $file_name;
			}
		}
		else
		{
			$file_name='';
		}
		$return  = $this->api_model->edit_profile($_POST,$file_name);	
		$this->set_response('application/json');
		$this->response($return);	
	}
}
?>