<?php
class Booking_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

    function booking($data)
    {
        $insert_array = array(
            'name'          =>  $data['name'],
            'email'         =>  $data['email'],
            'phone'         =>  $data['phone'],
            'person_count'  =>  $data['person_count'],
            'date'          =>  $data['date'],
            'time'          =>  $data['time'],
            'comment'       =>  $data['comment']
        );

        $return = $this->db->insert("online_booking", $insert_array);
        return $return;
    }
}
?>