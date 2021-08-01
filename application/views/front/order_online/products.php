<?php 
$food_categories = get_food_categories();
$get_sizes = get_category_sizes($category_id);
$get_category_addon = get_category_addon($category_id);
$addon_array = array();
foreach ($get_category_addon as $addon) {
	$addon_array[] = array(
		'type_id'		=>	$addon->id,
		'type_option_id'=>	""
	);
}
?>
<section class="page-banner" style="background: #121619 url(<?=base_url()?>dist/front/images/blog-9.jpg) no-repeat center / cover;">
	<div class="container">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div class="page-title">
					<h1 class="page-headding"><?=$mainheader?></h1>
					<ul>
						<li><a href="<?=base_url()?>" class="page-name">Home</a></li>
						<li<?=$mainheader?></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="pizza-crust pt-100 pb-50">
	<div class="container">
		<div class="crust-banner" style="background: url(<?=base_url()?>dist/front/images/crust.jpg) no-repeat center / cover;">
			<h2 class="crust-title">Pizza Crust & <span>Tortillas</span></h2>
			<p class="crust-sub">His creation set off a heated debate over whether pineapple belongs on pizza</p>
		</div>
	</div>
</section>

<section class="online-booking filter-part">
	<div class="container">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<ul class="filter-line">
					<li><img src="<?=base_url()?>dist/front/images/filter.png" alt="filter"> Filter</li>
					<?php if(!empty($food_categories)) { ?>
						<li>
							<select name="food_category" id="food_category" class=" sources form-control" data-placeholder="Type" onchange="get_val()">
							<option value="">Type</option>
								<?php 
									foreach($food_categories as $food_category) { ?>
										<option value="<?=$food_category->id?>"><?=$food_category->name?></option>
								<?php } ?>		
							</select>
						</li>
					<?php } ?>
					
					<li>
						<select name="price" id="price" class=" sources form-control" data-placeholder="Price" onchange="get_val()">
							<option value="">Price</option>
							<option value="1">< $ 15</option>
							<option value="2">$ 15 - $ 20</option>
							<option value="3">> $20</option>
						</select>
					</li>
					<?php if(!empty($get_sizes)) { ?> 
					<li>
						<select name="size" id="size" class=" sources form-control" data-placeholder="Size" onchange="get_val()">
						<option value="">Size</option>
							<?php 
								foreach($get_sizes as $size) { ?>
									<option value="<?=$size->id?>"><?=$size->name?></option>
							<?php } ?>
						</select>
					</li>
					<?php } ?>

					<?php if(!empty($get_category_addon)) { ?> 
						<?php $i = 0;
							foreach($get_category_addon as $type) { ?>
								<li>
									<select name="sources" id="type<?=$i?>" class=" sources form-control" data-placeholder="<?=$type->name?>"  onchange="get_addon(this, '<?=$type->id?>')">
									<option value=""><?=$type->name?></option>
									<?php if(!empty($type->type_option)) { 
											foreach($type->type_option as $type_option) { ?>
												<option value="<?=$type_option->id?>"><?=$type_option->name?></option>
									<?php } } ?>			
									</select>
								</li>
					<?php $i++; } ?><input type="hidden" id="addon_count" value="<?=$i?>"><?php } ?>
					
					<li></li>
				</ul>
			</div>
		</div>
		<div class="row" id="dyn_search_div">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<label class="active-filter">Active Filters</label>
			</div>
			<?php if(!empty($details)) { 
					foreach($details as $detail){ ?>
						<div class="col-xl-3 col-lg-3 col-md-3">
							<div class="filter-box">
								<div class="img-filter"><a href="<?=base_url()?>product/<?=$detail->id?>"><img src="<?=base_url()?>upload/products/normal/<?=$detail->image?>" style="width: 200px; height: 200px"></a></div>
								<a href="<?=base_url()?>product/<?=$detail->id?>" class="filter-name"><?=$detail->name?></a>
								<p class="filter-sub"><?=$detail->description?> </p>
								<span class="filter-price">$ <?=get_product_price($detail->id)?></span>
								<a href="<?=base_url()?>product/<?=$detail->id?>" class="order-filter">order now</a>
							</div>
						</div>
				<?php } } ?>
		</div>
	</div>
</section>

<script>
	var food_category;
	var price;
	var size;
	var arr = <?php echo json_encode($addon_array) ?>;
	// var arr = [];
	function get_val()
	{
		food_category  		= $('#food_category').val();
		price       		= $('#price').val();
		size     			= $('#size').val();
		filter_data();
	}

	function get_addon(elem, typeID)
	{
		var index = arr.findIndex(p => p.type_id == typeID);
		arr[index].type_option_id = elem.value;
		filter_data();
	}	

	function filter_data()
	{
		//console.log(arr);          
		var categoryID = <?php echo $category_id; ?>;
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
				
				url: '<?php echo base_url()?>' + 'order_online/filter_product',
				data: {'food_category':food_category,'price':price,'size':size,'addon_array':arr, 'category_id': categoryID},
				type: 'POST',
				dataType: "html",
				cache:false,

				error: function (xhr) {
					console.log(xhr);
				},
				success: function(data)
				{
					$("#dyn_search_div").html(data);
					$.unblockUI();
            		return false;
				},
				
		});
		return false;
	}
</script>