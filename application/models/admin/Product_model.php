<?php
class Product_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_product_details($id)
	{
		$query = $this->db->get_where("products", array("id" => $id));
		if($query->num_rows()>0)
		{
			$product_result = $query->row();
			$category_id = $product_result->category_id;
			$size_query = $this->db->query("SELECT sz.id, sz.name FROM pz_products pro INNER JOIN pz_size sz ON pro.category_id = sz.category_id WHERE pro.id = '$id'");
			if($size_query->num_rows()>0)
			{
				$size_results = $size_query->result();
				foreach ($size_results as $size) {
					$size_id = $size->id;

					$query = $this->db->query("SELECT id, name FROM pz_type WHERE category_id = '$category_id' AND is_active='1'");
					$add_on_array = array();
					if($query->num_rows()>0)
					{
						foreach($query->result() as $result)
						{
							$type_id = $result->id;
							// $type_option_query = $this->db->query("SELECT typ.id, typ.name, typ.image, pro.price FROM pz_type_options typ INNER JOIN pz_product_pricing pro ON pro.type_option_id = typ.id WHERE pro.product_id = '$id' AND pro.size_id='$size_id' AND typ.type_id='$type_id'");
							$type_option_query = $this->db->query("SELECT * FROM pz_type_options WHERE type_id='$type_id' AND is_active='1'");
							
							$option_array = array();
							foreach ($type_option_query->result() as $val) {
								$opt_price_query = $this->db->get_where("product_pricing", array("product_id" => $id, "type_option_id" => $val->id, "size_id" => $size_id));
								if($opt_price_query->num_rows()>0)
								{
									$option_price = $opt_price_query->row()->price;
								}
								else
								{
									$option_price = "";
								}
								$option_array [] = (object)array(
									'option_id'		=>	$val->id,
									'option_name'	=>	$val->name,
									'option_image'	=>	$val->image,
									'option_price'	=>	$option_price
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
					$product_size_price_query = $this->db->get_where("product_size_price", array("product_id" => $id, "size_id"=>$size->id));
					if($product_size_price_query->num_rows()>0)
					{
						$product_size_price = $product_size_price_query->row()->price;
					}
					else
					{
						$product_size_price = "";
					}
					
					$price_array[] = (object)array(
						'id'			=>	$size->id,
						'name'			=>	$size->name,
						'price'			=>	$product_size_price,
						'add_on_array'	=>	$add_on_array
					);
				}
				$size_exists	= 1;
				$base_price		=	"";
			}
			else {
				$query = $this->db->query("SELECT id, name FROM pz_type WHERE category_id = '$category_id' AND is_active='1'");
				$add_on_array = array();
				if($query->num_rows()>0)
				{
					foreach($query->result() as $result)
					{
						$type_id = $result->id;
						// $type_option_query = $this->db->query("SELECT * FROM pz_type_options INNER JOIN pz_product_pricing pro ON pro.type_option_id = typ.id WHERE pro.product_id = '$id' AND pro.size_id='0' AND typ.type_id='$type_id'");
						$type_option_query = $this->db->query("SELECT * FROM pz_type_options WHERE type_id='$type_id' AND is_active='1'");
						$option_array = array();
						foreach ($type_option_query->result() as $val) {
							$opt_price_query = $this->db->get_where("product_pricing", array("product_id" => $id, "type_option_id" => $val->id, "size_id"=>0));
							if($opt_price_query->num_rows()>0)
							{
								$option_price = $opt_price_query->row()->price;
							}
							else
							{
								$option_price = "";
							}
							$option_array [] = (object)array(
								'option_id'		=>	$val->id,
								'option_name'	=>	$val->name,
								'option_image'	=>	$val->image,
								'option_price'	=>	$option_price
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
				$price_array = $add_on_array;
				$size_exists	= 0;
				$product_size_price_query = $this->db->get_where("product_size_price", array("product_id" => $id, "size_id"=>0));
				if($product_size_price_query->num_rows()>0)
				{
					$base_price = $product_size_price_query->row()->price;
				}
				else
				{
					$base_price = "";
				}
			}
			$return=(object)array(
				'id' 					=>	$product_result->id,
				'name'	        		=>	$product_result->name,
                'description'   		=>  $product_result->description,
				'detailed_description'  =>  $product_result->detailed_description,
				'food_category_id'		=>	$product_result->food_category_id,
				'category_id'			=>	$product_result->category_id,
                'image'         		=>  $product_result->image,
				'base_price'			=>	$base_price,
				'is_active'				=>	$product_result->is_active,
				'price_array'			=>	$price_array,
				'size_exists'			=>	$size_exists
			);
		} 
		else
		{
			$return=(object)array(
					'id' 					=> 	'',
				   	'name' 					=> 	'',
                    'description'       	=> 	'',
					'detailed_description'  =>	'',
                    'image'             	=> 	'',
					'food_category_id'		=>	'',	
					'category_id'			=>	'',	
					'base_price'			=>	'',
                    'is_active' 			=> 	'1',
					'price_array'			=>	''
			);
		}
		return $return;
	}

	

	function get_addons($category_id)
	{
	    $return_array = array();
		$size_query = $this->db->get_where("size", array("category_id" => $category_id));
		if($size_query->num_rows()>0)
		{
			foreach ($size_query->result() as $size) {

				$query = $this->db->query("SELECT id, name FROM pz_type WHERE category_id = '$category_id' AND is_active='1'");
				$add_on_array = array();
				if($query->num_rows()>0)
				{
					foreach($query->result() as $result)
					{
						$type_id = $result->id;
						$sub_query = $this->db->get_where("type_options", array("type_id" => $type_id));
						if($sub_query->num_rows()>0){
							$option_array = array();
							foreach ($sub_query->result() as $val) {
								$option_array [] = (object)array(
									'option_id'		=>	$val->id,
									'option_name'	=>	$val->name,
									'option_image'	=>	$val->image,
									'option_price'	=>	''
								);
							}
						}
						else{
							$option_array = array();
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
				$return_array['array'][] = (object)array(
					'id'			=>	$size->id,
					'name'			=>	$size->name,
					'price'			=>	'',
					'add_on_array'	=>	$add_on_array
				);
			}
			$return_array['size_exists']	= 1;
		} else {
			$query = $this->db->query("SELECT id, name FROM pz_type WHERE category_id = '$category_id' AND is_active='1'");
			$add_on_array = array();
			if($query->num_rows()>0)
			{
				foreach($query->result() as $result)
				{
					$type_id = $result->id;
					$sub_query = $this->db->get_where("type_options", array("type_id" => $type_id));
					if($sub_query->num_rows()>0){
						$option_array = array();
						foreach ($sub_query->result() as $val) {
							$option_array [] = (object)array(
								'option_id'		=>	$val->id,
								'option_name'	=>	$val->name,
								'option_image'	=>	$val->image,
								'option_price'	=>	''
							);
						}
					}
					else{
						$option_array = array();
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
			$return_array['array'] = (object)array(
				'add_on_array'	=>	$add_on_array
			);
			$return_array['size_exists']	= 0;
		}
		return $return_array;
	}

	
	function addedit_product($file_name,$data,$image_array)
	{
		if($data['id'] != '')
		{
			$product_id = $data['id'];	

			if($file_name=='')
			{
				$update_array = array(
					'name'					=>	$data['name'],
					'food_category_id'		=>	$data['food_category_id'],
					'category_id'			=>	$data['category_id'],
					'description'			=>	$data['description'],
					'detailed_description'	=>	$data['detailed_description'],
					'size_exists'			=>	$data['size_exists']
				);
			}
			else
			{
				$image_query = $this->db->get_where("products", array("id" => $product_id));
		    	$image = $image_query->row()->image;
		    	if($image != "no_image.png")
		    	{
		    		$image_path = $this->config->item('server_absolute_path').'upload/products/normal/'.$image;
		    		$thumb_path = $this->config->item('server_absolute_path').'upload/products/thumb/'.$image;
				    // Check file exist or not
				    if( file_exists($image_path) && file_exists($thumb_path) )
				    {
				        unlink($image_path);
				        unlink($thumb_path);
					}
		    	}
				$update_array = array(
					'name'					=>	$data['name'],
					'food_category_id'		=>	$data['food_category_id'],
					'category_id'			=>	$data['category_id'],
					'description'			=>	$data['description'],
					'detailed_description'	=>	$data['detailed_description'],
					'size_exists'			=>	$data['size_exists'],
					'image'					=>	$file_name
				);
			}
			$return = $this->db->where('id', $product_id)->update('products', $update_array);
			if($return)
			{
				if(count($image_array)>0)
				{
					foreach($image_array as $img)
					{
						$insert_img = array(
							'product_id'	=>	$product_id,
							'image'			=>	$img
						);
						$return = $this->db->insert('product_images', $insert_img);
					}
				}
				if($data['size_exists'] == "1")
				{
					foreach ($data['size_id'] as $key => $value) {
						$size_id = $value;
						// $size_details = $this->get_size_details($size_id);
						$size_default_price = $data['size_price'][$key];
						$add_on_array = array();
						if(isset($data['options'.$key]) && !empty($data['options'.$key])){
						    foreach($data['options'.$key] as $k => $val)
    						{
    							$option_array = array();
    							$option_id = $val;
    							$option_price = $data['option_value'.$key][$k];
    
    							$opt_price_check_query = $this->db->get_where("product_pricing", array("product_id" => $product_id, "size_id"=>$size_id, "type_option_id"=>$option_id));
    							if($opt_price_check_query->num_rows()>0)
    							{
    								$this->db->set('price', $option_price)->where('id',$opt_price_check_query->row()->id)->update('product_pricing');
    							}
    							else
    							{
    								$insert_pricing_array = array(
    									'product_id'		=>	$product_id,
    									'size_id'			=>	$size_id,
    									'type_option_id'	=>	$option_id,
    									'price'				=>	$option_price
    								);
    								$return = $this->db->insert("product_pricing",$insert_pricing_array);
    							}
    						}
						}
						$size_price_check_query = $this->db->get_where("product_size_price", array("product_id" => $product_id, "size_id"=>$size_id));
						if($size_price_check_query->num_rows()>0)
						{
							$return = $this->db->set('price', $size_default_price)->where('id',$size_price_check_query->row()->id)->update('product_size_price');
						}
						else
						{
							$product_size_price_array = array(
								'product_id'	=>	$product_id,
								'size_id'		=>	$size_id,
								'price'			=>	$size_default_price
							);
							$return = $this->db->insert("product_size_price",$product_size_price_array);
						}
					}
				}
				else{
				    if(isset($data['options']) && (!empty($data['options']))){
				        foreach($data['options'] as $key => $value)
    					{
    						$option_id = $value;
    						$option_price = $data['option_value'][$key];
    
    						$opt_price_check_query = $this->db->get_where("product_pricing", array("product_id" => $product_id, "size_id"=>0, "type_option_id"=>$option_id));
    						if($opt_price_check_query->num_rows()>0)
    						{
    							$this->db->set('price', $option_price)->where('id',$opt_price_check_query->row()->id)->update('product_pricing');
    						}
    						else
    						{
    							$insert_pricing_array = array(
    								'product_id'		=>	$product_id,
    								'size_id'			=>	0,
    								'type_option_id'	=>	$option_id,
    								'price'				=>	$option_price
    							);
    							$return = $this->db->insert("product_pricing",$insert_pricing_array);
    						}
    					}   
				    }
					$size_price_check_query = $this->db->get_where("product_size_price", array("product_id" => $product_id, "size_id"=>0));
					if($size_price_check_query->num_rows()>0)
					{
						$return = $this->db->set('price', $data['base_price'])->where('id',$size_price_check_query->row()->id)->update('product_size_price');
					}
					else
					{
						$product_size_price_array = array(
							'product_id'	=>	$product_id,
							'size_id'		=>	0,
							'price'			=>	$data['base_price']
						);
						$return = $this->db->insert("product_size_price",$product_size_price_array);
					}
				}
			}
			
		} 
		else{
			$insert_array = array(
				'name'					=>	$data['name'],
				'food_category_id'		=>	$data['food_category_id'],
				'category_id'			=>	$data['category_id'],
				'description'			=>	$data['description'],
				'detailed_description'	=>	$data['detailed_description'],
				'size_exists'			=>	$data['size_exists'],
				'image'					=>	$file_name,
				'is_active'				=>	'1'
			);
			$return = $this->db->insert("products",$insert_array);
			$product_id = $this->db->insert_id();
			if($return)
			{
				if(count($image_array)>0)
				{
					foreach($image_array as $img)
					{
						$insert_img = array(
							'product_id'	=>	$product_id,
							'image'			=>	$img
						);
						$this->db->insert('product_images', $insert_img);
					}
				}
			}
			if($data['size_exists'] == "1")
			{
				foreach ($data['size_id'] as $key => $value) {
					$size_id = $value;
					$size_details = $this->get_size_details($size_id);
					$size_default_price = $data['size_price'][$key];
					$add_on_array = array();
					if(isset($data['options'.$key]) && !empty($data['options'.$key])){
					    foreach($data['options'.$key] as $k => $val)
    					{
    						$option_array = array();
    						$option_id = $val;
    						$option_price = $data['option_value'.$key][$k];
    
    						$insert_pricing_array = array(
    							'product_id'		=>	$product_id,
    							'size_id'			=>	$size_id,
    							'type_option_id'	=>	$option_id,
    							'price'				=>	$option_price
    						);
    						$return = $this->db->insert("product_pricing",$insert_pricing_array);
    					}   
					}
					$product_size_price_array = array(
						'product_id'	=>	$product_id,
						'size_id'		=>	$size_id,
						'price'			=>	$size_default_price
					);
					$return = $this->db->insert("product_size_price",$product_size_price_array);
				}
			}
			else{
			    if(isset($data['options']) && (!empty($data['options']))){
			        foreach($data['options'] as $key => $value)
    				{
    					$option_id = $value;
    					$option_price = $data['option_value'][$key];
    					$insert_pricing_array = array(
    						'product_id'		=>	$product_id,
    						'size_id'			=>	0,
    						'type_option_id'	=>	$option_id,
    						'price'				=>	$option_price
    					);
    					$return = $this->db->insert("product_pricing",$insert_pricing_array);
    				}   
			    }
				$product_size_price_array = array(
					'product_id'	=>	$product_id,
					'size_id'		=>	0,
					'price'			=>	$data['base_price']
				);
				$return = $this->db->insert("product_size_price",$product_size_price_array);
			}
		}
		return $return;
		// return $price_array;
	}


	function change_status($id, $table)
	{	    
	    $query=$this->db->get_where($table, array("id" => $id));

        if($query->row()->is_active==1)
        {
            $data_is_active = array('is_active' =>'0');
        }
        else
        {
            $data_is_active = array('is_active' =>'1');
        }
		$this->db->where('id', $id);
		$return=$this->db->update($table, $data_is_active);
		if($return==1)
		{
		    $query1=$this->db->select('*')->from($table)->get();
			$return_data=$query1->result();
			return $return_data;
		}
	}

	function get_option_details($option_id)
	{
		$query=$this->db->get_where('type_options', array("id" => $option_id));
		return $query->row();
	}

	function get_addon_details($add_on_id)
	{
		$query=$this->db->get_where('type', array("id" => $add_on_id));
		return $query->row();
	}
	function get_size_details($size_id)
	{
		$query=$this->db->get_where('size', array("id" => $size_id));
		return $query->row();
	}

	function remove_image($id)
    {
    	$return = 0;
		$product_image_query=$this->db->get_where('product_images', array("id" => $id));
    	
    	$image_name = $product_image_query->row()->image;

    	$normal_image_path = $this->config->item('server_absolute_path').'upload/products/normal/'.$image_name;
		//return $normal_image_path;
    	// Check file exist or not
	    if( file_exists($normal_image_path) )
	    {
	       if(unlink($normal_image_path))
	       {
	       		$return = $this->db->where('id', $id)->delete('product_images');
	       }
	       else 
	       {
	       		$return = 0;
	       }  
		}else{
	       // Set status
	       $return = 0;
	    }
	    return $return;
	    // return $normal_image_path;
    }
}
?>