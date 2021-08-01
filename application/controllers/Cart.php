<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->database();

		$this->load->helper('form');
		$this->load->helper('html');
        $this->load->helper('url');
		$this->load->helper('cookie');
		$this->load->helper('date');
		$this->load->helper('string');

		$this->load->model('front/cart_model','cart_model');
		$this->load->model('main_model');

		$this->load->library('email');
		$this->load->library('layout_front');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('session');

		$config['protocol'] = 'mail';
		$config['wordwrap'] = TRUE;
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$this->email->initialize($config);
	}

	public function index()
	{
		if($this->session->userdata('doughit_userid')){
			$return = $this->cart_model->get_cart($this->session->userdata('doughit_userid'));
			$viewdata['carts'] = $return;
			$viewdata['mainheader']= "Shopping Cart";
			$this->layout_front->view('/front/cart/index',$viewdata);
		}
		else
		{
			if(!empty($_COOKIE['cart'])) {
				$viewdata['carts'] = json_decode($_COOKIE['cart'], true);
				//$return = $this->cart_model->get($user_id='', $this->input->post());
				$viewdata['mainheader']= "Shopping Cart";
			    $this->layout_front->view('/front/cart/index',$viewdata);
			} else {
				$viewdata['carts'] = array();
				//$return = $this->cart_model->get($user_id='', $this->input->post());
				$viewdata['mainheader']= "Shopping Cart";
			    $this->layout_front->view('/front/cart/index',$viewdata);
			}
		}
	}

    public function add_to_cart()
    {
        // echo "<pre>";
        // print_r($this->input->post());
        if($this->session->userdata('doughit_userid')) {
			$user_id = $this->session->userdata('doughit_userid');
			$return = $this->cart_model->add_to_cart($user_id, $this->input->post());
			$return = json_encode($return);
			echo $return;
			die();
        }
        else
        {
			$cookiename = "cart";

			$cart = array();

			if(!empty($_COOKIE[$cookiename])) {
				
				$cart = json_decode($_COOKIE[$cookiename], true);
			}

			
			array_push($cart, $this->input->post());

			$return = setcookie($cookiename, json_encode($cart), time() + (86400*7), "/");
			
			if($return){
				$result['registered_user'] = 0;
				$result['error'] = 0;
			}
			else
			{
				$result['error'] = 1;
			}
			$result = json_encode($result);
			echo $result;
			die();
        }
    }

	public function update_cart()
	{
		$id = $this->input->post('id');
		$cookiename = 'cart';
		//echo "<pre>"; print_r($this->input->post('cart_array')); die();
		$cart_array = $this->input->post('cart_array');
		
		if($this->session->userdata('doughit_userid')){
			if($id == 0)
			{
				if(!empty($cart_array)){
					$updated_quantity = 0;
					foreach ($cart_array as $key => $data) {
						$cart_arr = array(
							'user_id'       =>  $this->session->userdata('doughit_userid'),
							'product_id'    =>  $data['product_id'],
							'size_id'       =>  $data['size_id'],
							'quantity'      =>  $data['quantity'],
							'custom_params' =>  serialize($data['type_array']),
							'price'         =>  $data['price'],
							'is_active'     =>  '1'
						);
						$updated_quantity = $updated_quantity + $data['quantity'];
						$insert_to_cart_db = $this->cart_model->update_cart($cart_arr, $id);
						if($insert_to_cart_db)
						{
							unset($cart_array[$key]);
						}
					}
					
					if (empty($cart_array)) {
						unset($_COOKIE[$cookiename]); 
						setcookie($cookiename, null, -1, '/');
						$error = 0;
					}
					else{
						$error = 1;
					}
				}
			}
			else
			{
				if(!empty($cart_array)){
					$updated_quantity = 0;
					foreach ($cart_array as $key => $data) {
						$updated_quantity = $updated_quantity + $data['quantity'];
						if($id == $data['id']){
							$cart_arr = array(
								'user_id'       =>  $this->session->userdata('doughit_userid'),
								'product_id'    =>  $data['product_id'],
								'size_id'       =>  $data['size_id'],
								'quantity'      =>  $data['quantity'],
								'custom_params' =>  serialize($data['type_array']),
								'price'         =>  $data['price'],
								'is_active'     =>  '1'
							);
						}
					}
					$update_cart_db = $this->cart_model->update_cart($cart_arr, $id);
					if($update_cart_db){
						$error = 0;
					} else {
						$error = 1;
					}
				}
			}
			$returndata['quantity'] = $updated_quantity;
			$returndata['error'] = $error;
		}
		else{
			if($id == 0)
			{
				if(!empty($cart_array)){
					$updated_quantity = 0;
					foreach ($cart_array as $key => $data) {
						$cart_arr[] = array(
							'quantity'      =>  $data['quantity'],
							'product_id'    =>  $data['product_id'],
							'final_price'   =>  $data['price'],
							'size_id'       =>  $data['size_id'],
							'type_array' 	=>  $data['type_array'],
						);
						$updated_quantity = $updated_quantity + $data['quantity'];
					}
					$return = setcookie($cookiename, json_encode($cart_arr), time() + (86400*7), "/");
				}
			}
			else
			{
				$cookie_cart = array();
				if(!empty($_COOKIE[$cookiename])) {
					
					$cookie_cart = json_decode($_COOKIE[$cookiename], true);
				}
				if(!empty($cart_array)){
					$updated_quantity = 0;
					foreach ($cart_array as $key => $data) {
						$cookie_cart[] = array(
							'quantity'      =>  $data['quantity'],
							'product_id'    =>  $data['product_id'],
							'final_price'   =>  $data['price'],
							'size_id'       =>  $data['size_id'],
							'type_array' 	=>  $data['type_array'],
						);
						$updated_quantity = $updated_quantity + $data['quantity'];
					}
					$return = setcookie($cookiename, json_encode($cookie_cart), time() + (86400*7), "/");
				}
			}
			if($return)
			{
				$returndata['quantity'] = $updated_quantity;
				$returndata['error'] = 0;
			}
			else
			{
				$returndata['quantity'] = $updated_quantity;
				$returndata['error'] = 1;
			}
		}
		$return_msg = json_encode($returndata);
		echo $return_msg;
		die();
	}

	public function delete_product_from_cart()
	{
		$id = $this->input->post('id');
		$key = $this->input->post('key');
		$cart_array = $this->input->post('cart_array');
		$cookiename = 'cart';
		if($id != 0){
			if($this->session->userdata('doughit_userid')){
				$return = $this->cart_model->delete_product_from_cart($id);
				if($return){
					$return = $this->cart_model->get_cart($this->session->userdata('doughit_userid'));
					$viewdata['carts'] = $return;
					$viewdata['err_code'] = 0;	//no error
					$viewdata=$this->load->view('/front/cart/ajaxData',$viewdata);
					return $viewdata;
				}
				else{
					return 0;
				}
			}
			else{
				return -1;
			}
		}
		else{
			array_splice($cart_array, $key, 1);
			if(count($cart_array)>0){
				foreach ($cart_array as $data) {
					$cookie_cart[] = array(
						'quantity'      =>  $data['quantity'],
						'product_id'    =>  $data['product_id'],
						'final_price'   =>  $data['price'],
						'size_id'       =>  $data['size_id'],
						'type_array' 	=>  $data['type_array'],
					);
				}
				$return = setcookie($cookiename, json_encode($cookie_cart), time() + (86400*7), "/");
				if($return){
					$viewdata['carts'] = $cookie_cart;
					$viewdata=$this->load->view('/front/cart/ajaxData',$viewdata);
					return $viewdata;
				}
				else{
					return 0;
				}
			}
			else{
				unset($_COOKIE['cart']); 
				$return = setcookie($cookiename, null, -1, '/');
				if($return){
					$viewdata['carts'] = array();
					$viewdata=$this->load->view('/front/cart/ajaxData',$viewdata);
					return $viewdata;
				}
				else{
					return 0;
				}
			}
		}
	}
}
?>