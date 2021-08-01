<?php 
	$site_settings = get_site_settings(1);
	$get_categories = get_categories();
	$get_all_products = get_products();
	$get_blog_info = get_blog_info();
	$customer_reviews = customer_reviews();

?>	
<section class="banner">
	<div class="banner-carousel owl-carousel">
		<div class="banner-slide">
			<div class="container">
				<div class="banner-box">
					<div class="banner-text">
						<div class="banner-center">
							<h2 class="banner-headding">Quality F<span>oo</span>ds</h2>
							<p class="banner-sub-hed">Healthy Food for healthy body</p>
						</div>
					</div>
					<div class="banner-images">
						<div class="all-img-banner">
							<img src="<?=base_url()?>dist/front/images/banner-bg-1.png" alt="banner" class="pizza-img">
							<img src="<?=base_url()?>dist/front/images/banner-bg-2.png" alt="banner" class="pizza-it pizza-1">
							<img src="<?=base_url()?>dist/front/images/banner-bg-3.png" alt="banner" class="pizza-it pizza-2">
							<img src="<?=base_url()?>dist/front/images/banner-bg-4.png" alt="banner" class="pizza-it pizza-3">
							<img src="<?=base_url()?>dist/front/images/banner-bg-5.png" alt="banner" class="pizza-it pizza-4">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="banner-slide-2">
			<div class="container">
				<div class="banner-box">
					<div class="banner-text">
						<div class="banner-center">
							<h2 class="banner-headding">Quality F<span>oo</span>ds</h2>
							<p class="banner-sub-hed">Healthy Food for healthy body</p>
						</div>
					</div>
					<div class="banner-images">
						<div class="all-img-banner">
							<img src="<?=base_url()?>dist/front/images/pizza-banner-1.png" alt="banner" class="pizza-img">
							<img src="<?=base_url()?>dist/front/images/pizza-1.png" alt="banner" class="pizza-it pizza-1">
							<img src="<?=base_url()?>dist/front/images/pizza-2.png" alt="banner" class="pizza-it pizza-2">
							<img src="<?=base_url()?>dist/front/images/pizza-3.png" alt="banner" class="pizza-it pizza-3">
							<img src="<?=base_url()?>dist/front/images/pizza-4.png" alt="banner" class="pizza-it pizza-4">
							<img src="<?=base_url()?>dist/front/images/pizza-5.png" alt="banner" class="pizza-it pizza-5">
							<img src="<?=base_url()?>dist/front/images/pizza-6.png" alt="banner" class="pizza-it pizza-6">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="banner-slide-3">
			<div class="container">
				<div class="banner-box">
					<div class="banner-images">
						<div class="all-img-banner">
							<img src="<?=base_url()?>dist/front/images/pizza-banner-2.png" alt="banner" class="pizza-img">
							<img src="<?=base_url()?>dist/front/images/pizza-7.png" alt="banner" class="pizza-it pizza-1">
							<img src="<?=base_url()?>dist/front/images/pizza-8.png" alt="banner" class="pizza-it pizza-2">
							<img src="<?=base_url()?>dist/front/images/pizza-9.png" alt="banner" class="pizza-it pizza-3">
							<img src="<?=base_url()?>dist/front/images/pizza-10.png" alt="banner" class="pizza-it pizza-4">
							<img src="<?=base_url()?>dist/front/images/pizza-11.png" alt="banner" class="pizza-it pizza-5">
							<img src="<?=base_url()?>dist/front/images/pizza-12.png" alt="banner" class="pizza-it pizza-6">
						</div>
					</div>
					<div class="banner-text">
						<div class="banner-center">
							<h2 class="banner-headding">Quality F<span>oo</span>ds</h2>
							<p class="banner-sub-hed">Healthy Food for healthy body</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="order-section ptb">
	<div class="container">
		<div class="row">
			<div class="order-top"><img src="<?=base_url()?>dist/front/images/order-top.png" alt="layer"></div>
			<div class="col-xl-4 col-lg-4 col-md-4 servose-box text-center padding-lf">
				<img src="<?=base_url()?>dist/front/images/order-1.svg" alt="order" class="order-img">
				<h2 class="order-title text-uppercase">order your Food</h2>
				<p class="order-des">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eius-Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eius-Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eius-</p>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 servose-box text-center padding-lf">
				<img src="<?=base_url()?>dist/front/images/order-2.svg" alt="delivery" class="order-img">
				<h2 class="order-title text-uppercase">delivery or pick up</h2>
				<p class="order-des">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eius-Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eius-Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eius-</p>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 servose-box text-center padding-lf">
				<img src="<?=base_url()?>dist/front/images/order-3.svg" alt="delicious" class="order-img">
				<h2 class="order-title text-uppercase">delicious receipe</h2>
				<p class="order-des">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eius-Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eius-Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eius-</p>
			</div>
			<div class="order-bottom"><img src="<?=base_url()?>dist/front/images/order-bottom.png" alt="layer"></div>
		</div>
	</div>
