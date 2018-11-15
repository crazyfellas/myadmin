<?php
  if(isset($_GET['farm_id'])){
    $f_id = udecode($_GET['farm_id']);

?>
<br/>
<a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#AddNewBio" onclick="new_activites()">+ New Biodiversity</a>
<?php
   $q_get_all_act = $this->db->query("select * from biodiversity WHERE farm_id=".$f_id." ");
?>
<hr/>
  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-bio">
    <thead>
      <tr>
        <th></th>
        <th>Plant Category</th>
        <th>Plant Variety</th>
        <th>Plant Name</th>
        <th>Plant About</th>
        <th>Plant Count</th>

      </tr>
    </thead>
    <tbody>
      <?php foreach($q_get_all_act->result() as $farm_act){ ?>
        <tr>
            <td><button type="button" class="btn btn-danger btn-xs btn-flat btn-rect btn-delete" id='<?php echo $farm_act->bio_id ?>'><i class="fa fa-trash-o"></i></button>
            <button type="button" class="btn btn-warning btn-xs btn-flat btn-rect btn-update" id='<?php echo $farm_act->bio_id ?>'><i class="fa fa-pencil"></i></button></td>
            <td><?php echo $farm_act->plant_category ?></td>
            <td><?php echo $farm_act->plant_variety ?></td>
            <td><?php echo $farm_act->plant_name ?></td>
            <td><?php echo $farm_act->plant_about ?></td>
            <td><?php echo $farm_act->plant_count ?></td>
        </tr>
      <?php }?>
    </tbody>
  </table>


<div class="modal fade" id="AddNewBio" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="cancel()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">New Crop to be Planted</h4>
      </div>
      <div class="modal-body" style="padding:20px;">
      	<?php $farm_id = udecode($_GET['farm_id']); ?>

		<form id="new_bio_form" action="" method="post" class="form-horizontal">
			<input type="hidden" value="<?php echo $farm_id?>" id="farm_id" name="farm_id_bio"/>
      <input type="text" name="bio_id"/>

			<div class="alert alert-success alert-success-activity"></div>
		<?php if (isset($message)) { ?>
			<CENTER><h3 style="color:green;"><?php echo $message;?></h3></CENTER><br>
		<?php } ?>


    <div class="form-group row">
      <label for="staticEmail" class="col-sm-2 col-form-label">Plant Category:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control"  name="plant_cat" required=""/>
      </div>
      <label for="staticEmail" class="col-sm-2 col-form-label">Plant Variety:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control"  name="plant_var" required=""/>
      </div>
    </div>

    <div class="form-group row">
      <label for="staticEmail" class="col-sm-2 col-form-label">Plant Name:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control"  name="plant_name" required=""/>
      </div>
      <label for="staticEmail" class="col-sm-2 col-form-label">Plant About:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control"  name="plant_about" required=""/>
      </div>
    </div>

    <div class="form-group row">
      <label for="staticEmail" class="col-sm-2 col-form-label">Plant Count:</label>
      <div class="col-sm-4">
        <input type="number" class="form-control"  name="plant_count" required=""/>
      </div>
      <label for="staticEmail" class="col-sm-2 col-form-label">Crop Replacement:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control"  name="crop_rep" required=""/>
      </div>
    </div>

    <div class="form-group row" id="status_bio">
      <label for="staticEmail" class="col-sm-2 col-form-label">Status:</label>
      <div class="col-sm-4">
        <input type="checkbox" name="active" id="checkStatus">
      </div>
    </div>



    </div>
      <div class="modal-footer">
				<!-- <button type="submit" class="btn btn-info pull-right">Add Crop Batch</button> -->
				<button type="button" id="create_bio" class="btn btn-primary pull-righ">Save</button>
        <button type="button" class="btn btn-default" onclick="cancel()">Close</button>
      </div>

        <?php echo form_close(); ?><br/>

      </div>
    </div>
  </div>
<?php }?>
