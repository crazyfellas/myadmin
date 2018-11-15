<?php 

	$ccd_id = udecode($_GET["id"]);

	$query = $this->db->query("select * from cultivated_crop_details where ccd_id = " . $ccd_id);

	foreach($query->result() as $q){
?>
	<?php echo form_open('crops/edit_crop_sched?ccd_id='.$ccd_id); ?>
		<h4>Update Crop Schedule and Content</h4>
			<?php 
				update_date_form("Start of Harvest", "harvest_sched_start", "harvest_sched_start", $q->harvest_sched_start, "");
				update_date_form("End of Harvest", "harvest_sched_end", "harvest_sched_end", $q->harvest_sched_end, "");
				update_text_form("Estimated Yield in Kgs", "", "yield_estimate", "yield_estimate", $q->yield_estimate,"");
				update_text_form("Actual Yield in Kgs", "", "yield_actual", "yield_actual", $q->yield_actual,"");
				update_text_form("Remarks", "remarks", "remarks", "",$q->crop_remarks ,"");
			?>
		</div>
		<div class="modal-footer">
			<input type="submit" name="action" class="btn btn-success" value="Edit" /> 
		</div>
	<?php echo form_close();?>

<?php } ?>