<?php track_page(basename(__FILE__)) ?>
<?php 

	$q_members = $this->db->query("select * from members where is_active = 'TRUE' and member_grp = 1");
?>
<h4>Data Analysts/Encoder's Profile</h4>
<hr/>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
	<thead>
		<tr>
			<th>User Code</th>
			<th>First Name</th>
			<th>Middle Name</th>
			<th>Last Name</th>
			<th>Ownership Type</th>
			<th>Subscription Type</th>
			<th>Region</th>
			<th>Province</th>
			<th>Muncity</th>
			<th>Brgy</th>
			<th>Date Created</th>
			<th>Option</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($q_members->result() as $member) { ?>
		<tr>
			<td> <a href="mem_profile?code=<?php echo uencode($member->user_code) ?>"><?php echo $member->user_code ?></a></td>
			<td> <?php echo decr($member->first_name) ?></td>
			<td> <?php echo decr($member->middle_name) ?></td>
			<td> <?php echo decr($member->last_name) ?></td>
			<td> <?php echo decr($member->ownership_type) ?></td>
			<td> <?php echo decr($member->subscription_type) ?></td>
			<td> <?php echo decr($member->region_code) ?></td>
			<td> <?php echo decr($member->province_code) ?></td>
			<td> <?php echo decr($member->muncity_code) ?></td>
			<td> <?php echo decr($member->brgy_code) ?></td>
			<td> <?php echo $member->date_created ?></td>
			<td> Renew | Deactivate | Update</td>
		</tr>
		<?php } //close foreach ?>
	</tbody>
</table>