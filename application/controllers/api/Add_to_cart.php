<?php
require(APPPATH.'/libraries/REST_Controller.php');
class Add_to_cart extends REST_Controller {
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
		// $return  = $this->api_model->add_to_cart($_POST);	
		$data = json_decode(file_get_contents('php://input'), true);

		$access_token = $data['access_token'];
		// $type_array = serialize($data['type_array']);
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
            
            $cart_response = $this->api_model->add_to_cart($details->id,$data);
            if($cart_response){
                $return_array['status'] =array(
                    "message"	=>	"Added to cart",
                    'err_code'	=>	200
                );
            }
            else{
                $return_array['status'] =array(
                    "message"	=>	"Error Occured",
                    'err_code'	=>	500
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