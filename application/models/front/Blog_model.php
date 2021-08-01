<?php
class Blog_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_blog_info($slug)
	{
	    $return = '';
	    $blog_query = $this->db->where("slug",$slug)->get("blog");
	    if($blog_query->num_rows()>0)
	    {
	        $return = $blog_query->row();   
	    }
        return $return;
	}
}
?>