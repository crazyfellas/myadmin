<?php track_page(basename(__FILE__)) ?>
<?php echo validation_errors(); ?>
<?php echo form_open('crops/create_major_crop'); ?>
<?php if (isset($message)) { ?>
	<CENTER><h3 style="color:green;"><?php echo $message;?></h3></CENTER><br>
<?php } ?>
<div class="row">

	<div class="col-lg-2 col-lg-6"> </div>
	<div class="col-lg-8 col-lg-6"> 
		<h4 class="alert alert-info">Crop Information</h4>
		<div class="form-group">
			<label>Crop Category</label>
			<select class="form-control" name="crop_cycle_cat" id="croptype-select" href = "<?=base_url('location/get_main_crop')?>">
				<option> - Please Select - </option>
            	<option value="Fruits">Fruits</option>
            	<option value="Leafy">Leafy</option>
            	<option value="Legumes">Legumes</option>
            	<option value="Roots">Roots</option>
            	<option value="Unidentified">Unidentified</option>
			</select>
			<p class="help-block">Please indicate the category of this crop</p>
		</div>
		<div class="form-group">
			<label>Crop</label>
	        <div class="form-group">
	            <select class="form-control" id="maincrop-select" name = "maincrop" >
	                <option value = "" selected="selected">- Select Main Crops -</option>
	            </select>
	        </div>
		</div>
		<?php input_text_form("Crop Variety", "crop_sub", "crop_sub", "What is the variety of the crop that you are planting?","",""); ?>
		<?php input_text_form("Agerage Maturity Index", "maturity_index", "maturity_index", "How many days to mature for harvest. (in Days)","Ex: 90","Days"); ?>
	<?php echo form_submit(array('id' => 'submit', 'value' => 'Add Major Crop')); ?>
	</div>
	<div class="col-lg-2 col-lg-6">	</div>
		
</div>

<?php echo form_close(); ?><br/>
