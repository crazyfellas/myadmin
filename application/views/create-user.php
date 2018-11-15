<?php track_page(basename(__FILE__)) ?>
<h4>System User Registration</h4>
<hr/>
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

			<?php echo validation_errors(); ?>
			<?php echo form_open('registrations/sys_user_reg'); ?>
			<div class="row">
			    <div class="col-sm-6 col-sm-offset-3">
			    	<label for="userlocation" class="control-label">User Location</label>
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

				<?php if (isset($message)) { ?>
					<CENTER><h3 style="color:green;"><?php echo $message;?></h3></CENTER><br>
				<?php } ?>
                    <div class="form-group">
                        <label for="email" class="control-label">email</label>
                        <input type="email" class="form-control" id="email" name = "email" placeholder="email" />
                    </div>
			    	<?php input_text_form("Full Name", "full_name", "full_name", "Enter Complete Name"); ?>
				    <div class="form-group">
				        <label for="password" class="control-label">Password</label>
				        <input type="text" class="form-control" id="password" name="password" value="tiklis@2017" />
				    </div>
			        <div class="form-group">
			            <label for="system_access_lvl" class="control-label">User Level</label>
			            <select class="form-control" name="system_access_lvl" id="system_access_lvl">
			            	<option value = "" selected="selected">- Select Type of User Level -</option>
			            	<?php 
			            		$q_su_type = $this->db->query("select * from lib_system_user_types where is_active = TRUE");
			            		foreach ($q_su_type->result() as $type) {
			            	?>
			                <option value="<?php echo $type->userlevel_id ?>"><?php echo $type->userlevel_name ?></option>
			                <?php }//closeforeach ?>
			            </select>
			        </div>
					<div class="form-group">
					    <label for="org_chapter" class="control-label">This user is assigned to: </label>
					    <select class="form-control" name="org_chapter" id="org_chapter">
					    	<option value = "" selected="selected">- Select Org/Coop/Assoc/Financier -</option>
					    	<?php 
					    		$q_org_chapter = $this->db->query("select * from organizations where is_active = TRUE order by org_name asc");
					    		foreach ($q_org_chapter->result() as $org) {
					    	?>
					        <option value="<?php echo $org->org_code ?>"><?php echo decr($org->org_name) ?></option>
					        <?php }//closeforeach ?>
					    </select>
					</div>
			        <?php input_date_form("Date of birth", "birth_date", "birth_date", ""); ?>
				<div class="form-group">
					<input type="submit" class="btn btn-default" value="Create System User">
				</div>
			    </div>
			</div>
			</form>
