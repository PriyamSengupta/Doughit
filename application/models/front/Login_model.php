<?php
class Login_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// Save user details after successfull registration in users rable
    function save_user($data) {
		//$name = $data['first_name'].' '.$data['last_name'];
        $savedata = array(
            'id' => '', 
            'fname' => ucfirst($data['first_name']),
            'lname' => ucfirst($data['last_name']),
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => md5($data['password']),
            //'registration_time' => date("Y-m-d H:i:s"),
            'is_active' => '1'
        );
        $this->db->insert('business_user', $savedata);
        $return = $this->db->insert_id();
        return $return;
    }
	function check_login($data) {
        // Get admin details from admin table
        $getdata = array();
        $getdata['table_name'] = 'business_user';
        $getdata['field_name'] = '*';
        $getdata['condition'] = array('email' => $data['login_email']);
        $getdata['sortorder'] = array();
        $getdata['groupbyorder'] = array();
        $getdata['searchvalue'] = array();
        $getdata['getvalue'] = 0;
        $getdata['limit'] = 0;
        $getdata['start'] = 0;
        $getdata['join'] = array();
        $userdetails = $this->main_model->get_full_details($getdata);
        $return = array();
        if (count($userdetails) >0 && $userdetails->id != '') {
            if ($userdetails->password == md5($data['login_password'])) {
                if($userdetails->is_active == '1') {
                    $return['error_code'] = "Success";
                    $return['message'] = "You have logged in.";
                    $return['id'] = $userdetails->id;
                    $return['name'] = $userdetails->fname." ".$userdetails->lname;
                } else {
                    $return['error_code'] = "Error";
                    $return['message'] = "You haven't activated your account yet. To activate please click on the verify link of your provided email address.";
                    $return['id'] = 0;
                    $return['name'] = $userdetails->fname." ".$userdetails->lname;
                }
            } else {
                $return['error_code'] = "Error";
                $return['message'] = "Invalid Credentials.";
                $return['id'] = 0;
                $return['name'] = '';
            }
        } else {
            $return['error_code'] = "Error";
            $return['message'] = "Invalid Credentials.";
            $return['id'] = 0;
            $return['name'] = '';
        }
        $return = json_decode(json_encode($return));
        return $return;
    }
    
    function save_verification($user_id,$verificationcode)
	{
		$data = array(
				   'verification_code' => $verificationcode
				);
		$this->db->where('id', $user_id);
		$return=$this->db->update('business_user', $data);

		return $return;
	}
	
	function change_password($data)
	{
		$savedata = array(
				   'verification_code' => '',
				   'password' => md5($data['password'])
				);
		$this->db->where('verification_code', $data['verification_code']);
		$return=$this->db->update('business_user', $savedata);

		return $return;
	}
}
?>