</section>

<section class="speciality ptb pt-140">
	<div class="container">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div class="headding-part text-center pb-50">
					<p class="headding-sub">Fresh From Doughit</p>
					<h2 class="headding-title text-uppercase font-weight-bold">our speciality</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<?php if(count($get_categories)>0){ 
				$i = 1;
				foreach($get_categories as $category) { 
					if($i < 4){
						if($category->is_active == '1'){
					?>
							<div class="col-xl-4 col-lg-4 col-md-4 text-center speciality-box">
                                <div class="speciality-img"><a href="<?=base_url()?>order_online/get_products/<?=$category->id?>"><img src="<?=base_url()?>upload/categories/normal/<?=$category->image?>" alt="speciality" class="spec-image"></a></div>
                                <a href="<?=base_url()?>order_online/product/<?=$category->id?>" class="ser-title text-uppercase font-weight-bold"> <?=$category->name?></a>
                            </div>

			<?php } } $i++; } } ?>				
		</div>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 text-center">
				<a href="<?=base_url()?>menu" class="com-btn">view more</a>
			</div>
		</div>
	</div>
</section>

<section class="special-menu ptb pt-140">
	<div class="container">
		<div class="menu-top-bg"><img src="<?=base_url()?>dist/front/images/menu-top-bg.png" alt="meu-bg"></div>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div class="headding-part text-center pb-50">
					<p class="headding-sub">Fresh From Doughit</p>
					<h2 class="headding-title text-uppercase font-weight-bold">Our Special Menu</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div class="special-tab text-center">
					<ul id="tabs" class="nav nav-tabs" role="tablist">
						<li role="presentation" class="text-uppercase font-weight-bold tab-link current" data-tab="tab-1"  onclick="get_products(0)"><a href="#tab-1" role="tab" data-toggle="tab" class="active"> all</a></li>
						<?php if(count($get_categories)>0){ 
							$i = 1;
								foreach($get_categories as $category) {
									if($category->is_active == '1'){ ?>
										<li role="presentation" class="text-uppercase font-weight-bold tab-link" data-tab="tab-1" onclick="get_products(<?=$category->id?>)"><a href="#tab-2" role="tab" data-toggle="tab"> <?=$category->name?></a></li>
						<?php $i += 1; } } } ?>				
						
					</ul>
				</div>
			</div>
		</div>
		<div class="tab-content">
			<div role="tabpanel" class="row pt-50 tab-pane fade in active show" id="tab-1">
				
				<?php if(count($get_all_products)>0){ 
					foreach($get_all_products as $product){	?>
					<div class="col-xl-3 col-lg-3 col-md-4 text-center pt-20">
						<div class="menu-img"><a href="j<?=base_url()?>product/<?=$product->id?>"><img src="<?=base_url()?>upload/products/normal/<?=$product->image?>" alt="menu" class="menu-image"></a></div>
						<a href="<?=base_url()?>product/<?=$product->id?>" class="menu-title text-uppercase"><?=$product->name?></a>
						<p class="menu-des"><?=$product->description?></p>
						<span class="menu-price">$<?=get_product_price($product->id)?></span>
					</div>
				<?php } } ?>
				
			</div>
		</div>
		<div class="menu-bottom-bg"><img src="<?=base_url()?>dist/front/images/menu-bottom-bg.png" alt="menu-bg"></div>
	</div>
</section>

