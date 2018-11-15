
<?php echo validation_errors(); ?>
<?php echo form_open('crops/create_main_crop'); ?>
<?php if (isset($message)) { ?>
	<CENTER><h3 style="color:green;"><?php echo $message;?></h3></CENTER><br>
<?php } ?>
<div class="row">
	<div class="col-lg-3">
	</div>
	<div class="col-lg-6">
		<h3 class="alert alert-info">Add a Main Crop</h3>
			<?php input_text_form("Crop Name", "crop_name", "crop_name", "","" ,""); ?>
            <div class="form-group">
                <label class="control-label">Crop Type</label>
                    <select class="form-control" name="crop_type">
                    <option>- Select Type - </option>
                    	<option value="Fruits">Fruits</option>
                    	<option value="Leafy">Leafy</option>
                    	<option value="Legumes">Legumes</option>
                        <option value="Roots">Roots</option>
                        <option value="Herbs">Herbs</option>
                    	<option value="Crucifer">Crucifer</option>
                    </select>
            </div>

		<hr/>
            <label class="control-label">Crop Description</label>
			<textarea class="form-control" name="desc"></textarea>
            <div class="form-group">
                <label class="control-label">Is Active</label>
                    <select class="form-control" name="is_active">
                    	<option value="TRUE">Yes</option>
                    	<option value="FALSE">No</option>
                    </select>
            </div>
    <?php echo form_submit(array('id' => 'submit', 'value' => 'Register New Crop')); ?>
    <?php echo form_close(); ?><br/>
	</div>
	<div class="col-lg-3">
	</div>
</div>

