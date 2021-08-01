<?php 
    $path=$this->config->item('file_upload_base_url').'products/normal/';
    //echo "<pre>"; print_r($carts); die();
    if(!$this->session->userdata('doughit_userid')){
        $total_amount = 0;
        if(!empty($carts)){
            foreach($carts as $key => $cart)
            {
                $total_price = get_final_price($cart) * $cart['quantity'];
                $cart_arr[] = array(
                    'id'            =>  0,
                    'quantity'      =>  (int)$cart['quantity'],
                    'product_id'    =>  $cart['product_id'],
                    'price'         =>  $total_price,
                    'size_id'       =>  $cart['size_id'],
                    'type_array'    =>  $cart['type_array']
                );
                $total_amount = $total_amount + $total_price;
            }
        }
        else{
            $cart_arr = array();
        }
    }
    else{
        $total_amount = 0;
        if(!empty($carts)){
            foreach($carts as $key => $cart)
            {
                $total_price = $cart['price'] * $cart['quantity'];
                $cart_arr[] = array(
                    'id'            =>  $cart['id'],
                    'quantity'      =>  (int)$cart['quantity'],
                    'product_id'    =>  $cart['product_id'],
                    'price'         =>  $cart['price'],
                    'size_id'       =>  $cart['size_id'],
                    'type_array'    =>  $cart['type_array']
                );
                $total_amount = $total_amount + $cart['price'];
            }
        }
        else
        {
            $cart_arr = array();
        }
    }
    // echo "<pre>"; print_r($test_arr); die();
?>


