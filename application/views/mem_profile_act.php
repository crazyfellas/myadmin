<?php
  if(isset($_GET['farm_id'])){
    $f_id = udecode($_GET['farm_id']);

?>
<br/>
<a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#AddNewActivities" onclick="new_activites()">+ New Activities</a>
<?php


   $q_get_all_act = $this->db->query("select * from farm_activities WHERE farm_id=".$f_id." ");

?>

<hr/>
  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-activity">
    <thead>
      <tr>
        <th></th>
        <th>Encoded</th>
        <th>Date Encoded</th>
        <th>Category</th>
        <th>Sub Category</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($q_get_all_act->result() as $farm_act){ ?>
        <tr>
            <td><button type="button" class="btn btn-danger btn-xs btn-flat btn-rect btn-delete" id='<?php echo $farm_act->fa_id ?>'><i class="fa fa-trash-o"></i></button>
            <button type="button" class="btn btn-warning btn-xs btn-flat btn-rect btn-update" id='<?php echo $farm_act->fa_id ?>'><i class="fa fa-pencil"></i></button></td>
            <td><?php echo $farm_act->encoded_by ?></td>
            <td><?php echo $farm_act->date_encoded ?></td>
            <td><?php echo $farm_act->prep_category ?></td>
            <td><?php echo $farm_act->prep_category_sub ?></td>
        </tr>
      <?php }?>
    </tbody>
  </table>


<div class="modal fade" id="AddNewActivities" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="cancel()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">New Crop to be Planted</h4>
      </div>
      <div class="modal-body" style="padding:20px;">
      	<?php $farm_id = udecode($_GET['farm_id']); ?>

		<form id="new_activites_form" action="" method="post" class="form-horizontal">
			<input type="hidden" value="<?php echo $farm_id?>" id="farm_id" name="farm_id_act"/>
      <input type="hidden" name="act_id"/>

			<div class="alert alert-success alert-success-activity"></div>
		<?php if (isset($message)) { ?>
			<CENTER><h3 style="color:green;"><?php echo $message;?></h3></CENTER><br>
		<?php } ?>

    <div class="form-group row">
      <label for="staticEmail" class="col-sm-3 col-form-label">Encoded By:</label>
      <div class="col-sm-9">
        <input type="text" class="form-control"  name="encoder" value="<?php echo $_SESSION['full_name'] ?>"/>
      </div>
    </div>

    <div class="form-group row">

      <label for="staticEmail" class="col-sm-3 col-form-label">Prep Category:</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="category"/>
      </div>

    </div>

    <div class="form-group row">
      <label for="staticEmail" class="col-sm-3 col-form-label" >Prep Sub-Category:</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="sub_category" />
      </div>
    </div>

    <div class="form-group row">
      <label for="staticEmail" class="col-sm-3 col-form-label">Details:</label>
      <div class="col-sm-9">
        <textarea class="form-control" name="details"></textarea>
      </div>.
    </div>

    </div>
      <div class="modal-footer">
				<!-- <button type="submit" class="btn btn-info pull-right">Add Crop Batch</button> -->
				<button type="button" id="create_activities" class="btn btn-primary pull-righ">Save Activity</button>
        <button type="button" class="btn btn-default" onclick="cancel()">Close</button>
      </div>

        <?php echo form_close(); ?><br/>

      </div>
    </div>
  </div>
<?php }?>
