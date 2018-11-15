<br>
<?php track_page(basename(__FILE__)) ?>
<?php if (validation_errors()) : ?>
	<div class="col-md-12">
		<div class="alert alert-danger" role="alert">
			<?= validation_errors() ?>
		</div>
	</div>
<?php endif; ?>
<?php if (isset($error)) : ?>
	<div class="col-md-12">
		<div class="alert alert-danger" role="alert">
			<?= $error ?>
		</div>
	</div>
<?php endif; ?>

<div class="panel panel-default">
    <div class="panel-heading">Independent Farmer Registration</div>
    <div class="panel-body">

			<?php echo validation_errors(); ?>

			<form method="post" action="<?php echo base_url('registrations/register')?>" onsubmit="return confirm()">
			<div class="row">
				<div class="col-sm-4">Location <br/>
				    <div class="form-group">
				        <select class="form-control select" id="region-select" name = "region" href="<?=base_url('location/region')?>">
				            <option value = "" selected="selected">- Select Region -</option>
				            <?php
				                $query = $this->db->query("select * from lib_loc_regions order by region asc");

				                foreach ($query->result() as $row){
				                 echo "<option value = \"{$row->psgc_rcode}\">{$row->region}</option>";
				                }
				            ?>
				        </select>
				    </div>
				    <div class="form-group">
				        <select class="form-control select" id="province-select" name = "province" href = "<?=base_url('location/province')?>">
				            <option value = "" selected="selected" >- Select Province -</option>
				        </select>
				    </div>
			        <div class="form-group">
			            <select class="form-control select" id="muncity-select" name = "muncity" href = "<?=base_url('location/get_muncity')?>">
			                <option value = "" selected="selected">- Select Municipality/City -</option>
			            </select>
			        </div>
			        <div class="form-group">
			            <select class="form-control select" id="brgy-select" name = "brgy" href = "<?=base_url('location/get_brgy')?>">
			                <option value = "" selected="selected">- Select Barangay -</option>
			            </select>
			        </div>
				</div>
			    <div class="col-sm-4">
			        <div class="form-group">
			            <label for="ownership_type" class="control-label">Ownership Type</label>
			            <select class="form-control select" name="ownership_type" id="ownership_type">
			            	<option value = "" selected="selected">- Select Type of Ownership -</option>
			            	<?php
			            		$q_ownership_type = $this->db->query("select * from lib_ownership_types  where is_active = TRUE order by ownership_id asc");
			            		foreach ($q_ownership_type->result() as $type) {
			            	?>
			                <option value="<?php echo $type->ownership_id ?>"><?php echo $type->ownership_name ?></option>
			                <?php }//closeforeach ?>
			            </select>
									<div class="alert alert-danger" role="alert" id="loadTextowner" style="display: none; margin-top: 15px; padding: 3px;">Add Ownership Type.</div>
			        </div>
			        <div class="form-group">
			            <label for="subscription_type" class="control-label">Subscription Type</label>
			            <select class="form-control select" name="subscription_type" id="subscription_type">
			            	<option value = "" selected="selected">- Select Type of Subscription -</option>
			            	<?php
			            		$q_subscription_type = $this->db->query("select * from lib_subscription_types  where is_active = TRUE  order by subscription_id asc");
			            		foreach ($q_subscription_type->result() as $type) {
			            	?>
			                <option value="<?php echo $type->subscription_id ?>"><?php echo $type->subscription_name ?></option>
			                <?php }//closeforeach ?>
			            </select>
									<div class="alert alert-danger" role="alert" id="loadTextsub" style="display: none; margin-top: 15px; padding: 3px;">Add Subscription Type.</div>
			        </div>
			    </div>
			    <div class="col-sm-4">
			    </div>
			</div>
			<hr/>
				<div class="row">
					<div class="col-md-6">
						<?php if (isset($message)) { ?>
							<CENTER><h3 style="color:green;"><?php echo $message;?></h3></CENTER><br>
						<?php } ?>
						<?php input_text_form("First Name", "first_name", "first_name", "Enter First Name"); ?>
						<?php input_text_form("Middle Name", "middle_name", "middle_name", "Enter Middle Name"); ?>
						<?php input_text_form("Last Name", "last_name", "last_name", "Enter Last Name"); ?>
			            <div class="row">
			                <div class="col-xs-6">
			                    <div class="form-group">
			                        <label for="email" class="control-label">Personal email</label>
			                        <input type="email" class="form-control" id="email" name ="email" placeholder="Email Address" />
															<div class="alert alert-danger" role="alert" id="loadText" style="display: none; margin-top: 15px; padding: 3px;">Email Address already exist.</div>

			                    </div>
			                </div>
			                <div class="col-xs-6">
			                	<?php input_text_form("Mobile Number", "mobile_num", "mobile_num", "Enter Mobile Number"); ?>

			                </div>
			            </div>
			            <div class="row">
			                <div class="col-xs-6">
			                        <div class="form-group">
			                            <label for="sex" class="control-label">Sex</label>
			                            <select class="form-control" name="sex">
			                              <option value="Male">Male </option>
			                              <option value="Female">Female </option>
			                            </select>
			                        </div>
			                </div>
			                <div class="col-xs-6">

			                         <div class="form-group">
			                            <label for="civil_status" class="control-label">Civil Status</label>
			                            <select class="form-control" name="civil_status">
			                              <option value="Single">Single </option>
			                              <option value="Married">Married </option>
			                              <option value="Widowed">Widowed </option>
			                            </select>
			                        </div>

			                </div>
			            </div>
			         	<?php input_date_form("Date of Birth", "birth_date", "birth_date", "Enter Date of Birth"); ?>

			         	<?php input_text_form("Place of Birth", "birth_place", "birth_place", "Enter Place of Birth"); ?>
					</div>
					<div class="col-md-6">
						<?php input_text_form("Mother's Maiden Name", "mm_name", "mm_name", "Enter Mother's Maiden Name"); ?>
					<div class="row">
						<div class="col-lg-6">
							<?php input_text_form("ID Card Used", "card_used", "card_used", "Govt issued ID"); ?>
						</div>
						<div class="col-lg-6">
							<?php input_text_form("ID Card Number", "card_id_num", "card_id_num", "Valid ID Number"); ?>
						</div>
						<div class="col-lg-12">
						<?php input_text_form("Complete Address", "address", "address", "Purok, Street Name, Lot #, Block #,.."); ?>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
							    <label for="org_chapter" class="control-label">Membership on an Organization</label>
							    <select class="form-control" name="org_chapter" id="org_chapter">
							    	<option value = "" selected="selected">- Select Org/Coop/Assoc/Financier -</option>
							    	<?php
							    		$q_org_chapter = $this->db->query("select * from organizations where is_active = TRUE and org_entity <> 'Govt' order by org_name asc");
							    		foreach ($q_org_chapter->result() as $org) {
							    	?>
							        <option value="<?php echo $org->org_code ?>"><?php echo decr($org->org_name) ?></option>
							        <?php }//closeforeach ?>
							    </select>
							</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
								    <label for="org_section" class="control-label">Organization Federation</label>
								    <select class="form-control" name="org_section" id="org_section">
								    	<option value = "" selected="selected">- Select Org/Coop/Assoc/Financier -</option>
								    	<?php
								    		$q_org_chapter = $this->db->query("select * from organizations where is_active = TRUE and org_entity <> 'Govt' order by org_name asc");
								    		foreach ($q_org_chapter->result() as $org) {
								    	?>
								        <option value="<?php echo $org->org_code ?>"><?php echo decr($org->org_name) ?></option>
								        <?php }//closeforeach ?>
								    </select>
								</div>
							</div>
					</div>

				</div>

					<div class="col-md-12">
					<div class="form-group">
					<button class="btn btn-success" type="submit"><i class="fa fa-plus-circle"></i> Register</button>
					</div>
				</div>

			</form>
	</div>
    </div> <!--END <div class="panel-body">-->