<section class="online-booking ptb">
	<div class="container">
		<div class="row">
			<div class="col-xl-6 col-lg-6 col-md-6">
				<div class="max-w-390">
					<div class="headding-part">
						<p class="headding-sub">Fresh From Doughit</p>
						<h2 class="headding-title text-uppercase font-weight-bold">BOOK ONLINE</h2>
					</div>
					<p class="online-des">Sit amet, consectetur adipiscing elit quisque eget maximus velit, non eleifend libero curabitur dapibus mauris sed leo cursus aliquetcras suscipit. Sit amet, consectetur adipiscing elit quisque eget maximus velit, non eleifend libero curabitur </p>
					<a href="#" class="online-call"><?=$site_settings->mobile?></a>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 text-center">
				<h2 class="book-table text-uppercase">Book a table</h2>
				<form class="online-order-form">
					<input type="hidden" name="admin_email" value="<?=$site_settings->admin_email?>">
					<input type="hidden" name="time" value="">
					<input type="hidden" name="comment" value="">
					<input type="hidden" name="phone" value="">
					<div class="form-group">
						<input type="text" class="form-control" id="name" name="name" placeholder="Name" required="">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="email" name="email" placeholder="Email" onblur="validateEmail(this);">
					</div>
					<div class="form-group">
						<select name="person_count" id="sources" class="custom-select sources form-control" data-placeholder="How many persons?">
								<option value="5" selected="">Person 5</option>
								<option value="4">Person 4</option>
								<option value="3">Person 3</option>
								<option value="2">Person 2</option>
						</select>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="datepicker" name="date" placeholder="Date" required="">
					</div>
					<div class="form-control form-group alert alert-success" id="success-alert" style="display: none">
						<button type="button" class="close" data-dismiss="alert">x</button>
						<strong>Success! </strong> Email Sent Successfully.
					</div>
					<div class="form-control form-group alert alert-warning" id="error-alert" style="display: none">
						<button type="button" class="close" data-dismiss="alert">x</button>
						<strong>Error! </strong> Something went wrong.
					</div>
					<button type="submit" class="more-table-v">book now</button>
				</form>
			</div>
		</div>
	</div>
</section>

<section class="chef ptb pt-120 pb-120">
	<div class="chef-top-bg"><img src="<?=base_url()?>dist/front/images/chef-top-bg.png" alt="chef-bg"></div>
	<div class="container">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div class="headding-part pb-50 text-center">
					<p class="headding-sub">Meet our experts</p>
					<h2 class="headding-title text-uppercase font-weight-bold">Our Best Chef</h2>
				</div>
			</div>
		</div>
		<div class="chef-banner owl-carousel">
			<?php if(count($chefs)>0){ 
					foreach ($chefs as $chef) { ?>
						<div class="chef-outer text-center">
							<div class="chef-box">
								<div class="chef-hover"><img src="<?=base_url()?>upload/chef/normal/<?=$chef->image?>" alt="<?=$chef->fname." ".$chef->lname?>" class="chef-img"></div>
								<p class="chef-name text-uppercase font-weight-bold"><?=$chef->fname." ".$chef->lname?></p>
								<span class="chef-ct"><?=$chef->expertise?></span>
							</div>
						</div>
			<?php	} }
				?>
		</div>
	</div>
	<div class="chef-bottom-bg"><img src="<?=base_url()?>dist/front/images/chef-bottom-bg.png" alt="chef-bg"></div>
</section>

<section class="news ptb">
	<div class="container">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div class="headding-part pb-50 text-center">
					<p class="headding-sub">Recent Events</p>
					<h2 class="headding-title text-uppercase font-weight-bold">Latest News</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<?php foreach ($get_blog_info as $blog) { ?>
					<div class="col-xl-4 col-lg-4 col-md-4 news-part">
						<div class="new-box">
							<div class="news-img">
								<a href="javascript:void(0);">
									<img src="<?=base_url()?>upload/blog/normal/<?=$blog->image?>" alt="news" class="news-image">
								</a>
								<div class="text-uppercase news-date"><span><?=date("j", strtotime($blog->time))?> <br><?=date("F", strtotime($blog->time))?></span></div>
								<span class="news-date-bg"></span>
							</div>
								<ul>
									<li>by - <?php $admin_info = get_admin_info(1); echo $admin_info->name?></li>
									<!-- <li>0 comments</li> -->
								</ul>
								<a href="javascript:void(0);" class="news-headline"><?=$blog->title?> </a>
								<a href="<?=base_url()?>news/<?=$blog->slug?>"  class="news-more">read More</a>
						</div>
					</div>
			<?php }?>
		</div>
	</div>
