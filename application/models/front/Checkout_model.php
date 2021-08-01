<?php
class Checkout_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

    function place_order($user_id)
	{
		$return_array = array();
		$count = 0;
		$cart_query = $this->db->get_where("cart", array("user_id" => $user_id, "is_active" => '1'));
		if($cart_query->num_rows()>0)
		{
			$address_query = $this->db->get_where("address_book", array("user_id" => $user_id, "is_active" => '1'));
			if($address_query->num_rows()>0)
			{
				$address_id = $address_query->row()->id;
				$digits = 8;
				$order_number = rand(pow(10, $digits-1), pow(10, $digits)-1);
				$insert_order_array = array(
					'order_number'		=>	$order_number,
					'user_id'			=>	$user_id,
					'address_id'		=>	$address_id,
					'status_id'			=>	1,
					'order_date'		=>	date("Y-m-d"),
					'payment_option'	=>	'COD'
				);
				$insert_query = $this->db->insert('order', $insert_order_array);
				if($insert_query)
				{
					$order_id = $this->db->insert_id();
					foreach ($cart_query->result() as $cart) {
						// $custom_params = unserialize($cart->custom_params);

						$insert_order_details_array = array(
							'order_id'		=>	$order_id,
							'product_id'    =>  $cart->product_id,
							'size_id'       =>  $cart->size_id,
							'quantity'      =>  $cart->quantity,
							'custom_params' =>  $cart->custom_params,
							'price'         =>  $cart->price
						);
						$insert_order_details = $this->db->insert('order_details', $insert_order_details_array);
						if($insert_order_details){
							$this->db->where('id', $cart->id)->delete('cart');
						}
						else{
							$count += 1;
						}
					}
					if($count == 0){
						$order_details_query = $this->db->get_where("order_details", array("order_id" => $order_id));
						$return_array = array(
							'user_id'			=>	$user_id,
							'order_id'			=>	$order_id,
							'order_no'			=>	$order_number,
							'address_id'		=>	$address_id,
							'order_date'		=>	date("Y-m-d"),
							'payment_option'	=>	'COD',
							'order_details'		=>	$order_details_query->result()
						);
					}
				}
			}
		}
		
		return $return_array;
	}

	function update_invoice($invoice_name,$order_id)
	{
		$this->db->set('invoice', $invoice_name)->where('id', $order_id)->update('order');
	}
}
?>