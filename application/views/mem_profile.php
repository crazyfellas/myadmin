<?php track_page(basename(__FILE__)) ?>
<?php
	$user_code = udecode($_GET['code']);

 ?>
 <?php $q_member = $this->db->query("select * from members where user_code ='$user_code' limit 1") ?>

<?php
	foreach ($q_member->result() as $member) {
		$_SESSION['member_id'] = $member->member_id;
		$_SESSION['user_code'] = $member->user_code;

?>
<div class="row">
	<br/>
	<h4>Farmer's Basic Information</h4>
	<hr/>
	<table class="" border="0">
		<tr>
			<th>Full Name: </th>
			<td>
				<?php echo strtoupper(decr($member->first_name) . " " . decr($member->middle_name) . " " . decr($member->last_name)) ?>
			</td>
			<th>Sex: </th>
			<td><?php echo decr($member->sex); ?></td>
		</tr>
		<tr>
			<th>User Code: </th>
			<td><?php echo $member->user_code; ?></td>
			<th>Subscription: </th>
			<td><?php echo $this->mod_registrations->get_ownership_name(decr($member->subscription_type)) ?></td>
		</tr>
		<tr>
			<th>Birth Date: </th>
			<td><?php echo $member->birthdate; ?></td>
			<th>Ownership: </th>
			<td><?php echo $this->mod_registrations->get_ownership_name(decr($member->ownership_type)) ?></td>
		</tr>
	</table>
	<hr/>
</div>
<?php }//close foreach ?>
<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
  	<li role="presentation" class="active"><a href="#farm" aria-controls="farm" role="tab" data-toggle="tab">Farms</a></li>
    <li role="presentation"><a href="#summary" aria-controls="summary" role="tab" data-toggle="tab">Farm Summary</a></li>
    <li role="presentation"><a href="#Organization" aria-controls="Organization" role="tab" data-toggle="tab">Organization</a></li>
  </ul>



  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane fade" id="Organization">Organization details</div>
    <div role="tabpanel" class="tab-pane fade" id="summary">

    <?php $q_get_all_crops = $this->db->query("select * from cultivated_crops where user_code='".$user_code."'") ?>

    <?php
    	foreach ($q_get_all_crops->result() as $all_crop) {
    		echo decr($all_crop->main_crop) . "<br/>";
    	}
    ?>

    </div>
    <div role="tabpanel" class="tab-pane fade in active" id="farm">
    <div class="row">
    	<div class="col-md-3">
    		<br/>
    		<?php $q_my_farm = $this->db->query("select * from farms where member_id =". $_SESSION['member_id'] ." " ) ?>
    		<div class="list-group">
    			<!-- CreateNewFarm modal -->
    			<a href="#" class="list-group-item active"  data-toggle="modal" data-target="#CreateNewFarm">Create New Farm</a>

	    		<?php foreach ($q_my_farm->result() as $my_farm) {
					$_SESSION['farm_name']   = (string)$my_farm->farm_name;
	    			echo "<a href = \"".base_url()."mem_profile?code=".uencode($_SESSION['user_code'])."&farm_id=".uencode($my_farm->farm_id)."\"  class=\"list-group-item\">" . decr($my_farm->farm_name) . "</a>";
	    		} ?>
    		</div>
    	</div>
    	<div class="col-md-9">
         <!--BLOCK SECTION -->
         <div class="row">
            <div class="col-lg-12">
            <?php
            if(!isset($_GET['farm_id'])){
            	$f_id = 0;
            }else{
            	$f_id = udecode($_GET['farm_id']);
            }
            if(isset($f_id)){ ?>
            	<?php
            		$q_get_farm_details = $this->db->query("select * from farms where farm_id=".$f_id);
            		foreach ($q_get_farm_details->result() as $farm_detail) {
            			echo "<h4>";
            			echo decr($farm_detail->farm_name);
            			//echo decr($farm_detail->farm_genre);
            			echo "<br/><small>";
            			echo decr($farm_detail->region) . ", ";
            			echo decr($farm_detail->province) . ", ";
            			echo decr($farm_detail->muncity) . ", ";
            			echo decr($farm_detail->brgy);
            			echo "</small>";
            			echo "</h4>";

            			$_SESSION['region'] 	= decr($farm_detail->region_code);
            			$_SESSION['province'] 	= decr($farm_detail->province_code);
            			$_SESSION['muncity'] 	= decr($farm_detail->muncity_code);
            			$_SESSION['brgy'] 		= decr($farm_detail->brgy_code);
            		}
            	?>
			    <!-- Nav tabs -->
			    <br/>
					<div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a href="#tab1default" data-toggle="tab">Crops</a></li>
                            <li><a href="#tab2default" data-toggle="tab">Activities</a></li>
                            <li><a href="#tab3default" data-toggle="tab">Expenses</a></li>
                            <li><a href="#tab4default" data-toggle="tab">Biodiversity</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1default">
													<br/>
										    	<?php
										    		if(isset($_GET['farm_id'])){

										    	?>
												<a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#AddNewCrop">+ New Crop Batch</a>
												<?php
										    		}
										    	?>
												<hr/>
										    	<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										    		<thead>
										    			<tr>
										    				<th>&nbsp;</th>
										    				<th>&nbsp;</th>
										    				<th>&nbsp;</th>
										    				<th></th>
										    				<th colspan="2">Yield (Kgs)</th>
										    				<th>&nbsp;</th>
										    				<th>&nbsp;</th>
										    			</tr>
										    			<tr>
										    				<th>Major Crop</th>
										    				<th>Variety</th>
										    				<th>Planting Dates</th>
										    				<th>Area (sqm)</th>
										    				<th>Estimate</th>
										    				<th>Actual</th>
										    				<th>Status</th>
										    				<th>Harvest Info</th>
										    			</tr>
										    		</thead>
										    		<tbody id="crop_batch">
										    		<?php
										    			$q_get_all_crops = $this->db->query("select * from cultivated_crops where user_code ='".$user_code."' and farm_id =" . $f_id)
										    		?>
										    		<?php foreach ($q_get_all_crops->result() as $my_crop) {?>
										    			<tr>
										    				<!-- <td><a class="btn btn-danger btn-xs btn-flat btn-rect" href=""><i class="fa fa-trash-o"></i></a>
										    					<a href="<?php echo base_url() ?>update_crop?code=<?php echo uencode($user_code) ?>&farm_id=<?php echo uencode($f_id) ?>&cc_id=<?php echo uencode($my_crop->cc_id); ?>" class="fetchCCropID btn btn-warning btn-xs btn-flat btn-rect"><i class="fa fa-pencil-square-o"></i> <?php echo decr($my_crop->main_crop); ?> </a>
										    				</td> -->

																<td>
																	<button class="btn btn-danger btn-xs btn-flat btn-rect DeleteMajorCrop" id='<?php echo $my_crop->cc_id ?>'><i class="fa fa-trash-o"></i></button>
																	<button class="btn btn-warning btn-xs btn-flat btn-rect EditMajorCrop" id='<?php echo $my_crop->cc_id ?>'><i class="fa fa-pencil-square-o"></i> <?php echo decr($my_crop->main_crop); ?></button>

																	<input type="hidden" id="status<?php echo $my_crop->cc_id ?>" value="<?php echo decr($my_crop->crop_status)?>"/>




																</td>
										    				<td><?php echo decr($my_crop->crop_variety); ?></td>
										    				<td><?php echo $my_crop->date_planted; echo " - " . $my_crop->date_planted_end; ?></td>
										    				<td><?php echo $my_crop->planting_area; ?></td>
										    				<td><?php echo $my_crop->yield_estimate; ?></td>
										    				<td><?php echo $my_crop->yield_actual; ?></td>
										    				<td>
										    					<?php
										    						$crop_stat = decr($my_crop->crop_status);
										    						switch ($crop_stat) {
										    							case '1':
										    								echo '<span class="label label-warning-border">On-going</span>';
										    								break;
										    							case '2':
										    								echo '<span class="label label-success-border">Completed</span>';
										    								break;
										    							case '3':
										    								echo '<span class="label label-danger-border">State of Calamity</span>';
										    								break;
										    							case '4':
										    								echo '<span class="label label-danger-border">Cancelled</span>';
										    								break;
										    							default:
										    								echo "#error";
										    								break;
										    						}
										    					?>
										    				</td>
										    				<td>
										    					<?php
										    						if(decr($my_crop->crop_status) == 2 || decr($my_crop->crop_status) == 4){
										    							echo "-";
										    						}else{
										    					?>
										    					 <a href="<?php echo base_url() ?>crop_sched?code=<?php echo uencode($user_code) ?>&farm_id=<?php echo uencode($f_id) ?>&cc_id=<?php echo uencode($my_crop->cc_id); ?>" class="fetchCCropID btn btn-info btn-xs btn-flat btn-rect"><i class="fa fa-calendar"></i> Schedules
										    					 	<?php $count_sched= $this->db->query("select * from cultivated_crop_details where cc_id=". $my_crop->cc_id);
										    					 	echo "[". $count_sched->num_rows() ."]" ?>
										    					 </a>
										    					 <?php } ?>
										    				</td>

										    			</tr>
										    		<?php } //close foreach ?>
										    		</tbody>
										    	</table>
                        </div>
                        <div class="tab-pane fade" id="tab2default"><?php $this->load->view('mem_profile_act');?></div>
                        <div class="tab-pane fade" id="tab3default"><?php $this->load->view('mem_profile_exp');?></div>
                        <div class="tab-pane fade" id="tab4default"><?php $this->load->view('mem_profile_bio');?></div>

                    </div>
                </div>
            </div>


			<?php } //close if
				else{
					echo "<h4>Please select a farm to update existing records.</h4>";
				}
			?>
            </div>
        </div>
          <!--END BLOCK SECTION -->
    	</div>
    </div>
    </div>
  </div>

