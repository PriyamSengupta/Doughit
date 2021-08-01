<?php
// date_default_timezone_set('UTC');
$CI =& get_instance();
$CI->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
$CI->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
$CI->output->set_header('Pragma: no-cache');
$CI->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
$site_settings = get_site_settings(1);
$pages = get_pages();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?=base_url()?>dist/front/css/style.css" />
    <link rel="stylesheet" href="<?=base_url()?>dist/front/css/animate.css" />
    <link rel="stylesheet" href="<?=base_url()?>dist/front/css/base.css" />
    <link rel="stylesheet" href="<?=base_url()?>dist/front/css/aos.css" />
    <link rel="stylesheet" href="<?=base_url()?>dist/front/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?=base_url()?>dist/front/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="<?=base_url()?>dist/front/css/owl.theme.default.min.css" />
    <script src="https://kit.fontawesome.com/e5c874c64c.js" crossorigin="anonymous"></script>
    <title><?=$mainheader?></title>
</head>

<body>
    <div class="loader"></div>
    <section class="header_sec">
        <div class="top_info_sec">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="top_info">
                            <ul class="d-flex">
                                <li><a href="tel:<?=$site_settings->telephone?>"><i class="fas fa-phone-alt"></i> <?=$site_settings->telephone?></a></li>
                                <li><a href="mailto:<?=$site_settings->site_email?>"><i class="far fa-envelope"></i> <?=$site_settings->site_email?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="top_cont_info d-flex w-100 align-items-center justify-content-md-end justify-content-center">
                            <div class="top_menu ">
                                <ul class="d-flex">
                                    <li><a href="<?=base_url()?>career">Career</a></li>
                                    <?php $page = get_page_by_id(6);?>
                                    <li><a href="<?=base_url().$page->slug?>">FAQ</a></li>
                                    <li>
                                        <?php if($this->session->userdata('bloom_userid')) { ?>
                                            <a href="<?=base_url()?>profile">Profile</a></li>
                                        <?php } else { ?>
                                            <a href="<?=base_url()?>login">Login</a></li>
                                        <?php } ?>
                                </ul>
                            </div>
                            <div class="top_social_icon">
                                <ul class="d-flex align-items-center">
                                    <li><a href="<?=$site_settings->facebook?>"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="<?=$site_settings->twitter?>"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="<?=$site_settings->linkedin?>"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="<?=$site_settings->instagram?>"><i class="fab fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main_menu">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-3 col-5">
                        <div class="logo_sec">
                            <a href="<?=base_url()?>"><img src="<?=base_url()?>upload/logo/<?=$site_settings->logo?>" /></a>
                        </div>
                    </div>
                    <div class="col-md-9 col-7">
                        <div class="main_nav">
                            <nav class="navbar navbar-expand-lg p-0">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <img src="<?=base_url()?>dist/front/img/menu.png" />
                                </button>

                                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                                    <ul class="navbar-nav">
<?php 
if($pages != []) {
    foreach($pages as $page) {
        if($page->id == 1) {
?>
        <li <?php if($mainheader == $page->name) { ?>class="active" <?php } ?>><a  href="<?=base_url()?>"> <?=$page->name?> </a><span></span></li>
<?php 
        } else if($this->session->userdata('bloom_userid')) {
            if($this->session->userdata('bloom_professional_type') == 'Mentee') {
?>
        <li <?php if($mainheader == $page->name) { ?>class="active" <?php } ?>><a  href="<?=base_url().$page->slug?>"> <?=$page->name?> </a><span></span></li>
<?php 
            } else if($this->session->userdata('bloom_professional_type') == 'Mentor') {
                if($page->id != 7) {
?>
        <li <?php if($mainheader == $page->name) { ?>class="active" <?php } ?>><a  href="<?=base_url().$page->slug?>"> <?=$page->name?> </a><span></span></li>
<?php
                }
            }
        } else if($page->id == 2 || $page->id == 5) {
?>
        <li <?php if($mainheader == $page->name) { ?>class="active" <?php } ?>><a  href="<?=base_url().$page->slug?>"> <?=$page->name?> </a><span></span></li>
<?php 
        } 
    } 
}
?>
                                        <!-- <li><a href="about.html">About Us</a><span></span></li>
                                        <li><a href="what-we-do.html">What we do</a><span></span></li>
                                        <li><a href="how-it-works.html">How it works</a><span></span></li>
                                        <li><a href="reach-us.html">Reach us</a><span></span></li> -->
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php echo $content_for_layout;?>

    <section class="footer_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="footer_menu w-100">
                        <ul class="d-sm-flex">
                            <?php if($pages != []){ 
                                foreach($pages as $page){?>
                                    
                                               <?php if($page->id == 1) {?>
                                               <li <?php if($mainheader == $page->name) { ?>class="active" <?php } ?>>
                                                    <a  href="<?=base_url()?>"> <?=$page->name?> </a><span></span></li>
                                               <?php } else if($this->session->userdata('bloom_userid')) { ?>
                                              <li <?php if($mainheader == $page->name) { ?>class="active" <?php } ?>>
                                                   <a  href="<?=base_url().$page->slug?>"> <?=$page->name?> </a><span></span></li>
                                               <?php } else if($page->id == 2 || $page->id == 5){ ?>
                                              <li <?php if($mainheader == $page->name) { ?>class="active" <?php } ?>>
                                                   <a  href="<?=base_url().$page->slug?>"> <?=$page->name?> </a><span></span></li>
                                               <?php } ?>
                                                    
                                              
                            <?php } } ?>
                            
                        </ul>
                        <h4>1-800-123-4567</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="copyright_sec theme_bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright_inner w-100">
                        <p>© COPYRIGHT <?php echo date("Y"); ?> ALL RIGHTS RESERVED | POWERED BY: <img src="<?=base_url()?>dist/front/img/sirchend-logo.png" /></p>
                        <ul class="d-flex">
                            <li><a href="<?=$site_settings->facebook?>"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="<?=$site_settings->twitter?>"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="<?=$site_settings->linkedin?>"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="<?=$site_settings->instagram?>"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


</body>
<script src="<?=base_url()?>dist/front/js/jquery-3.4.1.min.js"></script>
<script src="<?=base_url()?>dist/front/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>dist/front/js/owl.carousel.js"></script>
<script src="<?=base_url()?>dist/front/js/aos.js"></script>
<script src="<?=base_url()?>dist/front/js/bootstrap-better-nav.js"></script>
<script src="<?=base_url()?>dist/front/js/custom.js"></script>

<script>
    AOS.init();

</script>

</html>