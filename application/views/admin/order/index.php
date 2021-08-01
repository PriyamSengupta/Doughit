<?php

  $get_order_status = get_order_status();
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
          <!-- <a class="btn btn-secondary" href='<?=$this->config->item("base_url")."admin/chef/addedit"?>' style="float:right"  role="button">Add New</a> -->
      </div>
      
      <div class="table-responsive">
        <table id="basicExample" class="table custom-table">
          <thead>
            <tr>
              <th>Sl No.</th>
              <th>Order No</th>
              <th>Order By</th>
              <th>Date</th>
              <th>Invoice</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if($details!='') { 
            $sl=1;

            foreach($details as $detail)
            { 
              $editurl=$this->config->item('base_url').'admin/orders/download_invoice/'.$detail->id;
              ?>

            <tr>
              <td><?=$sl?></td>
              <td><?=$detail->order_number?></td>
              <td><?=get_username($detail->user_id)?></td>
              <td><?=date("F j, Y", strtotime($detail->order_date))?></td>
              <td><a href="<?=$editurl?>"><div class="icons"><span class="icon-download"></span></div></a></td>
              <td>
                  <div class="btn-group">
										<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <?php foreach ($get_order_status as $status) { 
                        if($status->id == $detail->status_id) { ?>
                            <?=$status->name?>
                      <?php } } ?>
										</button>

										<div class="dropdown-menu">
                      <?php foreach ($get_order_status as $status) { ?>
                        <a class="dropdown-item" href="javascript:void(0)" onclick="change_order_status(<?=$detail->id?>,<?=$status->id?>)"> <?=$status->name?></a>
                      <?php } ?>
										</div>
									</div>  
              </td>

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
    function change_order_status(order_id,status_id)
    {
        $.ajax({
              type: 'POST',
              url: '<?= base_url()?>admin/orders/change_order_status',
              data: {'order_id':order_id,'status_id':status_id},
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