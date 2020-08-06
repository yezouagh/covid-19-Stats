<?php
include_once '../scripts/bd.php';

function signin(){
if(isset($_POST["username"]) && isset($_POST["password"])){
$username=str_replace(array("'","=","".'"'),"",$_POST["username"]);
$password=str_replace(array("'","=","".'"'),"",$_POST["password"]);
$data = bd::query("SELECT * FROM account WHERE username='$username'");
$row  = mysql_fetch_array($data);
if($row!=null){
if($row['password']==$password){
session_start();
$_SESSION['username'] = $row['username'];
$_SESSION['start'] = time();
$_SESSION['expire'] = $_SESSION['start'] + (60*60);
$w=isset($_GET['pp'])?urldecode($_GET['pp']):'../update/';
header("Location: ".$w);
}else{return 'Username or password not match';}
}else{return 'Username or password not match';}
}
}

?>