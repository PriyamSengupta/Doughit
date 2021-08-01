<?php
// date_default_timezone_set('UTC');

    $CI =& get_instance();
    $CI->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
    $CI->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    $CI->output->set_header('Pragma: no-cache');
    $CI->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    $site_settings = get_site_settings(1);
	$get_pages_admin = get_pages_admin();
	// $carts = json_decode($_COOKIE['cart'], true);
	// echo "<pre>"; print_r($carts);
	if($this->session->userdata('doughit_userid')){
		$get_cart_summary = get_cart_summary($this->session->userdata('doughit_userid'));
	}
	else{
		$get_cart_summary = get_cart_summary();
		// print_r($get_cart_summary);
	}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title><?=$mainheader?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<link type="image/x-icon" href="<?=base_url()?>dist/front/images/header-logo.png" rel="icon">
	<link rel="stylesheet" href="<?=base_url()?>dist/front/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/front/css/animate.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/front/css/owl.carousel.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/front/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/front/css/style.css">
	<!-- <link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/front/css/mdb.min.css"> -->
	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.0/css/mdb.min.css" rel="stylesheet"> -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/front/css/glass-case.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/front/css/responsive.css">
	<script src="<?=base_url()?>dist/front/js/jquery.min.js"></script>
    <script src="<?=base_url()?>dist/front/js/jquery.blockUI.js"></script>
	<script src="<?=base_url()?>dist/front/js/jquery.validate.min.js"></script>
	
