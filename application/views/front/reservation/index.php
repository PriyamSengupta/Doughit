<?php 
	$site_settings = get_site_settings(1);
?>	


<section class="page-banner" style="background: #121619 url(<?=base_url()?>dist/front/images/blog-6.jpg) no-repeat center / cover;">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="page-title">
                    <h1 class="page-headding">reservation</h1>
                    <ul>
                        <li><a href="index.html" class="page-name">Home</a></li>
                        <li>Reservation</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
	
<section class="online-booking reservation pt-100">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="headding-part text-center">
                    <p class="headding-sub">Make Online Reservation</p>
                    <h2 class="headding-title text-uppercase font-weight-bold">Book a table</h2>
                </div>
            </div>
        </div>
        <form class="online-order-form">
            <input type="hidden" name="admin_email" value="<?=$site_settings->admin_email?>">
            
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="form-group">
                        <div class="custom-select-wrapper"><select name="time" id="time" class="custom-select sources form-control" data-placeholder="time" style="display: none;">
                                <option value="profile">Hour</option>
                                <option value="word">minute</option>
                                <option value="hashtag">second</option>
                        </select>
                        </div>
                        <!-- <input type="text" class="form-control" id="datepicker" name="date" placeholder="Pick a Date" required="" autocomplete="off" >  -->
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="form-group">
                        <div class="custom-select-wrapper">
                        <select name="person_count" id="sources" class="custom-select sources form-control" data-placeholder="Number Of People" style="display: none;">
                                <option value="5" selected="">Person 5</option>
								<option value="4">Person 4</option>
								<option value="3">Person 3</option>
                                <option value="2">Person 2</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" id="datepicker" name="date" placeholder="Pick a Date" required="" autocomplete="off" > 
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" id="phone" name="phone"  placeholder="Phone Number " required="">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name"  placeholder="Name" required="">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" id="email" name="email"  placeholder="Email Address" required="" onblur="validateEmail(this);">
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="form-group">
                        <textarea class="form-control" placeholder="Coments" name="comment" id="comment" required=""></textarea>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="form-control form-group alert alert-success" id="success-alert" style="display: none">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>Success! </strong>Thank you for choosing us.
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="form-control form-group alert alert-warning" id="error-alert" style="display: none">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>Error! </strong> Something went wrong.
                    </div>
                </div>    
                <div class="col-xl-12 col-lg-12 col-md-12 text-center">
                    <input type="submit" name="submit" value="Book a table" class="table-book">
                </div>
            </div>
        </form>
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
				$("#success-alert").fadeTo(2000, 1000).slideUp(1000, function(){
					$("#success-alert").slideUp(1000);
				});
			}
			else{
				$(".online-order-form").trigger("reset");
				$("#error-alert").fadeTo(2000, 1000).slideUp(1000, function(){
					$("#error-alert").slideUp(1000);
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