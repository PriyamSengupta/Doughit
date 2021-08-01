<?php if ( ! defined('BASEPATH')) exit('No direct script access
allowed');

if ( ! function_exists('get_login_id'))

{
	function get_login_id()

	{

		$CI = & get_instance();  //get instance, access the CI superobject

		$isLoggedIn = $CI->session->all_userdata();

		//print_r($isLoggedIn);

		if(!empty($isLoggedIn))

		{

		  $isLoggedIn_id=$isLoggedIn['pz_admin_userid'];

		}else{

		  $isLoggedIn_id=0;

		}

		return $isLoggedIn_id;

	}
}


if ( ! function_exists('get_banner'))

{
    function get_banner($page_id)
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    
	    $query=$CI->db->query("SELECT * FROM sc_banner WHERE page_id='$page_id'");
	    $results=$query->result();
	    foreach ($results as $result) {
	    	$banner[] = (object)array(
	    		"image"	=>	base_url()."upload/banner/normal/".$result->image
	    	); 
	    }
	    return $banner;
	}
}

if ( ! function_exists('get_pages_admin'))

{
    function get_pages_admin()
	{
		$results = array();
	    $CI = & get_instance();  //get instance, access the CI superobject
	    
	    $query=$CI->db->query("SELECT * FROM pz_pages WHERE is_cms='1'");
	    $results=$query->result();
	    
	    return $results;
	}
}
if ( ! function_exists('get_site_settings'))

{
    function get_site_settings($id)
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    
	    $query=$CI->db->query("SELECT * FROM pz_site_settings WHERE id='$id'");
	    $results=$query->row();
	    
	    return $results;
	}
}

if ( ! function_exists('get_type'))

{
    function get_type($id)
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    
	    $query=$CI->db->query("SELECT * FROM pz_type WHERE id='$id'");
	    $results=$query->row()->name;
	    
	    return $results;
	}
}

if ( ! function_exists('get_types'))

{
    function get_types()
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    
	    $query=$CI->db->query("SELECT * FROM pz_type WHERE is_active='1'");
	    $results=$query->result();
	    
	    return $results;
	}
}

if ( ! function_exists('get_category_type'))

{
    function get_category_type($id)
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $array = array();
	    $query=$CI->db->query("SELECT * FROM pz_category_to_type WHERE category_id='$id'");
	    if($query->num_rows()>0)
		{
			$results=$query->result();
			foreach($results as $result)
			{
				array_push($array, $result->type_id);
			}
		}
	    return $array;
	}
}

if ( ! function_exists('get_category_by_id'))

{
    function get_category_by_id($id)
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $query=$CI->db->query("SELECT * FROM pz_categories WHERE id='$id'");
	    if($query->num_rows()>0)
		{
			$results=$query->row();
		} else {
			$results= array();
		}
	    return $results;
	}
}

if ( ! function_exists('get_categories'))

{
    function get_categories()
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $results = array();
	    $query=$CI->db->query("SELECT * FROM pz_categories");
	    if($query->num_rows()>0)
		{
			$results=$query->result();
		}
	    return $results;
	}
}
if ( ! function_exists('get_products'))

{
    function get_products()
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $results = array();
	    $query=$CI->db->query("SELECT * FROM pz_products WHERE is_active='1'");
	    if($query->num_rows()>0)
		{
			$results=$query->result();
		}
	    return $results;
	}
}


if ( ! function_exists('get_food_category_by_id'))

{
    function get_food_category_by_id($id)
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $query=$CI->db->query("SELECT * FROM pz_food_category WHERE id='$id'");
	    if($query->num_rows()>0)
		{
			$results=$query->row();
		} else {
			$results= array();
		}
	    return $results;
	}
}

if ( ! function_exists('get_food_categories'))

{
    function get_food_categories()
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $results = array();
	    $query=$CI->db->query("SELECT * FROM pz_food_category");
	    if($query->num_rows()>0)
		{
			$results=$query->result();
		}
	    return $results;
	}
}

if ( ! function_exists('get_category_sizes'))

