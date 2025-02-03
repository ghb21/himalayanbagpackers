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
    // Enable error reporting for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    if (isset($_POST['update'])) {
        // Fetch session username
        $user = $_SESSION['alogin']; // Use the session variable directly, not strlen()
    
        // Hash the passwords
        $prepass = md5($_POST['prepass']);
        $newpass = md5($_POST['newpass']);
        $conpass = md5($_POST['conpass']);
    
        // Check if new password and confirm password match
        if ($newpass == $conpass) {
            // Check if the previous password matches the database
            $ret = mysqli_query($con, "SELECT * FROM users WHERE Username='$user' AND Password='$prepass'");
            $pas=mysqli_fetch_array($ret);
            if ($pas > 0) {
                // Update the password
                $sql = mysqli_query($con, "UPDATE `users` SET `Password`='$newpass' WHERE Username='$user'");
                if ($sql) {
                    echo "<script>
                        alert('Password Changed Successfully.');
                        window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                        </script>";
                        exit();
                } else {
                    echo "<script>
                        alert('Something Went Wrong Please Try Again!');
                        window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                        </script>";
                        exit();
                }
            } else {
                echo "<script>
                    alert('Current Password is incorrect!');
                    window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                    </script>";
                    exit();
            }
        } else {
            echo "<script>
                alert('New Password and Confirm Password do not match!');
                window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                </script>";
                exit();
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
            <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
            
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
                                <div class="module">
                                    <div class="module-head">
                                        <h3>Add New Package</h3>
                                    </div>
                                    <div class="module-body">
                                        <form class="form-vertical style-form" action="" method="post" enctype="multipart/form-data">
                                            <div class="form-horizontal row-fluid">
                                                <div class="control-group">
                                                    <label class="control-label" for="title">Current Password</label>
                                                    <div class="controls">
                                                        <input type="password" id="prepass" name="prepass" placeholder="Current Password" class="span8" required>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="title">New Password</label>
                                                    <div class="controls">
                                                        <input type="password" id="newpass" name="newpass" placeholder="New Password" class="span8" required>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="title">Confirm New Password</label>
                                                    <div class="controls">
                                                        <input type="password" id="conpass" name="conpass" placeholder="Confirm New Password" class="span8" required>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <button type="submit" name="update" id="update" class="btn btn-info"><i class="icon-save"></i> Update</button>
                                                    </div>
                                                </div>
                                            </div>    
                                        </form>
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