<?php
require(APPPATH.'/libraries/REST_Controller.php');
class Place_order extends REST_Controller {
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
            
            $response = $this->api_model->place_order($details->id);
            if(!empty($response)){
                if($response['err_code'] == 200)
                {
                    $return_array['order_number']  = $response['order_number'];
                    $return_array['status'] =array(
                        "message"   =>  "Your order has been placed successfully",
                        'err_code'  =>  $response['err_code']
                    );
                }
                else{
                    $return_array['order_number']  = "";
                    $return_array['status'] =array(
                        "message"   =>  "Error Occured",
                        'err_code'  =>  $response['err_code']
                    );
                }
            }
            else{
                $return_array['order_number']  = "";
                $return_array['status'] =array(
                    "message"	=>	"Error Occured",
                    'err_code'	=>	500
                );
            }
        }
        else{
            $return_array['order_number']  = "";
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