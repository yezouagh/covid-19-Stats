<!DOCTYPE html>
<?php session_start();
if(isset($_SESSION['username'])){header("Location: ../update/");}
include_once 'scripts.php';
?>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Signin</title><link rel="shortcut icon" type="image/gif" href="../images/logo.gif"/>
<link type="text/css" href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link type="text/css" href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
<link type="text/css" href="../css/theme.css" rel="stylesheet">
</head>
<body>
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a class="brand" style="text-align: center;float: none;" href="../update/">Covid-19</a>
</div>
</div><!-- /navbar-inner -->
</div><!-- /navbar -->
<div class="wrapper">
<div class="container">
<div class="row">
<div class="module module-login span4 offset4">
<form class="form-vertical" method="POST" action="">
<div class="module-head">
<h3>Sign In</h3>
</div>
<div class="module-body">
<div class="control-group">
<div class="controls row-fluid">
<input class="span12" type="text" id="inputEmail" name="username"  placeholder="Username">
</div>
</div>
<div class="control-group">
<div class="controls row-fluid">
<input class="span12" type="password" id="inputPassword" name="password" placeholder="Password">
</div>
</div>
<div class="control-group">
<div class="controls row-fluid">
<span class='label label-warning'><?php echo signin(); ?></span>
</div>
</div>
</div>
<div class="module-foot">
<div class="control-group">
<div class="controls clearfix">
<button type="submit" class="btn btn-primary pull-right">Login</button>
<label class="checkbox"><input type="checkbox"> Remember me</label>
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
<b class="copyright">&nbsp; &nbsp; &copy; yez App </b>.
</div>
</div>
</body>