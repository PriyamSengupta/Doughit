<?php
class Chef_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
    function get_chef_details($id)
	{
		$query = $this->db->get_where("chef", array("id" => $id));
		if($query->num_rows()>0)
		{
			$result = $query->row();
			$return=(object)array(
				'id' 			=>	$result->id,
				'fname'	        =>	$result->fname,
				'lname'	        =>	$result->lname,
                'expertise'     =>  $result->expertise,
				'image'			=>	$result->image
			);
		}
		else
		{
			$return=(object)array(
				'id' 			=>	'',
				'fname'	        =>	'',
                'lname'	        =>	'',
                'expertise'     =>  '',
                'description'   =>  '',
				'image'			=>	'',
				'category_id'	=>	''
			);
		}
		return $return;
	}

    function addedit_chef($file_name, $data)
	{
		if($data['id'] == '')
		{
			$insert_array = array(
				'fname'			=>	$data['fname'],
                'lname'			=>	$data['lname'],
				'expertise'	    =>	$data['expertise'],
				'image'			=>	$file_name,
				'is_active'		=>	'1'
			);
			$return = $this->db->insert('chef', $insert_array);
		}
		else{
			$chef_id = $data['id'];
			if($file_name=='')
			{
				$update_array = array(
					'fname'			=>	$data['fname'],
                    'lname'			=>	$data['lname'],
				    'expertise'	    =>	$data['expertise'],
				);
			}
			else{
				$image_query = $this->db->query("SELECT * FROM pz_chef WHERE id='".$chef_id."'");
		    	$image = $image_query->row()->image;
		    	if($image != "no_image.png")
		    	{
		    		$image_path = $this->config->item('server_absolute_path').'upload/chef/normal/'.$image;
		    		$thumb_path = $this->config->item('server_absolute_path').'upload/chef/thumb/'.$image;
				    // Check file exist or not
				    if( file_exists($image_path) && file_exists($thumb_path) )
				    {
				        unlink($image_path);
				        unlink($thumb_path);
					}
		    	}
				$update_array = array(
					'fname'			=>	$data['fname'],
                    'lname'			=>	$data['lname'],
				    'expertise'	    =>	$data['expertise'],
					'image'			=>	$file_name
				);
			}
			$return = $this->db->where('id', $chef_id)->update('chef', $update_array);
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