</div>



<!-- CreateNewFarm Modal -->
<div class="modal fade" id="CreateNewFarm" tabindex="-1" role="dialog" aria-labelledby="CreateNewFarmLabel">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="CreateNewFarmLabel">Create a New Farm</h4>
        </div>
        <div class="modal-body" style="padding:30px">
      		<div class="row">
				<?php echo validation_errors(); ?>
				<?php echo form_open('crops/create_farm'); ?>

				<?php input_text_form("Name of the New Farm", "farm_name", "farm_name", "What is the name of the new farm?"); ?>
				<?php input_date_form("Date of Purchase", "date_purchased", "date_purchased", ""); ?>
				<div class="row">
					<div class="col-sm-6">
						<h4>Farm Address</h4>
					    <div class="form-group">
					    		<label>Region</label>

					        <select class="form-control select" id="region-select" name="region" href="<?=base_url('location/region')?>">
					            <option value = "" selected="selected">- Select Region -</option>
					            <?php
					                $query = $this->db->query("select * from lib_loc_regions order by psgc_rcode asc");

					                foreach ($query->result() as $row){
					                echo "<option value = \"{$row->psgc_rcode}\">{$row->region}</option>";
					                }
					            ?>
					        </select>

					    </div>
					    <div class="form-group">
					    	<label>Province</label>
					        <select class="form-control select" id="province-select" name = "province" href = "<?=base_url('location/province')?>">
					            <option value = "" selected="selected" >- Select Province -</option>
					        </select>
					    </div>
				        <div class="form-group">
				        	<label>Municipality/City</label>
				            <select class="form-control" id="muncity-select" name = "muncity" href = "<?=base_url('location/get_muncity')?>">
				                <option value = "" selected="selected">- Select Municipality/City -</option>
				            </select>
				        </div>
				        <div class="form-group">
				        	<label>Barangay</label>
				            <select class="form-control" id="brgy-select" name = "brgy" href = "<?=base_url('location/get_brgy')?>">
				                <option value = "" selected="selected">- Select Barangay -</option>
				            </select>
				        </div>
				        <?php input_text_form("Sitio/Purok/Block", "address", "address", ""); ?>
					</div>
					<div class="col-sm-6">
						<h4>Farm Details</h4>
				        <?php input_text_form("Road Distance", "road_distance", "road_distance", "Road distance from a national road. (meters)"); ?>

				        <div class="form-group">
				        	<label>Farm Practice</label>
				        	<select class="form-control" name="farm_practice" id="farm_practice">
				        		<option value=""> - Select Farm Type - </option>
				        		<?php
				        			$q_farm_types = $this->db->query("select * from lib_farm_types");
				        			foreach ($q_farm_types->result() as $farmtype) {
				        				echo "<option value=\"".$farmtype->farm_type_id."\">".$farmtype->farm_type."</option>";
				        			}
				        		?>
				        	</select>
				        </div>

				        <div class="form-group">
				        	<label>Farm Genre</label>
				        	<select class="form-control" name="farm_genre" id="farm_genre">
				        		<option value=""> - Select Farm Genre - </option>
				        		<?php
				        			$q_farm_types = $this->db->query("select * from lib_farm_genres");
				        			foreach ($q_farm_types->result() as $farmgenre) {
				        				echo "<option value=\"".$farmgenre->farm_genre_id."\">".$farmgenre->farm_genre_name."</option>";
				        			}
				        		?>
				        	</select>
				        </div>
				        <div class="form-group">
				        	<label>Farm Class</label>
				        	<select class="form-control" name="farm_class" id="farm_class">
				        		<option value=""> - Select Farm Genre - </option>
				        		<?php
				        			$q_farm_class = $this->db->query("select * from lib_farm_classes");
				        			foreach ($q_farm_class->result() as $farm_class) {
				        				echo "<option value=\"".$farm_class->farm_class_id."\">".$farm_class->class_name."</option>";
				        			}
				        		?>
				        	</select>
				        </div>
					</div>
					</div>
      		</div>
        </div>
		<div class="modal-footer">
			<input type="submit" class="btn btn-success" value="Create New Farm">
			</form>
		</div>
    </div>
