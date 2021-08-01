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
                    <span class="filter-price">$ <?=$detail->base_price?></span>
                    <a href="<?=base_url()?>product/<?=$detail->id?>" class="order-filter">order now</a>
                </div>
            </div>
<?php } } else { ?>
    <div class="col-xl-12 col-lg-12 col-md-12">
        <p style="text-align: center">No Product Found</p>
    
    </div>
<?php } ?>