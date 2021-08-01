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
<?php } } else { ?>
    <div class="col-xl-12 col-lg-12 col-md-12">
        <p style="text-align: center">No Product Found</p>
    </div>
<?php } ?>