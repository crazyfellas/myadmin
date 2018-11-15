<?php track_page(basename(__FILE__))?>
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

<h4>Organization Registration</h4>
<hr/>

			<?php echo validation_errors(); ?>
			<?php echo form_open('registrations/org_register'); ?>
			<div class="row">
				<div class="col-sm-4">Location <br/>
				    <div class="form-group">
				        <select class="form-control" id="region-select" name = "region" href="<?=base_url('location/region')?>">
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
				        <select class="form-control" id="province-select" name = "province" href = "<?=base_url('location/province')?>">
				            <option value = "" selected="selected" >- Select Province -</option>
				        </select>
				    </div>
			        <div class="form-group">
			            <select class="form-control" id="muncity-select" name = "muncity" href = "<?=base_url('location/get_muncity')?>">
			                <option value = "" selected="selected">- Select Municipality/City -</option>
			            </select>
			        </div>
			        <div class="form-group">
			            <select class="form-control" id="brgy-select" name = "brgy" href = "<?=base_url('location/get_brgy')?>">
			                <option value = "" selected="selected">- Select Barangay -</option>
			            </select>
			        </div>
				</div>
			    <div class="col-sm-4">
			        <div class="form-group">
			            <label for="ownership_type" class="control-label">Ownership Type</label>
			            <select class="form-control" name="ownership_type" id="ownership_type">
			            	<option value = "" selected="selected">- Select Type of Ownership -</option>
			            	<?php 
			            		$q_ownership_type = $this->db->query("select * from lib_ownership_types  where is_active = TRUE  order by ownership_name asc");
			            		foreach ($q_ownership_type->result() as $type) {
			            	?>
			                <option value="<?php echo $type->ownership_id ?>"><?php echo $type->ownership_name ?></option>
			                <?php }//closeforeach ?>
			            </select>
			        </div>
			        <div class="form-group">
			            <label for="subscription_type" class="control-label">Subscription Type</label>
			            <select class="form-control" name="subscription_type" id="subscription_type">
			            	<option value = "" selected="selected">- Select Type of Subscription -</option>
			            	<?php 
			            		$q_subscription_type = $this->db->query("select * from lib_subscription_types  where is_active = TRUE order by subscription_id asc");
			            		foreach ($q_subscription_type->result() as $type) {
			            	?>
			                <option value="<?php echo $type->subscription_id ?>"><?php echo $type->subscription_name ?></option>
			                <?php }//closeforeach ?>
			            </select>
			        </div>
			        <?php input_date_form("Date of Approval", "date_approved", "date_approved", ""); ?>
			    </div>
			    <div class="col-sm-4">
			    	<?php input_text_form("User Code", "user_code", "user_code", "Enter User Code"); ?>
			    	<br/>
			    	<label for="org_entity" class="control-label">What type of Organization?</label><br/>
				    <div class="form-group">
				        <select class="form-control" id="org_entity" name = "org_entity">
				            <option value = "" selected="selected">- Select Org Type -</option>
				            <option value="Govt">Government</option>
				            <option value="Private">Private Assoc/Org/Coop</option>
				            <option value="Financier">Financier</option>
				        </select>
				    </div>
			    </div>
			</div>
			<hr/>
			<h4>Organization Information and Contacts</h4>
				<div class="row">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<?php if (isset($message)) { ?>
							<CENTER><h3 style="color:green;"><?php echo $message;?></h3></CENTER><br>
						<?php } ?>
						<?php input_text_form("Organization Official Registered Name", "org_official_name", "org_official_name", "Enter Organization Official Registered Name"); ?>
			            <div class="row">
			                <div class="col-xs-6">
			                    <div class="form-group">
			                        <label for="email" class="control-label">Organization Official email Address</label>
			                        <input type="email" class="form-control" id="org_email" name = "org_email" placeholder="email" />
			                    </div>
			                </div>
			                <div class="col-xs-6">
			                	<?php input_text_form("Office Number", "office_number", "office_number", "Enter Offical Number"); ?>
			                </div>
			            </div>
			         	<?php input_date_form("Date of Establishment", "birth_date", "birth_date", ""); ?>
						<div class="form-group">
							<input type="submit" class="btn btn-default" value="Register">
						</div>
					</div>
					<div class="col-md-3"></div>
			</form>

