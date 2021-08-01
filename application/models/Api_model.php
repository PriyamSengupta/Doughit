<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {

public function __construct() {
		
		parent::__construct();
	}

	public function check_login($data)
	{
		if($data['email'] == '' || $data['password'] == '')
    	{
    		$return_array['status'] =array(
				"message"	=>	"Provide Required details",
				'err_code'	=>	500
			);
    	}
    	else{
    		$query = $this->db->get_where("business_user", array('email' => $data['email']));
			if($query->num_rows()>0)
			{
				$login_password = $query->row()->password;
				if(md5($data['password']) == $login_password)
				{
					$user_id = $query->row()->id;
					if($data['device_type'] !== 'web'){
						$token = bin2hex(openssl_random_pseudo_bytes(16));
						$array=array(
							'access_token'	=>	$token,
							//'device_token'  =>  $device_token,
							// 'device_type'   => 	$device_type
						);
						$this->db->where('id',$user_id);
						$this->db->update('business_user',$array);
					} else {
						$token = "";
					}

					$return_array['user'] = array(
						"user_id"		=>	$user_id,
						"name"			=>	$query->row()->fname." ".$query->row()->lname,
						"image"			=>	$this->config->item('file_upload_base_url').'user/normal/'.$query->row()->image,
						'access_token'	=>	$data['device_type'] === 'web' ? "" : $token,
						"device_type"	=>	$data['device_type'],
						"email"			=>	$query->row()->email,
					);
					$return_array['status'] =array(
						"message"	=>	"Successfully logged in",
						'err_code'	=>	200
					);
				}
				else{
					$return_array['user'] = array(
						"user_id"		=>	"",
						"name"			=>	"",
						"image"			=>	"",
						'access_token'	=>	"",
						"device_type"	=> 	"",
						"email"			=>	"",
					);
					$return_array['status'] =array(
						"message"	=>	"Incorrect Credentials",
						'err_code'	=>	500
					);
				}
			}
			else{
				$return_array['user'] = array(
					"user_id"		=>	"",
					"name"			=>	"",
					"image"			=>	"",
					'access_token'	=>	"",
					"device_type"	=> 	"",
					"email"			=>	"",
				);
				$return_array['status'] =array(
					"message"	=>	"User doesn't exist",
					'err_code'	=>	404
				);
			}
    	}
		    
		return $return_array;
	}

	public function create_profile($data)
    {
    	if($data['fname'] == '' || $data['lname'] == '' || $data['email'] == '' || $data['password'] == '' || $data['phone'] == '')
    	{
    		$return_array['status'] =array(
				"message"	=>	"Provide Required details",
				'err_code'	=>	500
			);
    	}
    	else{
    		$query = $this->db->get_where("business_user", array("email" => $data['email']));
	        if($query->num_rows()>0) 
	        {
	            $return_array['status'] =array(
					"message"	=>	"User exists",
					'err_code'	=>	500
				);
	        }
	        else{
				if($data['device_type'] === 'web'){
					$token = "";
				} else {
					$token = bin2hex(openssl_random_pseudo_bytes(16));
				}
				
	            $insert_array = array(
	                'fname'      	=>  $data['fname'],
					'lname'      	=>  $data['lname'],
	                'email'     	=>  $data['email'],
					'phone'			=>	$data['phone'],
					'access_token'	=>	$token,
	                'password'  	=>  md5($data['password']),
					'is_active'		=>	'1'
	            );
	            $insert = $this->db->insert("business_user", $insert_array);
	            if($insert){
					$user_id = $this->db->insert_id();
					$query = $this->db->get_where("business_user", array('id' => $user_id));
	            	$return_array['status'] =array(
						"message"	=>	"Registered Successfully",
						'err_code'	=>	200
					);
					$return_array['user'] = array(
						"user_id"		=>	$user_id,
						"name"			=>	$query->row()->fname." ".$query->row()->lname,
						"image"			=>	$this->config->item('file_upload_base_url').'user/normal/'.$query->row()->image,
						'access_token'	=>	$token,
						"device_type"	=>	$data['device_type'],
						"email"			=>	$query->row()->email,
					);
	            }
	            else{
					$return_array['user'] = array(
						"user_id"		=>	"",
						"name"			=>	"",
						"image"			=>	"",
						'access_token'	=>	"",
						"device_type"	=> 	"",
						"email"			=>	"",
					);
	            	$return_array['status'] =array(
						"message"	=>	"Error Occured",
						'err_code'	=>	500
					);
	            }
	        }
    	}
        return $return_array;
    }

	public function my_profile($data)
	{
		if($data['device_type'] === 'web')
		{
			$query = $this->db->get_where("business_user", array('id' => $data['id']));
			if($query->num_rows() > 0)
			{
				$return_array['user'] = array(
					"user_id"		=>	$query->row()->id,
					"name"			=>	$query->row()->fname." ".$query->row()->lname,
					"image"			=>	$this->config->item('file_upload_base_url').'user/normal/'.$query->row()->image,
					'access_token'	=>	$query->row()->access_token,
					"device_type"	=>	$data['device_type'],
					"email"			=>	$query->row()->email,
				);
				$return_array['status'] =array(
					"message"	=>	"success",
					'err_code'	=>	200
				);
			}
			else {
				$return_array['user'] = array(
					"user_id"		=>	"",
					"name"			=>	"",
					"image"			=>	"",
					'access_token'	=>	"",
					"device_type"	=> 	"",
					"email"			=>	"",
				);
				$return_array['status'] =array(
					"message"	=>	"Invalid user",
					'err_code'	=>	500
				);
			}
		}
		else {
			if($data['access_token'] == '')
			{
				$return_array['status'] =array(
					"message"	=>	"Invalid Token",
					'err_code'	=>	500
				);
			}
			else {
				$query = $this->db->get_where("business_user", array('access_token' => $data['access_token']));
				if($query->num_rows() > 0)
				{
					$return_array['user'] = array(
						"user_id"		=>	$query->row()->id,
						"name"			=>	$query->row()->fname." ".$query->row()->lname,
						"image"			=>	$this->config->item('file_upload_base_url').'user/normal/'.$query->row()->image,
						'access_token'	=>	$query->row()->access_token,
						"device_type"	=>	$data['device_type'],
						"email"			=>	$query->row()->email,
					);
					$return_array['status'] =array(
						"message"	=>	"success",
						'err_code'	=>	200
					);
				}
				else {
					$return_array['user'] = array(
						"user_id"		=>	"",
						"name"			=>	"",
						"image"			=>	"",
						'access_token'	=>	"",
						"device_type"	=> 	"",
						"email"			=>	"",
					);
					$return_array['status'] =array(
						"message"	=>	"Invalid Token",
						'err_code'	=>	500
					);
				}
			}
		}
		return $return_array;
	}

	public function edit_profile($data,$file_name)
	{
		if($data['device_type'] === 'web')
		{
			$query = $this->db->get_where("business_user", array('id' => $data['id']));
			if($query->num_rows()>0)
			{
				$email = $data['email'];
				$user_id = $query->row()->id;
				$email_check_query = $this->db->query("SELECT * FROM pz_business_user WHERE email='$email' AND id != '$user_id'");
				if($email_check_query->num_rows() > 0)
				{
					$return_array['status'] =array(
						"message"	=>	"Email already exists",
						'err_code'	=>	500
					);
				}
				else 
				{
					if($file_name != '')
					{
						$image = $query->row()->image;
						if($image != "no_image.png")
						{
							$image_path = $this->config->item('server_absolute_path').'upload/user/normal/'.$image;
							$thumb_path = $this->config->item('server_absolute_path').'upload/user/thumb/'.$image;
							// Check file exist or not
							if( file_exists($image_path) && file_exists($thumb_path) )
							{
								unlink($image_path);
								unlink($thumb_path);
							}
						}
						$update_array = array(
							'fname'	=>	$data['fname'],
							'lname'	=>	$data['lname'],
							'email'	=>	$data['email'],
							'phone'	=>	$data['phone'],
							'image'	=>	$file_name
						);
					} 
					else 
					{
						$update_array = array(
							'fname'	=>	$data['fname'],
							'lname'	=>	$data['lname'],
							'email'	=>	$data['email'],
							'phone'	=>	$data['phone']
						);
					}
					$return = $this->db->where('id', $user_id)->update('business_user', $update_array);
					if($return)
					{
						$user_query = $this->db->get_where("business_user", array('id' => $user_id));
						$return_array['user'] = array(
							"user_id"		=>	$user_query->row()->id,
							"name"			=>	$user_query->row()->fname." ".$user_query->row()->lname,
							"image"			=>	$this->config->item('file_upload_base_url').'user/normal/'.$user_query->row()->image,
							'access_token'	=>	$user_query->row()->access_token,
							"device_type"	=>	$data['device_type'],
							"email"			=>	$user_query->row()->email,
						);
						$return_array['status'] =array(
							"message"	=>	"Profile edited successfully",
							'err_code'	=>	200
						);
					}
					else
					{
						$return_array['status'] =array(
							"message"	=>	"Error Occured",
							'err_code'	=>	500
						);
					}
				}
			}
			else
			{
				$return_array['status'] =array(
					"message"	=>	"Invalid User",
					'err_code'	=>	500
				);
			}
		} 
		else 
		{
			$query = $this->db->get_where("business_user", array('access_token' => $data['access_token']));
			if($query->num_rows()>0)
			{
				$email = $data['email'];
				$user_id = $query->row()->id;
				$email_check_query = $this->db->query("SELECT * FROM pz_business_user WHERE email='$email' AND id != '$user_id'");
				if($email_check_query->num_rows() > 0)
				{
					$return_array['status'] =array(
						"message"	=>	"Email already exists",
						'err_code'	=>	500
					);
				}
				else 
				{
					if($file_name != '')
					{
						$image = $query->row()->image;
						if($image != "no_image.png")
						{
							$image_path = $this->config->item('server_absolute_path').'upload/user/normal/'.$image;
							$thumb_path = $this->config->item('server_absolute_path').'upload/user/thumb/'.$image;
							// Check file exist or not
							if( file_exists($image_path) && file_exists($thumb_path) )
							{
								unlink($image_path);
								unlink($thumb_path);
							}
						}
						$update_array = array(
							'fname'	=>	$data['fname'],
							'lname'	=>	$data['lname'],
							'email'	=>	$data['email'],
							'phone'	=>	$data['phone'],
							'image'	=>	$file_name
						);
					} 
					else 
					{
						$update_array = array(
							'fname'	=>	$data['fname'],
							'lname'	=>	$data['lname'],
							'email'	=>	$data['email'],
							'phone'	=>	$data['phone']
						);
					}
					$return = $this->db->where('id', $user_id)->update('business_user', $update_array);
					if($return)
					{
						$user_query = $this->db->get_where("business_user", array('id' => $user_id));
						$return_array['user'] = array(
							"user_id"		=>	$user_query->row()->id,
							"name"			=>	$user_query->row()->fname." ".$user_query->row()->lname,
							"image"			=>	$this->config->item('file_upload_base_url').'user/normal/'.$user_query->row()->image,
							'access_token'	=>	$user_query->row()->access_token,
							"device_type"	=>	$data['device_type'],
							"email"			=>	$user_query->row()->email,
						);
						$return_array['status'] =array(
							"message"	=>	"Profile edited successfully",
							'err_code'	=>	200
						);
					}
					else
					{
						$return_array['status'] =array(
							"message"	=>	"Error Occured",
							'err_code'	=>	500
						);
					}
				}
			}
			else
			{
				$return_array['status'] =array(
					"message"	=>	"Invalid Token",
					'err_code'	=>	500
				);
			}
		}
		return $return_array;
	}

	public function get_categories($data)
	{
		$cat_array = array();
		$banner_array = array();
		if($data['device_type'] === 'web')
		{
			$query = $this->db->get_where("business_user", array('id' => $data['id']));
			if($query->num_rows() > 0)
			{
				$get_category_query = $this->db->get_where("categories", array('is_active' => '1'));
				if($get_category_query->num_rows() > 0)
				{
					foreach ($get_category_query->result() as $cat) {
						$cat_array[] = array(
							'id'			=>	$cat->id,
							'name'			=>	$cat->name,
							'description'	=>	$cat->description,
							'image'			=>	$this->config->item('file_upload_base_url').'categories/normal/'.$cat->image,
						);
					}
					$get_banner_query = $this->db->get_where("banner", array( 'page_id'=> 3,'type' => 'app','is_active' => '1'));
					if($get_banner_query->num_rows()>0){
						$banner = $get_banner_query->result_array();
						$banner_array = array(
							'id'	=>	$banner[0]['id'],
							'image'	=>	$this->config->item('file_upload_base_url').'banner/normal/'.$banner[0]['image'],
							'banner_text'	=>	$banner[0]['banner_text']
						);
					}
					$return_array['result'] = $cat_array;
					$return_array['banner'] = $banner_array;
					$return_array['status'] =array(
						"message"	=>	"success",
						'err_code'	=>	200
					);
				}
				else
				{
					$return_array['result'] = $cat_array;
					$return_array['banner'] = $banner_array;
					$return_array['status'] =array(
						"message"	=>	"No data found",
						'err_code'	=>	404
					);
				}
			}
			else
			{
				$return_array['status'] =array(
					"message"	=>	"Invalid User",
					'err_code'	=>	500
				);
			}
		}
		else
		{
			$query = $this->db->get_where("business_user", array('access_token' => $data['access_token']));
			if($query->num_rows() > 0)
			{
				$get_category_query = $this->db->get_where("categories", array('is_active' => '1'));
				if($get_category_query->num_rows() > 0)
				{
					foreach ($get_category_query->result() as $cat) {
						$cat_array[] = array(
							'id'			=>	$cat->id,
							'name'			=>	$cat->name,
							'description'	=>	$cat->description,
							'image'			=>	$this->config->item('file_upload_base_url').'categories/normal/'.$cat->image,
						);
					}

					$get_banner_query = $this->db->get_where("banner", array( 'page_id'=> 3,'type' => 'app','is_active' => '1'));
					if($get_banner_query->num_rows()>0){
						$banner = $get_banner_query->result_array();
						$banner_array = array(
							'id'	=>	$banner[0]['id'],
							'image'	=>	$this->config->item('file_upload_base_url').'banner/normal/'.$banner[0]['image'],
							'banner_text'	=>	$banner[0]['banner_text']
						);
					}
					$return_array['result'] = $cat_array;
					$return_array['banner'] = $banner_array;
					$return_array['status'] =array(
						"message"	=>	"success",
						'err_code'	=>	200
					);
				}
				else
				{
					$return_array['result'] = $cat_array;
					$return_array['banner'] = $banner_array;
					$return_array['status'] =array(
						"message"	=>	"No data found",
						'err_code'	=>	404
					);
				}
			}
			else
			{
				$return_array['status'] =array(
					"message"	=>	"Invalid Token",
					'err_code'	=>	500
				);
			}
		}
		return $return_array;
	}
 
	public function food_by_categories($data)
	{
		$product_array = array();
		$query = $this->db->get_where("business_user", array('access_token' => $data['access_token']));
		if($query->num_rows() > 0)
		{
			$user_id = $query->row()->id;
			$get_products_query = $this->db->get_where("products", array('category_id' => $data['category_id'], 'is_active'=>'1'));
			if($get_products_query->num_rows() > 0)
			{
				foreach ($get_products_query->result() as $product) {
					$get_favorite_product_query = $this->db->get_where("favorites", array('product_id' => $product->id, 'user_id'=>$user_id));

					if($product->size_exists == 1)
					{
						$get_size_query = $this->db->get_where("size", array('category_id' =>$product->category_id, 'is_active'=>'1'));
						$size_array = array();
						if($get_size_query->num_rows()>0)
						{
							foreach($get_size_query->result() as $size){
								$get_size_price_query = $this->db->get_where("product_size_price", array('product_id' =>$product->id, 'size_id' => $size->id));
								$size_base_price = $get_size_price_query->row()->price;
								$mandatory_type_query = $this->db->get_where("type", array("category_id" => $product->category_id,"is_active" => "1", "is_mandatory"=>"1"));
								if($mandatory_type_query->num_rows()>0)
								{
									foreach ($mandatory_type_query->result() as $type) {
										$default_type_option_query = $this->db->get_where("type_options", array("type_id" => $type->id,"is_active" => "1", "is_default"=>"1"));
										if($default_type_option_query->num_rows()>0)
										{
											$type_option_price_query = $this->db->get_where("product_pricing", array("product_id" => $product->id,"size_id" => $size->id, "type_option_id"=>$default_type_option_query->row()->id)); 
											$size_base_price = $size_base_price + $type_option_price_query->row()->price;
										}
									}
								}
								$size_array[] = array(
									'id'			=>	$size->id,
									'name'			=>	$size->name,
									'description'	=>	$size->description,
									'image'			=>	$this->config->item('file_upload_base_url').'size/normal/'.$size->image,
									'is_default'	=>	$size->is_default,
									'price'			=>	strval(number_format($size_base_price, 2, '.', ''))
								);
							}
						}
						else{
							$size_array = array();
						}
					}
					else
					{
						$size_array = array();
					}




					$product_array[] = array(
						'id'				=>	$product->id,
						'name'				=>	$product->name,
						'food_category_id'	=>	$product->food_category_id,
						'description'		=>	$product->description,
						'image'				=>	$this->config->item('file_upload_base_url').'products/normal/'.$product->image,
						'favorites'			=>	$get_favorite_product_query->num_rows(),
						'size_exists'		=>	$product->size_exists,
						'size_array'		=>	$size_array,
						'price'				=>	strval(number_format($this->get_product_price($product->id), 2, '.', ''))
					);
				}
				$return_array['result'] = $product_array;
				$return_array['status'] =array(
					"message"	=>	"success",
					'err_code'	=>	200
				);
			}
			else
			{
				$return_array['result'] = $product_array;
				$return_array['status'] =array(
					"message"	=>	"No data found",
					'err_code'	=>	404
				);
			}
		}
		else
		{
			$return_array['status'] =array(
				"message"	=>	"Invalid Token",
				'err_code'	=>	500
			);
		}
		return $return_array;
	}

	public function my_favorites($data)
	{
		$product_array = array();
		if($data['device_type'] === 'web')
		{
			$query = $this->db->get_where("business_user", array('id' => $data['id']));
			if($query->num_rows() > 0)
			{
				$user_id = $data['id'];
				$get_favorites_query = $this->db->query("SELECT pr.* FROM pz_products pr LEFT JOIN pz_favorites fav ON fav.product_id = pr.id WHERE fav.user_id='$user_id' AND fav.is_active='1' AND pr.is_active='1'");
				if($get_favorites_query->num_rows() > 0)
				{
					foreach ($get_favorites_query->result() as $product) {
						$product_array[] = array(
							'id'				=>	$product->id,
							'name'				=>	$product->name,
							'food_category_id'	=>	$product->food_category_id,
							'description'		=>	$product->description,
							'image'				=>	$this->config->item('file_upload_base_url').'products/normal/'.$product->image,
							'size_exists'		=>	$product->size_exists,
							'price_array'		=>	$product->price_array == '' ? array(): unserialize($product->price_array)
						);
					}
					$return_array['result'] = $product_array;
					$return_array['status'] =array(
						"message"	=>	"success",
						'err_code'	=>	200
					);
				}
				else
				{
					$return_array['result'] = $product_array;
					$return_array['status'] =array(
						"message"	=>	"No data found",
						'err_code'	=>	404
					);
				}
			}
			else
			{
				$return_array['status'] =array(
					"message"	=>	"Invalid User",
					'err_code'	=>	500
				);
			}
		}
		else
		{
			$query = $this->db->get_where("business_user", array('access_token' => $data['access_token']));
			if($query->num_rows() > 0)
			{
				$user_id = $query->row()->id;
				$get_favorites_query = $this->db->query("SELECT pr.* FROM pz_products pr LEFT JOIN pz_favorites fav ON fav.product_id = pr.id WHERE fav.user_id='$user_id' AND fav.is_active='1' AND pr.is_active='1'");
				if($get_favorites_query->num_rows() > 0)
				{
					foreach ($get_favorites_query->result() as $product) {
						$product_array[] = array(
							'id'				=>	$product->id,
							'name'				=>	$product->name,
							'food_category_id'	=>	$product->food_category_id,
							'description'		=>	$product->description,
							'image'				=>	$this->config->item('file_upload_base_url').'products/normal/'.$product->image,
							'size_exists'		=>	$product->size_exists,
							'price_array'		=>	$product->price_array == '' ? array(): unserialize($product->price_array)
						);
					}
					$return_array['result'] = $product_array;
					$return_array['status'] =array(
						"message"	=>	"success",
						'err_code'	=>	200
					);
				}
				else
				{
					$return_array['result'] = $product_array;
					$return_array['status'] =array(
						"message"	=>	"No data found",
						'err_code'	=>	404
					);
				}
			}
			else
			{
				$return_array['status'] =array(
					"message"	=>	"Invalid Token",
					'err_code'	=>	500
				);
			}
		}
		return $return_array;
	}

	public function edit_favorites($data)
	{
		if($data['device_type'] === 'web')
		{
			$query = $this->db->get_where("business_user", array('id' => $data['id']));
			if($query->num_rows() > 0)
			{
				$user_id = $data['id'];
				$check_product_query = $this->db->get_where("products", array('id'=> $data['product_id'], 'is_active'=> '1'));
				if($check_product_query->num_rows() > 0)
				{
					$check_favorites_query = $this->db->get_where("favorites", array('user_id' =>$user_id, 'product_id'=> $data['product_id']));
					if($check_favorites_query->num_rows() > 0)
					{
						if($check_favorites_query->row()->is_active == '1')
						{
							$favorite_query = $this->db->set('is_active', '0')->where('id', $check_favorites_query->row()->id)->update('favorites');
							if($favorite_query)
							{
								$return_array['status'] =array(
									"message"	=>	"Removed from favourites",
									'err_code'	=>	200
								);
							}
							else {
								$return_array['status'] =array(
									"message"	=>	"Error Occured",
									'err_code'	=>	500
								);
							}
						}
						else{
							$favorite_query = $this->db->set('is_active', '1')->where('id', $check_favorites_query->row()->id)->update('favorites');
							if($favorite_query)
							{
								$return_array['status'] =array(
									"message"	=>	"Added to favourites",
									'err_code'	=>	200
								);
							}
							else {
								$return_array['status'] =array(
									"message"	=>	"Error Occured",
									'err_code'	=>	500
								);
							}
						}
					}
					else
					{
						$insert_array = array(
							'user_id'		=>	$user_id,
							'product_id'	=>	$data['product_id'],
							'is_active'		=>	'1'
						);
						$favorite_query = $this->db->insert('favorites', $insert_array);
						if($favorite_query)
						{
							$return_array['status'] =array(
								"message"	=>	"Added to favourites",
								'err_code'	=>	200
							);
						}
						else {
							$return_array['status'] =array(
								"message"	=>	"Error Occured",
								'err_code'	=>	500
							);
						}
					}
				}
				else{
					$return_array['status'] =array(
						"message"	=>	"Item doesn't exist",
						'err_code'	=>	404
					);
				}
			}
			else
			{
				$return_array['status'] =array(
					"message"	=>	"Invalid User",
					'err_code'	=>	500
				);
			}
		}
		else
		{
			$query = $this->db->get_where("business_user", array('access_token' => $data['access_token']));
			if($query->num_rows() > 0)
			{
				$user_id = $query->row()->id;
				$check_product_query = $this->db->get_where("products", array('id'=> $data['product_id'], 'is_active'=> '1'));
				if($check_product_query->num_rows() > 0)
				{
					$check_favorites_query = $this->db->get_where("favorites", array('user_id' =>$user_id, 'product_id'=> $data['product_id']));
					if($check_favorites_query->num_rows() > 0)
					{
						if($check_favorites_query->row()->is_active == '1')
						{
							$favorite_query = $this->db->set('is_active', '0')->where('id', $check_favorites_query->row()->id)->update('favorites');
							if($favorite_query)
							{
								$return_array['status'] =array(
									"message"	=>	"Removed from favourites",
									'err_code'	=>	200
								);
							}
							else {
								$return_array['status'] =array(
									"message"	=>	"Error Occured",
									'err_code'	=>	500
								);
							}
						}
						else{
							$favorite_query = $this->db->set('is_active', '1')->where('id', $check_favorites_query->row()->id)->update('favorites');
							if($favorite_query)
							{
								$return_array['status'] =array(
									"message"	=>	"Added to favourites",
									'err_code'	=>	200
								);
							}
							else {
								$return_array['status'] =array(
									"message"	=>	"Error Occured",
									'err_code'	=>	500
								);
							}
						}
					}
					else
					{
						$insert_array = array(
							'user_id'		=>	$user_id,
							'product_id'	=>	$data['product_id'],
							'is_active'		=>	'1'
						);
						$favorite_query = $this->db->insert('favorites', $insert_array);
						if($favorite_query)
						{
							$return_array['status'] =array(
								"message"	=>	"Added to favourites",
								'err_code'	=>	200
							);
						}
						else {
							$return_array['status'] =array(
								"message"	=>	"Error Occured",
								'err_code'	=>	500
							);
						}
					}
				}
				else{
					$return_array['status'] =array(
						"message"	=>	"Item doesn't exist",
						'err_code'	=>	404
					);
				}
			}
			else
			{
				$return_array['status'] =array(
					"message"	=>	"Invalid Token",
					'err_code'	=>	500
				);
			}
		}
		return $return_array;
	}

	public function view_food($data)
	{
		$query = $this->db->get_where("business_user", array('access_token' => $data['access_token']));
		if($query->num_rows() > 0)
		{
			$user_id = $query->row()->id;
			$get_products_query = $this->db->get_where("products", array('id' => $data['product_id'], 'is_active'=>'1'));
			if($get_products_query->num_rows() > 0){
				$product = $get_products_query->row();
				$get_product_images_query = $this->db->get_where("product_images", array('product_id' => $data['product_id']));
				if($get_product_images_query->num_rows()>0)
				{
					foreach ($get_product_images_query->result() as $img) {
						$image_array[] = array(
							'id'	=>	$img->id,
							'image'	=>	$this->config->item('file_upload_base_url').'products/normal/'.$img->image,
						);
					}
				}
				else
				{
					$image_array = [];
				}
				if($product->size_exists == 1)
				{
					$get_size_query = $this->db->get_where("size", array('category_id' =>$product->category_id, 'is_active'=>'1'));
					if($get_size_query->num_rows()>0)
					{
						foreach($get_size_query->result() as $size){
							$get_size_price_query = $this->db->get_where("product_size_price", array('product_id' =>$product->id, 'size_id' => $size->id));
							$size_base_price = $get_size_price_query->row()->price;
							$mandatory_type_query = $this->db->get_where("type", array("category_id" => $product->category_id,"is_active" => "1", "is_mandatory"=>"1"));
							if($mandatory_type_query->num_rows()>0)
							{
								foreach ($mandatory_type_query->result() as $type) {
									$default_type_option_query = $this->db->get_where("type_options", array("type_id" => $type->id,"is_active" => "1", "is_default"=>"1"));
									if($default_type_option_query->num_rows()>0)
									{
										$type_option_price_query = $this->db->get_where("product_pricing", array("product_id" => $data['product_id'],"size_id" => $size->id, "type_option_id"=>$default_type_option_query->row()->id)); 
										$size_base_price = $size_base_price + $type_option_price_query->row()->price;
									}
								}
							}
							$size_array[] = array(
								'id'			=>	$size->id,
								'name'			=>	$size->name,
								'description'	=>	$size->description,
								'image'			=>	$this->config->item('file_upload_base_url').'size/normal/'.$size->image,
								'is_default'	=>	$size->is_default,
								'price'			=>	strval(number_format($size_base_price, 2, '.', ''))
							);
						}
					}
					else{
						$size_array = array();
					}
				}
				else
				{
					$size_array = array();
				}
				$product_array = array(
					'id'				=>	$product->id,
					'name'				=>	$product->name,
					'food_category_id'	=>	$product->food_category_id,
					'description'		=>	$product->description,
					'featured_image'	=>	$this->config->item('file_upload_base_url').'products/normal/'.$product->image,
					'other_images'		=>	$image_array,
					'size_exists'		=>	$product->size_exists,
					'size_array'		=>	$size_array,
					'type_array'		=>	$this->get_product_addon($product->id),
					'price'				=>	strval(number_format($this->get_product_price($product->id), 2, '.', ''))
				);
			}
			else
			{
				$product_array = array();
			}
			$return_array['food'] = $product_array;
			$return_array['status'] =array(
				"message"	=>	"Success",
				'err_code'	=>	200
			);
		}
		else
		{
			$return_array['status'] =array(
				"message"	=>	"Invalid Token",
				'err_code'	=>	500
			);
		}
		return $return_array;
	}

	public function order_status()
	{
		$query = $this->db->get_where("order_status", array('is_active' => '1'));
		if($query->num_rows()>0)
		{
			$return_array['result'] = $query->result();
			$return_array['status'] =array(
				"message"	=>	"Success",
				'err_code'	=>	200
			);
		}
		else
		{
			$return_array['status'] =array(
				"message"	=>	"No Data Found",
				'err_code'	=>	400
			);
		}
		return $return_array;
	}

	function add_address($user_id,$data)
    {
        $insert_array = array(
            'user_id'       =>  $user_id,
            'name'          =>  $data['name'],
            'address_name'  =>  $data['address_name'],
            'phone'         =>  $data['phone'],
            'country_id'    =>  $data['country_id'],
            'province_id'   =>  $data['state_id'],
            'zipcode'       =>  $data['zipcode'],
            'landmark'      =>  $data['landmark'],
            'city'          =>  $data['city'],
            'address'       =>  $data['address'],
            'is_active'     =>  '1'
        );

        $insert_query = $this->db->insert('address_book', $insert_array);
		if($insert_query){
			$address_id = $this->db->insert_id();
            $update_query = $this->db->set('is_active', '0')->where('id !=', $address_id)->update('address_book');
		}
        
        return $update_query;
    }

	function edit_address($data)
    {
        $update_array = array(
            'name'          =>  $data['name'],
            'address_name'  =>  $data['address_name'],
            'phone'         =>  $data['phone'],
            'country_id'    =>  $data['country_id'],
            'province_id'   =>  $data['state_id'],
            'zipcode'       =>  $data['zipcode'],
            'landmark'      =>  $data['landmark'],
            'city'          =>  $data['city'],
            'address'       =>  $data['address'],
        );

        $update_query = $this->db->where('id', $data['address_id'])->update('address_book', $update_array);
        return $update_query;
    }

	function delete_address($user_id,$data)
    {
		$address_id = $data['address_id'];
		$arr = array(
			'is_active'	=>	'0',
			'is_delete'	=>	'1'
		);
        $delete_query = $this->db->where('id', $address_id)->update('address_book', $arr);
		if($delete_query){
			$default_address_query = $this->db->query("SELECT * FROM pz_address_book WHERE id !='$address_id' AND user_id='$user_id' AND is_active='1' AND is_delete='0'");
			if($default_address_query->num_rows() == 0){
				$update_query = $this->db->query("UPDATE pz_address_book SET is_active = '1' WHERE is_delete='0' AND user_id='$user_id' ORDER BY id ASC LIMIT 1");
				$return = $update_query;
			}
			else{
				$return = $delete_query;
			}
		}
		else{
			$return = 0;
		}
        return $return;
    }

	function default_address($user_id,$data)
	{
		$address_id = $data['address_id'];
		$update_query = $this->db->set('is_active', '1')->where('id', $address_id)->update('address_book');
        if($update_query){
            $this->db->set('is_active', '0');
            $this->db->where('id !=', $address_id);
            $this->db->where('user_id', $user_id);
            $update_query = $this->db->update('address_book');
        }
        return $update_query;
	}

	function update_cart_quantity($data)
	{
		$get_cart_query = $this->db->get_where("cart", array('id' =>$data['cart_id']));
		if($get_cart_query->num_rows()>0){
			$unit_price = $get_cart_query->row()->price/$get_cart_query->row()->quantity;
			$updated_price = $unit_price * $data['quantity'];
			$arr = array(
				'quantity'	=>	$data['quantity'],
				'price'		=>	$updated_price
			);
			$update_query = $this->db->where('id', $data['cart_id'])->update('cart', $arr);
			$return = $update_query;
		}
		else{
			$return = 0;
		}
		return $return;
	}

	function delete_cart($id)
    {
		$get_cart_query = $this->db->get_where("cart", array('id' =>$id));
		if($get_cart_query->num_rows()>0){
			$return = $this->db->where('id', $id)->delete('cart');
        	return $return;
		}
		else{
			return 0;
		}
    }

	function place_order($user_id)
	{
		$return_array = array();
		$count = 0;
		$return = 0;
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
						$return_array = array(
							'order_number'	=>	$order_number,
							'err_code' 		=> 200
						);	
					}
					else{
						$return_array = array(
							'order_number'	=>	"",
							'err_code' 		=> 500
						);
					}
				}
			}
		}
		return $return_array;
	}

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
        }
		else{
			$return = 0;
		}
        return $return;
    }

	public function my_orders($user_id)
    {
        $return_array = array();
        $order_query = $this->db->get_where("order", array("user_id" => $user_id));
        if($order_query->num_rows()>0)
        {
            foreach($order_query->result() as $order){
                $get_order_details_query = $this->db->get_where("order_details", array("order_id" => $order->id));
                $order_details_array = array();
                if($get_order_details_query->num_rows()>0)
                {
                    foreach($get_order_details_query->result() as $order_details){
                    
                        $order_details_array[] = array(
                                'product_id'    =>  $order_details->product_id,
                                'size_id'       =>  $order_details->size_id,
                                'addon_array'   =>  unserialize($order_details->custom_params),
                                'price'         =>  $order_details->price,
                                'quantity'      =>  $order_details->quantity
                        );
                    }
                }
                $status_query = $this->db->get_where("order_status", array("id" => $order->status_id));
                $address_query = $this->db->get_where("address_book", array("id" => $order->address_id));
                $order_array[] = array(
                    'id'            =>  $order->id,
                    'order_no'      =>  $order->order_number,
                    'order_date'    =>  date("F j, Y", strtotime($order->order_date)),
                    'order_array'   =>  $order_details_array,
                    'address_array' =>  $address_query->row(),
                    'status_array'  =>  $status_query->row(),
                    'invoice'       =>  $this->config->item('file_upload_base_url').'dist/invoice_pdfs/'.$order->invoice,
                    'payment_method'=>  $order->payment_option
                );
            }
        }
        return $order_array;
    }

	// public function customize_food($data)
	// {
	// 	$product_id = $data['product_id'];
	// 	$size_id = $data['size_id'];
	// 	$type_option_id = $data['type_option_id'];
	// 	$query = $this->db->get_where("business_user", array('access_token' => $data['access_token']));
	// 	if($query->num_rows() > 0)
	// 	{
	// 		$user_id = $query->row()->id;
	// 		$get_size_price_query = $this->db->get_where("product_size_price", array('product_id' =>$product_id, 'size_id' => $size_id));
	// 		$size_base_price = $get_size_price_query->row()->price;

	// 		$type_option_price_query = $this->db->get_where("product_pricing", array("product_id" => $product_id,"size_id" => $size_id, "type_option_id"=>$default_type_option_query->row()->id)); 
	// 		$base_price = $base_price + $type_option_price_query->row()->price;


	// 	}
	// 	else
	// 	{
	// 		$return_array['status'] =array(
	// 			"message"	=>	"Invalid Token",
	// 			'err_code'	=>	500
	// 		);
	// 	}
	// 	return $return_array;
	// }

	function get_product_price($id)
	{
	    $default_query = $this->db->query("SELECT ty.* FROM pz_type ty LEFT JOIN pz_type_options tyo ON ty.id = tyo.type_id WHERE tyo.id ='$id' AND tyo.is_active = '1'");
	    
		$category_id_query = $this->db->get_where("products", array("id" => $id,"is_active" => "1"));
		
		$category_id = $category_id_query->row()->category_id;
		if($category_id_query->row()->size_exists == '1')
		{
			$size_id_query = $this->db->get_where("size", array("category_id" => $category_id,"is_active" => "1", "is_default"=>"1"));
			$size_id = $size_id_query->row()->id;
		}
		else
		{
			$size_id = 0;
		}
		$size_price_query = $this->db->get_where("product_size_price", array("product_id" => $id,"size_id" => $size_id));
		if($size_price_query->num_rows()>0)
		{
			$base_price = $size_price_query->row()->price;
		}
		else{
			$base_price = 0;
		}

		$mandatory_type_query = $this->db->get_where("type", array("category_id" => $category_id,"is_active" => "1", "is_mandatory"=>"1"));
		if($mandatory_type_query->num_rows()>0)
		{
			foreach ($mandatory_type_query->result() as $type) {
				$default_type_option_query = $this->db->get_where("type_options", array("type_id" => $type->id,"is_active" => "1", "is_default"=>"1"));
				if($default_type_option_query->num_rows()>0)
				{
					$type_option_price_query = $this->db->get_where("product_pricing", array("product_id" => $id,"size_id" => $size_id, "type_option_id"=>$default_type_option_query->row()->id)); 
					$base_price = $base_price + $type_option_price_query->row()->price;
				}
			}
		}
		return $base_price;
	}

	function get_product_addon($id)
	{
	    $addon_array = array();
	    $query=$this->db->query("SELECT ty.* FROM pz_type ty INNER JOIN pz_products pr ON ty.category_id = pr.category_id WHERE pr.id='$id' AND pr.is_active='1' AND ty.is_active='1'");
	    if($query->num_rows()>0)
		{
			$results=$query->result();
			foreach($results as $result)
			{
				$addon_query = $this->db->get_where("type_options", array("type_id" => $result->id, 'is_active' => '1'));
				$option_array = array();
				if($addon_query->num_rows()>0)
				{
					foreach ($addon_query->result() as $opt) {
						$option_array[] = (object)array(
							'option_id' 	=> $opt->id,
							'option_name'	=> $opt->name,
							'option_image'	=> $this->config->item('file_upload_base_url').'type_option/normal/'.$opt->image,
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
}