
$('#myTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})


$(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });

    $('.alert-success').hide();
});

function show_tabs(){
  $('#tabs').show();
}

////////////////// REFERSH Tab
$(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }
});

///////////////// END REFRESH TAB

//this is to pass a value from modal. UPDATE CROP
$(document).on("click", ".fetchCCropID", function () {
     var myCCropId = $(this).data('id');
     // alert(myCCropId);
     console.log(myCCropId);
     $(".modal-body #crop_cultivated_id").val(myCCropId);
});


///////////////// MAJOR CROP TAB /////////////////

$('#create').on('click', function(){
	var id = $('#farm_id').val();
  var DataString=$("#new_crop_form").serialize();


$.ajax({
  url : "crops/create_batch_crop/" + id,
  method: "POST",
  data: DataString,
  dataType: "JSON",
 success:function(data)
  {
    $("#new_crop_form")[0].reset();
		$('#crop_batch').append('<tr><td><a class="btn btn-danger btn-xs btn-flat btn-rect" href=""><i class="fa fa-trash-o"></i></a>'+data.main_crop+'</td><td>'+data.crop_variety+'</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>');
    $('.alert-success').html('Crop successfully added').fadeIn().delay(4000).fadeOut('slow');

  },
  error: function (jqXHR, textStatus, errorThrown)
  {
      alert('Error adding crop!');

  }
  });
});

//////////////////////////// EDIT MAJOR CROP ////////////////////////////

$('.EditMajorCrop').on('click',function(){

    $('#EditMajorCrop').modal('show');

    var id = $(this).attr('id');
    var status = $('#status'+id).val();


     $.ajax({
       url : "crops/fetch_MainCrops/" + id,
       type: "GET",
       dataType: "JSON",
       success: function(data)
       {


         $.ajax({
           url : "crops/fetch_cropStatus/",
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
             $('#cropStatusList').empty();
             $.each(data, function(key, value) {
                 $('#cropStatusList').append('<option value="'+ value.cs_id +'">'+ value.cs_name +'</option>');
             });

             $('#cropStatusList').val(status);
           },
           error: function (jqXHR, textStatus, errorThrown)
           {
               alert('Error fetch data');
           }
         });

         $.ajax({
           url : "crops/fetch_calamity/",
           type: "GET",
           dataType: "JSON",
           success: function(data)
           {
             $('#calamityList').empty();
             $.each(data, function(key, value) {
                 $('#calamityList').append('<option value="'+ value.soc_id +'">'+ value.soc_name +'</option>');
             });

             $('#calamityList').val(status);
           },
           error: function (jqXHR, textStatus, errorThrown)
           {
               alert('Error fetch data');
           }
         });


          $('#cid').val(id);
          $('[name="planted_start"]').val(data.date_planted);
          $('[name="planted_end"]').val(data.date_planted_end);
          $('[name="damage_kg"]').val(data.soc_damages_in_kg);
          $('[name="damage_cash"]').val(data.soc_damages_in_cash);

       },
       error: function (jqXHR, textStatus, errorThrown)
       {
           alert('Error deleting data');
       }
     });
});


$('#btn_edit_crop').on('click', function(){

	 var id = $('#cid').val();
   var DataString=$("#edit_crop_batch").serialize();
$.ajax({
  url : "crops/update_batch_crop/" + id,
  method: "POST",
  data: DataString,
  dataType: "JSON",
 success:function(data)
  {
    $('.alert-success').html('updated successfully').fadeIn().delay(4000).fadeOut('slow');

  },
  error: function (jqXHR, textStatus, errorThrown)
  {
      alert('Error udpating crop!');

  }
  });
});

//////////////////////////// END EDIT MAJOR CROP ////////////////////////////

//////////////////////////// DELETE MAJOR CROP

$('#dataTables-example').on('click','.DeleteMajorCrop',function(){
      var r = confirm("Are you sure you want to delete?!");
      if (r == true) {
        var id = $(this).attr('id');

       $(this).closest('tr').remove();
       $.ajax({
         url : "crops/delete_batch_crop/" + id,
         method: "GET",
         dataType: "JSON",
        success:function(data)
         {

         },
         error: function (jqXHR, textStatus, errorThrown)
         {
             alert('Error deleting crop!');

         }
         });
      }
});
//////////////////////////// END DELETE MAJOR CROP


////////////// END MAJOR CROP TAB ////////////////////

//////////////////////////////////////////////// ACTIVITIES TAB //////////////////////////////////////////////////////

function new_activites(){
  $("#new_activites_form")[0].reset();
}

///////////// SAVE ACTIVITES
var table=$('#dataTables-activity');

