<?php
/*
* Script responsável por apagar um usuário da base de dados.
* Ele não pode apagar a si mesmo.
* @since 2021-08-01
* @author Dennis Henrique
*/
require_once "topinho.php";

# Se foi setado o id do usuario para a exclusão.
if(isset($_GET["t"])){

    # Recebe o id do usuário.
    $idUser = addslashes(trim($_GET["t"]));

    # Se não for numérico, exibe mensagem de erro.
    if(!is_numeric($idUser)){
        $_SESSION["alert-danger"]= "Erro: O código enviado é inválido.";
        header("location: /");exit;
    }

    # Se o código enviado por o mesmo do usuário da sessão, aborta a exclusão e exibe mensagem de erro.
    if($idUser == $_SESSION["sess_id"]){
        $_SESSION["alert-danger"]= "Erro: Você não pode se excluir do sistema.";
        header("location: /");exit;
    }

    # Cria um objeto de usuário.
    $obj = new Usuario();
    
    # Verifica se o usuário existe no banco de dados.
    $existe = $obj->listar(array("id"=>$idUser));
    
    # Se existir, executa o método para apagar da base de dados.
    if(!empty($existe)){
        $apagar = $obj->apagar($idUser);
        $_SESSION["alert-success"]= "Usuário excluído com sucesso.";
    }else{
        # Se não existir, redireciona com a mensagem de erro.
        $_SESSION["alert-danger"]= "Usuário não encontrado.";
    }
    # Redireciona para a tela de listagem
    header("location: /");exit;
}
?>