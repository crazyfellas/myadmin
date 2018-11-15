<?php track_page(basename(__FILE__)) ?>
<?php

$user_code = udecode($_GET['code']);
$farm_id = udecode($_GET['farm_id']);

$cc_id = udecode($_GET['cc_id']);

$_SESSION['code'] = $_GET['code'];
$_SESSION['farm_id'] = $_GET['farm_id'];
$_SESSION['cc_id'] = $_GET['cc_id'];

$q_update_cc =  $this->db->query("select * from cultivated_crops where cc_id=" . $cc_id . " LIMIT 1" );

?>

<?php
	foreach ($q_update_cc->result() as $updateCC) {
?>
<br>

<div class="row">
<h4>CROP Scheduling</h4>
<a href="<?php echo base_url() ?>mem_profile?code=<?php echo $_GET['code'] ?>&farm_id=<?php echo $_GET['farm_id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-arrow-circle-left"></i> Back</a>
<hr/>
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

	<div class="col-lg-12">
		<div class="row">
			<button type="button" data-toggle="modal" data-target="#CropSchedModal" class="btn btn-success btn-sm">+ Add Schedule</button>
			<br><br>
			<table id="CropSchedTable" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Start of Harvest</th>
						<th>End of Harvest</th>
						<th>Estimate Yield (kgs)</th>
						<th>Actual Yield (kgs)</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$ctr = 1;
						$q_crop_sched = $this->db->query("select * from cultivated_crop_details where cc_id = " .  $cc_id);
						foreach ($q_crop_sched->result() as $c_sched) {
					?>
					<tr>

						<td>&nbsp;</td>
						<td><?php echo $c_sched->harvest_sched_start ?></td>
						<td><?php echo $c_sched->harvest_sched_end ?></td>
						<td><?php echo $c_sched->yield_estimate ?></td>
						<td><?php echo $c_sched->yield_actual ?></td>
						<td><?php echo $c_sched->crop_remarks ?></td>
					</tr>
					<?php
					$ctr++;
						} //end foreach

					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php } //close foreach ?>


<div id="CropSchedModal" class="modal fade">
	<div class="modal-dialog">
		<form method = "POST" id="crop_sched_form" name="crop_sched_form">
			<div class="modal-content">
				<div class="modal-header">
					<?php
					$_SESSION['farm_name']   = (string)$my_farm->farm_name;
	    			echo "<a href = \"".base_url()."mem_profile?code=".uencode($_SESSION['user_code'])."&farm_id=".uencode($my_farm->farm_id)."\"  class=\"list-group-item\">" . decr($my_farm->farm_name) . "</a>";
	    		?>

					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Crop Schedule</h4>
					<div class="class-body">
						<?php
							echo "<input type=\"hidden\" name=\"cc_id\" value=\"".$cc_id."\" />";
							update_date_form("Start of Harvest", "harvest_sched_start", "harvest_sched_start", $updateCC->date_planted_end, "");
							update_date_form("End of Harvest", "harvest_sched_end", "harvest_sched_end", $updateCC->date_planted_end, "");
							update_text_form("Estimated Yield in Kgs", "", "yield_estimate", "yield_estimate", "","");
							update_text_form("Actual Yield in Kgs", "", "yield_actual", "yield_actual", "","");
							update_text_form("Remarks", "remarks", "remarks", "", "","");
						?>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="action" class="btn btn-success" value="Add" />
						<input type="submit" name="action" class="btn btn-success" value="Add" />
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

	      var dataTable = $('#CropSchedTable').DataTable({
	           "processing":true,
	           "serverSide":true,
	           "order":[],
	           "ajax":{
	                url:"<?php echo base_url() . 'crops/show_crop_sched?cc_id='. $cc_id; ?>",
	                type:"POST"
	           },

	      });

		$(document).on('submit', '#crop_sched_form', function(event){
			event.preventDefault();
			//declare variables
			var harvest_sched_start = $('#harvest_sched_start').val();
			var harvest_sched_end = $('#harvest_sched_end').val();
			var yield_actual= $('#yield_actual').val();
			var remarks= $('#remarks').val();

			//check if textboxes are filled

			if(harvest_sched_start != '' && harvest_sched_end != '' && yield_actual != ''){
				$.ajax({
					url:"<?php echo base_url(). 'crops/create_crop_sched' ?>",
					method:'POST',
					data:new FormData(this),
					contentType:false,
					processData:false,
					success:function(data){
						alert(data);
						$("#crop_sched_form")[0].reset();
						$('#CropSchedModal').modal('hide');
						dataTable.ajax.reload();
					}
				});

			}else{
				alert('All fields are required!');
			}

		});
	});
</script>