{
    function get_category_sizes($id)
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $results = array();
	    $query=$CI->db->query("SELECT * FROM pz_size WHERE category_id='$id' AND is_active='1'");
	    if($query->num_rows()>0)
		{
			$results=$query->result();
		}
	    return $results;
	}
}

if ( ! function_exists('get_category_addon'))

{
    function get_category_addon($id)
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $type_array = array();
	    $query=$CI->db->query("SELECT * FROM pz_type WHERE category_id='$id' AND is_active='1' AND name NOT LIKE '%topping%' AND name NOT LIKE '%sauce%'");
	    if($query->num_rows()>0)
		{
			$results=$query->result();
			foreach($results as $result)
			{
				$type_option_query=$CI->db->query("SELECT * FROM pz_type_options WHERE type_id='$result->id'");
				$type_options = array();
				if($type_option_query->num_rows()>0)
				{
					$type_results=$type_option_query->result();
					foreach($type_results as $type)
					{
						$type_options[] = (object)array(
							'id'	=>	$type->id,
							'name'	=>	$type->name
						);
					}
				}
				$type_array[] = (object)array(
					'id'			=>	$result->id,
					'name'			=>	$result->name,
					'type_option'	=>	$type_options
				);
			}
		}
	    return $type_array;
	}
}

if ( ! function_exists('get_category_to_type'))

{
    function get_category_to_type($id)
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $type_array = array();
	    $query=$CI->db->query("SELECT ty.id, ty.name FROM pz_category_to_type ctt INNER JOIN pz_type ty ON ctt.type_id = ty.id WHERE ctt.category_id='$id' AND ty.name NOT LIKE '%topping%' AND ty.name NOT LIKE '%sauce%'");
	    if($query->num_rows()>0)
		{
			$results=$query->result();
			foreach($results as $result)
			{
				$type_option_query=$CI->db->query("SELECT * FROM pz_type_options WHERE type_id='$result->id'");
				$type_options = array();
				if($type_option_query->num_rows()>0)
				{
					$type_results=$type_option_query->result();
					foreach($type_results as $type)
					{
						$type_options[] = (object)array(
							'id'	=>	$type->id,
							'name'	=>	$type->name
						);
					}
				}
				$type_array[] = (object)array(
					'id'			=>	$result->id,
					'name'			=>	$result->name,
					'type_option'	=>	$type_options
				);
			}
		}
	    return $type_array;
	}
}

if ( ! function_exists('get_product_size'))

{
    function get_product_size($id)
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $size_array = array();
	    $query=$CI->db->query("SELECT sz.id, sz.name, sz.image, sz.is_default FROM pz_size sz INNER JOIN pz_products pr ON sz.category_id = pr.category_id WHERE pr.id='$id' AND pr.is_active='1' AND sz.is_active='1'");
	    if($query->num_rows()>0)
		{
			$results=$query->result();
			foreach($results as $result)
			{
				$size_array[] = (object)array(
					'id'			=>	$result->id,
					'name'			=>	$result->name,
					'image'			=>	$result->image,
					'is_default'	=>	$result->is_default
				);
			}
		}
	    return $size_array;
	}
}

if ( ! function_exists('get_product_addon'))

{
    function get_product_addon($id)
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $addon_array = array();
	    $query=$CI->db->query("SELECT ty.* FROM pz_type ty INNER JOIN pz_products pr ON ty.category_id = pr.category_id WHERE pr.id='$id' AND pr.is_active='1' AND ty.is_active='1'");
	    if($query->num_rows()>0)
		{
			$results=$query->result();
			foreach($results as $result)
			{
				$addon_query = $CI->db->get_where("type_options", array("type_id" => $result->id, 'is_active' => '1'));
				$option_array = array();
				if($addon_query->num_rows()>0)
				{
					foreach ($addon_query->result() as $opt) {
						$option_array[] = (object)array(
							'option_id' 	=> $opt->id,
							'option_name'	=> $opt->name,
							'option_image'	=> $opt->image,
							'is_default'	=> $opt->is_default		
						);
					}
				}

				$addon_array[] = (object)array(
					'id'			=>	$result->id,
					'name'			=>	$result->name,
					'multiselect'	=>	$result->multiselect,
					'is_mandatory'	=>	$result->is_mandatory,
					'options'		=>	$option_array
				);
			}
		}
	    return $addon_array;
	}
}

