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
                        <a class="nav-link active" id="user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="user" aria-selected="true">Reset Password</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="user" role="tabpanel" aria-labelledby="user-tab">                        	
                            <div class="inner-logo">
                                <img src="<?=base_url()?>upload/logo/<?=$site_settings->logo?>" alt="" />
                            </div>
                            <form action="/" id="resetpass_frm" method="post">
                                <input type="hidden" name="verification_code" value="<?=$verification_code?>">
                                <div class="row">
                                    <div class="col-md-12">             
                                        <div class="input-group mt-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                            </div>
                                            <input type="password" class="form-control required" placeholder="New Password" name="password" id="password">
                                        </div> 
                                    </div>
                                    <div class="col-md-12">             
                                        <div class="input-group mt-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                            </div>
                                            <input type="password" class="form-control required" placeholder="Confirm Password" name="retype_password" id="retype_password">
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
    $("#resetpass_frm").validate({
    ignore: [],
    debug: false,
    rules: {
        password: "required",
        retype_password : {
          required: true,
          equalTo : "#password"
        }
      },
      messages: {
        password: "Please provide password" ,
        retype_password : {
          required: "Please provide retype password",
          equalTo : "Password and retype password doesnot match"
        }
    },
    submitHandler: function(form) {
        //alert(grecaptcha.getResponse().length);return false;
        $.blockUI({ message:  '<img src="<?=base_url()?>dist/front/img/preloading-white.gif" alt="" class="img-loader-cls"/>',css: { 
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
            url: "<?php echo base_url().'login/change_password_details'; ?>",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(returndata) {
                $('#resetpass_frm').trigger("reset");
                var redirectUrl = "<?php echo base_url().'login'; ?>"
                //console.log(returndata);
                var msg = JSON.parse(returndata);
                if(msg.error_code == 'Success') {
                    swal(
                        'Success',
                        ""+msg.message+"",
                        'success'
                    ).then(function() {
                        window.location = redirectUrl;
                    });
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
            error: function(returndata){
                console.log("error");
                console.log(returndata);
            }
        });
        return false;
    }
  });
});

</script>
