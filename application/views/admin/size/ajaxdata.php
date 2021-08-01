<table id="basicExample" class="table custom-table">
  <thead>
    <tr>
      <th>Sl No.</th>
      <th>Name</th>
      <th>Category</th>
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
      $editurl=$this->config->item('base_url').'admin/size/addedit/'.$detail->id;
      ?>

    <tr>
      <td><?=$sl?></td>
      <td><?=$detail->name?></td>
      <td><?php $category = get_category_by_id($detail->category_id); echo $category->name; ?></td>
      <td><?php 
        if($detail->image=='no_image.png' || $detail->image== '')
          {?>
            <img src="<?=$this->config->item('base_url')?>upload/size/thumb/no_image.png" style="height: 80px; width: 80px">
        <?php } else 
        { ?><img src="<?=$this->config->item('base_url').'upload/size/thumb/'.$detail->image?>" style="height: 80px; width: 80px">
        <?php } ?>
      </td>
      <td>
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="customSwitch1" <?php if($detail->is_active == 1) { ?> checked <?php } ?>  onchange="change_status(<?=$detail->id?>)">
            <label class="custom-control-label" for="customSwitch1"></label>
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
    
      <tr class="warning"><td colspan="5"><center>No details found</center></td></tr>
    <?php } ?>
  </tbody>
</table>