if ( ! function_exists('get_product_images'))

{
    function get_product_images($id)
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $image_array = array();
	    $image_query = $CI->db->get_where("product_images", array("product_id" => $id));
	    if($image_query->num_rows()>0)
		{
			$image_array = $image_query->result();
		}
		return $image_array;
	}
}

if ( ! function_exists('get_related_products'))

{
    function get_related_products($id)
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $related_products_array = array();

		$product_query = $CI->db->get_where("products", array("id" => $id));
		$food_category_id = $product_query->row()->food_category_id;
		$category_id = $product_query->row()->category_id;
	    $related_products_query = $CI->db->query("SELECT * FROM pz_products WHERE food_category_id ='$food_category_id' AND category_id='$category_id' AND id != '$id'");
	    if($related_products_query->num_rows()>0)
		{
			$related_products_array = $related_products_query->result();
		}
		return $related_products_array;
	}
}

if ( ! function_exists('check_default'))

{
    function check_default($id)
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $default_query = $CI->db->query("SELECT ty.* FROM pz_type ty LEFT JOIN pz_type_options tyo ON ty.id = tyo.type_id WHERE tyo.id ='$id' AND tyo.is_active = '1'");
	    if($default_query->num_rows()>0)
		{
			$is_mandatory = $default_query->row()->is_mandatory;
		}
		return $is_mandatory;
	}
}

if ( ! function_exists('category_size_exists'))

{
    function category_size_exists()
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $query = $CI->db->get_where("categories", array("is_active" => "1"));
		if($query->num_rows()>0)
		{
			foreach ($query->result() as $value) {
				$query1 = $CI->db->get_where("size", array("category_id" => $value->id,"is_active" => "1"));
				if($query1->num_rows()>0)
				{
					$cat_size_arr[] = (object)array(
						'category_id'	=>	$value->id,
						'size_exists'	=>	'1'
					);
				}
				else
				{
					$cat_size_arr[] = (object)array(
						'category_id'	=>	$value->id,
						'size_exists'	=>	'0'
					);
				}
			}
			
		}
		else
		{
			$cat_size_arr = array();
		}
		return $cat_size_arr;
	}
}

if ( ! function_exists('get_product_price'))

{
    function get_product_price($id)
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $default_query = $CI->db->query("SELECT ty.* FROM pz_type ty LEFT JOIN pz_type_options tyo ON ty.id = tyo.type_id WHERE tyo.id ='$id' AND tyo.is_active = '1'");
	    
		$category_id_query = $CI->db->get_where("products", array("id" => $id,"is_active" => "1"));
		
		$category_id = $category_id_query->row()->category_id;
		if($category_id_query->row()->size_exists == '1')
		{
			$size_id_query = $CI->db->get_where("size", array("category_id" => $category_id,"is_active" => "1", "is_default"=>"1"));
			$size_id = $size_id_query->row()->id;
		}
		else
		{
			$size_id = 0;
		}
		$size_price_query = $CI->db->get_where("product_size_price", array("product_id" => $id,"size_id" => $size_id));
		if($size_price_query->num_rows()>0)
		{
			$base_price = $size_price_query->row()->price;
		}
		else{
			$base_price = 0;
		}

		$mandatory_type_query = $CI->db->get_where("type", array("category_id" => $category_id,"is_active" => "1", "is_mandatory"=>"1"));
		if($mandatory_type_query->num_rows()>0)
		{
			foreach ($mandatory_type_query->result() as $type) {
				$default_type_option_query = $CI->db->get_where("type_options", array("type_id" => $type->id,"is_active" => "1", "is_default"=>"1"));
				if($default_type_option_query->num_rows()>0)
				{
					$type_option_price_query = $CI->db->get_where("product_pricing", array("product_id" => $id,"size_id" => $size_id, "type_option_id"=>$default_type_option_query->row()->id)); 
					$base_price = $base_price + $type_option_price_query->row()->price;
				}
			}
		}
		return $base_price;
	}
}

