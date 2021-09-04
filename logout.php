<?php
/*
* Script responsável por deslogar o usuário do sistema.
* @since 2021-08-01
* @author Dennis Henrique
*/
session_start();
session_unset();
session_destroy();
header("location:login.php");exit;
?>