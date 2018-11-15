<?php track_page(basename(__FILE__)) ?>
<?php 
$org_code = udecode($_GET['org_code']) ;
$q_org = $this->db->query("select * from organizations where org_code = '".$org_code."' LIMIT 1");

foreach ($q_org->result() as $org) {

?>
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
<?php echo form_open('registrations/update_org_profile'); ?>
<div class="row">
	<div class="col-sm-4">Location <br/>
	    <div class="form-group">
	        <select class="form-control" id="region-select" name = "region" href="<?=base_url('location/region')?>">
	            <option value = "<?php echo decr($org->region_code) ?>" selected="selected"><?php echo decr($org->region) ?></option>
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
	            <option value = "<?php echo decr($org->province_code) ?>" selected="selected"><?php echo decr($org->province) ?></option>
	        </select>
	    </div>
        <div class="form-group">
            <select class="form-control" id="muncity-select" name = "muncity" href = "<?=base_url('location/get_muncity')?>">
                <option value = "<?php echo decr($org->muncity_code) ?>" selected="selected"><?php echo decr($org->region) ?></option>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" id="brgy-select" name = "brgy" href = "<?=base_url('location/get_brgy')?>">
                <option value = "<?php echo decr($org->brgy_code) ?>" selected="selected"><?php echo decr($org->brgy) ?></option>
            </select>
        </div>
	</div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="ownership_type" class="control-label">Ownership Type</label>
            <select class="form-control" name="ownership_type" id="ownership_type">
            	<option value = "<?php echo decr($org->org_ownership_type) ?>" selected="selected">
                    <?php echo $this->mod_registrations->get_subscription_name(decr($org->org_ownership_type)) ?>
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
            	<option value = "<?php echo decr($org->org_subscription_type) ?>" selected="selected">
                     <?php echo $this->mod_registrations->get_subscription_name(decr($org->org_subscription_type)) ?>
                </option>
            	<?php 
            		$q_subscription_type = $this->db->query("select * from lib_subscription_types  where is_active = TRUE order by subscription_id asc");
            		foreach ($q_subscription_type->result() as $type) {
            	?>
                <option value="<?php echo $type->subscription_id ?>"><?php echo $type->subscription_name ?></option>
                <?php }//closeforeach ?>
            </select>
        </div>
        <?php update_date_form("Date of Approval", "date_approved", "date_approved", $org->date_approved, ""); ?>
    </div>
    <div class="col-sm-4">
    	<?php input_text_form_readonly("User Code", "org_code", "org_code", "Enter User Code",$org->org_code ,""); ?>
    	<br/>
    	<label for="org_entity" class="control-label">What type of Organization?</label><br/>
	    <div class="form-group">
	        <select class="form-control" id="org_entity" name = "org_entity">
	            <option value = "<?php echo $org->org_entity ?>" selected="selected"><?php echo $org->org_entity ?></option>
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
			<?php update_text_form("Organization Official Registered Name", "org_official_name", "org_official_name", "Enter Organization Official Registered Name", decr($org->org_name),""); ?>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="email" class="control-label">Organization Official email Address</label>
                        <input type="email" class="form-control" id="org_email" name = "org_email" value="<?php echo $org->org_email ?>" />
                    </div>
                </div>
                <div class="col-xs-6">
                	<?php update_text_form("Office Number", "office_number", "office_number", "Enter Mobile Number",decr($org->office_number) , ""); ?>
                </div>
            </div>
         	<?php update_date_form("Date of Establishment", "birth_date", "birth_date", $org->date_established, ""); ?>
			<div class="form-group">
				<input type="submit" class="btn btn-default" value="Update Organization Profile">
			</div>
		</div>
		<div class="col-md-3"></div>
</form>

<?php } //close foreach ?>