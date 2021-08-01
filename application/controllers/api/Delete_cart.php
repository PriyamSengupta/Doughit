<?php
require(APPPATH.'/libraries/REST_Controller.php');
class Delete_cart extends REST_Controller {
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
        $cart_id = $this->input->post('cart_id');

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
            $response = $this->api_model->delete_cart($cart_id);
            if($response){
                $return_array['status'] =array(
                    "message"	=>	"success",
                    'err_code'	=>	200
                );
            }
            else{
                $return_array['status'] =array(
                    "message"	=>	"No Data Found",
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