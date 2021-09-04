<?php
/*
* Script responável pela validação do login do usuário.
* @since 2021-08-01
* @author Dennis Henrique
*/
require_once "class/Usuario.php";

# Se foi setado o login e a senha, recupera os dados do formulário.
if(isset($_POST["login"]) && isset($_POST["password"])){

    $login = addslashes(trim($_POST["login"]));
    $senha = addslashes(trim($_POST["password"]));
    
    # Se, por algum motivo, o usuário ou senha estiverem vazios, devolve para a tela de login.
    if($login=="" || $senha == ""){
        header("location: login.php");exit;    
    }

    #Cria objeto de Usuário
    $obj = new Usuario();
    $obj->setEmail($login);
    $obj->setSenha($senha);
    
    # Executa o método login
    $dadosUsuario = $obj->login();
    session_start();
    # Não achou o usuário com o login e senha. Redireciona para a tela de login com mensagem de erro.
    if(empty($dadosUsuario)){
        $_SESSION["alert-danger"]= "Login e/ou senha incorretos.";
        header("location: login.php");exit;
    }

    #Cria a Sessão do usuário
    $_SESSION["sess_id"]   = $dadosUsuario->getId();
    $_SESSION["sess_nome"] = $dadosUsuario->getNome();

    # Redireciona para a listagem
    header("location: /");exit;

}else{
    # Não foi enviado o formulário. Redireciona para a tela de login.
    header("location: login.php");exit;
}


?>