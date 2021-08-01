<?php
class Login_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function check_login($data)
	{
		$userdetails = array();
        $return=0;

        $query=$this->db->query("SELECT * FROM pz_admin WHERE email='".$data['loginemail']."'");
		if($query->num_rows()>0)
		{
		    $userdetails = $query->row();
		    if($userdetails->password==md5($data['loginpassword']))
			{
			    $return=$userdetails->id;
			}
		} 
		return $return;
	}
	
	function get_admin_info($admin_id)
    {
        $query=$this->db->query("SELECT * FROM pz_admin WHERE id='".$admin_id."'");
        $admin_name=$query->row()->name;
        
        return $admin_name;
    }

	// function save_verification($user_id,$verificationcode)
	// {
	// 	$data = array(
	// 			   'verification_code' => $verificationcode
	// 			);
	// 	$this->db->where('id', $user_id);
	// 	$return=$this->db->update('business_user', $data);

	// 	return $return;
	// }

	// function change_password($data)
	// {
	// 	$savedata = array(
	// 			   'verification_code' => '',
	// 			   'password' => md5($data['password'])
	// 			);
	// 	$this->db->where('verification_code', $data['verification_code']);
	// 	$return=$this->db->update('business_user', $savedata);

	// 	return $return;
	// }
	// function change_password_fontend($data)
	// {
	// 	$savedata = array(
	// 			   'verification_code' => '',
	// 			   'password' => md5($data['password'])
	// 			);
	// 	$this->db->where('verification_code', $data['verification_code']);
	// 	$return=$this->db->update('business_user', $savedata);

	// 	return $return;
	// }
	// function save_userverification($user_id,$verificationcode)
	// {
	// 	$data = array(
	// 			   'verification_code' => quotes_to_entities($verificationcode)
	// 			);
	// 	$this->db->where('id', $user_id);
	// 	$return=$this->db->update('business_user', $data);

	// 	return $return;
	// }
	// function change_userpassword($data)
	// {
	// 	$savedata = array(
	// 			   'verification_code' => '',
	// 			   'password' => md5($data['password'])
	// 			);
	// 	$this->db->where('verification_code', $data['verification_code']);
	// 	$return=$this->db->update('business_user', $savedata);

	// 	return $return;
	// }


}
?>