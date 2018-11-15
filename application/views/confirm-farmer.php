<?php track_page(basename(__FILE__)) ?>
<?php

	$q_owner_types = $this->db->query("select * from lib_ownership_types ");
	$q_subscription_types = $this->db->query("select * from lib_subscription_types ");

	//check if it is an enumerator for an organization
	$q_members = $this->db->query("select * from members where is_active = 'FALSE' and member_grp = 1");
?>
<h4>Unregistered Farmers</h4>
<hr/>
<table width="100%" class="table table-striped table-bordered table-hover verify-result" id="dataTables-example">
	<thead>
		<tr>
			<th>#</th>
			<th>First Name</th>
			<th>Middle Name</th>
			<th>Last Name</th>
			<th>Ownership Type</th>
			<th>Subscription Type</th>
			<th>Municipality</th>
			<th>Brgy</th>
			<th>Date Created</th>
			<th>Date Approved</th>
			<th>Organization</th>
			<th>Duplicity<br/>Check</th>
			<th>Confirm</th>
		</tr>
	</thead>
	<tbody>

		<?php
			$ctr = 1; $name = 1;
			foreach ($q_members->result() as $member) {

		?>
		<tr>
			<td><?php echo $ctr; ?></td>
			<td><?php echo decr($member->first_name) ?></td>
			<td><?php echo decr($member->middle_name)?></td>
			<td><?php echo decr($member->last_name) ?></td>
			<td><?php echo $this->mod_registrations->get_ownership_name(decr($member->ownership_type)) ?></td>
			<td><?php echo $this->mod_registrations->get_subscription_name(decr($member->subscription_type)) ?></td>
			<td><?php echo decr($member->muncity) ?></td>
			<td><?php echo decr($member->brgy) ?></td>
			<td><?php echo $member->date_created ?></td>
			<td><?php echo $member->date_approved ?></td>
			<td><?php echo decr($this->mod_registrations->get_org_name($member->org_chapter)) . " [".$member->org_chapter. "]";?></td>
			<td>
				<!-- <a href="confirm_individual?id=<?php echo uencode($member->member_id) ?>" id="showList" class="btn btn-primary btn-sm btn-flat btn-rect"><i class="fa fa-clipboard"></i> Verify</a> -->
					<button type="button" id="btn" class="btn btn-primary btn-sm btn-flat btn-rect"><i class="fa fa-clipboard"></i> Verify</button>
			</td>
			<td>
				<a href="generate_user_code.php?id=<?php echo uencode($member->member_id) ?>" class="btn btn-primary btn-sm btn-flat btn-rect"><i class="fa fa-clipboard"></i> Confirm</a></td>
			</td>
		</tr>
			<?php
			$ctr++;
			}
		?>


	</tbody>
</table>

<div id="list">

	<table  class="table table-hover table-bordered" id="">
	 <thead>
		 <th>Particular</th>
		 <th>Amount</th>

	 </thead>

	 <tbody id="verify_members">

	 </tbody>
 </table>
</div>
<script>
$('.list').hide();

$('.verify-result tbody').on('click','#btn',function(){
	var currow = $(this).closest('tr');
	var fname = currow.find('td:eq(1)').text();
	var mname = currow.find('td:eq(2)').text();
	var lname = currow.find('td:eq(3)').text();

	$.ajax({
	url : "<?php echo site_url('registrations/verify_farmer')?>",
	type: "POST",
	dataType: "text",
	data : {lastname: lname, firstname: fname},
	success: function(response)
	{
		alert('success');
		$('#list').show();
		var obj = $.parseJSON(response);
		$.each(obj, function (index, object) {
				$('#verify_members').append('<tr><td>' + object['first_name'] + '</td>' + '<td>' + object['last_name'] + '</td></tr>');

		})

	},
	error: function (jqXHR, textStatus, errorThrown)
	{
			alert('Error getting data');
	}
	});
});


function verify(){
var currow = $(this).closest('tr');
var col1 = currow.find('td:eq(0)').text();

alert(col1);
	  $.ajax({
	  url : "<?php echo site_url('registrations/verify_farmer')?>",
	  type: "POST",
		dataType: "text",
		data : {lastname: "Qwerty", firstname: "Glenn"},
	  success: function(response)
	  {
	    alert('success');
			$('#list').show();
	    var obj = $.parseJSON(response);
      $.each(obj, function (index, object) {
          $('#verify_table').append('<tr><td>' + object['first_name'] + '</td>' + '<td>' + object['last_name'] + '</td></tr>');

      })

	  },
	  error: function (jqXHR, textStatus, errorThrown)
	  {
	      alert('Error getting data');
	  }
	  });

};
</script>
