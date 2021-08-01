<!-- Container start -->
<div class="container">
    
    <form action="<?=base_url()?>admin/index/checklogin" method="post">
        <div class="row justify-content-md-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="login-screen">
                    <div class="login-box">
                        <a href="#" class="login-logo">
                            <!-- <img src="img/logo.png" alt="Tycoon Admin Dashboard" /> -->
                            Doughit
                        </a>
                        <h5>Welcome back,<br />Please Login to your Account.</h5>
                        <div class="form-group">
                            <input type="text" id="login-username" name="loginemail" required class="form-control" placeholder="Email Address" />
                        </div>
                        <div class="form-group">
                            <input type="password" id="login-password" name="loginpassword" required class="form-control" placeholder="Password" />
                        </div>
                        <div class="actions mb-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="remember_pwd">
                                <label class="custom-control-label" for="remember_pwd">Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-success">Login</button>
                        </div>
                        <!-- <div class="forgot-pwd">
                            <a class="link" href="forgot-pwd.html">Forgot password?</a>
                        </div> -->
                        <hr>
                        <!-- <div class="actions align-left">
                            <a href="signup.html" class="btn btn-info ml-0">Create an Account</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
<!-- Container end -->