</div>

<script>




$("#email").blur(function(){
var email = $('#email').val();

	if(email!=''){
			  $.ajax({
			   type: "post",
			   url: "<?php echo site_url('registrations/checkFarmer'); ?>",
			   cache: false,
				  data:'email=' + $("#email").val(),
			   success: function(response){

					     if(response=='true'){

					      $('#email').css('border', '2px green solid');
					      $('#loadText').css('display', 'none');
								$('#con').val('1');
					      return true;
					     }else{

					      $('#email').css('border', '2px red solid');
					      $('#loadText').css('display', 'block');
					      $('#loadText').css('margin-top', '5px');
								$('#con').val('0');
					      return false;
					     }

			   },
			   error: function(){
			    alert('Error processing request..');
			   }
			   });
	 }else{
		 $('#email').css('border', '1px #ccc solid');
		 $('#loadText').css('display', 'none');
	 }

});



function confirm(){
	var bday = $('#birth_date').val();
	var ownership = $('#ownership_type').val();
	var subs = $('#subscription_type').val();


	if(bday==""){
		$('#birth_date').css('border', '2px red solid');
		return false;
	}
	else if(ownership==""){
		$('#ownership_type').css('border', '2px red solid');
		$('#loadTextowner').css('display', 'block');
		$('#loadTextowner').css('margin-top', '5px');
		$('#birth_date').css('border', '1px #ccc solid');
		return false;
	}
	else if(subs==""){
		$('#subscription_type').css('border', '2px red solid');
		$('#loadTextsub').css('display', 'block');
		$('#loadTextsub').css('margin-top', '5px');
		$('#loadTextowner').css('display', 'none');
		return false;
	}
	else{
		return true;
	}



}
</script>
