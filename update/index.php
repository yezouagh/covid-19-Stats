<!DOCTYPE html>
<?php
include_once '../account/session.php';
include_once 'scripts.php';
$username_mailer=   $_SESSION['username'];
?>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload Data</title>
<!--<link rel="shortcut icon" type="image/gif" href="../../images/logo.gif"/>/////-->
<link type="text/css" href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link type="text/css" href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
<link type="text/css" href="../css/theme.css" rel="stylesheet">
<!--<link type="text/css" href="../images/icons/css/font-awesome.css" rel="stylesheet">/////-->
<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
<script src="../scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="../scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!--<script src="../scripts/flot/jquery.flot.js" type="text/javascript"></script>-->
<script src="scripts.js" type="text/javascript"></script>
</head>
<body>
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a class="brand" href="#">Covid-19</a>
<ul class="nav pull-right">
<li class="nav-user dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<img src="https://yez-linc.com/app/images/user.png" class="nav-avatar">
<b class="caret"></b></a>
<ul class="dropdown-menu">
<li><a href="#"><?php echo $username_mailer;?></a></li>
<li><a href="../account/logout.php"><span>Log Out</span></a></li>
</ul>
</li>
</ul>
</div>
</div><!-- /navbar-inner -->
</div><!-- /navbar -->
<div class="wrapper">
<div class="container">
<div class="row">
<div class="span9">
<div class="content">
<div class="module">
<div class="module-head"><h3>Upload Data <div class="processing" id="processing"></div></h3></div>
<div class="alert" id="message-warning">
<button type="button" class="close" onclick="close_message_warning();">×</button>
<strong>Warning!</strong> Please verify your data
</div>
<div class="alert" id="message-warning-custom">
<button type="button" class="close" onclick="close_message_warning_custom();">×</button>
<strong>Warning!</strong> <span id="message-custom"></span>
</div>
<div class="alert alert-error" id="message-error">
<button type="button" class="close" onclick="close_message_error();">×</button>
<strong>Error!</strong> There was an error while executing your request
</div>
<div class="alert alert-success" id="message-success">
<button type="button" class="close" onclick="close_message_success();">×</button>
<strong>Done!</strong> Data has been added successfully
</div>
<div class="module-body">
<form class="form-horizontal row-fluid" name="upload_form" method="POST" action="" enctype="multipart/form-data">
<div class="control-group">
<label class="control-label" for="basicinput">Data File</label>
<div class="controls">
<input type="file" id="file1" name="file1" placeholder="" class="span6">
<div class="span8"><?php echo upload_file(); ?></div>
</div>
</div>
<div class="control-group">
<div class="controls">
<button class="btn btn-primary" type="submit" name="submit" onclick="processing_show();">
<i class="icon-upload icon-white"></i>&nbsp;Upload Data</button>
</div>
</div>
</form>
</div>
</div>
</div><!--/.content-->
</div><!--/.span9-->
</div>
</div><!--/.container-->
</div><!--/.wrapper-->
<div class="footer">
<div class="container">
<b class="copyright">&copy; yez App </b>.
</div>
</div>
</body>