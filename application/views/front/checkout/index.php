<?php
    // echo "<pre>"; print_r($data);
    $path=$this->config->item('file_upload_base_url').'products/normal/';
    if(!$this->session->userdata('doughit_userid')){
        $total_amount = 0;
        
        foreach($data as $key => $cart)
        {
            $total_price = get_final_price($cart) * $cart['quantity'];
            $checkout_arr[] = array(
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
        $total_amount = 0;
        foreach($data as $key => $cart)
        {
            $total_price = get_final_price($cart) * $cart['quantity'];
            $checkout_arr[] = array(
                'id'            =>  $cart['id'],
                'quantity'      =>  (int)$cart['quantity'],
                'product_id'    =>  $cart['product_id'],
                'price'         =>  $total_price,
                'size_id'       =>  $cart['size_id'],
                'type_array'    =>  $cart['type_array']
            );
            $total_amount = $total_amount + $total_price;
        }
        // echo $this->session->userdata('doughit_userid');
        $get_default_address = get_default_address($this->session->userdata('doughit_userid'));
        
        // print_r($get_default_address);
    }
    $get_countries = get_countries();
?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/front/css/checkout-style.css">
<section class="page-banner" style="background: #121619 url(<?=base_url()?>dist/front/images/blog-1.jpg) no-repeat center / cover;">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="page-title">
                    <h1 class="page-headding"><?=$mainheader?></h1>
                    <ul>
                        <li><a href="<?=base_url()?>" class="page-name">Home</a></li>
                        <!-- <li><a href="<?=base_url()?>cart" class="page-name">Cart</a></li> -->
                        <li><?=$mainheader?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="checkout-part ptb">
    <div class="container">
        
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="mb-md-30">
                        <?php if(!$this->session->userdata('doughit_userid')){ ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="heading-part mb-30">
                                        <h3>Shipping Details</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <p style="text-align: center">Login to continue</p>
                                <div class="col-md-12">
                                    <div class="mt-30 text-center"> 
                                        <a href="<?=base_url()?>login" class="btn btn-color">
                                            <span>Login / Sign up</span>
                                        </a> 
                                    </div>
                                </div>
                            </div>
                            
                        <?php } else { ?>
                            <!-- <i class="fa fa-angle-left"></i> -->

                            <!-- <div class="mb-60">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="heading-part mb-30 mb-sm-20">
                                            <h3>Billing Details</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="full-name">Full Name*</label>
                                            <input id="full-name" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="company-name">Company Name</label>
                                            <input id="company-name" type="text">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input id="email" type="text">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="phone-no">Phone No*</label>
                                            <input id="phone-no" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="conutry">Conutry*</label>
                                            <input id="conutry" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="address">Address*</label>
                                            <input id="address" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="zip">Pastcode / Zip*</label>
                                            <input id="zip" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="city">Town / City*</label>
                                            <input id="city" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="check-box mt-n2">
                                            <span>
                                                <input type="checkbox" class="checkbox" id="create-account" name="Create an Account?">
                                                <label for="create-account" class="mb-0">Create an Account?</label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <div class="sc-hCbubC kbZrHQ" id="delivery_address" <?php if($get_default_address == []){ ?> style="display:none" <?php } ?>>
                                <div class="sc-kMBllD hBWlmF">
                                    <p class="sc-1hez2tp-0 sc-eMkkdE gynZOa">Delivery Address</p>
                                    <div class="sc-sJJJd CbSJd"></div>
                                </div>
                                
                                <div class="sc-cSYcjD ePjHlY">
                                    <div class="sc-gjAXCV dxlkqE">
                                        <div class="sc-dOkuiw kFKSeJ"><i class="sc-rbbb40-1 iFnyeo" color="#2781E7" size="24"><svg xmlns="http://www.w3.org/2000/svg" fill="#2781E7" width="24" height="24" viewBox="0 0 20 20" aria-labelledby="icon-svg-title- icon-svg-desc-" role="img" class="sc-rbbb40-0 fmIpur"><g clip-path="url(#clip0)"><path d="M14.75 8.3125L9.25 13.8125C9.125 13.9375 8.9375 14.0625 8.75 14.0625C8.5625 14.0625 8.375 14 8.1875 13.8125L5.1875 10.8125C4.875 10.5 4.875 10.0625 5.1875 9.75C5.5 9.4375 5.9375 9.4375 6.25 9.75L8.75 12.1875L13.6875 7.25C14 6.9375 14.4375 6.9375 14.75 7.25C15.0625 7.5625 15.0625 8 14.75 8.3125ZM17.0625 2.9375C13.125 -1 6.8125 -1 2.9375 2.9375C-0.9375 6.8125 -0.9375 13.1875 2.9375 17.0625C6.875 21 13.1875 21 17.125 17.0625C21.0625 13.125 21 6.8125 17.0625 2.9375Z"></path></g><defs><clipPath id="clip0"><rect width="20" height="20"></rect></clipPath></defs></svg></i>
                                            <div class="sc-bLJvFH ggeejr">
                                                <p class="sc-1hez2tp-0 sc-jGFFOr hyUFDP"><?=ucfirst($get_default_address->address_name)?></p>
                                            </div>
                                        </div>
                                        <div class="sc-eAudoH deAedY">
                                            <p class="sc-1hez2tp-0 sc-hZeNU lpgKaX"><?=$get_default_address->address?>, <?=$get_default_address->city?>, landmark- <?=$get_default_address->landmark?>, postal code- <?=$get_default_address->zipcode?>, city- <?=$get_default_address->city?>, Province- <?=get_province_name($get_default_address->province_id)?>, Country- <?=get_country_name($get_default_address->country_id)?></p>
                                        </div>
                                    </div>
                                    <p class="sc-1hez2tp-0 sc-hMjcWo fgStgS" onclick="change_address(<?=$this->session->userdata('doughit_userid')?>)">CHANGE</p>
                                </div>
                            </div>

                            <div class="sc-fdcRnX jZSwxz">
                                <div id="address_book" style="display:none">
                                    <!-- <div class="sc-dJJlpf kTDRxU">
                                        <p class="sc-1hez2tp-0 sc-TZjqS fhDAPo">Delivery Address</p>
                                        <div class="sc-kxyuPp gXbAHG"></div>
                                    </div>
                                    <div class="sc-cGrIXu khMiYs">
                                        <div>
                                            <div class="sc-ewTrYR AQYSc">
                                                <div class="sc-beROAQ xinvb"><i class="sc-rbbb40-1 iFnyeo" color="#2781E7" size="24"><svg xmlns="http://www.w3.org/2000/svg" fill="#2781E7" width="24" height="24" viewBox="0 0 20 20" aria-labelledby="icon-svg-title- icon-svg-desc-" role="img" class="sc-rbbb40-0 fmIpur"><g clip-path="url(#clip0)"><path d="M14.75 8.3125L9.25 13.8125C9.125 13.9375 8.9375 14.0625 8.75 14.0625C8.5625 14.0625 8.375 14 8.1875 13.8125L5.1875 10.8125C4.875 10.5 4.875 10.0625 5.1875 9.75C5.5 9.4375 5.9375 9.4375 6.25 9.75L8.75 12.1875L13.6875 7.25C14 6.9375 14.4375 6.9375 14.75 7.25C15.0625 7.5625 15.0625 8 14.75 8.3125ZM17.0625 2.9375C13.125 -1 6.8125 -1 2.9375 2.9375C-0.9375 6.8125 -0.9375 13.1875 2.9375 17.0625C6.875 21 13.1875 21 17.125 17.0625C21.0625 13.125 21 6.8125 17.0625 2.9375Z"></path></g><defs><clipPath id="clip0"><rect width="20" height="20"></rect></clipPath></defs></svg></i>
                                                </div>
                                                <div class="sc-iWdsyN igTohe">
                                                    <p class="sc-1hez2tp-0 sc-iupvsZ iGQBdM">Home</p>
                                                    <p class="sc-1hez2tp-0 sc-eYTUqP cAGsam">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                                                    <div class="sc-bXtxjY cSXkfQ">
                                                        <button role="button" tabindex="0" aria-disabled="false" class="sc-1kx5g6g-1 jrAmIP"><span tabindex="-1" class="sc-1kx5g6g-2 lpnzyc"><span class="sc-1kx5g6g-3 dkwpEa">Deliver here</span></span>
                                                        </button>
                                                        <button role="button" tabindex="0" aria-disabled="false" class="sc-1kx5g6g-1 jrAmIP"><span tabindex="-1" class="sc-1kx5g6g-2 hWLDLq"><span class="sc-1kx5g6g-3 dkwpEa">Edit</span></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sc-ewTrYR kuwulx">
                                                <div class="sc-beROAQ xinvb"><i class="sc-rbbb40-1 iFnyeo" color="#D02A38" size="24"><svg xmlns="http://www.w3.org/2000/svg" fill="#D02A38" width="24" height="24" viewBox="0 0 20 20" aria-labelledby="icon-svg-title- icon-svg-desc-" role="img" class="sc-rbbb40-0 fmIpur"><path d="M10 0C4.5 0 0 4.5 0 10C0 15.5 4.5 20 10 20C15.5 20 20 15.5 20 10C20 4.5 15.5 0 10 0ZM13.375 12.3125C13.6875 12.625 13.6875 13.125 13.375 13.4375C13.25 13.5625 13.0625 13.625 12.875 13.625C12.6875 13.625 12.5 13.5 12.375 13.4375L10 11.125L7.6875 13.4375C7.5625 13.5625 7.375 13.625 7.1875 13.625C7 13.625 6.8125 13.5 6.6875 13.4375C6.375 13.125 6.375 12.625 6.6875 12.3125L8.875 10L6.5625 7.6875C6.25 7.375 6.25 6.875 6.5625 6.5625C6.875 6.25 7.375 6.25 7.6875 6.5625L10 8.875L12.3125 6.5625C12.625 6.25 13.125 6.25 13.4375 6.5625C13.75 6.875 13.75 7.375 13.4375 7.6875L11.125 10L13.375 12.3125Z"></path></svg></i>
                                                </div>
                                                <div class="sc-iWdsyN igTohe">
                                                    <p class="sc-1hez2tp-0 sc-iupvsZ iGQBdM">Other</p>
                                                    <p class="sc-1hez2tp-0 sc-eYTUqP cAGsam">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                                                    <div class="sc-bXtxjY cSXkfQ">
                                                        <button disabled="" role="button" tabindex="0" aria-disabled="true" class="sc-1kx5g6g-1 dUSuIq"><span disabled="" tabindex="-1" class="sc-1kx5g6g-2 kQifCq"><span class="sc-1kx5g6g-3 dkwpEa">Does not deliver here</span></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sc-ewTrYR kuwulx">
                                                <div class="sc-beROAQ xinvb"><i class="sc-rbbb40-1 iFnyeo" color="#D02A38" size="24"><svg xmlns="http://www.w3.org/2000/svg" fill="#D02A38" width="24" height="24" viewBox="0 0 20 20" aria-labelledby="icon-svg-title- icon-svg-desc-" role="img" class="sc-rbbb40-0 fmIpur"><path d="M10 0C4.5 0 0 4.5 0 10C0 15.5 4.5 20 10 20C15.5 20 20 15.5 20 10C20 4.5 15.5 0 10 0ZM13.375 12.3125C13.6875 12.625 13.6875 13.125 13.375 13.4375C13.25 13.5625 13.0625 13.625 12.875 13.625C12.6875 13.625 12.5 13.5 12.375 13.4375L10 11.125L7.6875 13.4375C7.5625 13.5625 7.375 13.625 7.1875 13.625C7 13.625 6.8125 13.5 6.6875 13.4375C6.375 13.125 6.375 12.625 6.6875 12.3125L8.875 10L6.5625 7.6875C6.25 7.375 6.25 6.875 6.5625 6.5625C6.875 6.25 7.375 6.25 7.6875 6.5625L10 8.875L12.3125 6.5625C12.625 6.25 13.125 6.25 13.4375 6.5625C13.75 6.875 13.75 7.375 13.4375 7.6875L11.125 10L13.375 12.3125Z"></path></svg></i>
                                                </div>
                                                <div class="sc-iWdsyN igTohe">
                                                    <p class="sc-1hez2tp-0 sc-iupvsZ iGQBdM">Work</p>
                                                    <p class="sc-1hez2tp-0 sc-eYTUqP cAGsam">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                                                    <div class="sc-bXtxjY cSXkfQ">
                                                        <button disabled="" role="button" tabindex="0" aria-disabled="true" class="sc-1kx5g6g-1 dUSuIq"><span disabled="" tabindex="-1" class="sc-1kx5g6g-2 kQifCq"><span class="sc-1kx5g6g-3 dkwpEa">Does not deliver here</span></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sc-ewTrYR kuwulx">
                                                <div class="sc-beROAQ xinvb"><i class="sc-rbbb40-1 iFnyeo" color="#D02A38" size="24"><svg xmlns="http://www.w3.org/2000/svg" fill="#D02A38" width="24" height="24" viewBox="0 0 20 20" aria-labelledby="icon-svg-title- icon-svg-desc-" role="img" class="sc-rbbb40-0 fmIpur"><path d="M10 0C4.5 0 0 4.5 0 10C0 15.5 4.5 20 10 20C15.5 20 20 15.5 20 10C20 4.5 15.5 0 10 0ZM13.375 12.3125C13.6875 12.625 13.6875 13.125 13.375 13.4375C13.25 13.5625 13.0625 13.625 12.875 13.625C12.6875 13.625 12.5 13.5 12.375 13.4375L10 11.125L7.6875 13.4375C7.5625 13.5625 7.375 13.625 7.1875 13.625C7 13.625 6.8125 13.5 6.6875 13.4375C6.375 13.125 6.375 12.625 6.6875 12.3125L8.875 10L6.5625 7.6875C6.25 7.375 6.25 6.875 6.5625 6.5625C6.875 6.25 7.375 6.25 7.6875 6.5625L10 8.875L12.3125 6.5625C12.625 6.25 13.125 6.25 13.4375 6.5625C13.75 6.875 13.75 7.375 13.4375 7.6875L11.125 10L13.375 12.3125Z"></path></svg></i>
                                                </div>
                                                <div class="sc-iWdsyN igTohe">
                                                    <p class="sc-1hez2tp-0 sc-iupvsZ iGQBdM">Other</p>
                                                    <p class="sc-1hez2tp-0 sc-eYTUqP cAGsam">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                                                    <div class="sc-bXtxjY cSXkfQ">
                                                        <button disabled="" role="button" tabindex="0" aria-disabled="true" class="sc-1kx5g6g-1 dUSuIq"><span disabled="" tabindex="-1" class="sc-1kx5g6g-2 kQifCq"><span class="sc-1kx5g6g-3 dkwpEa">Does not deliver here</span></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="sc-dyKSPo dAAuHT" data-toggle="modal" data-target="#exampleModalCenter"><i class="sc-rbbb40-1 iFnyeo" size="24" color="#d93128"><svg xmlns="http://www.w3.org/2000/svg" fill="#d93128" width="24" height="24" viewBox="0 0 20 20" aria-labelledby="icon-svg-title- icon-svg-desc-" role="img" class="sc-rbbb40-0 fmIpur"><title>plus</title><path d="M15.5 9.42h-4.5v-4.5c0-0.56-0.44-1-1-1s-1 0.44-1 1v4.5h-4.5c-0.56 0-1 0.44-1 1s0.44 1 1 1h4.5v4.5c0 0.54 0.44 1 1 1s1-0.46 1-1v-4.5h4.5c0.56 0 1-0.46 1-1s-0.44-1-1-1z"></path></svg></i>
                                    <p class="sc-1hez2tp-0 sc-kVyEtE ijWzCn">Add new address</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <h4>Order Notes</h4>
                                    <div class="notes p-4">
                                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a </p>
                                    </div>
                                </div>
                            </div>
                            
                        <?php } ?>
                            <!-- <div class="mb-60">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="heading-part mb-30 mb-sm-20">
                                            <h3>Billing Details</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="full-name">Full Name*</label>
                                            <input id="full-name" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="company-name">Company Name</label>
                                            <input id="company-name" type="text">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input id="email" type="text">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="phone-no">Phone No*</label>
                                            <input id="phone-no" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="conutry">Conutry*</label>
                                            <input id="conutry" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="address">Address*</label>
                                            <input id="address" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="zip">Pastcode / Zip*</label>
                                            <input id="zip" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="city">Town / City*</label>
                                            <input id="city" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="check-box mt-n2">
                                            <span>
                                                <input type="checkbox" class="checkbox" id="create-account" name="Create an Account?">
                                                <label for="create-account" class="mb-0">Create an Account?</label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="heading-part mb-30 mb-sm-20">
                        <h3>Your order</h3>
                    </div>
                    <div class="checkout-products sidebar-product mb-60">
                        <ul>
                            <?php 
                                if($this->session->userdata('doughit_userid')){  
                                    foreach ($checkout_arr as $product) { ?>
                                        <li>
                                            <div class="pro-media"> <a href="<?=base_url()?>product/<?=$product['product_id']?>"><img alt="pizzon" src="<?=$path.get_image_name($product['product_id'])?>"></a> </div>
                                            <div class="pro-detail-info"> <a href="<?=base_url()?>product/<?=$product['product_id']?>" class="product-title"><?=get_product_name($product['product_id'])?></a>
                                                <div class="price-box"> 
                                                    <span class="price">$ <?=number_format(($product['price']), 2, '.', '')?></span>
                                                    <!-- <del class="price old-price">$22.00</del> -->
                                                </div>
                                                <div class="checkout-qty">
                                                    <div>
                                                        <label>Size: </label>
                                                        <span class="info-deta"><?=get_size_name($product['size_id'])?></span> 
                                                    </div>
                                                </div>
                                                <div class="checkout-qty">
                                                    <div>
                                                        <label>Qty: </label>
                                                        <span class="info-deta"><?=$product['quantity']?></span> 
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                            <?php } } ?>
                        </ul>
                    </div>
                    <div class="complete-order-detail commun-table gray-bg mb-30">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <tbody>
                                    <tr>
                                        <td><b>Date :</b></td>
                                        <td><?=date("F j, Y");?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Total :</b></td>
                                        <td><div class="price-box"> <span class="price">$ <?=number_format(($total_amount), 2, '.', '')?></span> </div></td>
                                    </tr>
                                    <tr>
                                        <td><b>Payment :</b></td>
                                        <td>COD</td>
                                    </tr>
                                    <!-- <tr>
                                        <td><b>Order No. :</b></td>
                                        <td>#011052</td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="dyn_place_order">
                    <button class="btn full btn-color" id="place_order" <?php if((!$this->session->userdata('doughit_userid')) || $get_default_address == []){ ?> disabled <?php } else { ?> onclick="place_order(<?=$this->session->userdata('doughit_userid')?>)" <?php } ?>>Place order</button>
                    </div>
                </div>
            </div>
        
    </div>
</section>


<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content checkout-part">
        <form class="main-form" id="address-form">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLongTitle">Add Address</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="user_id" value="<?=$this->session->userdata('doughit_userid')?>">
                <div class="mb-60">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Full Name*</label>
                                <input id="name" name="name" type="text">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="phone">Phone No*</label>
                                <input id="phone" name="phone" type="text">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="couutry">Conutry*</label>
                                <select id="country" name="country" onchange="get_province(this.value)">
                                    <?php foreach ($get_countries as $country) { ?>
                                    <option value="<?=$country->id?>"><?=$country->name?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="address">Province*</label>
                                <div id="states-presents-div">
                                    <select id="province" name="province">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="address">Address*</label>
                                <input id="address" name="address" type="text">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="zipcode">Postcode / Zip*</label>
                                <input id="zipcode" name="zipcode" type="text">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="landmark">Landmark*</label>
                                <input id="landmark" name="landmark" type="text">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="city">Town / City*</label>
                                <input id="city" name="city" type="text">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="address_name">Address Name*</label>
                                <input id="address_name" name="address_name" type="text">
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>    
    </div>
  </div>
</div>


<script>
    $("#address-form").validate({
        ignore: [],
        debug: false,
        rules: {
            name : "required",
            phone: "required",
            country: "required",
            province: "required",
            address: "required",
            zipcode: "required",
            landmark: "required",
            city: "required",
            address_name: "required"
        },
        messages: {
        name : "Please provide your name",
        phone: "Please provide your phone number",
        country: "Please select a country",
        province: "Please select a province",
        address: "Please provide your address",
        zipcode: "Please provide your zipcode",
        landmark: "Please provide a landmark ",
        city: "Please provide your city name",
        address_name: "Please provide a Short name"
        },
        submitHandler: function(form) {
            //alert(grecaptcha.getResponse().length);return false;
            $.blockUI({ message:  '<img src="<?=base_url()?>dist/admin/img/preloading-white.gif" alt="" class="img-loader-cls"/>',css: { 
                border: 'none', 
                padding: '0px', 
                backgroundColor: 'transparent', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                color: '#fff' 
            } }); 
            var formData = new FormData(form);
            $.ajax({
                type:'POST',
                url: "<?php echo base_url().'address_book/add_address'; ?>",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data) {
                    $('#address-form').trigger("reset");
                    $('#exampleModalCenter').modal('toggle');
                    $('#address_book').hide(); 
                    $('#delivery_address').show();
                    $('#delivery_address').html(data);
                    //$('#place_order').removeAttr("disabled");
                    $('#dyn_place_order').html('<button class="btn full btn-color" id="place_order" <?php if((!$this->session->userdata('doughit_userid'))){ ?> disabled <?php } else { ?> onclick="place_order(<?=$this->session->userdata('doughit_userid')?>)" <?php } ?>>Place order</button>')
                
                    $.unblockUI();
                    return false; 
                },
                error: function(data){
                    console.log("error");
                    console.log(data);
                }
            });
            return false;
        }
    });
    function get_province(countryID){

        var gotourl="<?php echo base_url(); ?>"+'/checkout/get_province';
        $.ajax({
             type: "POST",
             url: gotourl,
             data: { country_id:countryID},
             dataType: "text",
             cache:false,
             
            error: function (xhr) {
                console.log(xhr);
            },

            success: function(data){
                //alert(data);
                $("#states-presents-div").html(data);
            }
        })
    }

    function change_address(id)
    {
        var gotourl="<?php echo base_url(); ?>"+'/address_book/get_address';
        $.ajax({
             type: "POST",
             url: gotourl,
             data: { id:id},
             dataType: "text",
             cache:false,
             
            error: function (xhr) {
                console.log(xhr);
            },

            success: function(data){
                $('#delivery_address').hide();
                $('#address_book').show();
                $('#address_book').html(data);
            }
        })
    }

    function set_default_address(id,user_id)
    {
        var gotourl="<?php echo base_url(); ?>"+'/address_book/change_default_address';
        $.ajax({
             type: "POST",
             url: gotourl,
             data: { id:id, user_id: user_id},
             dataType: "text",
             cache:false,
             
            error: function (xhr) {
                console.log(xhr);
            },

            success: function(data){
                $('#address_book').hide(); 
                $('#delivery_address').show();
                $('#delivery_address').html(data);
            }
        })
    }

    function place_order(id)
    {
        $.blockUI({ message:  '<img src="<?=base_url()?>dist/admin/img/preloading-white.gif" alt="" class="img-loader-cls"/>',css: { 
            border: 'none', 
            padding: '0px', 
            backgroundColor: 'transparent', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            color: '#fff' 
        }});
        var gotourl="<?php echo base_url(); ?>"+'/checkout/place_order';
        $.ajax({
             type: "POST",
             url: gotourl,
             data: { id:id },
             dataType: "text",
             cache:false,
             
            error: function (xhr) {
                swal(
                    'Error',
                    "Something went wrong",
                    'error'
                )
                $.unblockUI();
            },

            success: function(data){
                if(data == -1){
                    swal(
                        'Error',
                        "Error Sending email",
                        'error'
                    )
                    $.unblockUI();
                }
                else if(data == -2){
                    swal(
                        'Error',
                        "Error creating invoice",
                        'error'
                    )
                    $.unblockUI();
                }
                else if(data == -3){
                    swal(
                        'Error',
                        "Something went wrong",
                        'error'
                    )
                    $.unblockUI();
                }
                else{
                    var redirectUrl = "<?php echo base_url(); ?>";
                    $.unblockUI();
                    swal(
                        'Success',
                        "Your order has been placed successfully.",
                        'success'
                    ).then(function() {
                        window.location = redirectUrl;
                    });
                }
            }
        })
    }
</script>