<?php
class Category_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

    function get_category_details($id)
    {
        $query = $this->db->get_where("categories", array("id" => $id));
		if($query->num_rows()>0)
		{
			$result = $query->row();
			$return=(object)array(
				'id' 			=>	$result->id,
				'name'	        =>	$result->name,
                'description'   =>  $result->description,
                'image'         =>  $result->image,
				'is_active'		=>	$result->is_active,
			);
		}
		else
		{
			$return=(object)array(
					'id' 				=> '',
				   	'name' 				=> '',
                    'description'       => '',
                    'image'             => '',
                    'is_active' 		=> '1'
			);
		}
		return $return;
    }

    function addedit_category($file_name, $data)
    {
        if($data['id'] == '')
		{
			$insert_array = array(
				'name'			=>	$data['name'],
				'description'	=>	$data['description'],
				'image'			=>	$file_name,
				'is_active'		=>	'1'
			);
			$return = $this->db->insert('categories', $insert_array);
            $category_id = $this->db->insert_id();
		}
        else 
        {
            $category_id = $data['id'];
			if($file_name=='')
			{
				$update_array = array(
					'name'			=>	$data['name'],
					'description'	=>	$data['description']
				);
			}
			else{
				$image_query = $this->db->query("SELECT * FROM pz_categories WHERE id='".$category_id."'");
		    	$image = $image_query->row()->image;
		    	if($image != "no_image.png")
		    	{
		    		$image_path = $this->config->item('server_absolute_path').'upload/categories/normal/'.$image;
		    		$thumb_path = $this->config->item('server_absolute_path').'upload/categories/thumb/'.$image;
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
					'image'			=>	$file_name
				);
			}
			$return = $this->db->where('id', $category_id)->update('categories', $update_array);
        }
        return $return;
    }

    function change_status($id, $table)
	{	    
	    $query=$this->db->get_where($table, array("id" => $id));

        if($query->row()->is_active == 1)
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