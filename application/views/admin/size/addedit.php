<?php 

$categories = get_categories();
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
        
        <form method="POST" action="<?=$this->config->item('base_url').'admin/size/addedit_size'?>" enctype="multipart/form-data">
          <input type="hidden" name="id" id="option_id" value="<?=$details->id?>">

          <div class="form-group row">
            <label for="category_id" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-10">
              <select name="category_id" id="category_id" class="form-control">
                <option value="">Select category</option>
                <?php if(count($categories) > 0) { 
                  foreach($categories as $cat) {
                  ?>
                  <option value="<?=$cat->id?>" <?php if($details->category_id == $cat->id) { ?> selected <?php } ?>><?=$cat->name?></option>
                <?php } } ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="<?=$details->name?>">
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
                <img id="img_preview" src="<?=base_url()?>upload/size/normal/<?=$details->image?>" style="width:300px ; height:200px;"/>
              <?php } ?>
            </div>
          </div>

          <div class="form-group row" id="default_div">
            <label for="is_default" class="col-sm-2 col-form-label">Default Size</label>
            <div class="col-sm-10">
              <select name="is_default" id="is_default" class="form-control" required>
                <option value="">Select</option>
                <option value="1" <?php if($details->is_default == '1') { ?> selected <?php } ?>>Yes</option>
                <option value="0" <?php if($details->is_default == '0') { ?> selected <?php } ?>>No</option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-9 ml-auto">
              <a href="<?=base_url()?>admin/size" class="btn btn-secondary">Cancel</a>
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