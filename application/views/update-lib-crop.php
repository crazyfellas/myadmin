<?php track_page(basename(__FILE__)) ?>
<?php 
    
    $crop_id = $_GET['crop_id'];
    $q_crop_lib = $this->db->query("select * from lib_crops where crop_id = ".$crop_id." ");

    foreach ($q_crop_lib->result() as $crop) {
 ?>

<?php echo validation_errors(); ?>
<?php echo form_open('crops/update_main_crop'); ?>
<?php if (isset($message)) { ?>
	<CENTER><h3 style="color:green;"><?php echo $message;?></h3></CENTER><br>
<?php } ?>
<div class="row">
	<div class="col-lg-3">
	</div>
	<div class="col-lg-6">
		<h3 class="alert alert-info">Update Crop</h3>
            <input type="hidden" name="crop_id" id="crop_id" value="<?php echo $crop->crop_id ?>" />
			<?php update_text_form("Crop Name", "crop_name", "crop_name", "",$crop->name,""); ?>
            <div class="form-group">
                <label class="control-label">Crop Type</label>
                    <select class="form-control" name="crop_type">
                        <option selected="selected" value="<?php echo $crop->type ?>"><?php echo $crop->type ?></option>
                        <option>________</option>
                    	<option value="Fruits">Fruits</option>
                    	<option value="Leafy">Leafy</option>
                    	<option value="Legumes">Legumes</option>
                    	<option value="Roots">Roots</option>
                        <option value="Unidentified">Unidentified</option>
                    </select>
            </div>

		<hr/>
            <label class="control-label">Crop Description</label>
			<textarea class="form-control" name="desc"><?php echo $crop->desc ?></textarea>
            <div class="form-group">
                <label class="control-label">Is Active</label>
                    <select class="form-control" name="is_active">
                    	<option value="TRUE">Yes</option>
                    	<option value="FALSE">No</option>
                    </select>
            </div>
    <?php echo form_submit(array('id' => 'submit', 'value' => 'Update Crop')); ?>
    <?php echo form_close(); ?><br/>
	</div>
	<div class="col-lg-3">
	</div>
</div>
<?php }//closeforeach ?>

