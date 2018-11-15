<?php track_page(basename(__FILE__)) ?>
<?php 

	$q_members = $this->db->query("select * from organizations where is_active = 'TRUE' and org_entity = 'Financier'");
?>
<h4>Farm Financier's Profile</h4>
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
		<?php foreach ($q_members->result() as $member) { ?>
		<tr>
			<td> <a href="edit_org_profile?code=<?php echo org_code($member->org_code) ?>"><?php echo $member->org_code ?></a></td>
			<td> <?php echo $member->org_name ?></td>
			<td> <?php echo $member->org_ownership_type ?></td>
			<td> <?php echo $member->org_subscription_type ?></td>
			<td> <?php echo $member->region_code ?></td>
			<td> <?php echo $member->province_code ?></td>
			<td> <?php echo $member->muncity_code ?></td>
			<td> <?php echo $member->brgy_code ?></td>
			<td> <?php echo $member->date_created ?></td>
			<td> <?php echo $member->date_deactivated ?></td>
			<td> 
				<a href="<?php echo base_url() ?>office-head?org_code=<?php echo uencode($member->org_code) ?>">Office Head</a><br/>
				<a href="<?php echo base_url() ?>create-user-enumerator?org_code=<?php echo uencode($member->org_code) ?>">Enumerator</a>
			</td>
		</tr>
		<?php } //close foreach ?>
	</tbody>
</table>