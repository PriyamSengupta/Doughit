<?php 

$types = get_types();
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
        
        <form method="POST" action="<?=$this->config->item('base_url').'admin/chef/addedit_chef'?>" enctype="multipart/form-data">
          <input type="hidden" name="id" id="chef_id" value="<?=$details->id?>">

          

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">First Name</label>
            <div class="col-sm-10">
                <input type="text" name="fname" id="fname" placeholder="First Name" class="form-control" value="<?=$details->fname?>">
            </div>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Last Name</label>
            <div class="col-sm-10">
                <input type="text" name="lname" id="lname" placeholder="Last Name" class="form-control" value="<?=$details->lname?>">
            </div>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Expertise</label>
            <div class="col-sm-10">
                <input type="text" name="expertise" id="expertise" placeholder="Expertise" class="form-control" value="<?=$details->expertise?>">
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
                <img id="img_preview" src="<?=base_url()?>upload/chef/normal/<?=$details->image?>" style="width:300px ; height:200px;"/>
              <?php } ?>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-9 ml-auto">
              <a href="<?=base_url()?>admin/chef" class="btn btn-secondary">Cancel</a>
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