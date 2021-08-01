<?php
  $types = get_types();
  // if($details->id != ''){
  //   $type_array = get_category_type($details->id);
  // }
  // else {
  //   $type_array = array();
  // }
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
<form method="POST" action="<?=$this->config->item('base_url').'admin/categories/addedit_category'?>" enctype="multipart/form-data">
<input type="hidden" name="id" id="category_id" value="<?=$details->id?>">
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
          <div class="card-title">General Info</div>
        </div>
        <div class="card-body">
            <div class="form-group row">
              <label for="site_email" class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                  <input type="text" name="name" id="name" placeholder="Category Name" class="form-control" value="<?=$details->name?>">
              </div>
            </div>

            <div class="form-group row">
              <label for="description" class="col-sm-2 col-form-label">Description</label>
              <div class="col-sm-10">
                <textarea name="description" placeholder="Description" id="description" class="form-control"><?=$details->description?></textarea>
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
                  <img id="img_preview" src="<?=base_url()?>upload/categories/normal/<?=$details->image?>" style="width:300px ; height:200px;"/>
                <?php } ?>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- <div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Add ons</div>
        </div>
        <div class="card-body">

         
          <?php if(count($types) > 0){
                  $i = 1;
                  foreach($types as $type) { ?>
          
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="type[]" class="custom-control-input" <?php if(in_array($type->id, $type_array)) { ?> checked = "" <?php } ?> value="<?=$type->id?>" id="customCheck<?=$i?>">
                      <label class="custom-control-label" for="customCheck<?=$i?>"><?=$type->name?></label>
                    </div>
          <?php $i += 1; } } ?>

        </div>
      </div>
    </div>
  </div> -->
  
  <div class="form-group row">
    <div class="col-sm-12 ml-auto">
      <a href="<?=base_url()?>admin/categories" class="btn btn-secondary">Cancel</a>
      <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
  </div>
</form>

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