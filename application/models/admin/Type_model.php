<?php
class Type_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

    function get_type_details($id)
    {
        $query = $this->db->get_where("type", array("id" => $id));
		if($query->num_rows()>0)
		{
			$result = $query->row();
			$return=(object)array(
				'id' 			=>	$result->id,
				'name'	        =>	$result->name,
				'category_id'	=>	$result->category_id,
                'description'   =>  $result->description,
				'multiselect'	=>	$result->multiselect,
				'is_mandatory'	=>	$result->is_mandatory,
				'is_active'		=>	$result->is_active,
			);
		}
		else
		{
			$return=(object)array(
					'id' 				=> '',
				   	'name' 				=> '',
					'category_id'		=> '',
                    'description'       => '',
					'multiselect'		=> '0',
					'is_mandatory'		=> '0',
                    'is_active' 		=> '1'
			);
		}
		return $return;
    }
 
    function addedit_type($data)
	{
		if($data['id'] == '')
		{
			$insert_array = array(
				'name'			=>	$data['name'],
				'category_id'	=>  $data['category_id'],
				'description'	=>	$data['description'],
				'multiselect'	=>	$data['multiselect'],
				'is_mandatory'	=>  $data['is_mandatory'],
				'is_active'		=>	'1'
			);
			$return = $this->db->insert('type', $insert_array);
		}
		else{
			$type_id = $data['id'];
			$update_array = array(
				'name'			=>	$data['name'],
				'description'	=>	$data['description'],
				'multiselect'	=>	$data['multiselect'],
				'is_mandatory'	=>	$data['is_mandatory'],
				'category_id'	=>  $data['category_id'],
			);
			$return = $this->db->where('id', $type_id)->update('type', $update_array);
		}
		return $return;
	}

	function get_option_details($id)
	{
		$query = $this->db->get_where("type_options", array("id" => $id));
		if($query->num_rows()>0)
		{
			$result = $query->row();
			$return=(object)array(
				'id' 			=>	$result->id,
				'name'	        =>	$result->name,
                'type_id'   	=>  $result->type_id,
				'is_default'	=>	$result->is_default,
				'image'			=>	$result->image,
			);
		}
		else
		{
			$return=(object)array(
				'id' 			=>	'',
				'name'	        =>	'',
                'type_id'   	=>  '',
				'is_default'	=>	'',
				'image'			=>	'',
			);
		}
		return $return;
	}

	function addedit_option($file_name, $data)
	{
		if($data['id'] == '')
		{
			$insert_array = array(
				'name'			=>	$data['name'],
				'type_id'		=>	$data['type_id'],
				'image'			=>	$file_name,
				'is_active'		=>	'1'
			);
			$return = $this->db->insert('type_options', $insert_array);

			$option_id = $this->db->insert_id();

			$query = $this->db->get_where("type", array("id" => $data['type_id']));
			if($query->row()->is_mandatory == "1")
			{
				if($data['is_default'] == 1)
				{
					$update_default_option = array("is_default" => "0");
					$update_default_query = $this->db->where('type_id', $data['type_id'])->update('type_options', $update_default_option);
					if($update_default_query)
					{
						$update_default_option = array("is_default" => "1");
						$update_default_query = $this->db->where('id', $option_id)->update('type_options', $update_default_option);
					}
				}
				else
				{
					$query1 = $this->db->get_where("type_options", array("type_id" => $data['type_id'], "is_default" => "1"));
					if($query1->num_rows() == 0)
					{
						$query2 = $this->db->get_where("type_options", array("type_id" => $data['type_id']));
						$type_opt_arr = $query2->result();
						$type_opt_id = $type_opt_arr[0]->id;
						$update_default_option = array("is_default" => "1");
						$update_default_query = $this->db->where('id', $type_opt_id )->update('type_options', $update_default_option);
					}
				}
			}
		}
		else{
			$option_id = $data['id'];
			if($file_name=='')
			{
				$update_array = array(
					'name'			=>	$data['name'],
					'type_id'		=>	$data['type_id'],
				);
			}
			else{
				$image_query = $this->db->query("SELECT * FROM pz_type_options WHERE id='".$option_id."'");
		    	$image = $image_query->row()->image;
		    	if($image != "no_image.png")
		    	{
		    		$image_path = $this->config->item('server_absolute_path').'upload/type_option/normal/'.$image;
		    		$thumb_path = $this->config->item('server_absolute_path').'upload/type_option/thumb/'.$image;
				    // Check file exist or not
				    if( file_exists($image_path) && file_exists($thumb_path) )
				    {
				        unlink($image_path);
				        unlink($thumb_path);
					}
		    	}
				$update_array = array(
					'name'			=>	$data['name'],
					'type_id'		=>	$data['type_id'],
					'image'			=>	$file_name
				);
			}
			$return = $this->db->where('id', $option_id)->update('type_options', $update_array);
			$query = $this->db->get_where("type", array("id" => $data['type_id']));
			if($query->row()->is_mandatory == "1")
			{
				if($data['is_default'] == 1)
				{
					$update_default_option = array("is_default" => "0");
					$update_default_query = $this->db->where('type_id', $data['type_id'])->update('type_options', $update_default_option);
					if($update_default_query)
					{
						$update_default_option = array("is_default" => "1");
						$update_default_query = $this->db->where('id', $option_id)->update('type_options', $update_default_option);
					}
				}
				else
				{
					$query1 = $this->db->get_where("type_options", array("type_id" => $data['type_id'], "is_default" => "1"));
					if($query1->num_rows() == 0)
					{
						$query2 = $this->db->get_where("type_options", array("type_id" => $data['type_id']));
						$type_opt_arr = $query2->result();
						$type_opt_id = $type_opt_arr[0]->id;
						$update_default_option = array("is_default" => "1");
						$update_default_query = $this->db->where('id', $type_opt_id )->update('type_options', $update_default_option);
					}
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
		$return=$this->db->update('type', $data_is_active);
		if($return==1)
		{
		    $query1=$this->db->select('*')->from($table)->get();
			$return_data=$query1->result();
			return $return_data;
		}
	}
}
?>