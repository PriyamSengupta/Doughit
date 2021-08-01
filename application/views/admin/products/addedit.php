<?php
  $categories = get_categories();
  $category_size_exists_arr = category_size_exists();
  $food_categories = get_food_categories();
  $path =$this->config->item('file_upload_base_url').'products/normal/';
  if($details->id != '')
  {
      $image_array = get_product_images($details->id);
      $count = count($image_array);
      $base_price_flag = $details->size_exists;
  }
  else
  {
      $image_array = array();
      $count = 0;
      $base_price_flag = "";
  }
  // $data = unserialize($details->price_array);
  // echo "<pre>"; print_r($details); die();
  // echo CI_VERSION;
?>
<style>
  .image-area {
      position: relative;
      width: 50%;
      /*background: #333;*/
      float: left;
      width: 50%;
      padding: 10px;
    }
    .image-area img{
      /*max-width: 80%;
      width: 80%;
      height: auto;*/
      margin-top: 12px;
      width: 100%;
    }

    .remove-image {
    display: none;
    position: absolute;
    top: 12px;
    /* right: 2px; */
    border-radius: 10em;
    padding: 2px 6px 3px;
    text-decoration: none;
    font: 700 21px/20px sans-serif;
    background: #555;
    border: 3px solid #fff;
    color: #FFF;
    box-shadow: 0 2px 6px rgba(0,0,0,0.5), inset 0 2px 4px rgba(0,0,0,0.3);
      text-shadow: 0 1px 2px rgba(0,0,0,0.5);
      -webkit-transition: background 0.5s;
      transition: background 0.5s;
    }
    .remove-image:hover {
     background: #E54E4E;
      padding: 3px 7px 5px;
      top: 12px;
      /* right: 2px; */
    }
    .remove-image:active {
     background: #E54E4E;
      top: 12px;
      /* right: 2px; */
    }
</style>
<!-- Page header start -->
<div class="page-header">
  
  <!-- Breadcrumb start -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><?=$mainheader?></li>
  </ol>
  <!-- Breadcrumb end -->

