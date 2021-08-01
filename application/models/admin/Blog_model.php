<?php
class Blog_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
    function get_blog_details($id)
	{
		$query = $this->db->get_where("blog", array("id" => $id));
		if($query->num_rows()>0)
		{
			$result = $query->row();
			$return=(object)array(
				'id'			=>	$result->id,
                'image'			=>	$result->image,
                'is_active'		=>	$result->is_active,
                'title'			=>	$result->title,
                'time'			=>	date("F j, Y", strtotime($result->time)),
                'content'		=>	$result->content
			);
		}
		else
		{
			$return=(object)array(
				'id'			=>	'',
                'image'			=>	'',
                'is_active'		=>	'',
                'title'			=>	'',
                'time'			=>	'',
                'content'		=>	''
			);
		}
		return $return;
	}

    function addedit_blog($file_name, $data)
	{
        $date_field=date("Y-m-d H:i:s");
		if($data['id'] == '')
		{
            $other_blog_name_query = $this->db->query("SELECT * FROM pz_blog WHERE title='".$data['title']."'");
		    if($other_blog_name_query->num_rows() > 0)
		    {
		       $i = $other_blog_name_query->num_rows();
		       $new_blog_name = $data['title'].$i++;
		       $slug = $this->slug_url($new_blog_name);
		    }
		    else
		    {
		       $new_blog_name = $data['title'];
		       $slug = $this->slug_url($new_blog_name);
		    }
			$insert_array = array(
				'title'		    =>	$data['title'],
				'content'		=>	$data['content'],
				'slug'          =>  $slug,
				'image'			=>	$file_name,
				'is_active'		=>	'1',
                'time'			=>	$date_field
			);
			$return = $this->db->insert('blog', $insert_array);
		}
		else{
            $blog_id = $data['id'];
            $check_blog_name_query = $this->db->where("id",$blog_id)->get("blog");
		    if($check_blog_name_query->row()->title != $data['title'] )
		    {
		        $other_blog_name_query = $this->db->query("SELECT * FROM pz_blog WHERE id !='".$blog_id."' AND title='".$data['title']."'");
		        if($other_blog_name_query->num_rows() > 0)
		        {
		            $i = $other_blog_name_query->num_rows();
		            $new_blog_name = $data['title'].$i++;
		            $slug = $this->slug_url($new_blog_name);
		        }
		        else
		        {
		            $new_blog_name = $data['title'];
		            $slug = $this->slug_url($new_blog_name);
		        }
		    }
		    else
		    {
		        $new_blog_name = $data['title'];
		        $slug = $this->slug_url($new_blog_name);
		    }
			
			if($file_name=='')
			{
				$update_array = array(
					'title'				=>	$data['title'],
					'content'			=>	$data['content'],
					'slug'               => $slug
				);
			}
			else{
		    	$image =  $check_blog_name_query->row()->image;
		    	if($image != "no_image.png")
		    	{
		    		$image_path = $this->config->item('server_absolute_path').'upload/blog/normal/'.$image;
		    		$thumb_path = $this->config->item('server_absolute_path').'upload/blog/thumb/'.$image;
				    // Check file exist or not
				    if( file_exists($image_path) && file_exists($thumb_path) )
				    {
				        unlink($image_path);
				        unlink($thumb_path);
					}
		    	}
				$update_array = array(
					'title'				=>	$data['title'],
					'content'			=>	$data['content'],
					'slug'               => $slug,
					'image'				=>	$file_name
				);
			}
			$return = $this->db->where('id', $blog_id)->update('blog', $update_array);
		}
		return $return;
	}

    function slug_url($text)
    {
      $text = preg_replace('~[^\pL\d]+~u', '-', $text);
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
      $text = preg_replace('~[^-\w]+~', '', $text);
      $text = trim($text, '-');
      $text = preg_replace('~-+~', '-', $text);
      $text = strtolower($text);
      if (empty($text)) {
         return 'n-a';
      }
        return $text;
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