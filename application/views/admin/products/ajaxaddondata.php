<?php if($details['size_exists'] == 1) { ?>
    <input type="hidden" name="size_exists" value="<?=$details['size_exists']?>">
    <?php if(count($details['array'])>0) {?>
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
                                    foreach ($details['array'] as $size) { ?>
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
                                                            <input type="text" class="form-control form-control-sm" id="size_price<?=$size_count?>"  name="size_price[]" value="" placeholder="Enter Price">
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
                            <?php $size_count += 1; } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>            
    </div>
    <?php } ?>
<?php } else { ?>
    <input type="hidden" name="size_exists" value="<?=$details['size_exists']?>">
    <?php if(count($details['array']->add_on_array) > 0) { ?>
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
                                foreach ($details['array']->add_on_array as $add_on) { 
                                    $count_array = count($details['array']->add_on_array);
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