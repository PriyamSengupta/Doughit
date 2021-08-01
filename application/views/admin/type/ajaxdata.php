  <table id="basicExample" class="table custom-table">
    <thead>
      <tr>
        <th>Sl No.</th>
        <th>Name</th>
        <th>Description</th>
        <th>Category</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if($details!='') { 
      $sl=1;

      foreach($details as $detail)
      { 
        $editurl=$this->config->item('base_url').'admin/type/addedit/'.$detail->id;
        ?>

      <tr>
        <td><?=$sl?></td>
        <td><?=$detail->name?></td>
        <td><?=$detail->description?></td>
        <td><?php $category = get_category_by_id($detail->category_id);
                  if(empty($category))
                      echo "No Categories Found";
                  else
                      echo $category->name;
            ?>
        </td>
        <td>
            <!-- <input type="checkbox" class="custom-control-input" id="customSwitch1" <?php if($detail->is_active == 1) { ?>value="1" checked <?php } else { ?> value="0" <?php } ?> onchange="change_status(<?=$detail->id?>)"><label class="custom-control-label" for="customRadio1"></label> -->

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
      
        <tr class="warning"><td colspan="6"><center>No details found</center></td></tr>
      <?php } ?>
    </tbody>
  </table>