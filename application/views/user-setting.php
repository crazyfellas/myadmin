<?php track_page(basename(__FILE__)) ?>
<h4>Change Password</h4>
<hr/>
	<?php echo validation_errors(); ?>
	<?php echo form_open('sys/change_user_pw'); ?>
	<div class="row">
	    <div class="col-sm-6 col-sm-offset-3">
		<?php if (isset($message)) { ?>
			<CENTER><h3 style="color:green;"><?php echo $message;?></h3></CENTER><br>
		<?php } ?>
			<p>Change Password</p>
		    <div class="form-group">
		        <label for="new_password" class="control-label">New Password</label>
		        <input type="password" class="form-control" id="new_password" name="new_password" />
		    </div>
		    <div class="form-group">
		        <label for="confirm_password" class="control-label">Confirm Password</label>
		        <input type="password" class="form-control" id="confirm_password" name="confirm_password" />
		    </div>

		<div class="form-group">
			<input type="submit" class="btn btn-default" value="Change Password">
		</div>
	    </div>
	</div>
	</form>