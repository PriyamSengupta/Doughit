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
        
        <form method="POST" action="<?=$this->config->item('base_url').'admin/settings/addedit_setting'?>" enctype="multipart/form-data">
          <input type="hidden" name="id" id="settings_id" value="<?=$details->id?>">
          <div class="form-group row">
            <label for="image" class="col-sm-2 col-form-label">Logo</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" name="image" id="image" placeholder="Change Image" onchange="readURL(this)">
            </div>
          </div>

          <div class="form-group row preview_img" <?php if($details->id=='') { ?> style="display: none;" <?php } ?>>
            <label for="colFormLabel" class="col-sm-2 col-form-label">Preview</label>
            <div class="col-sm-10">
              <?php if($details->id=='') { ?>
                <img id="img_preview"/>
              <?php } else { ?>
                <img id="img_preview" src="<?=base_url()?>upload/logo/<?=$details->logo?>" style="width:300px ; height:200px;"/>
              <?php } ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="description" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
              <textarea name="description" placeholder="Description" id="description" class="form-control"><?=$details->description?></textarea>
            </div>
          </div>

          <div class="form-group row">
            <label for="site_email" class="col-sm-2 col-form-label">Site Email</label>
            <div class="col-sm-10">
                <input type="text" name="site_email" id="site_email" placeholder="Site Email" class="form-control" value="<?=$details->site_email?>">
            </div>
          </div>

          <div class="form-group row">
            <label for="telephone" class="col-sm-2 col-form-label">Phone</label>
            <div class="col-sm-10">
               <input type="text" name="telephone" id="telephone" placeholder="Telephone" class="form-control" value="<?=$details->telephone?>">
            </div>
          </div>

          <div class="form-group row">
            <label for="mobile" class="col-sm-2 col-form-label">Mobile</label>
            <div class="col-sm-10">
               <input type="text" name="mobile" id="mobile" placeholder="Mobile" class="form-control" value="<?=$details->mobile?>">
            </div>
          </div>

          <div class="form-group row">
            <label for="address" class="col-sm-2 col-form-label">Address</label>
            <div class="col-sm-10">
               <textarea name="address" id="address" placeholder="Address" class="form-control"><?=$details->address?></textarea>
            </div>
          </div>

          <div class="form-group row">
            <label for="iframe" class="col-sm-2 col-form-label">Iframe</label>
            <div class="col-sm-10">
               <textarea name="iframe" placeholder="Iframe" class="form-control"><?=$details->iframe?></textarea><small class="help-block-none">Enter the Embedded url of your address.</small>
            </div>
          </div>


          <div class="form-group row">
            <label for="facebook" class="col-sm-2 col-form-label">Facebok</label>
            <div class="col-sm-10">
               <input type="text" name="facebook" placeholder="Facebok" class="form-control" value="<?=$details->facebook?>">
            </div>
          </div>

          <div class="form-group row">
            <label for="twitter" class="col-sm-2 col-form-label">Twitter</label>
            <div class="col-sm-10">
               <input type="text" name="twitter" id="twitter" placeholder="Twitter" class="form-control" value="<?=$details->twitter?>">
            </div>
          </div>

          <div class="form-group row">
            <label for="linkedin" class="col-sm-2 col-form-label">Linkedin</label>
            <div class="col-sm-10">
                <input type="text" name="linkedin" placeholder="Linkedin" class="form-control" value="<?=$details->linkedin?>">
            </div>
          </div>

          <div class="form-group row">
            <label for="instagram" class="col-sm-2 col-form-label">Instagram</label>
            <div class="col-sm-10">
               <input type="text" name="instagram" id="instagram" placeholder="Instagram" class="form-control" value="<?=$details->instagram?>">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-9 ml-auto">
              <a href="<?=base_url()?>admin/dashboard" class="btn btn-secondary">Cancel</a>
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

<!-- <script>
    // Replace the <textarea id="editor1"> with a CKEditor 4
    // instance, using default configuration.
    CKEDITOR.replace( 'editor1' );
</script> -->