<?php
require(APPPATH.'/libraries/REST_Controller.php');
class Edit_favorites extends REST_Controller {
	public $error = array();
	function __construct() {
				parent::__construct();
				$this->load->helper('form');
				$this->load->helper('html');
				$this->load->helper('url');
                $this->load->driver('session');
				$this->load->model('api_model');		
        		$this->load->database();
	}

	function index_post()
	{
		$return  = $this->api_model->edit_favorites($_POST);	
		$this->set_response('application/json');
		$this->response($return);	
	} 
}
?>