</div>
<!-- Page header end -->
<form method="POST" action="<?=$this->config->item('base_url').'admin/products/addedit_product'?>" enctype="multipart/form-data">
<input type="hidden" name="countImg" id="countImg" value="<?=$count?>">
<input type="hidden" name="currentImgCount" id="currentImgCount" value="0">
<input type="hidden" name="id" id="product_id" value="<?=$details->id?>">
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
              <label for="category_id" class="col-sm-2 col-form-label">Food category</label>
              <div class="col-sm-10">
                <select name="food_category_id" id="food_category_id" class="form-control">
                  <option value="">Select food category</option>
                  <?php if(count($food_categories) > 0) { 
                    foreach($food_categories as $food_cat) {
                    ?>
                    <option value="<?=$food_cat->id?>" <?php if($details->food_category_id == $food_cat->id) { ?> selected <?php } ?>><?=$food_cat->name?></option>
                  <?php } } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label for="category_id" class="col-sm-2 col-form-label">Category</label>
              <div class="col-sm-10">
                <select name="category_id" id="category_id" class="form-control" onchange="customize(this)">
                <!-- <select name="category_id" id="category_id" class="form-control"> -->
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
              <label for="image" class="col-sm-2 col-form-label">Featured Image:</label>
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
                    <img id="img_preview" src="<?=$path.$details->image?>" style="width:300px ; height:200px;"/>
                  <?php } ?>
                </div>
            </div>


            <div class="form-group row">
              <label for="other_image" class="col-sm-2 col-form-label">Other Images:</label>
              <div class="col-sm-10">
                <input type="file" class="form-control" name="other_images[]" id="other_images" placeholder="Change Image" onchange="readURL1()"  multiple="multiple">
              </div>
            </div>

            <div class="form-group row preview_img1" <?php if($details->id=='') { ?> style="display: none;" <?php } ?>>
                <label for="colFormLabel" class="col-sm-2 col-form-label">Preview</label>
                <div class="col-sm-10">
                    <?php 
                        if(count($image_array)>0){
                          $j = 1;
                          foreach($image_array as $img){ ?>
                            <div class="col-md-3 image-area" id="product_img<?=$j?>">
                              <img id="img_preview1" src="<?=$path.$img->image?>" style="width:200px ; height:200px;"/>
                              <a class="remove-image" href="javascript:void(0)" onclick='deleteFile("<?=$img->id?>")' style="display: inline;">&#215;</a>
                            </div>
                  <?php $j++; } } ?>
                  <div id="image_div"></div>
                </div>
            </div>

            <div class="form-group row">
              <label for="description" class="col-sm-2 col-form-label">Detailed Description</label>
              <div class="col-sm-10">
                <textarea name="detailed_description" placeholder="Description" id="detailed_description" class="form-control" rows="8"><?=$details->detailed_description?></textarea>
              </div>
            </div>

            <div class="form-group row" id="base_price_div" <?php if($base_price_flag == "1") { ?> style="display:none" <?php } ?>>
              <label for="base_price" class="col-sm-2 col-form-label">Default Price</label>
              <div class="col-sm-10">
                  <input type="text" name="base_price" id="base_price" placeholder="Default price" class="form-control" value="<?=$details->base_price?>">
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>


  <!-- <div id="dyn_addon">

  </div> -->


  <?php if($details->price_array != '') { ?>
    <div id="dyn_addon">
        <?php if($details->size_exists == 1) { ?>
        <input type="hidden" name="size_exists" value="<?=$details->size_exists?>">
        <?php if(count($details->price_array)>0) { ?>
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Pricing</div>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body">
                                <?php 
                                        $size_count = 0;
                                        foreach ($details->price_array as $size) { ?>
                                        <div class="monthly-avg">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="card-title"><?=$size->name?></div>
                                                    </div>
                                                    <div class="card-body">
                                                        
                                                        <div class="form-group row">
                                                            <label for="size_price<?=$size_count?>" class="col-sm-2 col-form-label col-form-label-sm">Default Price</label>
                                                            <div class="col-sm-10">
                                                                <input type="hidden" name="size_id[]" value="<?=$size->id?>">
                                                                <input type="text" class="form-control form-control-sm" id="size_price<?=$size_count?>"  name="size_price[]" value="<?=$size->price?>" placeholder="Enter Price">
                                                            </div>
                                                        </div>
                                                        <!-- <input type="hidden" name="size_id[]" value="<?=$size->id?>"> -->
                                                        <div class="form-group row">
                                                            <?php
                                                                $add_on_count = 0; 
                                                                foreach ($size->add_on_array as $add_on) { ?>
                                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                    <div class="monthly-avg">
                                                                        <h5><?=$add_on->name?></h5>
                                                                        <!-- <input type="hidden" name="add_on<?=$size_count?>[]" value="<?=$add_on->id?>"> -->
                                                                        <?php foreach($add_on->option_array as $option) { ?>
                                                                            <div class="form-group row">
                                                                                <label for="option_price<?=$size_count?>" class="col-sm-2 col-form-label col-form-label-sm"><?=$option->option_name?></label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="hidden" name="options<?=$size_count?>[]" value="<?=$option->option_id?>">
                                                                                    <input type="text" name="option_value<?=$size_count?>[]" value="<?=$option->option_price?>" class="form-control" id="option_price<?=$size_count?>" placeholder="Enter price" required>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            <?php $add_on_count += 1; } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php $size_count += 1; }  ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <?php } ?>
        <?php } else { ?>
            <input type="hidden" name="size_exists" value="<?=$details->size_exists?>">
            <?php if(count($details->price_array)>0) { ?>
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Pricing</div>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <?php
                                    $add_on_count = 0; 
                                    foreach ($details->price_array as $add_on) { 
                                        $count_array = count($details->price_array);
                                    ?>
                                    <div <?php if($count_array > 1){ ?> class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" <?php } else { ?> class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" <?php } ?>>
                                        <div class="monthly-avg">
                                            <h5><?=$add_on->name?></h5>
                                            <!-- <input type="hidden" name="add_on[]" value="<?=$add_on->id?>"> -->
                                            <?php foreach($add_on->option_array as $option) { ?>
                                                <div class="form-group row">
                                                    <label for="option_price" class="col-sm-2 col-form-label col-form-label-sm"><?=$option->option_name?></label>
                                                    <div class="col-sm-10">
                                                        <input type="hidden" name="options[]" value="<?=$option->option_id?>">
                                                        <input type="text" name="option_value[]" value="<?=$option->option_price?>" class="form-control" id="option_price" placeholder="Enter price" required>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php $add_on_count += 1; } ?>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        <?php } ?>
    </div>
  <?php } else {  ?>
    <div id="dyn_addon">
        
    </div>

  <?php } ?>  

  <div class="form-group row">
    <div class="col-sm-12 ml-auto">
      <a href="<?=base_url()?>admin/products" class="btn btn-secondary">Cancel</a>
      <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
  </div>
</form>

<script>
  var arr = <?php echo json_encode($category_size_exists_arr) ?>;
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

function customize(elem){
  var categoryId = elem.value;
  // console.log(categoryId);
  $.blockUI({
        message: '<img src="<?=base_url()?>dist/admin/img/preloading-white.gif" alt="" class="img-loader-cls"/>',
        css: {
            border: 'none',
            padding: '0px',
            backgroundColor: 'transparent',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            color: '#fff'
        }
    });

    var index = arr.findIndex(p => p.category_id == elem.value);
    var sizeFlag = arr[index].size_exists;

    if(sizeFlag === "0")
    {
        $('#base_price_div').show();
    }
    else
    {
      $('#base_price_div').hide();
    }

    $.ajax({
        type: 'POST',
        url: '<?= base_url()?>admin/products/get_addons',
        data: {'category_id':categoryId},
        dataType: "html",
        success: function(data) {
            $("#dyn_addon").html(data);
            // console.log(data);
            $.unblockUI();
            return false;
        },
        error: function(data) {
            console.log("error");
            console.log(data);
        }
    });
    return false;
}
var redirectUrl = "<?php echo base_url(); ?>admin/products"; 

function readURL1() 
{
 var total_file = document.getElementById("other_images").files.length;

 var count = parseInt(document.getElementById('countImg').value);
 
 var currentCount = 0;
  if(count === 0)
  {
    $('.preview_img1').show();
  }
 currentCount = currentCount + total_file;
 
 $('#currentImgCount').val(currentCount);
 $('#image_div').html("");
 for(var i=0;i<total_file;i++)
 {
    count = count + (i + 1);  
    $('#image_div').append("<div class='col-md-3 image-area' id='product_img"+count+"'> <img src='" + URL.createObjectURL(event.target.files[i]) + "' style='width:200px ; height: 200px;'/></div>");
 }
}

function deleteFile(id)
{
  swal({
    title: "Are you sure?",
    text: "You want to delete this image!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url()?>admin/products/remove_image',
            data: {'id':id},
            dataType: "html",
            
            success: function(data)
            {
              //console.log(data);
              if(data == 1)
              {
                var product_id = $('#product_id').val();
                window.location = redirectUrl +'/addedit/'+ product_id;     
              }
              else{
                swal(
                      'Alert!',
                      "Something went wrong",
                      'error'
                  );
                return false;  
              }
            }
      });
    }
  });
} 
</script>