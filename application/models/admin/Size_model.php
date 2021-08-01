<?php
class Size_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
    function get_size_details($id)
	{
		$query = $this->db->get_where("size", array("id" => $id));
		if($query->num_rows()>0)
		{
			$result = $query->row();
			$return=(object)array(
				'id' 			=>	$result->id,
				'name'	        =>	$result->name,
                'description'   =>  $result->description,
				'image'			=>	$result->image,
				'category_id'	=>	$result->category_id,
				'is_default'	=>	$result->is_default
			);
		} 
		else
		{
			$return=(object)array(
				'id' 			=>	'',
				'name'	        =>	'',
                'description'   =>  '',
				'image'			=>	'',
				'category_id'	=>	'',
				'is_default'	=>	''
			);
		}
		return $return;
	}

	function addedit_size($file_name, $data)
	{
		if($data['id'] == '')
		{
			$insert_array = array(
				'name'			=>	$data['name'],
				'description'	=>	$data['description'],
				'image'			=>	$file_name,
				'category_id'	=>	$data['category_id'],
				'is_active'		=>	'1'
			);
			$return = $this->db->insert('size', $insert_array);
			$size_id = $this->db->insert_id();


			if($data['is_default'] == 1)
			{
				$update_default_option = array("is_default" => "0");
				$update_default_query = $this->db->where('category_id', $data['category_id'])->update('size', $update_default_option);
				if($update_default_query)
				{
					$update_default_option = array("is_default" => "1");
					$update_default_query = $this->db->where('id', $size_id)->update('size', $update_default_option);
				}
			}
			else
			{
				$query1 = $this->db->get_where("size", array("category_id" => $data['category_id'], "is_default" => "1", "is_active" => "1"));
				if($query1->num_rows() == 0)
				{
					$query2 = $this->db->get_where("size", array("category_id" => $data['category_id'], "is_active" => "1"));
					$default_size_arr = $query2->result();
					$default_size_id = $type_opt_arr[0]->id;
					$update_default_option = array("is_default" => "1");
					$update_default_query = $this->db->where('id', $default_size_id )->update('size', $update_default_option);
				}
			}
		}
		else{
			$size_id = $data['id'];
			if($file_name=='')
			{
				$update_array = array(
					'name'			=>	$data['name'],
					'description'	=>	$data['description'],
					'category_id'	=>	$data['category_id'],
				);
			}
			else{
				$image_query = $this->db->query("SELECT * FROM pz_size WHERE id='".$size_id."'");
		    	$image = $image_query->row()->image;
		    	if($image != "no_image.png")
		    	{
		    		$image_path = $this->config->item('server_absolute_path').'upload/size/normal/'.$image;
		    		$thumb_path = $this->config->item('server_absolute_path').'upload/size/thumb/'.$image;
				    // Check file exist or not
				    if( file_exists($image_path) && file_exists($thumb_path) )
				    {
				        unlink($image_path);
				        unlink($thumb_path);
					}
		    	}
				$update_array = array(
					'name'			=>	$data['name'],
					'description'	=>	$data['description'],
					'category_id'	=>	$data['category_id'],
					'image'			=>	$file_name
				);
			}
			$return = $this->db->where('id', $size_id)->update('size', $update_array);

			if($data['is_default'] == 1)
			{
				$update_default_option = array("is_default" => "0");
				$update_default_query = $this->db->where('category_id', $data['category_id'])->update('size', $update_default_option);
				if($update_default_query)
				{
					$update_default_option = array("is_default" => "1");
					$update_default_query = $this->db->where('id', $size_id)->update('size', $update_default_option);
				}
			}
			else
			{
				$query1 = $this->db->get_where("size", array("category_id" => $data['category_id'], "is_default" => "1", "is_active" => "1"));
				if($query1->num_rows() == 0)
				{
					$query2 = $this->db->get_where("size", array("category_id" => $data['category_id'], "is_active" => "1"));
					$default_size_arr = $query2->result();
					$default_size_id = $default_size_arr[0]->id;
					$update_default_option = array("is_default" => "1");
					$update_default_query = $this->db->where('id', $default_size_id )->update('size', $update_default_option);
				}
			}
		}
		return $return;
	}

    function change_status($id, $table)
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
		    $query1=$this->db->select('*')->from($table)->get();
			$return_data=$query1->result();
			return $return_data;
		}
	}
}
?>