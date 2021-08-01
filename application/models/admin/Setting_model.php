<?php
class Setting_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}

    function get_details()
    {
    	$return = array();
    	$query=$this->db->query("SELECT * FROM pz_site_settings WHERE id='1'");

		if($query->num_rows()>0)
		{
			$return=$query->row();
		}
		else
		{
			$return = (object)array(
				'address' 			=> '',
				'description'		=> '',
				'telephone'			=> '',
				'mobile' 			=> '',
				'admin_email'		=> '',
				'site_email'		=> '',
				'facebook' 			=> '',
				'instagram'			=> '',
				'twitter'			=> '',
				'linkedin'			=> '',
				'request_call_one' 	=> '',
				'request_call_two'	=> '',
				'logo'				=> '',
				'iframe'			=> ''
			);
		}
		return $return;
    }

    function addedit_setting($data,$file_name)
	{
		$return = array();
		$date_field=date("Y-m-d H:i:s");
		if($data['id']!='')
		{

			if($file_name=='')
			{
				$update_data = array(
					   	'address' 			=> $data['address'],
					   	'description' 		=> $data['description'],
						'telephone'			=> $data['telephone'],
						'mobile' 			=> $data['mobile'],
						// 'admin_email'		=> $data['admin_email'],
						'site_email'		=> $data['site_email'],
						'facebook' 			=> $data['facebook'],
						'instagram'			=> $data['instagram'],
						'twitter'			=> $data['twitter'],
						'linkedin'			=> $data['linkedin'],
						// 'request_call_one' 	=> $data['request_call_one'],
						// 'request_call_two'	=> $data['request_call_two'],
						'iframe'			=> $data['iframe']	
					);	
			}
			else
			{
				$logo_query = $this->db->query("SELECT * FROM pz_site_settings WHERE id='".$data['id']."'");
		    	$logo = $logo_query->row()->logo;
		    	if($logo != "no_image.jpg")
		    	{
		    		$logo_path = $this->config->item('server_absolute_path').'upload/logo/'.$logo;
		    	
				    // Check file exist or not
				    if( file_exists($logo_path) )
				    {
				        unlink($logo_path);
					}
		    	}
				
				$update_data = array(
					    'address' 			=> $data['address'],
					    'description' 		=> $data['description'],
						'telephone'			=> $data['telephone'],
						'mobile' 			=> $data['mobile'],
						// 'admin_email'		=> $data['admin_email'],
						'site_email'		=> $data['site_email'],
						'facebook' 			=> $data['facebook'],
						'instagram'			=> $data['instagram'],
						'twitter'			=> $data['twitter'],
						'linkedin'			=> $data['linkedin'],
						// 'request_call_one' 	=> $data['request_call_one'],
						// 'request_call_two'	=> $data['request_call_two'],
						'iframe'			=> $data['iframe'],
					    'logo' 				=> $file_name
					);		
			}

			$this->db->where('id', $data['id']);
			$return=$this->db->update('site_settings', $update_data);
		}
		return $return;
	}
}
?>