$('#create_activities').on('click', function(){
	event.preventDefault();
	var DataString=$("#new_activites_form").serialize();

	var encoder = $("input[name='encoder']").val();
	var category = $("input[name='category']").val();
	var sub_category = $("input[name='sub_category']").val();

	var d = new Date();
	var date_encoded = d.getFullYear() +"-"+ d.getMonth()+"-"+d.getDate();

	var id = $('[name="act_id"]').val();



$.ajax({
	url : "crops/create_batch_activity/",
	method: "POST",
	data: DataString,
	dataType: "JSON",
 success:function(data)
	{
		if( !$('[name="act_id"]').val() ) {
			$('.alert-success-activity').html('Activity successfully added').fadeIn().delay(4000).fadeOut('slow');
			var markup = '<tr><td><button type="button" class="btn btn-danger btn-xs btn-flat btn-rect btn-delete" id=""><i class="fa fa-trash-o"></i></button><button type="button" class="btn btn-warning btn-xs btn-flat btn-rect btn-update" id=""><i class="fa fa-pencil"></i></button></td><td>'+encoder+'</td><td>'+date_encoded+'</td><td>'+category+'</td><td>'+sub_category+'</td></tr>';
			$("#dataTables-activity tbody").append(markup);
      $("#new_activites_form")[0].reset();
		}else{
			$('.alert-success-activity').html('Activity successfully updated').fadeIn().delay(4000).fadeOut('slow');
		}



	},
	error: function (jqXHR, textStatus, errorThrown)
	{
			alert('Error adding activity!');

	}
	});

});

///////////////// EDIT ACTIVITIES
$('#dataTables-activity').on('click','.btn-update',function(){

$('#AddNewActivities').modal('show');
		var id = $(this).attr('id');
	 $.ajax({
			url : "crops/fetch_batch_activity/" + id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				$('[name="act_id"]').val(data.fa_id);
				$('[name="encoder"]').val(data.encoded_by);
				$('[name="category"]').val(data.prep_category);
				$('[name="sub_category"]').val(data.prep_category_sub);
				$('[name="details"]').val(data.details);

			},
			error: function (jqXHR, textStatus, errorThrown)
			{
					alert('Error deleting data');
			}
			});

});

////////////// DELETE ACTIVITES
	$('#dataTables-activity').on('click','.btn-delete',function(){
	  var r = confirm("Are you sure you want to delete?!");
    if (r == true) {
			var id = $(this).attr('id');

		 $(this).closest('tr').remove();
		 $.ajax({
				url : "crops/delete_batch_activity/" + id,
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{

				},
				error: function (jqXHR, textStatus, errorThrown)
				{
						alert('Error deleting data');
				}
				});
    }
	});


//// CANCEL RELOAD page
function cancel(){
	location.reload();
	$('#AddNewActivities').modal('hide');
}


//////////////////////////////////////////////// END ACTIVITIES TAB //////////////////////////////////////////////////////


//////////////////////////////////////////////// EXPENSES TAB //////////////////////////////////////////////////////

function new_expenses(){
  $("#new_expenses_form")[0].reset();
}

///////////// SAVE EXPENSES

$('#create_expenses').on('click', function(){
	event.preventDefault();
	var DataString=$("#new_expenses_form").serialize();

$.ajax({
	url : "crops/create_batch_expenses/",
	method: "POST",
	data: DataString,
	dataType: "JSON",
 success:function(data)
	{

		if( !$('[name="exp_id"]').val() ) {
			$('.alert-success-activity').html('<center><b>Activity successfully added</b></center>').fadeIn().delay(4000).fadeOut('slow');
			var markup = '<tr><td><button type="button" class="btn btn-danger btn-xs btn-flat btn-rect btn-delete" id=""><i class="fa fa-trash-o"></i></button><button type="button" class="btn btn-warning btn-xs btn-flat btn-rect btn-update" id=""><i class="fa fa-pencil"></i></button></td><td>'+$('[name="dtpurchased"]').val()+'</td><td>'+$('[name="proCat"]').val()+'</td><td>'+$('[name="proName"]').val()+'</td><td>'+$('[name="amount"]').val()+'</td></tr>';
			$("#dataTables-expenses tbody").append(markup);
      $("#new_expenses_form")[0].reset();
		}else{
			$('.alert-success-activity').html('<center><b>Activity successfully updated</b></center>').fadeIn().delay(4000).fadeOut('slow');
		}

	},
	error: function (jqXHR, textStatus, errorThrown)
	{
			alert('Error adding activity!');

	}
	});

});

