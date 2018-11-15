<?php track_page(basename(__FILE__)) ?>
<?php 
	$org_code = udecode($_GET['org_code']);
?>
<h4>System User Registration for Enumerators [Government &amp; Private]</h4>
<!-- <a href="<?php echo base_url() ?>profile-govtoffice">< back</a> -->
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

<div class="row">
	<div class="col-md-6">
		<?php echo validation_errors(); ?>
		<?php echo form_open('registrations/sys_user_org_reg'); ?>
			<div class="form-group">
		        	<?php 
		        		$org = $this->db->query("select * from organizations where org_code ='".$org_code."' ");
		        		foreach ($org->result() as $org) {
		        	?>	<label for="org_chapter" class="control-label">This user is assigned to: <?php echo decr($org->org_name) ?> </label>
			    		<input class="form-control" type="hidden" name="org_chapter" id="org_chapter" value="<?php echo $org->org_code ?>"/>
			    		<input class="form-control" type="hidden" name="region" id="region" value="<?php echo decr($org->region_code) ?>"/>
			    		<input class="form-control" type="hidden" name="province" id="province" value="<?php echo decr($org->province_code) ?>"/>
			    		<input class="form-control" type="hidden" name="muncity" id="muncity" value="<?php echo decr($org->muncity_code) ?>"/>
			    		<input class="form-control" type="hidden" name="brgy" id="brgy" value="<?php echo decr($org->brgy_code) ?>"/>
			    <?php }//closeforeach ?>
			</div>
			<?php if (isset($message)) { ?>
				<CENTER><h3 style="color:green;"><?php echo $message;?></h3></CENTER><br>
			<?php } ?>
		    	<?php input_text_form("Full Name", "full_name", "full_name", "Enter Complete Name"); ?>
		    	<?php input_text_form("Official Email", "email", "email", "Enter Complete Name"); ?>
		    	<?php input_text_form("Mobile Contact", "contact_number", "contact_number", "Enter Complete Name"); ?>

	</div>
	<div class="col-md-6">
		<br/>
		<br/>
		<br/>
			    <div class="form-group">
			        <label for="password" class="control-label">Password</label>
			        <input type="text" class="form-control" id="password" name="password" value="tiklis@2017" />
			    </div>
		        <div class="form-group">
		            <label for="area_access_lvl" class="control-label">User Level</label>
		            <select class="form-control" name="system_access_lvl" id="system_access_lvl">
		            	<option value = "" selected="selected">- Select Type of User Level -</option>
		            	<?php 
		            		$q_su_type = $this->db->query("select * from lib_system_user_types where is_active = TRUE and for_organization_user = TRUE order by userlevel_name");
		            		foreach ($q_su_type->result() as $type) {
		            	?>
		                <option value="<?php echo $type->userlevel_id ?>"><?php echo $type->userlevel_name ?></option>
		                <?php }//closeforeach ?>
		            </select>
		        </div>
		        <?php input_date_form("Date of birth", "birth_date", "birth_date", ""); ?>
			<div class="form-group">
				<input type="submit" class="btn btn-default" value="Create System User">
			</div>
		</form>
	</div>
</div>

<p><b>List of Registered Users</b></p>
<div class="row">
	<div class="col-md-12">
		<?php 
			$q_users = $this->db->query("select * from users where org_chapter = '".$org_code."'");
		?>
		<table class="table">
			<tr>
				<thead>
					<th>Email</th>
					<th>Full Name</th>
					<th>Contact Number</th>
					<th>Date Created</th>
					<th>Date Deactivated</th>
					<th>Access Level</th>
				</thead>
			</tr>	
			<tr>
				<tbody>
					<?php 
					foreach ($q_users->result() as $users) {
						echo "<tr>";
						echo "<td><a href =\"#\"> ".$users->email . "</a></td>";
						echo "<td>".decr($users->full_name) . "</td>";
						echo "<td>".decr($users->contact_number) . "</td>";
						echo "<td>".$users->date_created . "</td>";
						echo "<td>".$users->date_deactivated . "</td>";
						echo "<td>".decr($users->system_access_lvl) . "</td>";
						echo "</tr>";
					}
					?>
				</tbody>
			</tr>
		</table>
	</div>
</div>