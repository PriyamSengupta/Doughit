<?php if(count($get_all_products)>0){ 
    foreach($get_all_products as $product){	?>
    <div class="col-xl-3 col-lg-3 col-md-4 text-center pt-20">
        <div class="menu-img"><a href="<?=base_url()?>product/<?=$product->id?>"><img src="<?=base_url()?>upload/products/normal/<?=$product->image?>" alt="menu" class="menu-image"></a></div>
        <a href="<?=base_url()?>product/<?=$product->id?>" class="menu-title text-uppercase"><?=$product->name?></a>
        <p class="menu-des"><?=$product->description?></p>
        <span class="menu-price">$<?=get_product_price($product->id)?></span>
    </div>
<?php } } else { ?>
    <div class="col-xl-12 col-lg-12 col-md-12 text-center pt-20">
        <p style="text-align: center">No Product Found</p>
    
    </div>
<?php } ?>