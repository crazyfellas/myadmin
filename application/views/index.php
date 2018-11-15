<?php track_page(basename(__FILE__)) ?>
<?php echo validation_errors(); ?>
<?php var_dump($_SESSION); ?>

<?php 

$day 			=  date("w");
$week_start 	= date('m-d-Y', strtotime('-'.$day.' days'));
$week_end 		= date('m-d-Y', strtotime('+'.(6-$day).' days'));
$week_range 	= "From ". $week_start . " to ". $week_end;
$org_chapter = $_SESSION['org_chapter'];
$region 		= $_SESSION['region'];
$province 		= $_SESSION['province'];
$muncity 		= $_SESSION['muncity'];

$q_get_crops = $this->db
              ->select('region, province, muncity, main_crop, crop_cycle_category, sum(yield_estimate) AS y_estimate,  sum(yield_actual) AS y_actual,  sum(soc_damages_in_kg) AS  soc')
             
              ->group_by('region')
              ->group_by('province')
              ->group_by('muncity')
              ->group_by('main_crop')
              ->group_by('crop_cycle_category')
              ->order_by('y_estimate', 'desc')
              ->get('cultivated_crops');

//farmers
$farmers = $this->db
			->select('member_id')
			->where('member_grp = ', 1)
			
			->get('members');
//crops
$crops = $this->db
            ->select('cc_id')
           
            ->get('cultivated_crops');
//orgs
$orgs = $this->db
            ->select('org_id')
            
            ->get('organizations');
//farms
$farms = $this->db
            ->select('farm_id')
            ->where('is_active = ', TRUE)
            
            ->get('farms');

?>

<script type="text/javascript">
	google.charts.load('current', {'packages':['bar']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Main Crop', 'Est. Planted Crops', 'Actual Harvest', 'State of Calamity'],
            //this is where it will query
            <?php 
          	foreach ($q_get_crops->result() as $hcrop) {
          		if(decr($hcrop->region) == $_SESSION['region'] && decr($hcrop->province) == $_SESSION['province'] && decr($hcrop->muncity) == $_SESSION['muncity']){
          	?>
         			['<?php echo decr($hcrop->main_crop)?>', <?php echo $hcrop->y_estimate ?>, <?php echo $hcrop->y_actual ?>, <?php echo $hcrop->soc ?>],
	            <?php
	          	} //close if
	            ?>
          <?php } //close foreach ?>
		]);

		var options = {
			chart: {
				title: 'Vegetables Performances from <?php echo  $week_range?>',
				subtitle: 'Est. Planted Crops VS Actual Harvested Crops',
			}
		};

		var chart = new google.charts.Bar(document.getElementById('columnchart_muncity'));
		chart.draw(data, google.charts.Bar.convertOptions(options));
	}
</script>

<?php 
	$org = $this->db->query("select * from organizations where org_code = '".$_SESSION['org_chapter']."' LIMIT 1");
	foreach ($org->result() as $org) {
		//echo decr($org->org_name) . "<br/>";
	}
?>
<?php if($_SESSION['system_access_lvl'] == 1){ ?>
<h3>Administration Dashboard</h3>
<hr/>
<!-- /.row -->
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-map fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $farms->num_rows();?></div>
                        <div>New Farms</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Farms</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-leaf fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $crops->num_rows();?></div>
                        <div>New Crops Planted</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Crops</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-bank fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $orgs->num_rows();?></div>
                        <div>New Organizations</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Organizations</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user-circle-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $farmers->num_rows();?></div>
                        <div>New Farmers</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Farmers</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- /.row -->
<hr/>
<?php } //close if | ADMINISTRATOR ?>

<div class="row">
	<h4><?php //echo $_SESSION['muncity'] . ", " . $_SESSION['province']?></h4>
		<div id="columnchart_muncity" style="min-width: 800px; min-height: 500px;"></div>
	</div>
</div>
