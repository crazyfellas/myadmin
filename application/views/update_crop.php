<?php track_page(basename(__FILE__)) ?>
<?php 

$user_code = udecode($_GET['code']);
$farm_id = udecode($_GET['farm_id']);
$cc_id = udecode($_GET['cc_id']);

$_SESSION['code'] = $_GET['code'];
$_SESSION['farm_id'] = $_GET['farm_id'];

$q_update_cc =  $this->db->query("select * from cultivated_crops where cc_id=" . $cc_id . " LIMIT 1" );

?>

<?php 
	foreach ($q_update_cc->result() as $updateCC) {
?>

<?php echo validation_errors(); ?>
<?php echo form_open('crops/update_batch_crop?cc_id='.$cc_id); ?>
<?php if (isset($message)) { ?>
	<CENTER><h3 style="color:green;"><?php echo $message;?></h3></CENTER><br>
<?php } ?>
<div class="row">
<h4>UPDATE CROP</h4>
<hr/>
	<div class="col-lg-12">

		<div class="row">
			<div class="col-md-6">
				Crop Category: <?php echo decr($updateCC->crop_cycle_category) ?><br/>
				Crop: <?php echo decr($updateCC->main_crop) ?><br/>
				Crop Variety: <?php echo decr($updateCC->crop_variety) ?><br/>	
				Maturity Index: <?php echo $updateCC->maturity_index ?><br/>			
			</div>
			<div class="col-md-6">
				Date Planted: <?php echo $updateCC->date_planted ?><br/>
				Yield Estimate: <?php echo $updateCC->yield_estimate ?><br/>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Crop Status</label>
			        <div class="form-group">
						<select name="sel_crop_status" class="form-control">
							<option value="<?php echo decr($updateCC->crop_status) ?>" selected="selected">
								<?php 

								;
								$q_cs=$this->db->query("select * from lib_crop_status where cs_id=".decr($updateCC->crop_status) . " Limit 1");

								foreach ($q_cs->result() as $cs) {
									echo $cs->cs_name;
								}
								?>
								
							</option>
							<option>______________</option>
								<?php 
								$q_cs=$this->db->query("select * from lib_crop_status ");

								foreach ($q_cs->result() as $cs) {
									echo "<option value=\"$cs->cs_id\"> ". $cs->cs_name . "</option>";
								}
								?>
						</select>
			        </div>
				</div>
			</div>
			<div class="col-md-4"></div>
		</div>
		<div class="row">
			<div class="col-md-12"><h4 align="center">Crop Planting to Harvesting Duration</h4></div>
			<div class="col-xs-6">
				<?php update_date_form("Start of Planting ", "date_planted", "date_planted", $updateCC->date_planted, "") ?>
			</div>
			<div class="col-xs-6">
				<?php update_date_form("Last Day of Harvest ", "date_planted_end", "date_planted_end", $updateCC->date_planted_end, "") ?>
			</div>
		</div>
		<hr/>
		<h4>For State of Calamity</h4>
		<div class="row">
			<div class="col-md-4">
				<label>Condition</label>
				<select class="form-control" name="state_of_calamity">
					<option value="<?php echo decr($updateCC->soc_desc) ?>" selected="selected">
						<?php 

						;
						$q_cs=$this->db->query("select * from lib_state_of_calamity where soc_id = " .decr($updateCC->soc_desc). " Limit 1");

						foreach ($q_cs->result() as $cs) {
							echo $cs->soc_name;
						}
						?>
						
					</option>
					<option>______________</option>
					<?php 
					$q_cs=$this->db->query("select * from lib_state_of_calamity ");

					foreach ($q_cs->result() as $cs) {
						echo "<option value=\"$cs->soc_id\"> ". $cs->soc_name . "</option>";
					}
					?>
				</select>
			</div>
			<div class="col-md-4">
				<?php update_text_form("Damages based on kilograms", "soc_damages_in_kg", "soc_damages_in_kg", "How many kilograms were destroyed?",$updateCC->soc_damages_in_kg,""); ?>
			</div>
			<div class="col-md-4">
				<?php update_text_form("Damages based on pesos", "soc_damages_in_cash", "soc_damages_in_cash", "How many pesos were destroyed?",$updateCC->soc_damages_in_cash,""); ?>
			</div>
		</div>



			
		<?php echo form_submit(array('id' => 'submit', 'value' => 'Update')); ?>
	</div>	
</div>
<?php echo form_close(); ?><br/>
<?php } //close foreach ?>