///////////////// EDIT EXPENSES
$('#dataTables-expenses').on('click','.btn-update',function(){

$('#AddNewExpenses').modal('show');
		var id = $(this).attr('id');
	 $.ajax({
			url : "crops/fetch_batch_expenses/" + id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				$('[name="exp_id"]').val(data.ce_id);
				$('[name="dtpurchased"]').val(data.date_purchased);
				$('[name="amount"]').val(data.amount);
				$('[name="proCat"]').val(data.prod_category);
        $('[name="proName"]').val(data.prod_name);
				$('[name="details"]').val(data.prod_details);

			},
			error: function (jqXHR, textStatus, errorThrown)
			{
					alert('Error fetching data');
			}
			});

});

////////////// DELETE EXPENSES
	$('#dataTables-expenses').on('click','.btn-delete',function(){
	  var r = confirm("Are you sure you want to delete?!");
    if (r == true) {
			var id = $(this).attr('id');

		 $(this).closest('tr').remove();
		 $.ajax({
				url : "crops/delete_batch_expenses/" + id,
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{

				},
				error: function (jqXHR, textStatus, errorThrown)
				{
						alert('Error deleting data');
				}
				});
    }
	});


//// CANCEL RELOAD page
function cancel(){
	location.reload();
	$('#AddNewActivities').modal('hide');
}


//////////////////////////////////////////////// END EXPENSES TAB //////////////////////////////////////////////////////


//////////////////////////////////////////////// BIODIVERSITY TAB //////////////////////////////////////////////////////


$(document).ready(function() {
$('#status_bio').hide();

});
function new_bio(){
  $("#new_bio_form")[0].reset();
}

///////////// SAVE BIO

$('#create_bio').on('click', function(){

	event.preventDefault();
	var DataString=$("#new_bio_form").serialize();

$.ajax({
	url : "crops/create_batch_biodiversity/",
	method: "POST",
	data: DataString,
	dataType: "JSON",
 success:function(data)
	{

		if( !$('[name="bio_id"]').val() ) {
			$('.alert-success-activity').html('<center><b>Activity successfully added</b></center>').fadeIn().delay(4000).fadeOut('slow');
			var markup = '<tr><td><button type="button" class="btn btn-danger btn-xs btn-flat btn-rect btn-delete" id=""><i class="fa fa-trash-o"></i></button><button type="button" class="btn btn-warning btn-xs btn-flat btn-rect btn-update" id=""><i class="fa fa-pencil"></i></button></td><td>'+$('[name="plant_cat"]').val()+'</td><td>'+$('[name="plant_var"]').val()+'</td><td>'+$('[name="plant_name"]').val()+'</td><td>'+$('[name="plant_about"]').val()+'</td><td>'+$('[name="plant_count"]').val()+'</td></tr>';
			$("#dataTables-bio tbody").append(markup);
      $("#new_bio_form")[0].reset();
		}else{
			$('.alert-success-activity').html('<center><b>Activity successfully updated</b></center>').fadeIn().delay(4000).fadeOut('slow');
		}



	},
	error: function (jqXHR, textStatus, errorThrown)
	{
			alert('Error adding activity!');

	}
	});

});

///////////////// EDIT BIO
$('#dataTables-bio').on('click','.btn-update',function(){

$('#AddNewBio').modal('show');
		var id = $(this).attr('id');

	 $.ajax({
			url : "crops/fetch_batch_biodiversity/" + id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{
				$('[name="bio_id"]').val(data.bio_id);
        $('[name="plant_cat"]').val(data.plant_category);
        $('[name="plant_var"]').val(data.plant_variety);
        $('[name="plant_name"]').val(data.plant_name);
        $('[name="plant_about"]').val(data.plant_about);
        $('[name="plant_count"]').val(data.plant_count);
        $('[name="crop_rep"]').val(data.crop_replacement);

			},
			error: function (jqXHR, textStatus, errorThrown)
			{
					alert('Error fetching data');
			}
			});

});

////////////// DELETE BIO
	$('#dataTables-bio').on('click','.btn-delete',function(){
	  var r = confirm("Are you sure you want to delete?!");
    if (r == true) {
			var id = $(this).attr('id');

		 $(this).closest('tr').remove();
		 $.ajax({
				url : "crops/delete_batch_biodiversity/" + id,
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{

				},
				error: function (jqXHR, textStatus, errorThrown)
				{
						alert('Error deleting data');
				}
				});
    }
	});


//// CANCEL RELOAD page
function cancel(){
	location.reload();
	$('#AddNewActivities').modal('hide');
}


//////////////////////////////////////////////// END BIODIVERSITY TAB //////////////////////////////////////////////////////
