<?php
require_once "class/Usuario.php";
if(isset($_POST["login"]) && isset($_POST["password"])){

    $login = addslashes(trim($_POST["login"]));
    $senha = addslashes(trim($_POST["password"]));
    
    if($login=="" || $senha == ""){
        header("location: login.php");exit;    
    }

    $obj = new Usuario();
    $obj->setEmail($login);
    $obj->setSenha($senha);
    
    $dadosUsuario = $obj->login();
    session_start();
    if(empty($dadosUsuario)){
        $_SESSION["alert-danger"]= "Usuário não encontrado na base de dados.";
        header("location: login.php");exit;
    }
    $_SESSION["sess_id"]   = $dadosUsuario->getId();
    $_SESSION["sess_nome"] = $dadosUsuario->getNome();
    header("location: /");exit;

}else{
    header("location: login.php");exit;
}


?>