<?php 
    $categories = get_categories();
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
        
        <form method="POST" action="<?=$this->config->item('base_url').'admin/type/addedit_type'?>" enctype="multipart/form-data">
          <input type="hidden" name="id" id="type_id" value="<?=$details->id?>">

          <div class="form-group row">
            <label for="site_email" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" name="name" id="name" placeholder="Type Name" class="form-control" value="<?=$details->name?>">
            </div>
          </div>

          <div class="form-group row">
            <label for="description" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
              <textarea name="description" placeholder="Description" id="description" class="form-control"><?=$details->description?></textarea>
            </div>
          </div>

          <div class="form-group row">
            <label for="category_id" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-10">
              <select name="category_id" id="category_id" class="form-control">
                <option value="">Select category</option>
                <?php if(count($categories) > 0) { 
                  foreach($categories as $cat) { ?>
                  <option value="<?=$cat->id?>" <?php if($details->category_id == $cat->id) { ?> selected <?php } ?>><?=$cat->name?></option>
                <?php } } ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label for="multiselect" class="col-sm-2 col-form-label">Choose Multiple</label>
            <div class="col-sm-10">
              <select name="multiselect" id="multiselect" class="form-control" required>
                <option value="">Select</option>
                <option value="1" <?php if($details->multiselect == 1) { ?> selected <?php } ?>>Yes</option>
                <option value="0" <?php if($details->multiselect == 0) { ?> selected <?php } ?>>No</option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label for="is_mandatory" class="col-sm-2 col-form-label">Mandatory Field</label>
            <div class="col-sm-10">
              <select name="is_mandatory" id="is_mandatory" class="form-control" required>
                <option value="">Select</option>
                <option value="1" <?php if($details->is_mandatory == 1) { ?> selected <?php } ?>>Yes</option>
                <option value="0" <?php if($details->is_mandatory == 0) { ?> selected <?php } ?>>No</option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-9 ml-auto">
              <a href="<?=base_url()?>admin/type" class="btn btn-secondary">Cancel</a>
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