</div>
</div>


<!-- CROPS -->
<!-- Modal -->
<div class="modal fade" id="AddNewCrop" tabindex="-1" role="dialog" aria-labelledby="AddNewCrop">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="AddNewCrop">New Crop to be Planted</h4>
      </div>
      <div class="modal-body" style="padding:40px;">
      	<?php $farm_id = udecode($_GET['farm_id']); ?>
		<?php echo validation_errors(); ?>

		<?php// echo form_open('crops/create_batch_crop?farm_id='.$farm_id); ?>
		<form id="new_crop_form" action="" method="post" class="form-horizontal">
			<input type="hidden" value="<?php echo $farm_id?>" id="farm_id"/>
			<div class="alert alert-success"></div>
		<?php if (isset($message)) { ?>
			<CENTER><h3 style="color:green;"><?php echo $message;?></h3></CENTER><br>
		<?php } ?>
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>Crop Category</label>
			<select class="form-control croptype-select" name="crop_cycle_cat" href = "<?=base_url('location/get_main_crop')?>">
				<option> - Please Select - </option>
            	<option value="Fruits">Fruits</option>
            	<option value="Leafy">Leafy</option>
            	<option value="Legumes">Legumes</option>
            	<option value="Roots">Roots</option>
            	<option value="Unidentified">Unidentified</option>
			</select>
					<p class="help-block">Please indicate the category of this crop</p>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label>Crop</label>
			        <div class="form-group">
			            <select class="form-control" id="maincrop-select" name = "maincrop" >href = "<?=base_url('location/get_main_crop')?>"
			                <option value = "" selected="selected">- Select Main Crops -</option>
			            </select>
			        </div>
				</div>
			</div>
			<div class="col-lg-12">
				<?php input_text_form("Crop Variety", "crop_sub", "crop_sub", "What is the variety of the crop that you are planting?","",""); ?>
			</div>
				<hr/>
				<div class="row">
					<div class="col-lg-6">
						<div class="col-md-12"><h4 align="center">Projected Harvest Dates</h4></div>
						<div class="col-xs-6">
							<?php input_date_form("Date of Planting ", "date_planted", "date_planted", "") ?>
						</div>
						<div class="col-xs-6">
							<?php input_date_form("Last Day of Harvest", "date_planted_end", "date_planted_end", "") ?>
						</div>
					</div>

					<div class="col-lg-6">
					<div class="col-md-12"><h4 align="center">Pre-Harvest Details</h4></div>
					<div class="col-xs-12">
						<?php input_text_form("Plant Area", "planting_area", "planting_area", "Area of Plantation (in sqm)","Ex: 1800", "(sqm)"); ?>
					</div>
					<div class="col-xs-6">
						<?php //input_text_form("Yield Estimate", "yield_estimate", "yield_estimate", "Estimated Yield of the farm (in kgs)","Ex: 1800", "(kgs)"); ?>
					</div>
					</div>
				</div>

				<!-- <?php// echo form_submit(array('id' => 'submit', 'value' => 'Add Crop Batch')); ?> -->

			</div>
		</div>
		<div class="modal-footer">
				<!-- <button type="submit" class="btn btn-info pull-right">Add Crop Batch</button> -->
				<button type="button" id="create" class="btn btn-primary pull-righ">Add Crop Batch</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
		<?php echo form_close(); ?><br/>

      </div>
    </div>
  </div>
