<?php
require(APPPATH.'/libraries/REST_Controller.php');
class Order_status extends REST_Controller {
	public $error = array();
	function __construct() {
				parent::__construct();
                $this->load->driver('session');
				$this->load->helper('form');
				$this->load->helper('html');
				$this->load->helper('url');
				$this->load->model('api_model');		
        		$this->load->database();
	}

	function index_get()
	{
		$return  = $this->api_model->order_status();	
		$this->set_response('application/json');
		$this->response($return);	
	} 
}
?>