<?php
require(APPPATH.'/libraries/REST_Controller.php');
class My_address extends REST_Controller {
	public $error = array();
	function __construct() {
				parent::__construct();
                $this->load->driver('session');
				$this->load->helper('form');
				$this->load->helper('html');
				$this->load->helper('url');
				$this->load->model('main_model');		
        		$this->load->database();
	}

	function index_post()
	{
        $access_token = $this->input->post('access_token');

		$getdata = array();

        $getdata['table_name'] = 'business_user';
		$getdata['field_name'] = '*';
		$getdata['condition'] = array('access_token'=> $access_token, 'is_active' => '1');
		$getdata['sortorder'] = array();
		$getdata['groupbyorder'] = array();
		$getdata['searchvalue'] = array();
		$getdata['getvalue'] = 0;
		$getdata['limit'] = 0;
		$getdata['start'] = 0;
		$getdata['join'] = array();
        $details = $this->main_model->get_full_details($getdata);

        if(!empty($details)){
            $getdata = array();
            $getdata['table_name'] = 'address_book';
            $getdata['field_name'] = '*';
            $getdata['condition'] = array('user_id'=> $details->id, 'is_delete'=>'0');
            $getdata['sortorder'] = array();
            $getdata['groupbyorder'] = array();
            $getdata['searchvalue'] = array();
            $getdata['getvalue'] = 1;
            $getdata['limit'] = 0;
            $getdata['start'] = 0;
            $getdata['join'] = array();
            $address_details = $this->main_model->get_full_details($getdata);
            if(count($address_details)>0){
                $return_array['address'] = $address_details;
                $return_array['status'] =array(
                    "message"	=>	"success",
                    'err_code'	=>	200
                );
            }
            else{
                $return_array['address'] = array();
                $return_array['status'] =array(
                    "message"	=>	"No data found",
                    'err_code'	=>	404
                );
            }
        }
        else{
            $return_array['status'] =array(
                "message"	=>	"Invalid Token",
                'err_code'	=>	500
            );
        }
		$this->set_response('application/json');
		$this->response($return_array);	
	} 
}
?>