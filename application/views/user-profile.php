<?php track_page(basename(__FILE__)) ?>
<?php 

	$q_user = $this->db->query("select * from users where email = '". $_SESSION['email']  ."' LIMIT 1 ");
?>
<h4>User's Profile</h4>
<hr/>
<table width="100%" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th>Email</th>
			<th>Name</th>
			<th>Contact</th>
			<th>Access Level</th>
			<th>region</th>
			<th>Provine</th>
			<th>Muncity</th>
			<th>is_active</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($q_user->result() as $member) { ?>
		<tr>
			<td> <?php echo $member->email ?></td>
			<td> <?php echo decr($member->full_name) ?></td>
			<td> <?php echo decr($member->contact_number) ?></td>
			<td> <?php echo decr($member->system_access_lvl) ?></td>
			<td> <?php echo decr($member->region) ?></td>
			<td> <?php echo decr($member->province) ?></td>
			<td> <?php echo decr($member->muncity) ?></td>
			<td> <?php echo decr($member->is_active) ?></td>
			
		</tr>
		<?php } //close foreach ?>
	</tbody>
</table>