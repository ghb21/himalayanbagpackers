<?php
 session_start();
 error_reporting(0);
 include("./include/config.php");
 if(strlen($_SESSION['alogin'])==0){
    header('location:home.php');
 }
 else{
   date_default_timezone_set('Asia/Kolkata'); //change according to timezone
   $currentTime = date('d-m-Y h:i:s A', time () );
   if(isset($_GET['b_id'])&& $_GET['action']=='approve'){ 
        $status='Active';
        $query=mysqli_query($con,"UPDATE bookingquery SET Status='$status' WHERE Id=$_GET[b_id]");
        header('location:booking.php');
        if($query){
        echo "<script>alert('Booking Successfully Placed')</script>";
        }
    }
    elseif(isset($_GET['b_id'])&& $_GET['action']=='can'){
        $status='Cancled';
        $query=mysqli_query($con,"UPDATE bookingquery SET Status='$status' WHERE Id=$_GET[b_id]");
        header('location:booking.php');
        if($query){
        echo "<script>alert('Booking Successfully Cancled')</script>";
        }
    }
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
                                <!--  -->
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
                            <div class="module">
                                <div class="module-head">
                                    <h3>Bookings</h3>
                                </div>
                                <div class="module-body">
                                    <table class="datatable-1 table table-bordered table-striped display" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Client Name</th>
                                                <th>Contact No.</th>
                                                <th>Client Email</th>
                                                <th>Booking Date</th>
                                                <th>Message</th>
                                                <th>Arrival Date</th>
                                                <th>Return Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $sql=mysqli_query($con, "SELECT * FROM bookingquery");
                                            while($row=mysqli_fetch_array($sql)){ ?>
                                            <tr>
                                                <td><?php echo $row["Id"]; ?></td>
                                                <td><?php echo $row["ClientName"]; ?></td>
                                                <td><?php echo $row["ContactNo"]; ?></td>
                                                <td><?php echo $row["ClientEmail"]; ?></td>
                                                <td><?php echo $row["BookingDate"] ?></td>
                                                <td><?php echo $row["Message"]; ?></td>
                                                <td><?php echo $row["DepartureDate"]; ?></td>
                                                <td><?php echo $row["ReturnDate"]; ?></td>
                                                <td>
                                                    <?php 
                                                        if($row['Status']=="Pending"){?>
                                                            <a href ="booking.php?b_id=<?php echo $row['Id'];?>&&action=approve" title="Approve" onClick="return confirm('You Want To Approve ? ')"><button class="btn btn-info" type="button">Approve</button></a>
                                                            <a href ="booking.php?b_id=<?php echo $row['Id'];?>&&action=can" title="Cancle" onClick="return confirm('Do You Really Want To Cancle ? ')"><button class="btn btn-warning" type="button">Cancle</button><a>
                                                    <?php } elseif($row['Status']=="Cancled"){?>
                                                            <a href=""><button class="btn btn-danger">* Cancled</button></a>
                                                            <a href ="booking.php?b_id=<?php echo $row['Id'];?>&&action=approve" title="Approve" onClick="return confirm('Do You Really Want To Approve ? ')"><button class="btn btn-info" type="button">Approve</button><a>
                                                    <?php } else{?>
                                                            <a href=""><button class="btn btn-danger">* Approved</button></a>
                                                            <a href ="booking.php?b_id=<?php echo $row['Id'];?>&&action=can" title="Cancle" onClick="return confirm('Do You Really Want To Cancle ? ')"><button class="btn btn-warning" type="button">Cancle</button><a>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                            <?php } ?> 
                                        </tbody>
                                    </table>
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