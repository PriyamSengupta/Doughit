<select id="province" name="province" required="">
    <?php if(count($states)>0){
        foreach ($states as $state) { ?>
            <option value="<?=$state->id?>"><?=$state->province_name?></option>
    <?php } } else { ?>
        <option value="">Select</option>
    <?php } ?>    
</select>