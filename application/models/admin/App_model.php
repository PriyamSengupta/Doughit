<?php
class App_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
    function get_page_details($id)
	{
		$query = $this->db->get_where("pages", array("id" => $id));
		if($query->num_rows()>0)
		{
			$result = $query->row();
			$return=(object)array(
				'id' 			=>	$result->id,
				'name'	        =>	$result->name,
				'description'	=>	$result->description,
			);
		}
		else
		{
			$return=(object)array(
				'id' 			=>	'',
				'name'	        =>	'',
				'description'	=>	'',
			);
		}
		return $return;
	}

    function addedit_page($data)
	{
		if($data['id'] == '')
		{
			$insert_array = array(
				'name'			=>	$data['name'],
                'description'	=>	$data['description'],
				'is_cms'	    =>	'0',
				'type'			=>	'app',
				'is_active'		=>	'1'
			);
			$return = $this->db->insert('pages', $insert_array);
		}
		else{
			$page_id = $data['id'];
			
			$update_array = array(
				'name'			=>	$data['name'],
                'description'	=>	$data['description'],
				'is_cms'	    =>	'0',
				'type'			=>	'app',
				'is_active'		=>	'1'
			);
			$return = $this->db->where('id', $page_id)->update('pages', $update_array);
		}
		return $return;
	}

	function get_banner_details($id)
	{
		$query = $this->db->get_where("banner", array("id" => $id));
		if($query->num_rows()>0)
		{
			$result = $query->row();
			$return=(object)array(
				'id' 			=>	$result->id,
				'page_id'	    =>	$result->page_id,
				'banner_text'	=>	$result->banner_text,
				'image'			=>	$result->image,
			);
		}
		else
		{
			$return=(object)array(
				'id' 			=>	'',
				'page_id'	    =>	'',
				'banner_text'	=>	'',
				'image'			=>	'',
			);
		}
		return $return;
	}

	function addedit_banner($file_name, $data)
	{
		if($data['id'] == '')
		{
			$insert_array = array(
				'page_id'		=>	$data['page_id'],
                'banner_text'	=>	$data['banner_text'],
				'type'	    	=>	'app',
				'image'			=>	$file_name,
				'is_active'		=>	'1'
			);
			$return = $this->db->insert('banner', $insert_array);
		}
		else{
			$banner_id = $data['id'];
			if($file_name=='')
			{
				$update_array = array(
					'page_id'		=>	$data['page_id'],
	                'banner_text'	=>	$data['banner_text'],
				);
			}
			else{
				$image_query = $this->db->query("SELECT * FROM pz_banner WHERE id='".$banner_id."'");
		    	$image = $image_query->row()->image;
		    	if($image != "no_image.png")
		    	{
		    		$image_path = $this->config->item('server_absolute_path').'upload/banner/normal/'.$image;
		    		$thumb_path = $this->config->item('server_absolute_path').'upload/banner/thumb/'.$image;
				    // Check file exist or not
				    if( file_exists($image_path) && file_exists($thumb_path) )
				    {
				        unlink($image_path);
				        unlink($thumb_path);
					}
		    	}
				$update_array = array(
					'page_id'		=>	$data['page_id'],
	                'banner_text'	=>	$data['banner_text'],
					'image'			=>	$file_name,
				);
			}
			$return = $this->db->where('id', $banner_id)->update('banner', $update_array);
		}
		return $return;
	}

    function change_status($id, $table, $type)
	{	    
	    $query=$this->db->get_where($table, array("id" => $id));

        if($query->row()->is_active==1)
        {
            $data_is_active = array('is_active' =>'0');
        }
        else
        {
            $data_is_active = array('is_active' =>'1');
        }
		$this->db->where('id', $id);
		$return=$this->db->update($table, $data_is_active);
		if($return==1)
		{
		    $query1=$this->db->get_where($table, array("type" => $type));
			$return_data=$query1->result();
			return $return_data;
		}
	}
}
?>