if ( ! function_exists('get_product_price_array'))

{
    function get_product_price_array($id)
	{
		$CI = & get_instance();  //get instance, access the CI superobject
		$query = $CI->db->get_where("products", array("id" => $id));
		if($query->num_rows()>0)
		{
			$product_result = $query->row();
			$category_id = $product_result->category_id;
			$size_query = $CI->db->query("SELECT sz.id, sz.name, sz.is_default FROM pz_products pro INNER JOIN pz_size sz ON pro.category_id = sz.category_id WHERE pro.id = '$id'");
			if($size_query->num_rows()>0)
			{
				$size_results = $size_query->result();
				foreach ($size_results as $size) {
					$size_id = $size->id;

					$query = $CI->db->query("SELECT id, name FROM pz_type WHERE category_id = '$category_id' AND is_active='1'");
					$add_on_array = array();
					if($query->num_rows()>0)
					{
						foreach($query->result() as $result)
						{
							$type_id = $result->id;
							$type_option_query = $CI->db->query("SELECT typ.id, typ.name, typ.image, pro.price FROM pz_type_options typ INNER JOIN pz_product_pricing pro ON pro.type_option_id = typ.id WHERE pro.product_id = '$id' AND pro.size_id='$size_id' AND typ.type_id='$type_id'");
							$option_array = array();
							foreach ($type_option_query->result() as $val) {
								$option_array [] = (object)array(
									'option_id'		=>	$val->id,
									'option_name'	=>	$val->name,
									'option_image'	=>	$val->image,
									'option_price'	=>	$val->price
								);
							}
		
							if(count($option_array)>0){
								$add_on_array [] = (object)array(
									'id'			=>	$type_id,
									'name'			=>	$result->name,
									'option_array'	=>	$option_array
								);
							}
						}
					}
					$product_size_price_query = $CI->db->get_where("product_size_price", array("product_id" => $id, "size_id"=>$size->id));
					$product_size_price = $product_size_price_query->row()->price;
					$price_array[] = (object)array(
						'id'			=>	$size->id,
						'name'			=>	$size->name,
						'price'			=>	$product_size_price,
						'add_on_array'	=>	$add_on_array
					);
				}
			}
			else {
				$query = $CI->db->query("SELECT id, name FROM pz_type WHERE category_id = '$category_id' AND is_active='1'");
				$add_on_array = array();
				if($query->num_rows()>0)
				{
					foreach($query->result() as $result)
					{
						$type_id = $result->id;
						$type_option_query = $CI->db->query("SELECT typ.id, typ.name, typ.image, pro.price FROM pz_type_options typ INNER JOIN pz_product_pricing pro ON pro.type_option_id = typ.id WHERE pro.product_id = '$id' AND pro.size_id='0' AND typ.type_id='$type_id'");
						$option_array = array();
						foreach ($type_option_query->result() as $val) {
							$option_array [] = (object)array(
								'option_id'		=>	$val->id,
								'option_name'	=>	$val->name,
								'option_image'	=>	$val->image,
								'option_price'	=>	$val->price
							);
						}
						
	
						if(count($option_array)>0){
							$add_on_array [] = (object)array(
								'id'			=>	$type_id,
								'name'			=>	$result->name,
								'option_array'	=>	$option_array
							);
						}
					}
				}
				$product_size_price_query = $CI->db->get_where("product_size_price", array("product_id" => $id, "size_id"=>0));
				$price_array['price'] = $product_size_price_query->row()->price;
				$price_array['add_on_array'] = $add_on_array;
			}
		}
		return $price_array;
	}

}

if ( ! function_exists('get_product_type_array'))

