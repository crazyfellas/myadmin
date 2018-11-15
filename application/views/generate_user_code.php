<?php track_page(basename(__FILE__)) ?>


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

<?php
	$meber_id = udecode($_GET['id']); 
	$q_update_member = $this->db->query("select * from members where member_id =".$meber_id." LIMIT 1");

	foreach ($q_update_member->result() as $member) {
?>
<div class="panel panel-default">
    <div class="panel-heading">Confirm Farmer Registration</div>
    <div class="panel-body">

			<?php echo validation_errors(); ?>
			<?php echo form_open('registrations/generate_user_code?member_id='. $meber_id); ?>
			<div class="row">
				<div class="col-sm-4"> </div>
			    <div class="col-sm-4">
			    	<?php 
			    		echo strtoupper(decr($member->first_name) . " " . decr($member->middle_name) . " " . decr($member->last_name));
			    	?>
			    	<hr/>
			    	<?php input_text_form("User Code", "user_code", "user_code", "","",""); ?>
			        <?php update_date_form("Date of Approval", "date_approved", "date_approved",$member->date_approved ,""); ?>
			    	<br/>
			    	<input type="submit" class="btn btn-default" value="Complete Registration">
			    </div>
			    <div class="col-sm-4"> </div>
			</div>
			</form>
	</div>
    </div> <!--END <div class="panel-body">-->
</div>
<?php } //close foreach ?>