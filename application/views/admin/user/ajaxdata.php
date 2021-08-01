<table id="basicExample" class="table custom-table">
  <thead>
    <tr>
      <th>Sl No.</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
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
      $editurl=$this->config->item('base_url').'admin/users/addedit/'.$detail->id;
      ?>

    <tr>
      <td><?=$sl?></td>
      <td><?=$detail->fname." ".$detail->lname?></td>
      <td><?=$detail->email?></td>
      <td><?=$detail->phone?></td>
      <td><?php 
        if($detail->image=='no_image.png' || $detail->image== '')
          {?>
            <img src="<?=$this->config->item('base_url')?>upload/user/thumb/no_image.png" style="height: 80px; width: 80px">
        <?php } else 
        { ?><img src="<?=$this->config->item('base_url').'upload/user/thumb/'.$detail->image?>" style="height: 80px; width: 80px">
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
    
      <tr class="warning"><td colspan="7"><center>No details found</center></td></tr>
    <?php } ?>
  </tbody>
</table>