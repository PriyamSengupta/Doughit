<?php
  $get_order_status = get_order_status();
?>

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