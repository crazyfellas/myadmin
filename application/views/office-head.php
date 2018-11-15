<?php track_page(basename(__FILE__)) ?>
<?php 
	$org_code = udecode($_GET['org_code']);
?>
<h4>Office/Agency Head for {Organization name}</h4>
<a href="<?php echo base_url() ?>profile-govtoffice">< back</a>
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

<p><b>Office Head</b></p>
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