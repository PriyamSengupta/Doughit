<?php
class Address_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

    function add_address($data)
    {
        $return_data = array();
        $insert_array = array(
            'user_id'       =>  $data['user_id'],
            'name'          =>  $data['name'],
            'address_name'  =>  $data['address_name'],
            'phone'         =>  $data['phone'],
            'country_id'    =>  $data['country'],
            'province_id'   =>  $data['province'],
            'zipcode'       =>  $data['zipcode'],
            'landmark'      =>  $data['landmark'],
            'city'          =>  $data['city'],
            'address'       =>  $data['address'],
            'is_active'     =>  '1'
        );

        $insert_query = $this->db->insert('address_book', $insert_array);
        if($insert_query){
            $address_id = $this->db->insert_id();
            $update_query = $this->db->set('is_active', '0')->where('id !=', $address_id)->update('address_book');
            if($update_query){
                $return_query = $this->db->get_where("address_book", array("id" => $address_id));
                $return_data = $return_query->row();
            }
        }
        return $return_data;
    }
 
    function change_default_address($address_id,$user_id)
    {
        $return_data = array();
        $update_query = $this->db->set('is_active', '1')->where('id', $address_id)->update('address_book');
        if($update_query){
            $this->db->set('is_active', '0');
            $this->db->where('id !=', $address_id);
            $this->db->where('user_id', $user_id);
            $update_query = $this->db->update('address_book');
            if($update_query){
                $return_query = $this->db->get_where("address_book", array("id" => $address_id));
                $return_data = $return_query->row();
            }
        }
        return $return_data;
    }
}
?>