{
    function get_product_type_array($id)
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $type_array = array();
	    $query=$CI->db->query("SELECT ty.* FROM pz_type ty LEFT JOIN pz_products pr ON ty.category_id = pr.category_id WHERE pr.id='$id' AND pr.is_active='1'");
	    if($query->num_rows()>0)
		{
			$results=$query->result();
			foreach($results as $result)
			{
				if($result->is_mandatory == '1')
				{
					$type_option_query=$CI->db->query("SELECT * FROM pz_type_options WHERE type_id='$result->id' AND is_default='1' AND is_active='1'");
					if($type_option_query->num_rows()>0)
					{
						$type_array[] = (object)array(
							'type_id' => $result->id,
							'multiselect'	=>	$result->multiselect,
							'type_option_id'=> $result->multiselect == '1' ? array($type_option_query->row()->id) : $type_option_query->row()->id
						);
					}
					else
					{
						$type_array[] = (object)array(
							'type_id' 			=> $result->id,
							'multiselect'		=> $result->multiselect,
							'type_option_id'	=> $result->multiselect == '1' ? array() : ""
						);
					}
					
				}
				else
				{
					$type_array[] = (object)array(
						'type_id' => $result->id,
						'multiselect'	=>	$result->multiselect,
						'type_option_id'=> $result->multiselect == '1' ? array() : ""
					);
				}
			}
		}
	    return $type_array;
	}
}

if ( ! function_exists('get_cart_summary'))
{
    function get_cart_summary($id="")
	{
	    $CI = & get_instance();  //get instance, access the CI superobject
		$result = array();
		if($id != '')
		{
			$cookiename = "cart";
			if(!empty($_COOKIE[$cookiename])) {
				$carts = json_decode($_COOKIE[$cookiename], true);
				foreach($carts as $key => $cart)
				{
					$final_price = get_final_price($cart);
					if($final_price != 0)
        			{
						$insert_array = array(
							'user_id'   	=>  $id,
							'product_id'    =>  $cart['product_id'],
							'size_id'       =>  $cart['size_id'],
							'quantity'      =>  $cart['quantity'],
							'custom_params' =>  serialize($cart['type_array']),
							'price'         =>  ($final_price * $cart['quantity']),
							'is_active'     =>  '1'
						);
						$return = $CI->db->insert('cart',$insert_array);
						if($return)
						{
							unset($carts[$key]);
						}
					}
				}
				if (empty($carts)) {
					unset($_COOKIE[$cookiename]); 
					setcookie($cookiename, null, -1, '/'); 
				} else {
					setcookie($cookiename, json_encode($carts), time() + (86400 * 7), "/");
				}
			}

			$cart_details_query = $CI->db->query("SELECT SUM(quantity) AS quant, SUM(price) AS price FROM pz_cart WHERE is_active='1' AND user_id= '$id'");
			$result['price'] = $cart_details_query->row()->price;
			$result['quantity'] = $cart_details_query->row()->quant;
		}
		else
		{
			$cookiename = "cart";
			if(!empty($_COOKIE[$cookiename])) {
				$carts = json_decode($_COOKIE[$cookiename], true);
				$quantity = 0;
				$price = 0;
				foreach($carts as $cart)
				{
					$final_price = get_final_price($cart);
					if($final_price != 0)
        			{
						$quantity = $quantity + $cart['quantity'];
						$final_price = $final_price * $cart['quantity'];
						$price = $price + $final_price;
					}
				}
				$result['quantity'] = $quantity;
				$result['price'] = $price;
			}
			else
			{
				$result['quantity'] = "";
				$result['price'] = "";
			}
			
		}
		return $result;
		// return $final_price;
	}
}