</div>
<!-- CROPS end -->



<!-- EDIT MAJOR CROP -->

<!-- Modal -->
<form id="edit_crop_batch">
<div class="modal fade" id="EditMajorCrop" tabindex="-1" role="dialog" aria-labelledby="AddNewCrop"data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edit Crop to be Planted</h4>

      </div>
      <div class="modal-body" style="padding:20px;">
				<input type="text" id="cid" name="cid"/>
				<div class="alert alert-success"></div>
				<div class="row">
					<div class="form-group">
						<br>
						<label class="col-md-2">Crop Status</label>
						<div class="col-md-4">
							<select class="form-control" id="cropStatusList" name="crop_status">
							</select>
							<br>
						</div>
					</div>
					<hr2>

					<div class="form-group">
						<br>
						<h4 class="col-md-12">Crop Planting to Harvesting Duration</h4>
						<label class="col-md-2">Start of Planting</label>
						<div class="col-md-4">
							<input type="text" class="form-control datepicker" name="planted_start" required=""/>
						</div>

						<label class="col-md-2">Last Day of Harvest</label>
						<div class="col-md-4">
							<input type="text" class="form-control datepicker" name="planted_end" required=""/>
							<br>
						</div>
					</div>
					<hr2>

					<div class="form-group">
						<br>
						<h4 class="col-md-12">For State of Calamity</h4>
						<label class="col-md-4">Condition</label>
						<label class="col-md-4">Damages based on kilograms</label>
						<label class="col-md-4">Damages based on pesos</label>

						<div class="col-md-4">

							<select class="form-control" id="calamityList" name="state_of_calamity">
							</select>

						</div>
						<div class="col-md-4">
							<input type="text" class="form-control" name="damage_kg"/>
						</div>
						<div class="col-md-4">
							<input type="text" class="form-control" name="damage_cash"/>
						</div>
					</div>

				</div>

			</div>
			<div class="modal-footer">
					<!-- <button type="submit" class="btn btn-info pull-right">Add Crop Batch</button> -->
					<button type="button" id="btn_edit_crop" class="btn btn-primary pull-righ">Update Crop Batch</button>
	        <button type="button" class="btn btn-default" onclick="cancel()">Close</button>
	      </div>

      </div>
    </div>
  </div>
</div>
</form>
<!-- END EDIT MAJOR CROP -->

<script src="<?php echo base_url() ?>assets/js/mem_profile.js"></script>