<?php if(!empty($cart_arr)) { ?>
        <div class="container">
            <div class="cart-item-table commun-table">
                <div class="table-responsive">

                <table class="table border mb-0">
                    <thead>
                        <tr>
                            <th class="align-left">Product</th>
                            <th class="align-left">Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Sub Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        if($this->session->userdata('doughit_userid')){  
                            foreach($cart_arr as $key => $cart)
                            { ?>
                                <tr id="tr_row<?=$key?>">
                                    <td class="align-left">
                                        <a href="<?=base_url()?>product/<?=$cart['product_id']?>">
                                            <div class="product-image">
                                                <img alt="Eshoper" src="<?=$path.get_image_name($cart['product_id'])?>">
                                            </div>
                                            </a>
                                    </td>
                                    <td class="align-left">
                                        <div class="product-title"> 
                                            <a href="<?=base_url()?>product/<?=$cart['product_id']?>"><?=get_product_name($cart['product_id'])?></a> 
                                        </div>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>
                                                <div class="base-price price-box"> 
                                                    <span class="price">$ <?=number_format(($cart['price'] / $cart['quantity']), 2, '.', '')?></span> 
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <div class="input-box">
                                            <span class="minus" onclick="update_quantity(<?=$cart['id']?>,'minus', <?=$key?>)">-</span>
                                            <input type="text" id="quant<?=$key?>" value="<?=$cart['quantity']?>"/>
                                            <span class="plus" onclick="update_quantity(<?=$cart['id']?>,'plus', <?=$key?>)">+</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="total-price price-box"> 
                                            <span class="price" id="sub_total<?=$key?>">$ <?=number_format(($cart['price']), 2, '.', '')?></span> 
                                        </div>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn small btn-color" onclick="delete_product_from_cart(<?=$cart['id']?>,<?=$key?>)">
                                            <i title="Remove Item From Cart" data-id="100" class="fa fa-trash cart-remove-item"></i>
                                        </a>
                                    </td>
                                </tr>
                        <?php  }  
                        }
                        else {
                            foreach($cart_arr as $key => $cart)
                            { ?>
                                <tr id="tr_row<?=$key?>">
                                    <td class="align-left">
                                        <a href="<?=base_url()?>product/<?=$cart['product_id']?>">
                                            <div class="product-image">
                                                <img alt="Eshoper" src="<?=$path.get_image_name($cart['product_id'])?>">
                                            </div>
                                            </a>
                                    </td>
                                    <td class="align-left">
                                        <div class="product-title"> 
                                            <a href="<?=base_url()?>product/<?=$cart['product_id']?>"><?=get_product_name($cart['product_id'])?></a> 
                                        </div>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>
                                                <div class="base-price price-box"> 
                                                    <span class="price">$ <?=number_format((get_final_price($cart)), 2, '.', '')?></span> 
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <div class="input-box">
                                            <span class="minus" onclick="update_quantity(<?=$cart['id']?>,'minus', <?=$key?>)">-</span>
                                            <input type="text" id="quant<?=$key?>" value="<?=$cart['quantity']?>"/>
                                            
                                            <span class="plus" onclick="update_quantity(<?=$cart['id']?>,'plus', <?=$key?>)">+</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="total-price price-box"> 
                                            <span class="price" id="sub_total<?=$key?>">$ <?=number_format((get_final_price($cart) * $cart['quantity']), 2, '.', '')?></span> 
                                        </div>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn small btn-color" onclick="delete_product_from_cart(<?=$cart['id']?>,<?=$key?>)">
                                            <i title="Remove Item From Cart" data-id="100" class="fa fa-trash cart-remove-item"></i>
                                        </a>
                                    </td>
                                </tr>
                    <?php   } 
                        } ?>    
                        
                    </tbody>
                </table>
                    
                </div>
            </div>
            <div class="mb-30">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-30 text-center-r"> 
                            <a href="<?=base_url()?>order_online" class="btn btn-color">
                                <i class="fa fa-angle-left"></i><span>Continue Shopping</span>
                            </a> 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-30 right-side float-none-sm text-center-r"> 
                            <a href="javascript:void(0)" class="btn btn-color">Update Cart</a> 
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="mtb-30">
                <div class="row">
                    <div class="col-md-6 mb-sm-20">
                        <!-- <div class="estimate">
                            <div class="heading-part mb-20">
                                <h3 class="sub-heading text-center-r">Estimate shipping and tax</h3>
                            </div>
                            <form class="full">
                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-box mb-20">
                                            <select id="country_id" class="full">
                                                <option selected="" value="">Select Country</option>
                                                <option value="1">India</option>
                                                <option value="2">China</option>
                                                <option value="3">Pakistan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box mb-20">
                                            <select id="state_id" class="full">
                                                <option selected="" value="1">Select State/Province</option>
                                                <option value="2">---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-box mb-20">
                                            <select id="city_id" class="full">
                                                <option selected="" value="1">Select City</option>
                                                <option value="2">---</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div> -->
                    </div>
                    <div class="col-md-6">
                        <div class="cart-total-table commun-table">
                            <div class="table-responsive">
                                <table class="table border">
                                    <thead>
                                        <tr>
                                            <th colspan="2" class="text-center-r">Cart Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Item(s) Subtotal</td>
                                            <td>
                                                <div class="price-box"> 
                                                    <span class="price" id="total_amount">$ <?=number_format($total_amount,2,'.','')?></span> 
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Shipping</td>
                                            <td>
                                                <div class="price-box"> 
                                                    <span class="price">$0.00</span> 
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Amount Payable</b></td>
                                            <td>
                                                <div class="price-box">
                                                    <input type="hidden" id="amount_payable_hidden" value="<?=$total_amount?>">
                                                    <span class="price" id="amount_payable"><b>$ <?=number_format($total_amount,2,'.','')?></b></span> 
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="mt-30">
                <div class="row">
                    <div class="col-12">
                        <div class="right-side float-none-xs text-center-r float-none-sm"> 
                            <a href="<?=base_url()?>checkout" class="btn btn-color">Proceed to checkout
                                <span><i class="fa fa-angle-right"></i></span>
                            </a> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php } else { ?>
    <div class="col-xl-12 col-lg-12 col-md-12">
        <p style="text-align: center">Your Cart is empty</p>
        <div class="col-md-12">
        <div class="mt-30 text-center"> 
                <a href="<?=base_url()?>order_online" class="btn btn-color">
                    <i class="fa fa-angle-left"></i><span>Continue Shopping</span>
                </a> 
            </div>
        </div>
    </div>
<?php } ?>  