<?php
   $blog_path = base_url()."upload/blog/normal/";
?>

<section class="page-banner" style="background: #121619 url(<?=base_url()?>dist/front/images/blog-1.jpg) no-repeat center / cover;">
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
 
<section class="inner_abt_cont_sec">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="inn_left_cont">
                    <!--<span class="theme_color"></span>-->
                    <h3><?=$details->title?></h3>
                    <h5><?=date("F j, Y", strtotime($details->time))?></h5>
                    <?=$details->content?>
                    
                </div>
            </div>
            <div class="col-md-5 ">
                <div class="inn_right_abt_img">
                    <img src="<?=$blog_path.$details->image?>" class="abt_big_img w-100" data-aos="fade-down" data-aos-duration="1000" />
                </div>
            </div>
        </div>
    </div>
</section>