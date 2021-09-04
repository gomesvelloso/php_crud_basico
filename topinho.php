<?php
/*
* Script responsável por verificar se existe mensagem de sucesso ou de erro, verificar se o usuário ainda
* está logado no sistema.
* @since 2021-08-01
* @author Dennis Henrique
*/
session_start();
# Se o usuario não estiver logado, redireciona para a tela de login.
if(!$_SESSION["sess_id"]>0){
    header("location: login.php");exit;
}
# Verifica se existe mensagens de erro ou de sucesso para exibir em tela.
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
# Instancia um objecto da classe de Usuário.
require_once "class/Usuario.php";
$obj = new Usuario();
?>
