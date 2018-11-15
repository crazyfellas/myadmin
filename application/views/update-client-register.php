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

<?php
	$user_code = udecode($_GET['user_code']); 
	$q_update_member = $this->db->query("select * from members where user_code ='".$user_code."' LIMIT 1");

	foreach ($q_update_member->result() as $member) {
?>
<div class="panel panel-default">
    <div class="panel-heading">Independent Farmer Registration</div>
    <div class="panel-body">

			<?php echo validation_errors(); ?>
			<?php echo form_open('registrations/update_member?user_code='. $user_code); ?>
			<div class="row">
				<div class="col-sm-4">Location <br/>
				    <div class="form-group">
				        <select class="form-control" id="region-select" name = "region" href="<?=base_url('location/region')?>">
				            <option value = "" selected="selected" value="<?php echo decr($member->region_code) ?>"><?php echo decr($member->region) ?></option>
				            <?php
				                $query = $this->db->query("select * from lib_loc_regions order by region asc");

				                foreach ($query->result() as $row){
				                 echo "<option value = \"{$row->psgc_rcode}\">{$row->region}</option>";
				                }
				            ?>
				        </select>
				    </div>
				    <div class="form-group">
				        <select class="form-control" id="province-select" name = "province" href = "<?=base_url('location/province')?>">
				            <option value = "" selected="selected" value="<?php echo decr($member->province_code) ?>"><?php echo decr($member->province) ?></option>
				        </select>
				    </div>
			        <div class="form-group">
			            <select class="form-control" id="muncity-select" name = "muncity" href = "<?=base_url('location/get_muncity')?>">
			                <option value = "" selected="selected" value="<?php echo decr($member->muncity_code) ?>"><?php echo decr($member->muncity) ?></option>
			            </select>
			        </div>
			        <div class="form-group">
			            <select class="form-control" id="brgy-select" name = "brgy" href = "<?=base_url('location/get_brgy')?>">
			                <option value = "" selected="selected" value="<?php echo decr($member->brgy_code) ?>"><?php echo decr($member->brgy) ?></option>
			            </select>
			        </div>
				</div>
			    <div class="col-sm-4">
			        <div class="form-group">
			            <label for="ownership_type" class="control-label">Ownership Type</label>
			            <select class="form-control" name="ownership_type" id="ownership_type">
			            	<option selected="selected" value="<?php echo decr($member->ownership_type)?>">
			            		<?php echo $this->mod_registrations->get_ownership_name(decr($member->ownership_type)) ?>
			            	</option>
			            	<?php 
			            		$q_ownership_type = $this->db->query("select * from lib_ownership_types  where is_active = TRUE order by ownership_id asc");
			            		foreach ($q_ownership_type->result() as $type) {
			            	?>
			                <option value="<?php echo $type->ownership_id ?>"><?php echo $type->ownership_name ?></option>
			                <?php }//closeforeach ?>
			            </select>
			        </div>
			        <div class="form-group">
			            <label for="subscription_type" class="control-label">Subscription Type</label>
			            <select class="form-control" name="subscription_type" id="subscription_type">
			            	<option selected="selected" value="<?php echo decr($member->subscription_type)?>">
			            		<?php echo $this->mod_registrations->get_subscription_name(decr($member->subscription_type)) ?>
			            	</option>
			            	<?php 
			            		$q_subscription_type = $this->db->query("select * from lib_subscription_types  where is_active = TRUE  order by subscription_id asc");
			            		foreach ($q_subscription_type->result() as $type) {
			            	?>
			                <option value="<?php echo $type->subscription_id ?>"><?php echo $type->subscription_name ?></option>
			                <?php }//closeforeach ?>
			            </select>
			        </div>
			        <?php update_date_form("Date of Approval", "date_approved", "date_approved",$member->date_approved ,""); ?>
			    </div>
			    <div class="col-sm-4">
			    	<?php input_text_form_readonly("User Code", "user_code", "user_code", "",$member->user_code,""); ?>
			    </div>
			</div>
			<hr/>
				<div class="row">
					<div class="col-md-6">
						<?php if (isset($message)) { ?>
							<CENTER><h3 style="color:green;"><?php echo $message;?></h3></CENTER><br>
						<?php } ?>
						<?php update_text_form("First Name", "first_name", "first_name", "Enter First Name",decr($member->first_name) ,""); ?>
						<?php update_text_form("Middle Name", "middle_name", "middle_name", "Enter Middle Name",decr($member->middle_name) ,""); ?>
						<?php update_text_form("Last Name", "last_name", "last_name", "Enter Last Name",decr($member->last_name) ,""); ?>
			            <div class="row">
			                <div class="col-xs-6">
			                    <?php update_text_form("Official Email", "email", "email", "Enter First Name",decr($member->email) ,""); ?>
			                </div>
			                <div class="col-xs-6">
			                	<?php update_text_form("Mobile Number", "mobile_num", "mobile_num", "Enter Mobile Number",decr($member->mobile_number) ,""); ?>
			                </div>
			            </div>
			            <div class="row">
			                <div class="col-xs-6">
			                        <div class="form-group">
			                            <label for="sex" class="control-label">Sex</label>
			                            <select class="form-control" name="sex">
 											<option value = "" selected="selected" value="<?php echo decr($member->sex)?>"><?php echo decr($member->sex) ?></option>
			                                <option value="Male">Male </option>
			                                <option value="Female">Female </option>
			                            </select>
			                        </div>
			                </div>
			                <div class="col-xs-6">
			                    
			                         <div class="form-group">
			                            <label for="civil_status" class="control-label">Civil Status</label>
			                            <select class="form-control" name="civil_status">
			                            	<option value = "" selected="selected" value="<?php echo decr($member->civil_status)?>"><?php echo decr($member->civil_status) ?></option>
			                                <option value="Single">Single </option>
			                                <option value="Married">Married </option>
			                                <option value="Widowed">Widowed </option>
			                            </select>
			                        </div>
			                               
			                </div>
			            </div>
			         	<?php update_date_form("Date of Birth", "birth_date", "birth_date", $member->birthdate,""); ?>
			         	<?php update_text_form("Place of Birth", "birth_place", "birth_place", "Enter Place of Birth",decr($member->birthplace) ,""); ?>
					</div>
					<div class="col-md-6">
						<?php update_text_form("Mother's Maiden Name", "mm_name", "mm_name", "Enter Mother's Maiden Name",decr($member->mother_maiden_name) ,""); ?>
					<div class="row">
						<div class="col-lg-6">
							<?php update_text_form("ID Card Used", "card_used", "card_used", "Govt issued ID",decr($member->id_card) ,""); ?>
						</div>
						<div class="col-lg-6">
							<?php update_text_form("ID Card Number", "card_id_num", "card_id_num", "Valid ID Number",decr($member->id_card_number) ,""); ?>
						</div>
						<?php update_text_form("Complete Address", "address", "address", "Purok, Street Name, Lot #, Block #,..",decr($member->complete_address) ,""); ?>
						<div class="form-group">
						    <label for="org_chapter" class="control-label">Membership on an Organization</label>
						    <select class="form-control" name="org_chapter" id="org_chapter">
						    	<option selected="selected" value="">- Select Organization - </option>
						    	<?php 
						    		$q_org_chapter = $this->db->query("select * from organizations where is_active = TRUE and org_entity <> 'Govt' order by org_name asc");
						    		foreach ($q_org_chapter->result() as $org) {
						    	?>
						        <option value="<?php echo $org->org_code ?>"><?php echo decr($org->org_name) ?></option>
						        <?php }//closeforeach ?>
						    </select>
						</div>
					</div>
						<div class="form-group">
							<input type="submit" class="btn btn-default" value="Update Member Profile">
						</div>
					</div>
			</form>
	</div>
    </div> <!--END <div class="panel-body">-->
</div>
<?php } //close foreach ?>