<?php 

$pages = get_pages('app');
// print_r($types);
?>

<!-- Page header start -->
<div class="page-header">
  
  <!-- Breadcrumb start -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><?=$mainheader?></li>
  </ol>
  <!-- Breadcrumb end -->

</div>
<!-- Page header end -->   
<div class="row gutters"> 
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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
    <div class="card">
      <div class="card-header">
        <div class="card-title"><?=$mainheader?></div>
      </div>
      <div class="card-body">
        
        <form method="POST" action="<?=$this->config->item('base_url').'admin/app_banner/addedit_banner'?>" enctype="multipart/form-data">
          <input type="hidden" name="id" id="banner_id" value="<?=$details->id?>">

          

          <div class="form-group row">
            <label for="page_id" class="col-sm-2 col-form-label">Page Name</label>
            <div class="col-sm-10">
                <select name="page_id" id="page_id" class="form-control">
                  <option value="">Select page</option>
                  <?php if(count($pages) > 0) { 
                    foreach($pages as $page) {
                    ?>
                    <option value="<?=$page->id?>" <?php if($details->page_id == $page->id) { ?> selected <?php } ?>><?=$page->name?></option>
                  <?php } } ?>
                </select>
            </div>
          </div>

          
          <div class="form-group row">
            <label for="image" class="col-sm-2 col-form-label">Image</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" name="image" id="image" placeholder="Change Image" onchange="readURL(this)" <?php if($details->image == '') { ?> required <?php } ?>>
            </div>
          </div>

          <div class="form-group row preview_img" <?php if($details->id=='') { ?> style="display: none;" <?php } ?>>
            <label for="colFormLabel" class="col-sm-2 col-form-label">Preview</label>
            <div class="col-sm-10">
              <?php if($details->id=='') { ?>
                <img id="img_preview"/>
              <?php } else { ?>
                <img id="img_preview" src="<?=base_url()?>upload/banner/normal/<?=$details->image?>" style="width:300px ; height:200px;"/>
              <?php } ?>
            </div>
          </div>
           <div class="form-group row">
            <label for="banner_text" class="col-sm-2 col-form-label">Banner Text</label>
            <div class="col-sm-10">
                <input type="text" name="banner_text" id="banner_text" placeholder="Banner Text" class="form-control" value="<?=$details->banner_text?>">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-9 ml-auto">
              <a href="<?=base_url()?>admin/app_banner" class="btn btn-secondary">Cancel</a>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
  $("#get_error_msg_main_id1").hide();
  $("#get_error_msg_main_id1").fadeTo(2000, 500).slideUp(500, function() {
      $("#get_error_msg_main_id1").slideUp(500);
    });
});
  </script>

<script>
  function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
          $('.preview_img').show();

           $('#img_preview')
              .attr('src', e.target.result)
              .width(300)
              .height(200);
          };
          reader.readAsDataURL(input.files[0]);
       }
}
</script>