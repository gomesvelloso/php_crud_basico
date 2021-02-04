<?php
require_once "topo.php";
if(isset($_GET["t"])){

    $idUser = addslashes(trim($_GET["t"]));
    
     //Verifica se existe
    $dados = $obj->listar(array("id"=>$idUser));
    
    if(!empty($dados)){
        $nome  = $dados[0]->getNome();
        $email = $dados[0]->getEmail();
    }else{
        $_SESSION["alert-danger"]= "Usuário não encontrado.";
        header("location: index.php");exit;

    }
}else if(isset($_POST["nome"])){
    $nome   = addslashes($_POST["nome"]);
    $email  = addslashes(trim($_POST["email"]));
    $idUser = addslashes(trim($_POST["id"]));
   
    //Verifica se existe
    $dados = $obj->listar(array("id"=>$idUser));
    if(empty($dados)){
         $_SESSION["alert-danger"]= "Usuário não encontrado.";
        header("location: /");exit;
    }
    
    $obj->setId($idUser);
    $obj->setNome(ucwords($nome));
    $obj->setEmail($email);
    
    $salva = $obj->ataualizar();
    
    if(isset($_POST["senha"])){
        $senha = addslashes(trim($_POST["senha"]));
        $atualizaSenha = $obj->alterarSenha($idUser,$senha);
    }
     $_SESSION["alert-success"]= "Usuário atualizado com sucesso.".
        header("location: /");exit;
}
?>

<form action="atualizar.php" method="post">
    <div class="row">
        <div class="col-md-12"  style="margin-top:30px; text-align:center;">
            <h2>ATUALIZAR USUÁRIO</h2>
            <hr/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="margin-top: 10px; text-align:right">
            <button class="btn btn-primary" type="submit">Atualizar Dados</button>
            <button class="btn btn-success" type="button" onclick="location.href='/'">Voltar Para Listagem</button>
            
        </div>
    </div>
    <div class="row" style="margin-top:10px">
        
        <div class="col-md-12">
        
            <div class="col-md-12">
                <label>
                    Nome
                </label>
                <input type="text" class="form-control" required="required" name="nome" value="<?php echo $nome?>" />
                <input type="hidden" name="id" value="<?php echo $idUser?>" />
            </div>
            <div class="col-md-12">
                <label>
                    E-mail
                </label>
                <input type="email" class="form-control" required="required" name="email" value="<?php echo $email?>" />
            </div>
            <div class="col-md-12">
            <?php if($dadosUsuario[0]->getId() == $_SESSION["sess_id"]){?>
                <label>
                    Senha
                </label>
                <input type="password" required="required" class="form-control" name="senha" />
            <?php } ?>
            </div>
            
        </div>
    </div>            
</form>  
<?php require_once "rodape.php" ?>