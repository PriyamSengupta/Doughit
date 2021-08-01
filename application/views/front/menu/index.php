<?php 
	$site_settings = get_site_settings(1);
	$get_categories = get_categories();
	$get_all_products = get_products();
?>	

<section class="page-banner" style="background: #121619 url(<?=base_url()?>dist/front/images/menu-banner-1.png) no-repeat center / cover;">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="page-title">
                    <h1 class="page-headding"><?=$mainheader?></h1>
                    <ul>
                        <li><a href="<?=base_url()?>" class="page-name">Home</a></li>
                        <li><?=$mainheader?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="menu-list pt-100">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="menu-tabbing">
                    <ul id="tabs" class="nav nav-tabs" role="tablist">
                        <!-- <li role="presentation" class="tab-link current" data-tab="tab-1"><a href="#tab-1" role="tab" data-toggle="tab" class="active">all</a></li> -->
						<li role="presentation" class="tab-link current" data-tab="tab-1"  onclick="get_products(0)"><a href="#tab-1" role="tab" data-toggle="tab" class="active"> all</a></li>
                        
                        <?php if(count($get_categories)>0){ 
							$i = 1;
								foreach($get_categories as $category) {
									if($category->is_active == '1'){ ?>
										<!-- <li role="presentation" class="tab-link" data-tab="tab-2"><a href="#tab-2" role="tab" data-toggle="tab">Drinks</a></li> -->
                                        <li role="presentation" class="tab-link" data-tab="tab-1" onclick="get_products(<?=$category->id?>)"><a href="#tab-1" role="tab" data-toggle="tab"> <?=$category->name?></a></li>
						<?php $i += 1; } } } ?>		                  
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div role="tabpanel" class="row tab-pane fade in active show" id="tab-1">
                <?php if(count($get_all_products)>0){ 
                    foreach($get_all_products as $product){	?>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="menu-list-box-2">
                                <div class="list-img-2">
                                    <a href="<?=base_url()?>product/<?=$product->id?>"><img src="<?=base_url()?>upload/products/normal/<?=$product->image?>" alt="<?=$product->name?>"></a>
                                </div>
                                <div class="menu-detail-2">
                                    <div class="iteam-name-list">
                                        <a href="<?=base_url()?>product/<?=$product->id?>" class="iteam-name"><?=$product->name?></a>
                                        <span class="iteam-srice">$<?=get_product_price($product->id)?></span>
                                    </div>
                                    <p class="iteam-desc"><?=$product->description?></p>
                                </div>
                            </div>
                        </div>
                <?php } } ?>        
             </div>
        </div>
    </div>
</section>


<script>
    function get_products(categoryID)
	{
		$.ajax({
              type: 'POST',
              url: '<?= base_url()?>menu/get_products',
              data: {'category_id':categoryID},
              dataType: "html",
              
              
              success: function(data)
              {
                if(data)
                {
                  // console.log(data);
                    $("#tab-1").html(data);
                    //$('#example2').DataTable();
                    
                }
              }
        });
	}
</script>