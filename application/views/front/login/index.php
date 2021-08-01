<?php $site_settings = get_site_settings(1); ?>
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

<section class="shopping-cart ptb">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                                    
                <div class="log-sign-prt">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                        <a class="nav-link active" id="user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="user" aria-selected="true">Login</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" id="vendor-tab" data-toggle="tab" href="#vendor" role="tab" aria-controls="vendor" aria-selected="false">Sign Up</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="user" role="tabpanel" aria-labelledby="user-tab">
                            <div class="inner-logo">
                                <img src="<?=base_url()?>upload/logo/<?=$site_settings->logo?>" alt="" />
                            </div>
                            <form method="post" action="/" id="login_frm">  
                                <div class="row">
                                    <div class="col-md-12">             
                                        <div class="input-group mt-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                            </div>
                                            <input type="email" class="form-control required" placeholder="Email" name="login_email" id="login_email">
                                        </div> 
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-group mt-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                            </div>
                                            <input type="password" class="form-control required" placeholder="Password" name="login_password" id="login_password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-check mt-3">    
                                            <input type="checkbox" class="form-check-input" name="remember_me" id="exampleCheck1">
                                            <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                                        </div>
                                    </div>  
                                    <div class="col-md-6">
                                        <div class="form-group mt-3 text-right">
                                            <a id="forgetpass-tab" data-toggle="tab" href="#forget_password" role="tab" aria-controls="forget_password">Forget Password?</a>
                                        </div>
                                    </div>                                      
                                    <div class="col-md-12">
                                        <button type="submit" class="btn signup-btn">Login</button>
                                    </div>    
                                    <div class="col-md-12 text-center">
                                        <p class="devide-pera mt-4">Don't have an account? <a id="vendor-tab" data-toggle="tab" href="#vendor" role="tab" aria-controls="vendor">Sign Up</a></p>
                                    </div>    
                                </div>                             
                            </form>                                
                        </div>
                        <div class="tab-pane fade" id="vendor" role="tabpanel" aria-labelledby="vendor-tab">                          	
                            <div class="inner-logo">
                                <img src="<?=base_url()?>upload/logo/<?=$site_settings->logo?>" alt="" />
                            </div>
                            <form action="/" id="reg_frm" method="post">  
                                <div class="row">
                                    <div class="col-md-12">             
                                        <div class="input-group mt-5">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user-o"></i></span>
                                        </div>
                                        <input type="text" class="form-control required" placeholder="First Name" name="first_name" id="first_name">
                                        </div> 
                                    </div>
                                    <div class="col-md-12">             
                                        <div class="input-group mt-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user-o"></i></span>
                                        </div>
                                        <input type="text" class="form-control required" placeholder="Last Name" name="last_name" id="last_name">
                                        </div> 
                                    </div>  
                                    <div class="col-md-12">             
                                        <div class="input-group mt-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                            </div>
                                            <input type="tel" class="form-control required number" placeholder="Mobile no." name="phone" id="phone">
                                        </div> 
                                    </div> 
                                    
                                    <div class="col-md-12">             
                                        <div class="input-group mt-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                            </div>
                                            <input type="email" class="form-control required" placeholder="Email" name="email" id="email">
                                        </div> 
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-group mt-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                            </div>
                                            <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn signup-btn">Sign Up</button>
                                    </div>    
                                    <div class="col-md-12 text-center">
                                        <p class="devide-pera mt-4">Already have an account? <a href="<?php echo site_url('login');?>">Sign In</a></p>
                                    </div>  
                                </div>                               
                            </form>  
                                                        
                        </div>
                        <div class="tab-pane fade" id="forget_password" role="tabpanel" aria-labelledby="forgetpass-tab">                          	
                            <div class="inner-logo">
                                <img src="<?=base_url()?>upload/logo/<?=$site_settings->logo?>" alt="" />
                            </div>
                            <div class="inner-logo">
                                <p style="color: white !important">Forgot Password</p>
                            </div>
                            <form action="/" id="fp_frm" method="post">  
                                <div class="row">
                                    <div class="col-md-12">             
                                        <div class="input-group mt-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                            </div>
                                            <input type="email" class="form-control required" placeholder="Email" name="useremail" id="useremail">
                                        </div> 
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn signup-btn">Send</button>
                                    </div>    
                                    
                                </div>                               
                            </form>  
                                                        
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function(e) {
    $("#reg_frm").validate({
        ignore: [],
        debug: false,
        rules: {
        first_name: "required",
        last_name: "required",
        phone: "required",
        email : {
            required: true,
            email : true,
            remote: {
                url: "<?php echo base_url().'login/check_email'; ?>",
                type: "post",
                data: {
                    email: function(){ return $("#email").val(); }
                }
            }
        },
        password: "required",
        },
        messages: {
            first_name: "Please provide first name",
            last_name: "Please provide last name",
            phone: "Please provide phone number",
            email : {
                    required: "Please provide email",
                    email : "Please provide valid email",
                    remote : "Email is already exist"
                },
            password: "Please provide password",
        },
        submitHandler: function(form) {
            //alert(grecaptcha.getResponse().length);return false;
            $.blockUI({ message:  '<img src="<?=base_url()?>dist/admin/img/preloading-white.gif" alt="" class="img-loader-cls"/>',css: { 
                border: 'none', 
                padding: '0px', 
                backgroundColor: 'transparent', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                color: '#fff' 
            } }); 
            var formData = new FormData(form);
            $.ajax({
                type:'POST',
                url: "<?php echo base_url().'login/save_user'; ?>",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data) {
                    $('#reg_frm').trigger("reset");
                    // console.log(data);
                    var msg = JSON.parse(data);
                    
                    if(msg.error_code == 'Success') {
                        swal(
                            'Success',
                            ""+msg.message+"",
                            'success'
                        );
                    } else {
                        swal(
                            'Alert!',
                            ""+msg.message+"",
                            'error'
                        );
                    } 
                    $.unblockUI();
                    return false;
                },
                error: function(data){
                    console.log("error");
                    console.log(data);
                }
            });
            return false;
        }
    });

    $("#login_frm").validate({
        ignore: [],
        debug: false,
        rules: {
        login_email : {
            required: true,
            email : true
        },
        login_password: "required"
        },
        messages: {
        login_email : {
            required: "Please provide email",
            email : "Please provide valid email"
        },
        login_password: "Please provide password"
        },
        submitHandler: function(form) {
            //alert(grecaptcha.getResponse().length);return false;
            $.blockUI({ message:  '<img src="<?=base_url()?>dist/admin/img/preloading-white.gif" alt="" class="img-loader-cls"/>',css: { 
                border: 'none', 
                padding: '0px', 
                backgroundColor: 'transparent', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                color: '#fff' 
            } }); 
            var formData = new FormData(form);
            $.ajax({
                type:'POST',
                url: "<?php echo base_url().'login/check_login'; ?>",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data) {
                    var email = formData.get("login_email");
                    $('#login_frm').trigger("reset");
                    var redirectUrl = "<?php echo base_url(); ?>"
                    var msg = JSON.parse(data);
                    
                    if(msg.error_code == 'Success') {
                        window.location = redirectUrl;
                    } else {
                        swal(
                            'Alert!',
                            ""+msg.message+"",
                            'error'
                        );
                    }
                
                    $.unblockUI();
                    return false; 
                    
                    //changeFirebaseStatus(msg.firebase_id,email);
                        
                },
                error: function(data){
                    console.log("error");
                    console.log(data);
                }
            });
            return false;
        }
    });

    $("#fp_frm").validate({
        ignore: [],
        debug: false,
        rules: {
        useremail : {
            required: true,
            email : true
        }
        },
        messages: {
        useremail : {
            required: "Please provide email",
            email : "Please provide valid email"
        }
        },
        submitHandler: function(form) {
            //alert(grecaptcha.getResponse().length);return false;
            $.blockUI({ message:  '<img src="<?=base_url()?>dist/admin/img/preloading-white.gif" alt="" class="img-loader-cls"/>',css: { 
                border: 'none', 
                padding: '0px', 
                backgroundColor: 'transparent', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                color: '#fff' 
            } }); 
            var formData = new FormData(form);
            $.ajax({
                type:'POST',
                url: "<?php echo base_url().'login/checkforgotpassword'; ?>",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data) {
                    $('#fp_frm').trigger("reset");
                    var msg = JSON.parse(data);
                    if(msg.error_code == 'Success') {
                        swal(
                            'Success',
                            ""+msg.message+"",
                            'success'
                        );
                    } else {
                        swal(
                            'Alert!',
                            ""+msg.message+"",
                            'error'
                        );
                    } 
                    $.unblockUI();
                    return false;
                },
                error: function(data){
                    console.log("error");
                    console.log(data);
                }
            });
            return false;
        }
    });
});

</script>