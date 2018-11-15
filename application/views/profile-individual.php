<?php track_page(basename(__FILE__)) ?>
<?php 
	
	$q_owner_types = $this->db->query("select * from lib_ownership_types ");
	$q_subscription_types = $this->db->query("select * from lib_subscription_types ");

	//check if it is an enumerator for an organization
	if($_SESSION['system_access_lvl'] == 4){
		//$q_members = $this->db->query("select * from members where is_active = 'TRUE' and is_analyst = 'TRUE' and member_grp = 1 and org_chapter = '".$_SESSION['org_chapter']."'");
		//$q_members = $this->db->query("select * from members where org_chapter = '".$_SESSION['org_chapter']."'");
		$q_members = $this->db->query("select * from members ");
	
	}elseif($_SESSION['system_access_lvl'] == 3){
		//the enumerator is a Section/Federation Encoder
		$q_members = $this->db->query("select * from members where is_active = 'TRUE' and member_grp = 1 and org_chapter='' ");
	}elseif($_SESSION['system_access_lvl'] == 6){
		//the enumerator is a section 
		$q_members = $this->db->query("select * from members where is_active = 'TRUE' and member_grp = 1 and org_chapter='". $_SESSION['org_chapter'] . "'");
	}else{
		//for sys admin
		$q_members = $this->db->query("select * from members where is_active = 'TRUE' and member_grp = 1");
	}
?>
<h4>Farmer's Profile</h4>
<a href="<?php base_url()?>client-register">Register New Farmer</a>
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
			<th>Municipality</th>
			<th>Brgy</th>
			<th>Date Created</th>
			<th>Organization</th>
			<th>Farm[s]</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($q_members->result() as $member) { 

			//this will filter farmer members that are within the municipality
			if($_SESSION['system_access_lvl'] == 3){
				if(decr($member->muncity_code) == $_SESSION['muncity_code']){
		?>
		<tr>
			<td><a href="update-client-register?user_code=<?php echo uencode($member->user_code) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $member->user_code ?></a></td>
			<td><?php echo decr($member->first_name) ?></td>
			<td><?php echo decr($member->middle_name) ?></td>
			<td><?php echo decr($member->last_name) ?></td>
			<td><?php echo $this->mod_registrations->get_ownership_name(decr($member->ownership_type)) ?></td>
			<td><?php echo $this->mod_registrations->get_subscription_name(decr($member->subscription_type)) ?></td>
			<td><?php echo decr($member->muncity) ?></td>
			<td><?php echo decr($member->brgy) ?></td>
			<td><?php echo $member->date_created ?></td>
			<td><?php echo decr($this->mod_registrations->get_org_name($member->org_chapter)) . " [".$member->org_chapter. "]";?></td>
			<td><a href="mem_profile?code=<?php echo uencode($member->user_code) ?>" class="btn btn-primary btn-sm btn-flat btn-rect"><i class="fa fa-map" aria-hidden="true"></i> Farm</a></td>
		</tr>
			<?php }//close if inner
			}
			if(($_SESSION['system_access_lvl'] == 6)){ //this is for the federation
				//if($member->org_chapter == $_SESSION['org_chapter']){
		?>
		<tr>
			<td><a href="update-client-register?user_code=<?php echo uencode($member->user_code) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $member->user_code ?></a></td>
			<td><?php echo "6".decr($member->first_name) ?></td>
			<td><?php echo decr($member->middle_name) ?></td>
			<td><?php echo decr($member->last_name) ?></td>
			<td><?php echo $this->mod_registrations->get_ownership_name(decr($member->ownership_type)) ?></td>
			<td><?php echo $this->mod_registrations->get_subscription_name(decr($member->subscription_type)) ?></td>
			<td><?php echo decr($member->muncity) ?></td>
			<td><?php echo decr($member->brgy) ?></td>
			<td><?php echo $member->date_created ?></td>
			<td><?php echo decr($this->mod_registrations->get_org_name($member->org_chapter)) . " [".$member->org_chapter. "]";?></td>
			<td><a href="mem_profile?code=<?php echo uencode($member->user_code) ?>" class="btn btn-primary btn-sm btn-flat btn-rect"><i class="fa fa-map" aria-hidden="true"></i> Farm</a></td>
		</tr>
			<?php //}//close if inner
			}

	?>
	<?php 
		if($_SESSION['system_access_lvl'] == 1){
	?>
		<tr>
			<td><a href="update-client-register?user_code=<?php echo uencode($member->user_code) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $member->user_code ?></a></td>
			<td><?php echo decr($member->first_name) ?></td>
			<td><?php echo decr($member->middle_name) ?></td>
			<td><?php echo decr($member->last_name) ?></td>
			<td><?php echo $this->mod_registrations->get_ownership_name(decr($member->ownership_type)) ?></td>
			<td><?php echo $this->mod_registrations->get_subscription_name(decr($member->subscription_type)) ?></td>
			<td><?php echo decr($member->muncity) ?></td>
			<td><?php echo decr($member->brgy) ?></td>
			<td><?php echo $member->date_created ?></td>
			<td><?php echo decr($this->mod_registrations->get_org_name($member->org_chapter)) . " [".$member->org_chapter. "]";?></td>
			<td><a href="mem_profile?code=<?php echo uencode($member->user_code) ?>" class="btn btn-primary btn-sm btn-flat btn-rect"><i class="fa fa-map" aria-hidden="true"></i> Farm</a></td>
		</tr>
	<?php
		} //close if
	} //close foreach 
	?>
	</tbody>
</table>