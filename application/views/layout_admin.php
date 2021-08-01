<?php
// date_default_timezone_set('UTC');
if($this->session->userdata('pz_admin_userid'))

{

  $CI =& get_instance();



  $CI->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');

  $CI->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

  $CI->output->set_header('Pragma: no-cache');

  $CI->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

  // $get_pages = get_pages();
  // $page_id_arr = array();
  // foreach ($get_pages as $page) {
  //   array_push($page_id_arr, base64_encode($page->id));
  // }
  // $get_pages_admin = get_pages_admin();
}
else
{

  redirect($this->config->item('base_url').'admin');

}
$get_pages_admin = get_pages_admin();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap4 Dashboard Template">
    <meta name="author" content="ParkerThemes">
    <link rel="shortcut icon" href="<?=base_url()?>dist/admin/img/fav.png" />

    <!-- Title -->
    <title>Doughit Admin :: <?=$mainheader?></title>


    <!-- *************
      ************ Common Css Files *************
    ************ -->
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="<?=base_url()?>dist/admin/css/bootstrap.min.css">
    <!-- Icomoon Font Icons css -->
    <link rel="stylesheet" href="<?=base_url()?>dist/admin/fonts/style.css">
    <!-- Main css -->
    <link rel="stylesheet" href="<?=base_url()?>dist/admin/css/main.css">
    <!-- Chat css -->
    <link rel="stylesheet" href="<?=base_url()?>dist/admin/css/chat.css">

    <!-- Data Tables -->
		<link rel="stylesheet" href="<?=base_url()?>dist/admin/vendor/datatables/dataTables.bs4.css" />
		<link rel="stylesheet" href="<?=base_url()?>dist/admin/vendor/datatables/dataTables.bs4-custom.css" />

    <!-- *************
      ************ Vendor Css Files *************
    ************ -->
    <script src="<?=base_url()?>dist/admin/js/jquery.min.js"></script>
    <script src="<?=base_url()?>dist/admin/js/sweetalert.min.js"></script>
    <script src="<?=base_url()?>dist/admin/js/jquery.blockUI.js"></script>
    <!-- <script type="application/javascript" src="<?=base_url()?>dist/admin/js/additional-methods.min.js"></script> -->

  </head>

  <body>

    <!-- Loading starts -->
    <div id="loading-wrapper">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <!-- Loading ends -->
    
    <!-- Page wrapper start -->
    <div class="page-wrapper">
      
      <!-- Sidebar wrapper start -->
      <nav id="sidebar" class="sidebar-wrapper">

        <!-- Sidebar brand start  -->
        <div class="sidebar-brand">
          <a href="<?=base_url()?>admin/dashboard" class="logo">Doughit Admin</a>
        </div>
        <!-- Sidebar brand end  -->
        
        <!-- User profile start -->
        <div class="sidebar-user-details">
          <div class="user-profile">
            <img src="<?=base_url()?>dist/admin/img/user2.png" class="profile-thumb" alt="User Thumb">
            <span class="status-label"></span>
          </div>
          <h6 class="profile-name">Doughit Admin</h6>
          <div class="profile-actions">
            <a href="account-settings.html" data-toggle="tooltip" data-placement="top" title="" data-original-title="Settings">
              <i class="icon-settings1"></i>
            </a>
            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Twitter">
              <i class="icon-twitter1"></i>
            </a>
            <a href="<?=base_url()?>admin/logout" class="red" data-toggle="tooltip" data-placement="top" title="" data-original-title="Logout">
              <i class="icon-power1"></i>
            </a>
          </div>          
        </div>
        <!-- User profile end -->

        <!-- Sidebar content start -->
        <div class="sidebar-content">

          <!-- sidebar menu start -->
          <div class="sidebar-menu">
            <ul>
              <li <?php if($mainheader == "Dashboard") { ?> class="active" <?php } ?>>
                <a <?php if($mainheader == "Dashboard") { ?> class="current-page" <?php } ?> href="<?=base_url()?>admin/dashboard">
                  <i class="icon-home2"></i>
                  <span class="menu-text">Dashboard</span>
                </a>
              </li>

              <li <?php if($mainheader == "Add-ons" || $mainheader == "Create Add-on" || $mainheader == "Edit Add-on" || $mainheader == "Type Options" || $mainheader == "Add Option" || $mainheader == "Edit Option" || $mainheader == "Size" || $mainheader == "Add Size" || $mainheader == "Edit Size" || $mainheader == "Categories" || $mainheader == "Add Category" || $mainheader == "Edit Category" || $mainheader == "Products" || $mainheader == "Add Product" || $mainheader == "Edit Product") { ?> class="sidebar-dropdown active" <?php } else { ?> class="sidebar-dropdown" <?php } ?>>
                <a href="#">
                  <i class="icon-calendar1"></i>
                  <span class="menu-text">Product Management</span>
                </a>
                <div class="sidebar-submenu">
                  <ul>
                    <li>
                      <a <?php if($mainheader == "Categories" || $mainheader == "Add Category" || $mainheader == "Edit Category") { ?> class="current-page" <?php } ?> href="<?=base_url()?>admin/categories">
                        Categories
                      </a>
                    </li>
            
                    <li>
                      <a href="<?=base_url()?>admin/size" <?php if($mainheader == "Size" || $mainheader == "Add Size" || $mainheader == "Edit Size") { ?> class="current-page" <?php } ?>>Size</a>
                    </li>
                    <li>
                      <a href="<?=base_url()?>admin/type" <?php if($mainheader == "Add-ons" || $mainheader == "Create Add-on" || $mainheader == "Edit Add-on") { ?> class="current-page" <?php } ?>>Add-on</a>
                    </li>
                    <li>
                      <a href="<?=base_url()?>admin/type_options" <?php if($mainheader == "Type Options" || $mainheader == "Add Option" || $mainheader == "Edit Option") { ?> class="current-page" <?php } ?>>Add-on Options</a>
                    </li>

                    <li>
                      <a <?php if($mainheader == "Products" || $mainheader == "Add Product" || $mainheader == "Edit Product") { ?> class="current-page" <?php } ?> href="<?=base_url()?>admin/products">
                        Products
                      </a>
                    </li>
                  </ul>
                </div>
              </li>    
              
              <li <?php if($mainheader == "App Pages" || $mainheader == "Add App Page" || $mainheader == "Edit App Page" || $mainheader == "App Banner" || $mainheader == "Add App Banner" || $mainheader == "Edit App Banner") { ?> class="sidebar-dropdown active" <?php } else { ?> class="sidebar-dropdown" <?php } ?>>
                <a href="#">
                  <i class="icon-calendar1"></i>
                  <span class="menu-text">App Management</span>
                </a>
                <div class="sidebar-submenu">
                  <ul>
                    <li>
                      <a <?php if($mainheader == "App Pages" || $mainheader == "Add App Page" || $mainheader == "Edit App Page") { ?> class="current-page" <?php } ?> href="<?=base_url()?>admin/app_page">
                        App Pages
                      </a>
                    </li>
                    <li>
                      <a <?php if($mainheader == "App Banner" || $mainheader == "Add App Banner" || $mainheader == "Edit App Banner") { ?> class="current-page" <?php } ?> href="<?=base_url()?>admin/App_banner">
                        App Banner
                      </a>
                    </li>
                  </ul>
                </div>
              </li> 

              <li <?php if($mainheader == "Users" || $mainheader == "Add User" || $mainheader == "Edit User") { ?> class="active" <?php } ?>>
                <a <?php if($mainheader == "Users" || $mainheader == "Add User" || $mainheader == "Edit User") { ?> class="current-page" <?php } ?> href="<?=base_url()?>admin/users">
                  <i class="icon-users"></i>
                  <span class="menu-text">Users</span>
                </a>
              </li>

              <li <?php if($mainheader == "Orders") { ?> class="active" <?php } ?>>
                <a <?php if($mainheader == "Orders") { ?> class="current-page" <?php } ?> href="<?=base_url()?>admin/orders">
                  <i class="icon-question_answer"></i>
                  <span class="menu-text">Order Management</span>
                </a>
              </li>

              <li <?php if($mainheader == "Chefs" || $mainheader == "Add Chef" || $mainheader == "Edit Chef") { ?> class="active" <?php } ?>>
                <a <?php if($mainheader == "Chefs" || $mainheader == "Add Chef" || $mainheader == "Edit Chef") { ?> class="current-page" <?php } ?> href="<?=base_url()?>admin/chef">
                  <i class="icon-box"></i>
                  <span class="menu-text">Chefs</span>
                </a>
              </li>

              <li <?php if($mainheader == "Blogs" || $mainheader == "Add Blog" || $mainheader == "Edit Blog") { ?> class="active" <?php } ?>>
                <a <?php if($mainheader == "Blogs" || $mainheader == "Add Blog" || $mainheader == "Edit Blog") { ?> class="current-page" <?php } ?> href="<?=base_url()?>admin/blog">
                  <i class="icon-box"></i>
                  <span class="menu-text">Blog Management</span>
                </a>
              </li>

              <li <?php if($mainheader == "Customer Booking") { ?> class="active" <?php } ?>>
                <a <?php if($mainheader == "Customer Booking") { ?> class="current-page" <?php } ?> href="<?=base_url()?>admin/booking">
                  <i class="icon-box"></i>
                  <span class="menu-text">Customer Booking</span>
                </a>
              </li>

              <li <?php if($mainheader == "Customer Enquiry") { ?> class="active" <?php } ?>>
                <a <?php if($mainheader == "Customer Enquiry") { ?> class="current-page" <?php } ?> href="<?=base_url()?>admin/enquiry">
                  <i class="icon-question_answer"></i>
                  <span class="menu-text">Customer Enquiry</span>
                </a>
              </li>

              <li <?php if($mainheader == "Settings") { ?> class="active" <?php } ?>>
                <a <?php if($mainheader == "Settings") { ?> class="current-page" <?php } ?> href="<?=base_url()?>admin/settings">
                  <i class="icon-settings1"></i>
                  <span class="menu-text">Site Settings</span>
                </a>
              </li>
              
            </ul>
          </div>
          <!-- sidebar menu end -->

        </div>
        <!-- Sidebar content end -->
        
      </nav>
      <!-- Sidebar wrapper end -->

      <!-- Page content start  -->
      <div class="page-content">
        
        <!-- Header start -->
        <header class="header">
          <div class="toggle-btns">
            <a id="toggle-sidebar" href="#">
              <i class="icon-menu"></i>
            </a>
            <a id="pin-sidebar" href="#">
              <i class="icon-menu"></i>
            </a>
          </div>
          <div class="header-items">
            <!-- Custom search start -->
            <!-- <div class="custom-search">
              <input type="text" class="search-query" placeholder="Search here ...">
              <i class="icon-search1"></i>
            </div> -->
            <!-- Custom search end -->

            <!-- Header actions start -->
            <ul class="header-actions">
              
              <li class="dropdown user-settings">
                <a href="#" id="userSettings" data-toggle="dropdown" aria-haspopup="true">
                  <img src="<?=base_url()?>dist/admin/img/user2.png" class="user-avatar" alt="Avatar">
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
                  <div class="header-profile-actions">
                    <div class="header-user-profile">
                      <div class="header-user">
                        <img src="<?=base_url()?>dist/admin/img/user2.png" alt="Admin Template">
                      </div>
                      <h5>Yuki Hayashi</h5>
                      <p>Super Admin</p>
                    </div>
                    <a href="user-profile.html"><i class="icon-user1"></i> My Profile</a>
                    <a href="account-settings.html"><i class="icon-settings1"></i> Account Settings</a>
                    <a href="<?=base_url()?>admin/logout"><i class="icon-log-out1"></i> Sign Out</a>
                  </div>
                </div>
              </li>
            </ul>           
            <!-- Header actions end -->
          </div>
        </header>
        <!-- Header end -->

        <!-- Main container start -->
        <div class="main-container">

          <?php
          if($this->session->flashdata('success_msg'))
          {
          ?>
                <div class="alert alert-success alert-dismissable" id="get_error_msg_main_id1">
                  <button class="close" type="button" onclick="javascript:hide_error_msg('get_error_msg_main_id1');">×</button>
                  <?php echo $this->session->flashdata('success_msg'); ?>
                </div>

          <?php
            $this->session->set_flashdata('success_msg', "");
          }
          else if($this->session->flashdata('error_msg'))
          {
          ?>
                <div class="alert alert-danger alert-dismissable" id="get_success_msg_main_id1">

                  <button class="close" type="button" onclick="javascript:hide_error_msg('get_success_msg_main_id1');">×</button>

                  <?php echo $this->session->flashdata('error_msg'); ?>

                </div>

          <?php
            $this->session->set_flashdata('error_msg', "");
          }
          ?>
          <?php echo $content_for_layout;?>

        </div>
        <!-- Main container end -->

        <!-- Container fluid start -->
        <div class="container-fluid">
          <!-- Row start -->
          <div class="row gutters">
            <div class="col-12">
              <!-- Footer start -->
              <div class="footer">
                Copyright Doughit Admin <?=date("Y")?>
              </div>
              <!-- Footer end -->
            </div>
          </div>
          <!-- Row end -->
        </div>
        <!-- Container fluid end -->
        
        <!-- Chat start -->
        <!-- <div id="chat-box">
          <div id="chat-circle" class="btn btn-raised">
            <img src="img/chat.svg" alt="Chat" />
          </div>
          <div class="chat-box">
            <div class="chat-box-header">
              Chat
              <span class="chat-box-toggle"><i class="icon-close"></i></span>
            </div>
            <div class="chat-box-body">
              <div class="chat-logs">
                <div class="chat-msg self">
                  <img src="img/user2.png" class="user" alt="">
                  <div class="chat-msg-text">Hello</div>
                </div>
                <div class="chat-msg user">
                  <img src="img/user15.png" class="user" alt="">
                  <div class="chat-msg-text">Are we meeting today?</div>
                </div>
                <div class="chat-msg self">
                  <img src="img/user2.png" class="user" alt="">
                  <div class="chat-msg-text">Yes, what time suits you?</div>
                </div>
                <div class="chat-msg user">
                  <img src="img/user15.png" class="user" alt="">
                  <div class="chat-msg-text">Can we connect at 3pm?</div>
                </div>
                <div class="chat-msg self">
                  <img src="img/user2.png" class="user" alt="">
                  <div class="chat-msg-text">Sure, Thanks. I will send you some important files.</div>
                </div>
                <div class="chat-msg user">
                  <img src="img/user15.png" class="user" alt="">
                  <div class="chat-msg-text">Great. Thanks!</div>
                </div>
              </div>
            </div>
            <div class="chat-input">
              <form>
                <input type="text" id="chat-input" placeholder="Send a message..."/>
              <button type="submit" class="chat-submit" id="chat-submit"><i class="icon-send"></i></button>
              </form>
            </div>
          </div>
        </div> -->
        <!-- Chat end -->

      </div>
      <!-- Page content end -->

    </div>
    <!-- Page wrapper end -->

    <!--**************************
      **************************
        **************************
              Required JavaScript Files
        **************************
      **************************
    **************************-->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->
    <script src="<?=base_url()?>dist/admin/js/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url()?>dist/admin/js/moment.js"></script>


    <!-- *************
      ************ Vendor Js Files *************
    ************* -->
    <!-- Slimscroll JS -->
    <script src="<?=base_url()?>dist/admin/vendor/slimscroll/slimscroll.min.js"></script>
    <script src="<?=base_url()?>dist/admin/vendor/slimscroll/custom-scrollbar.js"></script>

    <!-- Data Tables -->
		<script src="<?=base_url()?>dist/admin/vendor/datatables/dataTables.min.js"></script>
		<script src="<?=base_url()?>dist/admin/vendor/datatables/dataTables.bootstrap.min.js"></script>

    <!-- Custom Data tables -->
		<script src="<?=base_url()?>dist/admin/vendor/datatables/custom/custom-datatables.js"></script>
		<!-- <script src="<?=base_url()?>dist/admin/vendor/datatables/custom/fixedHeader.js"></script> -->

    

    <!-- Polyfill JS -->
    <script src="<?=base_url()?>dist/admin/vendor/polyfill/polyfill.min.js"></script>
    <script src="<?=base_url()?>dist/admin/vendor/polyfill/class-list.min.js"></script>
    
    <!-- Main JS -->
    <script src="<?=base_url()?>dist/admin/js/main.js"></script>

  </body>
</html>