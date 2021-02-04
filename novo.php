<?php
require_once "topo.php";

if(isset($_POST["nome"])){
    $nome  = addslashes($_POST["nome"]);
    $email = addslashes(trim($_POST["email"]));
    $senha = addslashes(trim($_POST["senha"]));
        
    //Verifica se existe
    $dados = $obj->listar(array("email"=>$email));
    if(!empty($dados)){
        $_SESSION["alert-danger"]= "Usuário já existe com este e-mail: $email. ";
        header("location: /");exit;
    }
    
    $obj->setNome(ucwords($nome));
    $obj->setEmail($email);
    $obj->setSenha($senha);
    
    $salva = $obj->criar();
    $_SESSION["alert-success"]= "Usuário atualizado com sucesso.".
    header("location: /");exit;
     
}
?>
<form action="novo.php" method="post">
    <div class="row">
        <div class="col-md-12"  style="margin-top:30px; text-align:center;">
            <h2>NOVO USUÁRIO</h2>
            <hr/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="margin-top: 10px; text-align:right">
            <button class="btn btn-primary" type="submit">Criar Usuário</button>
            <button class="btn btn-success" type="button" onclick="location.href='/'">Voltar Para Listagem</button>
        </div>
    </div>
    <div class="row" style="margin-top:10px">
        
        <div class="col-md-12">
        
            <div class="col-md-12">
                <label>
                    Nome
                </label>
                <input type="text" class="form-control"  required="required" name="nome" value="<?php echo $nome?>" />
                <input type="hidden" name="id" value="<?php echo $idUser?>" />
            </div>
            <div class="col-md-12">
                <label>
                    E-mail
                </label>
                <input type="email" class="form-control"  required="required" name="email" value="<?php echo $email?>" />
            </div>
            <div class="col-md-12">
                <label>
                    Senha
                </label>
                <input type="password" class="form-control"  required="required" name="senha" />
            </div>
        </div>
    </div>
</form>  
<?php require_once "rodape.php"; ?>