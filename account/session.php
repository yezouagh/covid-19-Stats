<?php session_start();
include_once '../scripts/bd.php';
if(!isset($_SESSION['username'])){
header("Location: ../account/signin.php?pp=".urlencode($_SERVER['REQUEST_URI']));
exit();
}

?>