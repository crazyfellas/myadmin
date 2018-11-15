
<?php
	$q_all_crops = $this->db->query("select * from lib_crops ORDER BY crop_id");
?>

<div class="row">
	<div class="col-md-12">
		<h4>
			Complete Crop Library <br/>


		</h4>

	</div>
</div>
<hr />
<a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#AddCropList" onclick="new_activites()">+ New Main Crop</a>
<br><br>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
	<thead>
		<tr>
			<th></th>
			<th>Crop Name</th>
			<th>Description</th>
			<th>Type</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($q_all_crops->result() as $acrop) { ?>
			<tr>
				<td>
					<button class="btn btn-danger btn-xs btn-flat btn-rect DeleteCrop" id='<?php echo $acrop->crop_id ?>'><i class="fa fa-trash-o"></i></button>
			
					<button class="btn btn-warning btn-xs btn-flat btn-rect EditCrop" id='<?php echo $acrop->crop_id ?>'><i class="fa fa-pencil-square-o"></i></button>

				</td>
				<td><a href="<?php base_url() ?>update-lib-crop?crop_id=<?php echo $acrop->crop_id ?>"><?php echo $acrop->name ?></a></td>
				<td><?php echo $acrop->desc ?></td>
				<td><?php echo $acrop->type ?></td>
				<td>
					<?php $status = $acrop->is_active;
								if($status==True){
									echo '<span class="label label-success-border">Active</span>';
								}else{
									echo '<span class="label label-danger-border">Not Active</span>';
								}
					?>
				</td>
			</tr>
		<?php }// close foreach ?>
	</tbody>
</table>

<!-- MODAL CREATE CROP LIB -->
<form id="create_maincrop">
<div class="modal fade" id="AddCropList" tabindex="-1" role="dialog" aria-labelledby="AddNewCrop"data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edit Crop to be Planted</h4>

      </div>
      <div class="modal-body" style="padding:20px;">
					<div class="alert alert-success"></div>
				<input type="hidden" id='crop_id' name="cropid"/>
				<div class="row">
					<div class="form-group">
						<label class="col-md-2">Crop Name</label>
						<div class="col-md-10">
							<input type="text" class="form-control" name="crop_name"/>
						</div>
					</div>
					<br><br>
					<div class="form-group">

						<label class="col-md-2">Crop Type</label>
						<div class="col-md-10">
							<select class="form-control" name="crop_type">

								<option value="Fruits">Fruits</option>
								<option value="Leafy">Leafy</option>
								<option value="Legumes">Legumes</option>
									<option value="Roots">Roots</option>
									<option value="Herbs">Herbs</option>
								<option value="Crucifer">Crucifer</option>
							</select>
						</div>
					</div>
					<br><br>
					<div class="form-group">

						<label class="col-md-2">Crop Description</label>
						<div class="col-md-10">
							<textarea class="form-control" name="desc"></textarea>
						</div>
					</div>
					<br><br><br>
					<div class="form-group">

						<label class="col-md-2">Active</label>
						<div class="col-md-10">
						<select class="form-control" name="is_active">
							<option value="true">Yes</option>
							<option value="false">No</option>
						</select>
					</div>
					</div>

			</div>
		  </div>
			<div class="modal-footer">
					<!-- <button type="submit" class="btn btn-info pull-right">Add Crop Batch</button> -->
					<button type="button" id="new_crop_list" class="btn btn-primary pull-righ">Save Crop</button>
	        <button type="button" class="btn btn-default" onclick="cancel()">Close</button>
	      </div>
				      </div>
				    </div>
				  </div>

</form>

<!-- END MODAL CREATE CROP LIB -->

<script>
//////////////////// ADD NEW CROP LIST /////////////////////////
$('#new_crop_list').on('click', function(){
	event.preventDefault();
	var DataString=$("#create_maincrop").serialize();

$.ajax({
	url : "<?php echo 'crops/create_main_crop/'?>",
	method: "POST",
	data: DataString,
	dataType: "JSON",
 success:function(data)
	{

		if( !$('[name="cropid"]').val() ) {
			$('.alert-success').html('<center><b>Activity successfully added</b></center>').fadeIn().delay(4000).fadeOut('slow');
      $("#create_maincrop")[0].reset();
		}else{
			$('.alert-success').html('<center><b>Activity successfully updated</b></center>').fadeIn().delay(4000).fadeOut('slow');
		}

	},
	error: function (jqXHR, textStatus, errorThrown)
	{
			alert('Error adding crop!');

	}
	});
});
//////////////////// END ADD NEW CROP LIST /////////////////////////

//////////////////// FETCH CROP LIST /////////////////////////
$('.EditCrop').on('click', function(){

	var id = $(this).attr('id');
	$('#AddCropList').modal('show');
	$.ajax({
		url : "<?php echo 'crops/fetch_main_crop/'?>" + id,
		method: "POST",
		dataType: "JSON",
	 success:function(data)
		{

			//alert(data.is_active);
			$('[name="cropid"]').val(data.crop_id);
			$('[name="crop_name"]').val(data.name);
			$('[name="desc"]').val(data.desc);
			$('[name="crop_type"]').val(data.type);
				// $('[name="is_active"]').val(data.is_active);
			if(data.is_active=="1"){
				$('[name="is_active"]').val('true');
			}
			else{
				$('[name="is_active"]').val('false');
			}
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
				alert('Error fetch data!');

		}
		});
});
//////////////////// END FETCH CROP LIST /////////////////////////


//////////////////// DELETE CROP LIST /////////////////////////
$('.DeleteCrop').on('click', function(){
var id = $(this).attr('id');
alert(id);
	// $.ajax({
	// 	url : "<?php echo 'crops/delete_main_crop/'?>" + id,
	// 	method: "GET",
	// 	dataType: "JSON",
	// 	success:function(data){
	// 		alert('success');
	// 	},
	// 	error: function()
	// 	{
	// 		alert('Error delete data');
	// 	}
	// });

	$.ajax({
		url : "<?php echo site_url('crops/delete_main_crop')?>/" + id,
		type: "GET",
		dataType: "JSON",
		success: function(data)
		{
				alert('success');

		},
		error: function (jqXHR, textStatus, errorThrown)
		{
				alert('Error deleting data ');
		}
		});


});
//////////////////// END DELETE CROP LIST /////////////////////////

function cancel(){
	location.reload();
	$('#AddCropList').modal('hide');
}
</script>
