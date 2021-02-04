<?php
require_once "topinho.php";
if(isset($_GET["t"])){

    $idUser = addslashes(trim($_GET["t"]));

    $obj = new Usuario();
    
    //Verifica se existe
    $existe = $obj->listar(array("id"=>$idUser));
    
    if(!empty($existe)){
        $apagar = $obj->apagar($idUser);
        $_SESSION["alert-success"]= "Usuário excluído com sucesso.";
    }else{
        $_SESSION["alert-danger"]= "Usuário não encontrado.";
    }
    header("location: index.php");exit;
}
?>