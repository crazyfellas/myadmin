<?php track_page(basename(__FILE__)) ?>
<?php 

	$org_code = udecode($_GET['org_code']);
	//check if it is an enumerator for an organization
	if($_SESSION['system_access_lvl'] == 4){
		$q_members = $this->db->query("select * from members where org_chapter ='".$org_code."' and is_active = 'TRUE' and member_grp = 1 and org_chapter = '".$_SESSION['org_chapter']."'");
	}elseif($_SESSION['system_access_lvl'] == 1){ //for administrators
		//the enumerator is a MUNICIPAL/CHAMPION 
		$q_members = $this->db->query("select * from members where is_active = 'TRUE' and member_grp = 1 ");
	}else{
		$q_members = $this->db->query("select * from members where muncity_code ='".$_SESSION['muncity']."' and is_active = 'TRUE' and member_grp = 1 and org_chapter ='' ");
	}
?>
<h4>Farmer's Profilemun</h4>
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
			<th>Brgy</th>
			<th>Date Created</th>
			<th>Organization</th>
			<th>Farm[s]</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($q_members->result() as $member) { ?>
		<tr>
			<td><a href="update-client-register?user_code=<?php echo uencode($member->user_code) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $member->user_code ?></a></td>
			<td><?php echo decr($member->first_name) ?></td>
			<td><?php echo decr($member->middle_name) ?></td>
			<td><?php echo decr($member->last_name) ?></td>
			<td><?php echo $this->mod_registrations->get_ownership_name(decr($member->ownership_type)) ?></td>
			<td><?php echo $this->mod_registrations->get_subscription_name(decr($member->subscription_type)) ?></td>
			<td><?php echo decr($member->brgy) ?></td>
			<td><?php echo $member->date_created ?></td>
			<td><?php echo decr($this->mod_registrations->get_org_name($member->org_chapter)) . " [".$member->org_chapter. "]";?></td>
			<td><a href="mem_profile?code=<?php echo uencode($member->user_code) ?>" class="btn btn-primary btn-sm btn-flat btn-rect"><i class="fa fa-map" aria-hidden="true"></i> Farm</a></td>

		</tr>
		<?php } //close foreach ?>
	</tbody>
</table>