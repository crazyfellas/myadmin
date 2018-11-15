<?php track_page(basename(__FILE__)) ?>
<?php  
    //check if userdata is set
    if($_SESSION['system_access_lvl'] == 4 || $_SESSION['system_access_lvl'] == 3){
    	redirect('index');
    }else{
       //nothing happens 
    }
?>

<?php 

	$q_members = $this->db->query("select * from organizations where is_active = 'TRUE' and org_entity = 'Govt'");
?>
<h4>Governemt Offices Profile</h4>
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
			<th>Date Created</th>
			<th>Date Deactivated</th>
			<th>Profiles</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($q_members->result() as $member) { ?>
		<tr>
			<td> <a href="update-org-profile?org_code=<?php echo uencode($member->org_code) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $member->org_code ?></a></td>
			<td> <?php echo decr($member->org_name) ?></td>
			<td><?php echo $this->mod_registrations->get_ownership_name(decr($member->org_ownership_type)) ?></td>
			<td><?php echo $this->mod_registrations->get_subscription_name(decr($member->org_subscription_type)) ?></td>
			<td> <?php echo decr($member->region) ?></td>
			<td> <?php echo decr($member->province) ?></td>
			<td> <?php echo decr($member->muncity) ?></td>
			<td> <?php echo $member->date_created ?></td>
			<td> <?php echo $member->date_deactivated ?></td>
			<td> 
				<a href="<?php echo base_url() ?>office-head?org_code=<?php echo uencode($member->org_code) ?>">Office Head</a><br/>
				<a href="<?php echo base_url() ?>create-user-enumerator?org_code=<?php echo uencode($member->org_code) ?>">Enumerator</a><br/>
				<a href="<?php echo base_url() ?>profile-muncity-members?org_code=<?php echo uencode($member->org_code) ?>&muncity=<?php echo uencode(decr($member->muncity)) ?>">members</a><br/>
			</td>
		</tr>
		<?php } //close foreach ?>
	</tbody>
</table>