<?php
class Search_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

    function filter_product($data)
    {
        $addon_array = array();
        $return = array();
        if(isset($data['addon_array']))
        {
            foreach ($data['addon_array'] as $addon) {
                if($addon['type_option_id'] == '')
                {
                    $addon_query = $this->db->get_where("type_options", array("type_id" => $addon['type_id'], 'is_active' => '1'));
                    if($addon_query->num_rows()>0)
                    {
                        foreach ($addon_query->result() as $result) {
                            array_push($addon_array, $result->id);
                        }
                    }
                }
                else
                {
                    array_push($addon_array, $addon['type_option_id']);
                }
                $addon_array_str = implode("','", $addon_array);
            }
            $query = "SELECT prod.* FROM pz_products prod LEFT JOIN pz_product_pricing prc ON prod.id = prc.product_id WHERE prod.is_active = '1' AND prod.category_id ='".$data["category_id"]."' AND prc.type_option_id IN('".$addon_array_str."')";
        }
        else
        {
            $query = "SELECT prod.* FROM pz_products prod LEFT JOIN pz_product_pricing prc ON prod.id = prc.product_id WHERE prod.is_active = '1' AND prod.category_id ='".$data["category_id"]."'";
        }
    

        if((isset($data['food_category'])) && ($data['food_category'] != ""))
        {
            $query .= " AND prod.food_category_id = '".$data['food_category']."'";
        }
        if((isset($data['size'])) && ($data['size'] != ""))
        {
            $query .= " AND prc.size_id = '".$data['size']."'";
        }
        $query .=  " GROUP BY prod.id";

        if((isset($data['price'])) && ($data['price'] != ""))
        {
            $filter_query=$this->db->query($query);
            if($filter_query->num_rows()>0)
            {
                $results=$filter_query->result();
                foreach ($results as $product) {
                    $base_price = $this->get_product_price($product->id);
                    if($data['price'] == 1)
                    {
                        if($base_price < 15)
                        {
                            $return[] = (object)array(
                                'id'            =>  $product->id,
                                'name'          =>  $product->name,
                                'description'   =>  $product->description,
                                'image'         =>  $product->image,
                                'base_price'    =>  $base_price
                            );
                        }
                    }
                    if($data['price'] == 2)
                    {
                        if($base_price > 15 && $base_price < 20)
                        {
                            $return[] = (object)array(
                                'id'            =>  $product->id,
                                'name'          =>  $product->name,
                                'description'   =>  $product->description,
                                'image'         =>  $product->image,
                                'base_price'    =>  $base_price
                            );
                        }
                    }
                    if($data['price'] == 3)
                    {
                        if($base_price > 20)
                        {
                            $return[] = (object)array(
                                'id'            =>  $product->id,
                                'name'          =>  $product->name,
                                'description'   =>  $product->description,
                                'image'         =>  $product->image,
                                'base_price'    =>  $base_price
                            );
                        }
                    }
                }
            }
            else
            {
                $return= [];   
            }
            
        }
        else
        {
            $filter_query=$this->db->query($query);
            if($filter_query->num_rows()>0)
            {
                $results=$filter_query->result();
                foreach ($results as $product) {
                    $base_price = $this->get_product_price($product->id);
                    $return[] = (object)array(
                        'id'            =>  $product->id,
                        'name'          =>  $product->name,
                        'description'   =>  $product->description,
                        'image'         =>  $product->image,
                        'base_price'    =>  $base_price
                    );
                }
            }
            else
            {
                $return= [];   
            }
        }
        return $return;
    }


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
}
?>