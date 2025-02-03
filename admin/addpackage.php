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
if (isset($_POST['submit'])) {
    $dest = $_POST['dest'];
    $title = $_POST['title'];
    $faci = $_POST['facilities'];
    $cost = $_POST['cost'];
    $img = $_FILES["image"]["name"];

    // Use a unique identifier to prevent filename conflicts
    $img = md5(uniqid($img, true));
    // Get the file extension to preserve the original format
    $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

    // Ensure the extension is lowercase for consistency
    $extension = strtolower($extension);

    // Validate the file extension (optional but recommended for security)
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($extension, $allowed_extensions)) {
        die("Invalid file type.");
    } else {
        // Define the target folder with the proper filename
        $folder = "packageimg/" . $img . "." . $extension;
        $img = $img . "." . $extension;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $folder)) {
            $query = mysqli_query($con, "INSERT INTO `packages`(`DestinationID`, `PackageName`, `image`, `Facilities`, `Cost`) VALUES ('$dest','$title','$img','$faci','$cost')");
            if ($query) {
                // Redirect to avoid resubmitting the form
                echo "<script>alert('Package Added Successfully');
                window.location.href='" . $_SERVER['PHP_SELF']. "'; </script>";// Redirect to the same page
                exit(); // Ensure no further code runs after the redirect
            } else {
                echo "<script>alert('Sorry! Try Again');
                window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                </script>";
                exit();
            }
        } else {
            echo "<script>alert('Failed to upload image.');
            window.location.href = '" . $_SERVER['PHP_SELF'] . "';
            </script>";
            exit();
        }
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
                                                <label class="control-label" for="basicinput">Destination</label>
                                                <div class="controls">
                                                    <div class="dropdown">
                                                        <select class="dropdown-toggle btn span8" data-toggle="dropdown" name="dest" required><i class="icon-caret-down"></i>
                                                        <option value="" disabled selected>Select Destination</option>
                                                            <?php 
                                                            $sql=mysqli_query($con, "SELECT * FROM destination WHERE Status='Active'");
                                                            while($row=mysqli_fetch_array($sql)){ ?>
                                                                <option value="<?php echo $row['Id']; ?>"><?php echo $row['DestinationName']; ?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="title">Package Title</label>
                                                <div class="controls">
                                                    <input type="text" id="title" name="title" placeholder="package Title" class="span8" required>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="title">Facilities</label>
                                                <div class="controls">
                                                    <textarea id="ckeditor_standard" name="facilities"  class="form-control span8" rows="8" cols="10" placeholder="Package facilities" required></textarea>    
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="title">Package Cost</label>
                                                <div class="controls">
                                                    <input type="number" name="cost" id="cost" class="span8" placeholder="Package Cost" required>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="title">Package Image</label>
                                                <div class="controls">
                                                    <input type="file" name="image" id="image" class="span8" placeholder="package Image" required>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <button type="submit" name="submit" id="submit" value="submit" class="btn btn-info"><i class="icon-save"></i> Add Package</button>
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
        <!--script for this page-->
        <script src="scripts/jquery-ui-1.9.2.custom.min.js"></script>
        <!--script for this page-->
    
        <script type="text/javascript" src="scripts/ckeditor/ckeditor.js"></script>     
        <script type="text/javascript" src="scripts/ckeditor/adapters/jquery.js"></script> 
        <script>
            $(function() {
            // Bootstrap
         

            // Ckeditor standard
            $( 'textarea#ckeditor_standard' ).ckeditor({width:'98%', height: '150px', toolbar: [
            { name: 'document', items: [ 'Format','Font','FontSize'] }, // Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
            ['Source', '-','TextColor','BGColor' ],['Styles'],
            [ 'Bold', 'Italic','Underline' ],['NumberedList', 'BulletedList', '-', 'Link', 'Unlink'] ,     // Defines toolbar group without name.
            { name: 'basicstyles', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] }
            ]});
                $( 'textarea#ckeditor_full' ).ckeditor({width:'98%', height: '150px'});
            });

        </script>
    </body>
</html>
  <?php } ?>