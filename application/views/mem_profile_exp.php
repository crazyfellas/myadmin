<?php
  if(isset($_GET['farm_id'])){
    $f_id = udecode($_GET['farm_id']);

?>
<br/>
<a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#AddNewExpenses" onclick="new_activites()">+ New Expenses</a>
<?php


   $q_get_all_act = $this->db->query("select * from farm_expenses WHERE farm_id=".$f_id." ");

?>

<hr/>
  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-expenses">
    <thead>
      <tr>
        <th></th>
        <th>Date Purchased</th>
        <th>Product Category</th>
        <th>Product Name</th>
        <th>Amount</th>


      </tr>
    </thead>
    <tbody>
      <?php foreach($q_get_all_act->result() as $farm_act){ ?>
        <tr>
            <td><button type="button" class="btn btn-danger btn-xs btn-flat btn-rect btn-delete" id='<?php echo $farm_act->ce_id ?>'><i class="fa fa-trash-o"></i></button>
            <button type="button" class="btn btn-warning btn-xs btn-flat btn-rect btn-update" id='<?php echo $farm_act->ce_id ?>'><i class="fa fa-pencil"></i></button></td>
            <td><?php echo $farm_act->date_purchased ?></td>
            <td><?php echo $farm_act->prod_category ?></td>
            <td><?php echo $farm_act->prod_name ?></td>
            <td><?php echo number_format($farm_act->amount,2) ?></td>
        </tr>
      <?php }?>
    </tbody>
  </table>


<div class="modal fade" id="AddNewExpenses" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="cancel()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">New Crop to be Planted</h4>
      </div>
      <div class="modal-body" style="padding:20px;">
      	<?php $farm_id = udecode($_GET['farm_id']); ?>

		<form id="new_expenses_form" action="" method="post" class="form-horizontal">
			<input type="hidden" value="<?php echo $farm_id?>" id="farm_id" name="farm_id_exp"/>
      <input type="hidden" name="exp_id"/>

			<div class="alert alert-success alert-success-activity"></div>
		<?php if (isset($message)) { ?>
			<CENTER><h3 style="color:green;"><?php echo $message;?></h3></CENTER><br>
		<?php } ?>

    <div class="form-group row">
      <label for="staticEmail" class="col-sm-2 col-form-label">Date Purchased:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control datepicker"  name="dtpurchased" required=""/>
      </div>
      <label for="staticEmail" class="col-sm-2 col-form-label">Amount:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control number"  name="amount" required=""/>
      </div>
    </div>

    <div class="form-group row">

      <label for="staticEmail" class="col-sm-2 col-form-label">Product Category:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" name="proCat" required=""/>
      </div>

      <label for="staticEmail" class="col-sm-2 col-form-label" >Prodcut Name:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" name="proName" required=""/>
      </div>

    </div>

    <div class="form-group row">
      <label for="staticEmail" class="col-sm-12 col-form-label">Product Details:</label>
      <div class="col-sm-12">
        <textarea class="form-control" name="details"></textarea>
      </div>.
    </div>


    </div>
      <div class="modal-footer">
				<!-- <button type="submit" class="btn btn-info pull-right">Add Crop Batch</button> -->
				<button type="button" id="create_expenses" class="btn btn-primary pull-righ">Save Expenses</button>
        <button type="button" class="btn btn-default" onclick="cancel()">Close</button>
      </div>

        <?php echo form_close(); ?><br/>

      </div>
    </div>
  </div>
<?php }?>
