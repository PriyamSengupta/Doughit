<?php $site_settings = get_site_settings(1);?>
<section class="page-banner" style="background: #121619 url(<?=base_url()?>dist/front/images/blog-8.jpg) no-repeat center / cover;">
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
<section class="contact ptb">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="headding-part text-center">
                    <p class="headding-sub">Get in touch</p>
                    <h2 class="headding-title text-uppercase font-weight-bold"><?=$mainheader?></h2>
                </div>
            </div>
        </div>
        <div class="contact-in">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-5">
                    <div class="contact-detail">
                        <h3 class="contact-head">Contact Details</h3>
                        <p class="contact-desc"><?=$site_settings->description?></p>
                        <ul>
                            <li><i class="fa fa-home" aria-hidden="true"></i><a href="javascript:void(0)"><?=$site_settings->address?></a></li>
                            <li><i class="fa fa-phone" aria-hidden="true"></i><a href="tel:1234567890"><?=$site_settings->telephone?> , <?=$site_settings->mobile?></a></li>
                            <li><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:<?=$site_settings->site_email?>"><?=$site_settings->site_email?></a></li>
                            <li>
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <a href="javascript:void(0)">
                                    <span>Monday – Friday: 10 am – 10pm</span>
                                    <span>Sunday: 11 am – 9pm</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-7">
                    <div class="leave">
                        <form class="contact-us-form">
                            <input type="hidden" name="admin_email" value="<?=$site_settings->admin_email?>">
                            <div class="form-group">
                                <input type="text" name="name" id="name"  class="form-control" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" id="email"  class="form-control" placeholder="Email"  onblur="validateEmail(this);">
                            </div>
                            <div class="form-group">
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" required="">
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" required="">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="message" placeholder="Message"></textarea>
                            </div>
                            <div class="form-control form-group alert alert-success" id="success-alert" style="display: none">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <strong>Success! </strong> Email Sent Successfully.
                            </div>
                            <div class="form-control form-group alert alert-warning" id="error-alert" style="display: none">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <strong>Error! </strong> Something went wrong.
                            </div>
                            <input type="submit" name="submit" value="Send Message" class="post-com">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="contact-map">
    <?=$site_settings->iframe?>
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
</script>
<script>
	$(function () {

	$('.contact-us-form').on('submit', function (e) {

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
		url: '<?= base_url()?>contact/send_mail',
		data: $('.contact-us-form').serialize(),
		success: function (data) {
			if(data == 1)
			{
				$(".contact-us-form").trigger("reset");
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").slideUp(500);
				});
			}
			else{
				$(".contact-us-form").trigger("reset");
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