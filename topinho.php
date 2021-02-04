<?php
session_start();
if(!$_SESSION["sess_id"]>0){
    header("location: login.php");exit;
}
$class_id = $msg = null;
if(isset($_SESSION["alert-danger"])){
    $msg = $_SESSION["alert-danger"];
    $class_id = 'alert-danger';
    unset($_SESSION["alert-danger"]);
}else if(isset($_SESSION["alert-success"])){
    $msg = $_SESSION["alert-success"];
    $class_id = 'alert-success';
    unset($_SESSION["alert-success"]);
}

require_once "class/Usuario.php";
$obj = new Usuario();
?>
