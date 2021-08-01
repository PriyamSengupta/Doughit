<?php 
	$site_settings = get_site_settings(1);
	$get_categories = get_categories();
	$get_all_products = get_products();
?>	
<section class="page-banner" style="background: #121619 url(<?=base_url()?>dist/front/images/blog-9.jpg) no-repeat center / cover;">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="page-title">
                    <h1 class="page-headding"><?=$mainheader?> </h1>
                    <ul>
                        <li><a href="<?=base_url()?>" class="page-name">Home</a></li>
                        
                        <li><?=$mainheader?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
    if($this->session->userdata('success_msg'))
    {
    ?>
        <div class="alert alert-success alert-dismissible fade show" id="get_error_msg_main_id1">
            <!-- <button class="close" type="button">×</button> -->
            <strong><?php echo $this->session->userdata('success_msg'); ?></strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

    <?php
    $this->session->set_userdata('success_msg', "");
    }
    else if($this->session->userdata('error_msg'))
    {
    ?>
        <div class="alert alert-danger alert-dismissible fade show" id="get_success_msg_main_id1">
            <strong><?php echo $this->session->userdata('error_msg'); ?></strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>

    <?php
    $this->session->set_userdata('error_msg', "");
    }
?>
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
                        if($category->is_active == '1'){ ?>
                            <div class="col-xl-4 col-lg-4 col-md-4 text-center speciality-box">
                                <div class="speciality-img"><a href="<?=base_url()?>order_online/get_products/<?=$category->id?>"><img src="<?=base_url()?>upload/categories/normal/<?=$category->image?>" alt="speciality" class="spec-image"></a></div>
                                <a href="<?=base_url()?>order_online/product/<?=$category->id?>" class="ser-title text-uppercase font-weight-bold"> <?=$category->name?></a>
                            </div>
            <?php $i += 1; } } } ?>
        </div>
        <!-- <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 text-center">
                <a href="menu-1.html" class="com-btn">view more</a>
            </div>
        </div> -->
    </div>
</section>
<script>
  $(document).ready(function() {
    $("#get_error_msg_main_id1").hide();
      $("#get_error_msg_main_id1").fadeTo(2000, 500).slideUp(500, function() {
          $("#get_error_msg_main_id1").slideUp(500);
        });
  });
  </script>  