</head>
<body>

	<!-- Start preloader -->
	<!-- <div id="preloader">-->
	<!--	<label>Loading</label>-->
	<!--</div>-->
	<!-- End preloader -->

	<header id="header">
		<div class="container">
			<div class="row m-0 align-items-center">
				<div class="col-xl-3 col-lg-2 col-md-4 col-3 p-0">
		            <div class="navbar-header">
			               	<a class="navbar-brand page-scroll" href="<?=base_url()?>">
			                	<img alt="Doughit" src="<?=base_url()?>upload/logo/<?=$site_settings->logo?>">
			                </a> 
		            </div>
			    </div>
			    <div class="col-xl-9 col-lg-10 col-md-8 col-9 p-0 text-right">
			        <div id="menu" class="navbar-collapse collapse">
			            <ul class="nav navbar-nav">
				            <li class="level">
				                <a href="<?=base_url()?>" class="page-scroll">Home</a>
				            </li>
				            <li class="level dropdown set"> 
				                <a href="<?=base_url()?>menu" class="page-scroll">Menu</a>
				                <!-- <span class="opener plus"></span>
				                <div class="megamenu mobile-sub-menu content megamenu-big">
				                    <div class="megamenu-inner-top">
				                        <ul class="sub-menu-level1">
					                        <li class="level2 menu-list-d">
					                            <div class="row">
					                            	<div class="col-xl-9 col-lg-9 col-md-9">
					                            		<div class="row">
					                            			<div class="col-xl-4 col-lg-4 col-md-4">
					                            				<div class="menu-grid">
					                            					<a href="shop-detail.html" class="menu-grid-center">
						                            					<div class="pizza-menu">
						                            						<img src="<?=base_url()?>dist/front/images/1.png" alt="pizza">
						                            					</div>
						                            					<div class="pizza-det">
						                            						<p class="Pizza-name-1">Pepperoni</p>
						                            						<span class="pizza-price-1">$12.99</span>
						                            					</div>
						                            				</a>
					                            				</div>
					                            			</div>
					                            			<div class="col-xl-4 col-lg-4 col-md-4">
					                            				<div class="menu-grid">
					                            					<a href="shop-detail.html" class="menu-grid-center">
						                            					<div class="pizza-menu">
						                            						<img src="<?=base_url()?>dist/front/images/1-1.png" alt="pizza">
						                            					</div>
						                            					<div class="pizza-det">
						                            						<p class="Pizza-name-1">Vegetarian</p>
						                            						<span class="pizza-price-1">$12.99</span>
						                            					</div>
						                            				</a>
					                            				</div>
					                            			</div>
					                            			<div class="col-xl-4 col-lg-4 col-md-4">
					                            				<div class="menu-grid">
					                            					<a href="shop-detail.html" class="menu-grid-center">
						                            					<div class="pizza-menu">
						                            						<img src="<?=base_url()?>dist/front/images/2.png" alt="pizza">
						                            					</div>
						                            					<div class="pizza-det">
						                            						<p class="Pizza-name-1">Specialty</p>
						                            						<span class="pizza-price-1">$12.99</span>
						                            					</div>
						                            				</a>
					                            				</div>
					                            			</div>
					                            			<div class="col-xl-4 col-lg-4 col-md-4">
					                            				<div class="menu-grid">
					                            					<a href="shop-detail.html" class="menu-grid-center">
						                            					<div class="pizza-menu">
						                            						<img src="<?=base_url()?>dist/front/images/2-1.png" alt="pizza">
						                            					</div>
						                            					<div class="pizza-det">
						                            						<p class="Pizza-name-1">Ham & Cheese</p>
						                            						<span class="pizza-price-1">$12.99</span>
						                            					</div>
						                            				</a>
					                            				</div>
					                            			</div>
					                            			<div class="col-xl-4 col-lg-4 col-md-4">
					                            				<div class="menu-grid">
					                            					<a href="shop-detail.html" class="menu-grid-center">
						                            					<div class="pizza-menu">
						                            						<img src="<?=base_url()?>dist/front/images/3.png" alt="pizza">
						                            					</div>
						                            					<div class="pizza-det">
						                            						<p class="Pizza-name-1">Onion</p>
						                            						<span class="pizza-price-1">$12.99</span>
						                            					</div>
						                            				</a>
					                            				</div>
					                            			</div>
					                            			<div class="col-xl-4 col-lg-4 col-md-4">
					                            				<div class="menu-grid">
					                            					<a href="shop-detail.html" class="menu-grid-center">
						                            					<div class="pizza-menu">
						                            						<img src="<?=base_url()?>dist/front/images/4.png" alt="pizza">
						                            					</div>
						                            					<div class="pizza-det">
						                            						<p class="Pizza-name-1">Margheritapizza</p>
						                            						<span class="pizza-price-1">$12.99</span>
						                            					</div>
						                            				</a>
					                            				</div>
					                            			</div>
					                            		</div>
					                            	</div>
					                            	<div class="col-xl-3 col-lg-3 col-md-3">
					                            		<ul>
					                            			<li><a href="menu-2.html">Menu list</a></li>
					                            			<li><a href="menu-1.html">Menu grid</a></li>
					                            			<li><a href="#">Special Pizza</a></li>
					                            			<li><a href="#">All pizza</a></li>
					                            		</ul>
					                            	</div>
					                            </div>
					                        </li>
					                        <li class="level2 level2 menu-list-res">
					                            <ul class="sub-menu-level2 ">
					                              <li class="level3"><a href="menu-2.html"><span>■</span>Menu list</a></li>
					                              <li class="level3"><a href="menu-1.html"><span>■</span>Menu grid</a></li>
					                              <li class="level3"><a href="#"><span>■</span>Special Pizza</a></li>
					                              <li class="level3"><a href="#"><span>■</span>All pizza</a></li>
					                            </ul>
					                        </li>
				                        </ul>
				                    </div>
				                </div> -->
				            </li>
				            
				            <li class="level">
				                <a href="<?=base_url()?>reservation" class="page-scroll">Reservation</a>
				            </li>

							<?php if($this->session->userdata('doughit_userid')) { ?>
				            <li class="level"> 
								<a href="javascript:void(0);">Profile</a>
							</li>
							<li class="level"> 
								<a href="<?=base_url()?>logout">Log out</a>
							</li>
							<?php } else { ?>
							<li class="level"> 
								<a href="<?=base_url()?>login">Login</a>
							</li>
							<?php } ?>
			            </ul>
			        </div>
			        <div class=" header-right-link">
			            <ul>
			                <!-- <li class="call-icon">
			                	<a href="javascript:void(0);">
			                		<span class="icon"></span>
			                		<div class="link-text">+91 123 456 789</div>
			                	</a>
			                </li> -->

							<?php if(($get_cart_summary['quantity']!= "") && ($get_cart_summary['price']!= "")){ ?> 
								<li class="cart-icon"> 
									<a href="<?=base_url()?>cart"> 
										<span class="icon"></span>
										<div class="link-text" id="cart-amnt"><?=$get_cart_summary['quantity']?> items - <span>$ <?=number_format($get_cart_summary['price'], 2, '.', '')?></span></div>
									</a>
									<!--<div class="cart-dropdown header-link-dropdown">-->
									<!--    <ul class="cart-list link-dropdown-list">-->
									<!--      	<li> <a class="close-cart"><i class="fa fa-times-circle"></i></a>-->
									<!--        	<div class="media"> <a href="shop-detail.html" class="pull-left"> <img alt="Doughit" src="<?=base_url()?>dist/front/images/1.png"></a>-->
									<!--          	<div class="media-body"> <span><a href="shop-detail.html">margherita pizza</a></span>-->
									<!--             <p class="cart-price">$14.99</p>-->
									<!--             <div class="product-qty">-->
									<!--               	<label>Qty:</label>-->
									<!--               	<div class="custom-qty">-->
									<!--                 	<input type="text" name="qty" maxlength="8" value="1" title="Qty" class="input-text qty" disabled="">-->
									<!--               	</div>-->
									<!--             </div>-->
									<!--          	</div>-->
									<!--        </div>-->
									<!--      	</li>-->
									<!--      	<li> <a class="close-cart"><i class="fa fa-times-circle"></i></a>-->
									<!--        	<div class="media"> <a class="pull-left"> <img alt="Doughit" src="<?=base_url()?>dist/front/images/2.png"></a>-->
									<!--           	<div class="media-body"> <span><a href="#">GREEK PIZZA</a></span>-->
									<!--             	<p class="cart-price">$14.99</p>-->
									<!--             	<div class="product-qty">-->
										<!--                	<label>Qty:</label>-->
										<!--                	<div class="custom-qty">-->
										<!--                  	<input type="text" name="qty" maxlength="8" value="1" title="Qty" class="input-text qty" disabled="">-->
										<!--                	</div>-->
									<!--             	</div>-->
									<!--           	</div>-->
									<!--        	</div>-->
									<!--      	</li>-->
									<!--    </ul>-->
									<!--    <p class="cart-sub-totle"> -->
									<!--    <span class="pull-left">Cart Subtotal</span> -->
									<!--    <span class="pull-right"><strong class="price-box">$29.98</strong></span> </p>-->
									<!--    <div class="clearfix"></div>-->
									<!--    <div class="mt-20 text-left"> -->
									<!--    	<a href="cart.html" class="btn-color btn">Cart</a> -->
									<!--    	<a href="checkout.html" class="btn-color btn right-side">Checkout</a> -->
									<!--    </div>-->
									<!--</div>-->
								</li>
							<?php } ?>

								
							
			                <li class="order-online">
			                	<a href="<?=base_url()?>order_online" class="btn btn-green">Order online</a>
			                </li>
			                <li class="side-toggle">
			                  	<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button"><span></span></button>
			                </li>
			            </ul>
			        </div>
			    </div>
			</div>
		</div>
	</header>

	<?php echo $content_for_layout;?>

	<div class="top-scrolling">
		<a href="#header" class="scrollTo"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
	</div>

	<footer style="background-image: url(<?=base_url()?>dist/front/images/chef-top-bg.png); background-position: 0px -240px; background-repeat: no-repeat; background-size: contain">
        
		<div class="container">
			<div class="footer">
				<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-4 footer-box">
						<div class="footer-logo">
							<img src="<?=base_url()?>upload/logo/<?=$site_settings->logo?>" alt="fooret-logo">
							<p class="footer-des"><?=$site_settings->address?></p>
							<ul>
								<li>phone  - <a href="+911234567890"><?=$site_settings->telephone?> , <?=$site_settings->mobile?></a></li>
								<li>email  - <a href="#"><?=$site_settings->site_email?></a></li>
							</ul>
						</div>
					</div>

					<div class="col-xl-4 col-lg-4 col-md-4 footer-box">
						<div class="opening-hours">
							<h2>Opening Hours</h2>
							<ul>
								<li>Mon - Tues :  <span>6.00 am - 10.00 pm</span></li>
								<li>Wednes - Thurs : <span>6.00 am - 10.00 pm</span></li>
								<li>Launch :  <span>Everyday</span></li>
								<li>Sunday :  <span class="footer-close">Closed</span></li>
							</ul>
						</div>
					</div>

					<div class="col-xl-4 col-lg-4 col-md-4 footer-box">
						<div class="useful-links">
							<h2>useful links</h2>
							<ul>
								<li><a href="#">Privacy Policy</a></li>
								<!-- <li><a href="#">Order Tracking</a></li> -->
								<li><a href="#">Warranty and Services</a></li>
								<?php if($get_pages_admin != []) {
									foreach($get_pages_admin as $page) {?>
										<li><a href="<?=base_url().$page->slug?>"><?=$page->name?></a></li>
								<?php } } ?>
								<!-- <li><a href="<?=base_url()?>about">About</a></li>
								<li><a href="<?=base_url()?>contact">Contact Us</a></li> -->
								<li><a href="#">Wishlist</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="copyright">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6 copyright-box">
						<p class="copy-text">© Doughit all Rights Reserved. Designed by <a href="https://www.sirchend.com/" target="_blank">Sirchend Software</a></p>
					</div>

					<div class="col-xl-6 col-lg-6 col-md-6 copyright-box">
						<ul>
							<li><a href="<?=$site_settings->facebook?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							<li><a href="<?=$site_settings->twitter?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							<li><a href="<?=$site_settings->linkedin?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
							<li><a href="<?=$site_settings->instagram?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<script src="<?=base_url()?>dist/front/js/owl.carousel.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
	<script src="<?=base_url()?>dist/front/js/bootstrap.min.js"></script>
	<script type="application/javascript" src="<?=base_url()?>dist/front/js/sweetalert.min.js"></script>
	<script src="<?=base_url()?>dist/front/js/modernizr.js"></script>
	<script src="<?=base_url()?>dist/front/js/script.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
	<script>
		$( function() {
			$( "#datepicker" ).datepicker();
			$('#glasscase').glassCase({ 
	           	'thumbsPosition': 'bottom', 
	            'widthDisplayPerc' : 100,
	            isDownloadEnabled: false,
	        });
		});
  	</script>
	 <!-- <script>
	    $(document).ready( function () {
	        //If your <ul> has the id "glasscase"
	        $('#glasscase').glassCase({ 
	           	'thumbsPosition': 'bottom', 
	            'widthDisplayPerc' : 100,
	            isDownloadEnabled: false,
	        });
	    });
	</script> -->
</body>
</html>