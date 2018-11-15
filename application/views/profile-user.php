
<?php 

	$q_users = $this->db->query("select * from users ");
?>
<h4>System User's Profile</h4>
<hr/>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
	<thead>
		<tr>
			<th>Email</th>
			<th>Complete Name</th>
			<th>Access Level</th>
			<th>Date Created</th>
			<th>Options</th>

		</tr>
	</thead>
	<tbody>
		<?php foreach ($q_users->result() as $user) { ?>
		<tr>
			<td> <?php echo $user->email ?></td>
			<td> <?php echo decr($user->full_name) ?></td>
			<td> <?php echo decr($user->system_access_lvl) ?></td>
			<td> <?php echo $user->date_created ?></td>
			<td> option</td>
		</tr>
		<?php } //close foreach ?>
	</tbody>
</table>