if ( ! function_exists('get_final_price'))
{

	function get_final_price($data)
    {
		$CI = & get_instance();  //get instance, access the CI superobject
        $final_price = 0;
        if(isset($data['type_array']) && (!empty($data['type_array'])))
        {
            $category_id_query = $CI->db->get_where("products", array("id" => $data['product_id'], "is_active" => '1'));
            if($category_id_query->num_rows()>0)
            {
                $category_id = $category_id_query->row()->category_id;
                $size_price_query = $CI->db->get_where("product_size_price", array("product_id" => $data['product_id'], "size_id" => $data['size_id']));
                if($size_price_query->num_rows()>0)
                {
                    $final_price = $size_price_query->row()->price;
					foreach ($data['type_array'] as $type) {
						$type_exists_query = $CI->db->get_where("type", array("id" => $type['type_id'], "category_id" => $category_id, "is_active" => '1'));
						if($type_exists_query->num_rows()>0){
							 
							if($type['multiselect'] == 0)
							{
								if(array_key_exists('type_option_id',$type)){
									$type_option_exists_query = $CI->db->get_where("type_options", array("type_id" => $type['type_id'], "id" => $type['type_option_id'], "is_active" => '1'));
									if($type_option_exists_query->num_rows()>0)
									{
										$price_query = $CI->db->get_where("product_pricing", array("product_id" => $data['product_id'], "size_id" => $data['size_id'], "type_option_id" => $type['type_option_id']));
										$final_price = $final_price + $price_query->row()->price;
									}
								}
							}
							else
							{
								if(array_key_exists('type_option_id',$type)){
									foreach ($type['type_option_id'] as $type_option) {
										$type_option_exists_query = $CI->db->get_where("type_options", array("type_id" => $type['type_id'], "id" => $type_option, "is_active" => '1'));
										if($type_option_exists_query->num_rows()>0)
										{
											$price_query = $CI->db->get_where("product_pricing", array("product_id" => $data['product_id'], "size_id" => $data['size_id'], "type_option_id" => $type_option));
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
		// return $arr;
    }
}


if ( ! function_exists('get_image_name'))
{

	function get_image_name($id)
    {
		$CI = & get_instance();
		$query = $CI->db->get_where("products", array("id" => $id, 'is_active' => '1'));
		if($query->num_rows()>0)
		{
			return $query->row()->image;
		}
	}
}

if ( ! function_exists('get_product_name'))
{

	function get_product_name($id)
    {
		$CI = & get_instance();
		$query = $CI->db->get_where("products", array("id" => $id, 'is_active' => '1'));
		if($query->num_rows()>0)
		{
			return $query->row()->name;
		}
	}
}

if ( ! function_exists('get_size_name'))
{

	function get_size_name($id)
    {
		$CI = & get_instance();
		$query = $CI->db->get_where("size", array("id" => $id, 'is_active' => '1'));
		if($query->num_rows()>0)
		{
			return $query->row()->name;
		}
	}
}

if ( ! function_exists('get_countries'))
{

	function get_countries()
    {
		$CI = & get_instance();
		$query = $CI->db->get_where("country", array('is_active' => 1));
		if($query->num_rows()>0)
		{
			return $query->result();
		}
	}
}

if ( ! function_exists('get_country_name'))
{

	function get_country_name($country_id)
    {
		$CI = & get_instance();
		$query = $CI->db->get_where("country", array('id' => $country_id));
		if($query->num_rows()>0)
		{
			return $query->row()->name;
		}
	}
}

if ( ! function_exists('get_province_name'))
{

	function get_province_name($province_id)
    {
		$CI = & get_instance();
		$query = $CI->db->get_where("province", array('id' => $province_id));
		if($query->num_rows()>0)
		{
			return $query->row()->province_name;
		}
	}
}

if ( ! function_exists('get_default_address'))
{

	function get_default_address($id)
    {
		$CI = & get_instance();
		$return = array();
		//$query = $CI->db->get_where("address_book", array('user_id' => $id, 'is_active'=>'1'));
		$query = $CI->db->query("SELECT * FROM pz_address_book WHERE user_id='$id' AND is_active='1'");
		if($query->num_rows()>0)
		{
			$return = $query->row();
		}
		return $return;
	}
}

if ( ! function_exists('get_address_by_id'))
{

	function get_address_by_id($address_id)
    {
		$CI = & get_instance();
		$query = $CI->db->get_where("address_book", array('id' => $address_id));
		if($query->num_rows()>0)
		{
			return $query->row();
		}
	}
}
if ( ! function_exists('get_username'))
{

	function get_username($user_id)
    {
		$CI = & get_instance();
		$query = $CI->db->get_where("business_user", array('id' => $user_id));
		if($query->num_rows()>0)
		{
			return $query->row()->fname." ".$query->row()->lname;
		}
	}
}
if ( ! function_exists('get_user_email'))
{

	function get_user_email($user_id)
    {
		$CI = & get_instance();
		$query = $CI->db->get_where("business_user", array('id' => $user_id));
		if($query->num_rows()>0)
		{
			return $query->row()->email;
		}
	}
}

if ( ! function_exists('get_user_image'))
{

	function get_user_image($user_id)
    {
		$CI = & get_instance();
		$query = $CI->db->get_where("business_user", array('id' => $user_id));
		if($query->num_rows()>0)
		{
			return $query->row()->image == '' ? 'no_image.png' : $query->row()->image;
		}
	}
}

if ( ! function_exists('get_pages'))
{

	function get_pages($type)
    {
		$CI = & get_instance();
		$query = $CI->db->get_where("pages", array('type' => $type));
		if($query->num_rows()>0)
		{
			return $query->result();
		}
	}
}
if ( ! function_exists('get_page_name'))
{

	function get_page_name($page_id)
    {
		$CI = & get_instance();
		$query = $CI->db->get_where("pages", array('id' => $page_id));
		if($query->num_rows()>0)
		{
			return $query->row()->name;
		}
	}
}

if ( ! function_exists('get_post_comment'))
{

	function get_post_comment($product_id)
    {
		$CI = & get_instance();
		$query = $CI->db->get_where("product_comment", array('product_id' => $product_id));
		if($query->num_rows()>0)
		{
			$total_comments = $query->num_rows();
			foreach ($query->result() as $comment) {
				$comment_array[] = (object)array(
					'id'			=>	$comment->id,
					'comment_time'	=>	$comment->comment_time,
					'comment'		=>	$comment->comment,
					'user_id'		=>	$comment->user_id
				);
			}
			$return_array['total_comments'] = $total_comments;
			$return_array['comment_array'] = $comment_array; 
		}
		else{
			$return_array['total_comments'] = 0;
			$return_array['comment_array'] = array(); 
		}
		return $return_array;
	}
}

if ( ! function_exists('customer_reviews'))
{

	function customer_reviews()
    {
		$CI = & get_instance();
		$query=$CI->db->query("SELECT * FROM pz_product_comment ORDER BY id desc LIMIT 5");
		if($query->num_rows()>0)
		{
			$total_comments = $query->num_rows();
			foreach ($query->result() as $comment) {
				$comment_array[] = (object)array(
					'id'			=>	$comment->id,
					'comment'		=>	$comment->comment,
					'user_id'		=>	$comment->user_id
				);
			}
		}
		else{
			$comment_array = array(); 
		}
		return $comment_array;
	}
}

if ( ! function_exists('get_blog_info'))

{
    function get_blog_info()
	{
		$result = array();
	    $CI = & get_instance();  //get instance, access the CI superobject
	    
	    $query=$CI->db->query("SELECT * FROM pz_blog WHERE is_active='1' ORDER BY id desc LIMIT 3");
	    $result=$query->result();
	    
	    return $result;
	}
}

if ( ! function_exists('get_admin_info'))

{
    function get_admin_info($id)
	{
		$result = array();
	    $CI = & get_instance();  //get instance, access the CI superobject
	    
	    $query = $CI->db->get_where("admin", array('id' => $id));
		if($query->num_rows()>0)
		{
			$result = $query->row();
		}
		return $result;
	}
}

if ( ! function_exists('get_order_status'))

{
    function get_order_status()
	{
		$result = array();
	    $CI = & get_instance();  //get instance, access the CI superobject
	    
	    $query = $CI->db->get_where("order_status", array('is_active' => '1'));
		if($query->num_rows()>0)
		{
			$result = $query->result();
		}
		return $result;
	}
}