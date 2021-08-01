<?php
class Main_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function get_full_details($data) {
        if ($data['limit'] > 0) {
            $this->db->limit($data['limit'], $data['start']);
        }
        if (count($data['sortorder']) > 0) {
            foreach ($data['sortorder'] as $sortorder1) {
                $this->db->order_by($sortorder1[0], $sortorder1[1]);
            }
        }
        $this->db->group_by($data['groupbyorder']);
        if (count($data['searchvalue']) > 0) {
            foreach ($data['searchvalue'] as $searchvalue1) {
                $this->db->like($searchvalue1[0], $searchvalue1[1], 'both');
            }
        }
        $fulldetails = $this->db->select($data['field_name'])->get_where($data['table_name'], $data['condition']);
        if ($fulldetails->num_rows() > 0) {
            if ($data['getvalue'] != 0) {
                $return = $fulldetails->result_object();
            } else {
                $return = $fulldetails->row();
            }
        } else {
            $return = array();
        }
        return $return;
    }
    function record_count($data) {
        $this->db->group_by($data['groupbyorder']);
        if (count($data['searchvalue']) > 0) {
            foreach ($data['searchvalue'] as $searchvalue1) {
                $this->db->like($searchvalue1[0], $searchvalue1[1], 'both');
            }
        }
        $fulldetails = $this->db->get_where($data['table_name'], $data['condition']);
        return $fulldetails->num_rows();
    }

    public function get_full_details_table($table) {
		$query = $this->db->get($table);
		$result = $query->result();
		return $result;
	}
}