<?php

    //check if userdata is set
    if(isset($_SESSION['email'])){


    }else{
        redirect('login');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tiklis</title>

    <!-- jQuery the menu will break if this will be changed-->
    <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
    <!-- Bootstrap Core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <!-- MetisMenu CSS ok-->
    <link href="<?php echo base_url() ?>assets/css/main.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS ok-->
    <link href="<?php echo base_url() ?>assets/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo base_url('assets/js/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');?>">
    <!-- load google charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url() ?>index"><i class="fa fa-gears fa-fw"></i> Tiklis Admin Panel</a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <?php
                    if($_SESSION['system_access_lvl'] == 1){
                ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-calendar fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-calendar fa-fw"></i> Audit Trails
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-unlock-alt"></i><i class="fa fa-users fa-fw"></i> Confirmation <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="<?php echo base_url() ?>confirm-farmer">
                                <div>
                                    <i class="fa fa-check"></i><i class="fa fa-user fa-fw"></i>
                                    <span class="pull-right text-muted small">Individual</span>
                                </div>
                            </a>
                        </li>

                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-plus fa-fw"></i><i class="fa fa-users fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="<?php echo base_url() ?>create-user">
                                <div>
                                    <i class="fa fa-plus fa-fw"></i> User
                                    <span class="pull-right text-muted small">Create System User</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo base_url() ?>profile-user">
                                <div>
                                    <i class="fa fa-user fa-fw"></i> User
                                    <span class="pull-right text-muted small">List of System User</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <?php } //close IF ?>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['full_name'] ?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo base_url() ?>user-profile"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="<?php echo base_url() ?>user-setting"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url() ?>sys/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                         <li class="active">
                            <a href="<?php echo base_url() ?>index"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <?php if($_SESSION['system_access_lvl'] == 3 || $_SESSION['system_access_lvl'] == 4 || $_SESSION['system_access_lvl'] == 6 ){ ?>
                             <li><a href="<?php echo base_url() ?>profile-individual"><i class="fa fa-user fa-fw"></i> Farmers</a></li>
                             <li><a href="<?php echo base_url() ?>profile-organizations"><i class="fa fa-bank fa-fw"></i> Organizations</a></li>
                        <?php } ?>
                        <?php if($_SESSION['system_access_lvl'] == 1){  ?>
                        <li>
                            <a href="#"><i class="fa fa-file-text-o fa-fw"></i> Registrations<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url()?>client-register"><i class="fa fa-user fa-fw"></i> Individuals </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>org-register"><i class="fa fa-sitemap fa-fw"></i> Organizations</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-briefcase fa-fw"></i> Profiles<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url()?>profile-individual"><i class="fa fa-user"></i> Farmers</a>
                                </li>
<!--                                 <li>
                                    <a href="<?php echo base_url()?>profile-financier"><i class="fa fa-user"></i> Financiers</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>profile-data-user"><i class="fa fa-user"></i> Data Users</a>
                                </li> -->
                                <li>
                                    <a href="<?php echo base_url()?>profile-organization-lists"><i class="fa fa-sitemap"></i>Private Organizations</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>profile-govtoffice"><i class="fa fa-sitemap"></i> Govt. Offices</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <?php } //close if ?>
                         <?php if($_SESSION['system_access_lvl'] == 1 || $_SESSION['system_access_lvl'] == 2 ){  ?>
                        <li>
                            <a href="#"><i class="fa fa-barcode fa-fw"></i> Libraries<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#"><i class="fa fa-leaf"></i> Crops <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="<?php echo base_url()?>lib_crops"><i class="fa fa-th-list"></i> Crop Library</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-key"></i> Farm Management <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Management</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <?php } //close if ?>
                        <li>
                            <a href="#"><i class="fa fa-life-saver"></i> Help<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#"><i class="fa fa-question"></i> How To's <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-wrench"></i> Work Arounds</a>
                                </li>
                                <li>
                                    <a href="#">Others</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#">
                                <p>
                                    &copy;  Tiklis Enterprises &nbsp; 2017 &nbsp;
                                    <br/>
                                    <small>
                                        Version: 3.3 Rel 34818
                                    </small>
                                </p>
                            </a>

                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 test_table">
