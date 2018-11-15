<?php track_page(basename(__FILE__)) ?>
<?php 

	$q_members = $this->db->query("select * from organizations where is_active = 'TRUE' and org_entity = 'Private'");
?>
<h4>Organizations/Associations/Cooperatives Profile</h4>
<hr/>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
	<thead>
		<tr>
			<th>Organization Code</th>
			<th>Organization Name</th>
			<th>Ownership Type</th>
			<th>Subscription Type</th>
			<th>Region</th>
			<th>Province</th>
			<th>Muncity</th>
			<th>Brgy</th>
			<th>Date Created</th>
			<th>Date Deactivated</th>
			<th>Profiles</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($q_members->result() as $member) { 
			//show only the organizations that are within its muncity for both LGU and ORGs
			
			if(decr($member->muncity) == $_SESSION['muncity']){
		?>
		<tr>
			<td> <a href="update-org-profile?org_code=<?php echo uencode($member->org_code) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $member->org_code ?></a></td>
			<td> <?php echo decr($member->org_name) ?></td>
			<td><?php echo $this->mod_registrations->get_ownership_name(decr($member->org_ownership_type)) ?></td>
			<td><?php echo $this->mod_registrations->get_subscription_name(decr($member->org_subscription_type)) ?></td>
			<td> <?php echo decr($member->region) ?></td>
			<td> <?php echo decr($member->province) ?></td>
			<td> <?php echo decr($member->muncity) ?></td>
			<td> <?php echo decr($member->brgy) ?></td>
			<td> <?php echo $member->date_created ?></td>
			<td> <?php echo $member->date_deactivated ?></td>
			<td>
				<?php 
					if($_SESSION['system_access_lvl'] == 3 || $_SESSION['system_access_lvl'] == 6 ){
					?>
					<a href="#" class="btn btn-default btn-sm btn-flat btn-rect">
						<?php echo $this->mod_crops->count_org_farmers($member->org_code) ?> Farmers
					</a>
				<?php
				//will just show how many are registered in this org and if ill click on it i can see the memvers list only
					}else{
				?>
					<a href="<?php echo base_url() ?>office-head?org_code=<?php echo uencode($member->org_code) ?>" class="btn btn-primary btn-sm btn-flat btn-rect"><i class="fa fa-user" aria-hidden="true"></i></a>
					<a href="<?php echo base_url() ?>create-user-enumerator?org_code=<?php echo uencode($member->org_code) ?>" class="btn btn-primary btn-sm btn-flat btn-rect"><i class="fa fa-map" aria-hidden="true"></i></a>
					<a href="<?php echo base_url() ?>profile-organization-members?org_code=<?php echo uencode($member->org_code) ?>" class="btn btn-primary btn-sm btn-flat btn-rect"><i class="fa fa-map" aria-hidden="true"></i></a>
				<?php	
				} //close inner if
			} //close outer if
				?>
			</td>

		</tr>
	<?php } //close foreach ?>
	</tbody>
</table>