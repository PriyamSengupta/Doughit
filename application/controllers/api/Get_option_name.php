<?php
require(APPPATH.'/libraries/REST_Controller.php');
class Get_option_name extends REST_Controller {
	public $error = array();
	function __construct() {
				parent::__construct();
                $this->load->driver('session');
				$this->load->helper('form');
				$this->load->helper('html');
				$this->load->helper('url');
				$this->load->model('main_model');
                $this->load->model('api_model');	
        		$this->load->database();
	}

	function index_post()
	{
        $access_token = $this->input->post('access_token');
        $option_id = $this->input->post('option_id');

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
            $user_id = $details->id;
            $getdata = array();

            $getdata['table_name'] = 'type_options';
            $getdata['field_name'] = '*';
            $getdata['condition'] = array('id'=> $option_id, 'is_active' => '1');
            $getdata['sortorder'] = array();
            $getdata['groupbyorder'] = array();
            $getdata['searchvalue'] = array();
            $getdata['getvalue'] = 0;
            $getdata['limit'] = 0;
            $getdata['start'] = 0;
            $getdata['join'] = array();
            $name_details = $this->main_model->get_full_details($getdata);

            if(!empty($name_details)){
                $return_array['name'] = $name_details->name;
                $return_array['status'] =array( 
                    "message"   =>  "Success",
                    'err_code'  =>  200
                );
            }
            else{
                $return_array['name'] = "";
                $return_array['status'] =array(
                    "message"   =>  "No Data Found",
                    'err_code'  =>  404
                );
            }
        }
        else{
            $return_array['name'] = "";
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