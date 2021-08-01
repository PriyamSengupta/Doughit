<?php
class Order_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

    function get_order_details()
    {
        $return = array();
        $query = $this->db->query("SELECT * FROM pz_order ORDER BY id DESC");
        if($query->num_rows()>0){
            $return = $query->result();
        }
        return $return;
    }

    function change_order_status($data)
    {
        $return = array();
        $update_query = $this->db->set('status_id', $data['status_id'])->where('id', $data['order_id'])->update('order');
        if($update_query){
            $return = $this->get_order_details();
        }
        return $return;
    }
}
?>