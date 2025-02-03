<?php
session_start();
error_reporting(0);
include("./include/config.php");
if(isset($_POST['login'])){
  $username=$_POST['username'];
  $password=md5($_POST['password']);
  $ret=mysqli_query($con,"SELECT * FROM users WHERE Username='$username' and Password='$password'");
  $num=mysqli_fetch_array($ret);
  if($num > 0){
    $extra="dashboard.php";//
    $_SESSION['alogin']=$_POST['username'];
    $_SESSION['id']=$num['id'];
    $host=$_SERVER['HTTP_HOST'];
    $uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
    header("location:http://$host$uri/$extra");
    exit();
  }
  else{
    $_SESSION['errmsg']="Invalid username or password";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
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
					<i class="icon-reorder shaded"></i>
				</a>
			  	<a class="brand" href="home.php">
			  		Admin
			  	</a>
				<div class="nav-collapse collapse navbar-inverse-collapse">	
					<ul class="nav pull-right">
						<li><a href="setpassword.php">
							Forgot your password?
						</a></li>
					</ul>
				</div><!-- /.nav-collapse -->
			</div>
		</div><!-- /navbar-inner -->
	</div><!-- /navbar -->

	<div class="wrapper">
		<div class="container">
			<div class="row">
				<div class="module module-login span4 offset4">
					<form class="form-vertical" action="" method="post">
						<div class="module-head">
							<h3>Sign In</h3>
						</div>
                        <span style="color:red;" ><?php echo $_SESSION['errmsg']; ?><?php echo $_SESSION['errmsg']="";?></span>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<input class="span12" type="text" name="username" id="inputEmail" placeholder="Username" required>
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
									<input class="span12" type="password" name="password" id="inputPassword" placeholder="Password" required>
								</div>
							</div>
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
									<button type="submit" name="login" class="btn btn-primary pull-right">Login</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div><!--/.wrapper-->

	<div class="footer">
		<div class="container">
			<b class="copyright">&copy; <span id="year"></span> Himalayanbagpackers</b> All rights reserved.
            <b class="pull-right">Designed By: EGrappler.com</b>
		</div>
	</div>
	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script>
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
</body>