</section>

<section class="customer ptb">
	<div class="container">
		<div class="customer-inner">
			<div class="customer-top-bg"><img src="<?=base_url()?>dist/front/images/customer-top-bg.png" alt="customer"></div>
			<div class="headding-part pb-50 text-center">
				<p class="headding-sub">What Say Our Clients</p>
				<h2 class="headding-title text-uppercase font-weight-bold">Customer Reviews</h2>
			</div>
			<div class="customer-slide owl-carousel">
				<?php foreach ($customer_reviews as $review) { ?>
					<div class="customer-detail">
						<div class="customer-img">
							<div class="customer-img-in">
								<img src="<?=base_url()?>upload/user/normal/<?=get_user_image($review->user_id)?>" alt="customer" class="customer-image">
								<p class="customer-name"><?=get_username($review->user_id)?></p>
							</div>
						</div>
						<div class="customer-reviews">
							<p class="review-cus"><?=$review->comment?></p>
							<label class="post-name"><?=get_username($review->user_id)?></label>
						</div>
					</div>
				<?php } ?>
			</div>
			<div class="customer-bottom-bg"><img src="<?=base_url()?>dist/front/images/customer-bottom-bg.png" alt="customer"></div>
		</div>
	</div>
</section>

<section class="about-pizzon ptb">
	<div class="container">
		<div class="row">
			<div class="col-xl-6 col-lg-6 col-md-6">
				<div class="max-w-390">
					<div class="headding-part">
						<p class="headding-sub">Delicious Restaurant</p>
						<h2 class="headding-title text-uppercase font-weight-bold">about Doughit</h2>
					</div>
					<p class="online-des">Sit amet, consectetur adipiscing elit quisque eget maximus velit, non eleifend libero curabitur dapibus mauris sed leo cursus aliquetcras suscipit. Sit amet, consectetur adipiscing elit quisque eget maximus velit, non eleifend libero curabitur Sit amet, consectetur adipiscing elit quisque eget maximus velit, non eleifend libero curabitur dapibus mauris sed leo cursus aliquetcras suscipit. Sit amet, consectetur adipiscing elit quisque eget maximus velit, non eleifend libero curabitur </p>
					<!-- <a href="javascript:void(0);" class="about-more-z com-btn">view more</a> -->
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6">
				<div class="about-pizzon-img">
					<img src="<?=base_url()?>dist/front/images/about-pizzon.png" alt="about" class="pizzon-ab">
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	function validateEmail(emailField){
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	
			if (reg.test(emailField.value) == false) 
			{
				alert('Invalid Email Address');
				return false;
			}
	
			return true;
	} 

	function get_products(categoryID)
	{
		$.ajax({
              type: 'POST',
              url: '<?= base_url()?>index/get_products',
              data: {'category_id':categoryID},
              dataType: "html",
              
              
              success: function(data)
              {
                if(data)
                {
                    $("#tab-1").html(data);
                    //$('#example2').DataTable();
                    
                }
              }
        });
	}
</script>


<script>
	$(function () {

	$('.online-order-form').on('submit', function (e) {

		e.preventDefault();
		$.blockUI({
			message: '<img src="<?=base_url()?>dist/admin/img/preloading-white.gif" alt="" class="img-loader-cls"/>',
			css: {
				border: 'none',
				padding: '0px',
				backgroundColor: 'transparent',
				'-webkit-border-radius': '10px',
				'-moz-border-radius': '10px',
				color: '#fff'
			}
		});

		$.ajax({
		type: 'post',
		url: '<?= base_url()?>booking',
		data: $('.online-order-form').serialize(),
		success: function (data) {
			if(data == 1)
			{
				$(".online-order-form").trigger("reset");
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").slideUp(500);
				});
			}
			else{
				$(".online-order-form").trigger("reset");
				$("#error-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#error-alert").slideUp(500);
				});
			}
			$.unblockUI();
	        return false;
		},
        error: function(data) {
            console.log("error");
            console.log(data);
        }
		});

	});

	});
</script>