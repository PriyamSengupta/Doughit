<!-- Page header start -->
<div class="page-header">
  
  <!-- Breadcrumb start -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><?=$mainheader?></li>
  </ol>
  <!-- Breadcrumb end -->

</div>
<!-- Page header end -->   

<!-- Row start -->
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
    <div class="table-container">
      <div class="t-header">
          <?=$mainheader?>
          <a class="btn btn-secondary" href='<?=$this->config->item("base_url")."admin/chef/addedit"?>' style="float:right"  role="button">Add New</a>
      </div>
      
      <div class="table-responsive">
        <table id="basicExample" class="table custom-table">
          <thead>
            <tr>
              <th>Sl No.</th>
              <th>Name</th>
              <th>Expertise</th>
              <th>Image</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if($details!='') { 
            $sl=1;

            foreach($details as $detail)
            { 
              $editurl=$this->config->item('base_url').'admin/chef/addedit/'.$detail->id;
              ?>

            <tr>
              <td><?=$sl?></td>
              <td><?=$detail->fname." ".$detail->lname?></td>
              <td><?=$detail->expertise?></td>
              <td><?php 
                if($detail->image=='no_image.png' || $detail->image== '')
                  {?>
                    <img src="<?=$this->config->item('base_url')?>upload/chef/thumb/no_image.png" style="height: 80px; width: 80px">
                <?php } else 
                { ?><img src="<?=$this->config->item('base_url').'upload/chef/thumb/'.$detail->image?>" style="height: 80px; width: 80px">
                <?php } ?>
              </td>
              <td>
                  <div class="custom-control custom-switch">
										<input type="checkbox" class="custom-control-input" id="customSwitch<?=$sl?>" <?php if($detail->is_active == 1) { ?> checked <?php } ?>  onchange="change_status(<?=$detail->id?>)">
										<label class="custom-control-label" for="customSwitch<?=$sl?>"></label>
									</div>
              </td>
              <td><a href="<?=$editurl?>" class="btn btn-secondary btn-rounded"><i class="icon-edit1"></i></a></td>
            </tr>
            
            <?php
              $sl++;
              }
            }
            else
            { ?>
            
              <tr class="warning"><td colspan="6"><center>No details found</center></td></tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Row end -->
<script>
  $(document).ready(function() {
    $("#get_error_msg_main_id1").hide();
      $("#get_error_msg_main_id1").fadeTo(2000, 500).slideUp(500, function() {
          $("#get_error_msg_main_id1").slideUp(500);
        });
  });
  </script>
  <script>
    function change_status(id)
    {
        $.ajax({
              type: 'POST',
              url: '<?= base_url()?>admin/chef/change_status',
              data: {'chef_id':id},
              dataType: "html",
              
              
              success: function(data)
              {
                if(data)
                {
                  // console.log(data);
                    $("#basicExample").html(data);
                    //$('#example2').DataTable();
                    
                }
              }
        });
    }
</script>