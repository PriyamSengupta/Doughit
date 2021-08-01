<?php
class Cart_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

    public function get_cart($user_id)
    {
        $final_array = array();
        $cart_query = $this->db->get_where("cart", array("user_id" => $user_id, "is_active" => '1'));
        if($cart_query->num_rows()>0)
        {
            $sl_no = 1;
            foreach ($cart_query->result() as $cart) {
                $data = array(
                    'product_id'    =>  $cart->product_id,
                    'size_id'       =>  $cart->size_id,
                    'type_array'    =>  unserialize($cart->custom_params)
                );

                $final_price = $this->get_final_price($data);
                if($final_price > 0)
                {
                    $final_array[] = array(
                        'id'            =>  $cart->id,
                        'product_id'    =>  $cart->product_id,
                        'size_id'       =>  $cart->size_id,
                        'quantity'      =>  (int)$cart->quantity,
                        'type_array'    =>  unserialize($cart->custom_params),
                        'price'         =>  $final_price * $cart->quantity
                    );
                }
                $sl_no += 1;
            }
        }
        return $final_array;
    }
 
	// Save user details after successfull registration in users rable
    function add_to_cart($user_id, $data) {
        $final_price = $this->get_final_price($data);
        $result = array();
        $return = false;
        if($final_price != 0)
        {
            $insert_array = array(
                'user_id'       =>  $user_id,
                'product_id'    =>  $data['product_id'],
                'size_id'       =>  $data['size_id'],
                'quantity'      =>  $data['quantity'],
                'custom_params' =>  serialize($data['type_array']),
                'price'         =>  ($final_price * $data['quantity']),
                'is_active'     =>  '1'
            );
            
            $return = $this->db->insert('cart',$insert_array);
            if($return){
                $cart_details_query = $this->db->query("SELECT SUM(quantity) AS quant, SUM(price) AS price FROM pz_cart WHERE is_active='1' AND user_id= '$user_id'");
                $result['price'] = $cart_details_query->row()->price;
                $result['quantity'] = $cart_details_query->row()->quant;
                $result['registered_user'] = 1;
                $result['error'] = 0;
            }
        }
        return $result;
    }

    function get_final_price($data)
    {
        $final_price = 0;
        if(isset($data['type_array']) && (!empty($data['type_array'])))
        {
            $category_id_query = $this->db->get_where("products", array("id" => $data['product_id'], "is_active" => '1'));
            if($category_id_query->num_rows()>0)
            {
                $category_id = $category_id_query->row()->category_id;
                $size_price_query = $this->db->get_where("product_size_price", array("product_id" => $data['product_id'], "size_id" => $data['size_id']));
                if($size_price_query->num_rows()>0)
                {
                    $final_price = $size_price_query->row()->price;
					foreach ($data['type_array'] as $type) {
						$type_exists_query = $this->db->get_where("type", array("id" => $type['type_id'], "category_id" => $category_id, "is_active" => '1'));
						if($type_exists_query->num_rows()>0){
							 
							if($type['multiselect'] == 0)
							{
								if(array_key_exists('type_option_id',$type)){
									$type_option_exists_query = $this->db->get_where("type_options", array("type_id" => $type['type_id'], "id" => $type['type_option_id'], "is_active" => '1'));
									if($type_option_exists_query->num_rows()>0)
									{
										$price_query = $this->db->get_where("product_pricing", array("product_id" => $data['product_id'], "size_id" => $data['size_id'], "type_option_id" => $type['type_option_id']));
										$final_price = $final_price + $price_query->row()->price;
									}
								}
							}
							else
							{
								if(array_key_exists('type_option_id',$type)){
									foreach ($type['type_option_id'] as $type_option) {
										$type_option_exists_query = $this->db->get_where("type_options", array("type_id" => $type['type_id'], "id" => $type_option, "is_active" => '1'));
										if($type_option_exists_query->num_rows()>0)
										{
											$price_query = $this->db->get_where("product_pricing", array("product_id" => $data['product_id'], "size_id" => $data['size_id'], "type_option_id" => $type_option));
											$final_price = $final_price + $price_query->row()->price;
										}
									}
								}	
							}  
						}
					}
                }
            }
        }
        return $final_price;
    }

    function update_cart($cart_arr, $id)
    {
        if($id == 0)
        {
           $return = $this->db->insert('cart',$cart_arr);
        }
        else
        {
            $return = $this->db->where('id', $id)->update('cart', $cart_arr);
        }
        return $return;
    }

    function delete_product_from_cart($id)
    {
        $return = $this->db->where('id', $id)->delete('cart');
        return $return;
    }
}
?>