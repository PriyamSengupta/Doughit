<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {

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

		$this->load->model('admin/product_model','product_model');
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
        $viewdata['mainheader']='Products';
		$details=$this->main_model->get_full_details_table("products");   
        $viewdata['details']=$details;
        // print_r($details); die();
		$this->layout_admin->view('/admin/products/index',$viewdata);
    }

    public function addedit($id='')
	{
		if($id== '')
		{		   	
            $viewdata['mainheader']='Add Product';
			$details=$this->product_model->get_product_details(0);   
            $viewdata['details']=$details;
			$this->layout_admin->view('/admin/products/addedit',$viewdata);
		}
		else
		{
		    $viewdata['mainheader']='Edit Product';    
    		$details=$this->product_model->get_product_details($id);

    		$viewdata['details']=$details;
			$this->layout_admin->view('/admin/products/addedit',$viewdata);
		}
	}

    function addedit_product()
	{
		// echo "<pre>";
		// print_r($_FILES);
		// print_r($this->input->post());
		// die();
        // $file_name = '';
        // $return=$this->product_model->addedit_product($file_name,$this->input->post());
        // echo "<pre>"; print_r($return); die();
        $image_array = array();
        $path=$this->config->item('server_absolute_path').'upload/products/normal';
        $count = $this->input->post('currentImgCount');
        $error1url=$this->input->post('id')!='' ? "/".$this->input->post('id') : "";
        $errorurl=$this->input->post('url_segment')!='' ? '/'.$this->input->post('id').'/'.$this->input->post('url_segment') : $error1url;
        
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('food_category_id', 'Food Category', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        // $this->form_validation->set_rules('base_price', 'Base price', 'required');
        
        // $this->form_validation->set_rules('image', 'Image', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_userdata('error_msg', "Enter all required details.");
            redirect($this->config->item('base_url').'admin/products/addedit'.$errorurl);
        } else {

            if($_FILES['image']['name']!='')
            {
                $image_name = $_FILES['image']['name'];
                //echo $image_name; die();
                $actual_name = pathinfo($image_name,PATHINFO_FILENAME);
                $original_name = $actual_name;
                $extension = pathinfo($image_name, PATHINFO_EXTENSION);
                $i = 1;
                while(file_exists($this->config->item('server_absolute_path').'upload/products/normal/'.$actual_name.".".$extension))
                {           
                    $actual_name = (string)$original_name.'_'.$i;
                    $image_name = $actual_name.".".$extension;
                    $i++;
                }
                
                $config['upload_path'] = $this->config->item('server_absolute_path').'upload/products/normal/';
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
                    $config['source_image'] = $this->config->item('server_absolute_path').'upload/products/normal/'.$image_name;
                    $config['new_image'] = $this->config->item('server_absolute_path').'upload/products/thumb/';
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = ($width < 70) ? $width : 70;
                    $config['height'] = ($height < 70) ? $height : 70;
            
                    $this->load->library('image_lib',$config);
                    $resizeimage=$this->image_lib->resize();

                    $filesize = filesize($this->config->item('server_absolute_path').'upload/products/normal/'.$image_name);
                    $src = $this->config->item('file_upload_base_url').'products/thumb/'.$image_name;
                    $file_name=$image_name;
                    // echo $file_name;
                }
            }
            else
            {
                $file_name='';
            }
            for($i=0; $i<$count; $i++)
            {
                if(isset($_FILES['other_images']))
                {
                    if($_FILES['other_images']['name'][$i]!='')
                    {
                        $image_name = (time() + $i).$_FILES['other_images']['name'][$i];
                        // $file_name=$this->file_upload($_FILES['ib1img'.$i],$file);
                        if(move_uploaded_file($_FILES['other_images']['tmp_name'][$i],$path.'/'.$image_name))
                        {
                            $file_name1= $image_name;
                        }
                        else
                        {
                            $file_name1= 'no_image.jpg';
                        }
                        array_push($image_array, $file_name1);
                    }
                    else
                    {
                        $file_name1 = '';
                    }
                }
                else
                {
                    $file_name1 = '';
                }		
            }
            $return=$this->product_model->addedit_product($file_name,$this->input->post(),$image_array);
            // echo "<pre>"; print_r($return); die();
            if($return > 0)
            {
                $success_msg=$this->input->post('id')!='' ? "Product edited successfully." : "Product added successfully.";
                $this->session->set_userdata('success_msg', $success_msg);
                redirect($this->config->item('base_url').'admin/products');
            }
            else
            {
                $this->session->set_userdata('error_msg', "Error occurs.");
                redirect($this->config->item('base_url').'admin/products/addedit'.$errorurl);
            }
        }
	}
 
    public function get_addons()
    {
        $category_id    =   $_REQUEST['category_id'];
        $details        =   $this->product_model->get_addons($category_id);
        $viewdata['details']=$details;

        // echo "<pre>"; print_r($details); die();

		if(!empty($details))
		{
			$viewdata=$this->load->view('/admin/products/ajaxaddondata',$viewdata);
			return $viewdata;

		}else{

			return 0;
		}
        // echo $categroy_id;
    }

    public function change_status()
	{
	    $id=$_REQUEST['product_id'];
	    
	    $details=$this->product_model->change_status($id, "products");
	    
	    $viewdata['details']=$details;
		if(!empty($details))
		{
			$viewdata=$this->load->view('/admin/products/ajaxdata',$viewdata);
			return $viewdata;

		}else{

			return 0;
		}
	}

    public function remove_image()
    {
        $id=$_REQUEST['id'];
		$return=$this->product_model->remove_image($id);
		if($return)
		{
			$success_msg= "Image Removed.";
			$this->session->set_userdata('success_msg', $success_msg);
		}
		echo $return;
    }
}?>