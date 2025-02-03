<?php
session_start();
error_reporting(0);
include("./include/config.php");
if(strlen($_SESSION['alogin'])==0){
    echo "<script>alert('Login Please!')</script>";
    header('location:home.php');
  }
  else{
    date_default_timezone_set('Asia/Kolkata'); //change according to timezone
    $currentTime = date('d-m-Y h:i:s A', time () );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="css/theme.css" rel="stylesheet">
        <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
            rel='stylesheet'>
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="#">Admin</a>
                    <div class="nav-collapse collapse navbar-inverse-collapse">
                        <ul class="nav pull-right">
                            <li class="nav-user dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="images/user.png" class="nav-avatar" />
                                <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="password.php"><i class="menu-icon icon-cog"></i>Change Password</a></li>
                                    <li><a href="logout.php"><i class="menu-icon icon-signout"></i>Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /.nav-collapse -->
                </div>
            </div>
            <!-- /navbar-inner -->
        </div>
        <!-- /navbar -->
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="span3">
                        <div class="sidebar">
                            <ul class="widget widget-menu unstyled">
                                <li class="active"><a href="dashboard.php"><i class="menu-icon icon-dashboard"></i>Dashboard</a></li>
                                <li><a href="booking.php"><i class="menu-icon icon-inbox"></i>Booking Query<b class="label green pull-right">
                                <?php
                                    $sql=mysqli_query($con, "SELECT * FROM bookingquery WHERE Status='Pending'");
                                    $cnt=mysqli_num_rows($sql);
                                    if($cnt>0){
                                        echo $cnt;
                                    } 
                                    ?>
                                </b></a></li>
                                <li><a href="destinations.php"><i class="menu-icon icon-map-marker"></i>Destination</a></li>
                            </ul>
                             <!--/.widget-nav-->
                             <ul class="widget widget-menu unstyled">
                                <li><a class="collapsed" data-toggle="collapse" href="#togglePages"><i class="menu-icon icon-tasks"></i>
                                <i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right">
                                </i class="active">Packages</a>
                                    <ul id="togglePages" class="collapse unstyled">
                                        <li><a href="packages.php"><i class="menu-icon icon-tasks"></i>Packages List</a></li>
                                        <li><a href="addpackage.php"><i class="menu-icon icon-tasks"></i>Add New Package</a></li>
                                    </ul>
                                </li>
                             </ul>
                             <ul class="widget widget-menu unstyled">
                                <li><a href="feedback.php"><i class="menu-icon icon-envelope"></i>FeedBack<b class="label orange pull-right">
                                    <?php
                                    $sql=mysqli_query($con, "SELECT * FROM feedback WHERE Status='UnPublished'");
                                    $cnt=mysqli_num_rows($sql);
                                    if($cnt>0){
                                        echo $cnt;
                                    }
                                    ?>
                                </b></a></li>
                            </ul>
                            <!--/.widget-nav-->
                        </div>
                        <!--/.sidebar-->
                    </div>
                    <!--/.span3-->
                    <div class="span9">
                        <div class="content">
                            <div class="btn-controls">
                                <div class="btn-box-row row-fluid">
                                    <?php 
                                    $sql=mysqli_query($con,"SELECT * FROM destination");
                                    $cnt=mysqli_num_rows($sql); ?>
                                    <a href="#" class="btn-box big span4"><i class=" icon-random"></i><b><?php echo $cnt; ?></b>
                                        <p class="text-muted">Destinations</p>
                                    </a>
                                    <?php 
                                    $sql=mysqli_query($con,"SELECT * FROM packages");
                                    $cnt=mysqli_num_rows($sql); ?>
                                    <a href="#" class="btn-box big span4"><i class="icon-tasks"></i><b><?php echo $cnt; ?></b>
                                        <p class="text-muted">Packages</p>
                                    </a>
                                    <?php 
                                    $sql=mysqli_query($con,"SELECT * FROM bookingquery");
                                    $cnt=mysqli_num_rows($sql); ?>
                                    <a href="#" class="btn-box big span4"><i class="icon-inbox"></i><b><?php echo $cnt; ?></b>
                                        <p class="text-muted">Bookings</p>
                                    </a> 
                                </div>
                                <div class="btn-box-row row-fluid">
                                    <div class="span9">
                                        <div class="row-fluid">
                                            <b>FeedBacks</b>
                                            <div class="span12">
                                                <?php 
                                                $sql=mysqli_query($con,"SELECT * FROM feedback");
                                                $cnt=mysqli_num_rows($sql); ?>
                                                <a href="#" class="btn-box small span4"><i class="icon-envelope"></i><b><?php echo $cnt; ?></b><b>Total</b></a>
                                                <?php
                                                $sql=mysqli_query($con, "SELECT * FROM feedback WHERE Status='Active'");
                                                $cnt=mysqli_num_rows($sql);
                                                ?>
                                                <a href="#" class="btn-box small span4"><i class="icon-envelope "></i><b><?php echo $cnt; ?></b><b>Published</b></a>
                                                <?php
                                                $sql=mysqli_query($con, "SELECT * FROM feedback WHERE Status='Pending'");
                                                $cnt=mysqli_num_rows($sql);
                                                ?>
                                                <a href="#" class="btn-box small span4"><i class="icon-envelope"></i><b><?php echo $cnt; ?></b><b>Under Review</b></a>
                                            </div>
                                        </div>
                                    
                                        <div class="row-fluid">
                                            <b>Packages</b>
                                            <div class="span12">
                                            <?php 
                                                $sql=mysqli_query($con,"SELECT * FROM packages");
                                                $cnt=mysqli_num_rows($sql); ?>
                                                <a href="#" class="btn-box small span4"><i class="icon-tasks"></i><b><?php echo $cnt; ?></b><b>Total</b></a>
                                                <?php 
                                                $sql=mysqli_query($con,"SELECT * FROM packages WHERE Status='Active'");
                                                $cnt=mysqli_num_rows($sql); ?>
                                                <a href="#" class="btn-box small span4"><i class="icon-tasks"></i><b><?php echo $cnt; ?></b><b>Active</b></a>
                                                <?php 
                                                $sql=mysqli_query($con,"SELECT * FROM feedback WHERE Status='Pending'");
                                                $cnt=mysqli_num_rows($sql); ?>
                                                <a href="#" class="btn-box small span4"><i class="icon-tasks"></i><b><?php echo $cnt; ?></b><b>InActive</b></a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <!--/.content-->
                    </div>
                    <!--/.span9-->
                </div>
            </div>
            <!--/.container-->
        </div>
        <!--/.wrapper-->
        <div class="footer">
            <div class="container">
                <b class="copyright">&copy; <span id="year"></span> Himalayanbagpackers</b> All rights reserved.
                <b class="pull-right">Designed By: EGrappler.com</b>
            </div>
        </div>
        <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
        <script src="scripts/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="scripts/common.js" type="text/javascript"></script>
        <script>
            document.getElementById('year').textContent = new Date().getFullYear();
        </script>
    </body>
</html>
  <?php } ?>