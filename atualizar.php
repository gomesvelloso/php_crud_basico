<?php
/*
* Script responsável por carregar os dados do usuário em tela (Quando foi enviado o GET)
* e responsável por atualizar os dados quando for enviado um formulário via post.
* @since 2021-08-01
* @author Dennis Henrique
*/
require_once "topo.php";

# Seto as variáveis como null.
$idUser = $nome = $email = null;

# Se for setado o id via GET.
if(isset($_GET["t"])){

    # Recebe o id do usuário via GET.
    $idUser = addslashes(trim($_GET["t"]));
    
    # Verifica se o id é um númérico.
    if(! is_numeric($idUser)){
        $_SESSION["alert-danger"]= "Erro: O código enviado é inválido.";
        header("location: /");exit;
    }

    # Verifica se o usuário existe na base de dados.
    $dados = $obj->listar(array("id"=>$idUser));
    
    if(!empty($dados)){
        $nome  = $dados[0]->getNome();
        $email = $dados[0]->getEmail();
    }else{
        # Se não achou, redireciona para o index com msg de erro.
        $_SESSION["alert-danger"]= "Usuário não encontrado.";
        header("location: /");exit;

    }
}else if(isset($_POST["nome"])){

    # Recebe os dados via post do formulário.
    $nome   = addslashes($_POST["nome"]);
    $email  = addslashes(trim($_POST["email"]));
    $idUser = addslashes(trim($_POST["id"]));
    
    # Verifica se existe na base de dados
    $dados = $obj->listar(array("id"=>$idUser));
    if(empty($dados)){
        # Se não achou o usuário, redireciona com aviso de erro.
        $_SESSION["alert-danger"]= "Usuário não encontrado.";
        header("location: /");exit;
    }
    
    # Verifica se o e-mail digitado existe na base para outro usuário.
    $consultaEmail = $obj->listar(array("email"=>$email));
    if(!empty($consultaEmail)){
        # Se achou o e-mail na base de dados e ele não pertencer ao usuário que está sendo atualizado.
        # redireciona com aviso de erro.
        foreach($consultaEmail as $consulta){
            if($consulta->getId() != $idUser){
                # Usuários diferentes. Atualização não permitida, pois ja tem outro usuário com o e-mail.
                $_SESSION["alert-danger"]= "Atenção: Este e-mail [$email] está cadastrado para outro Usuário. Atualizaçao de dados do $nome não permitida.";
                header("location: /");exit;
            }
        }
    }

    # Achou o usuário. Atualiza os dados.
    $obj->setId($idUser);
    $obj->setNome(ucwords($nome));
    $obj->setEmail($email);
    
    # Executa o método para atualizar o usuário.
    $salva = $obj->ataualizar();
    
    # Se foi setado o post senha, atualiza a senha.
    if(isset($_POST["senha"])){
        $senha = addslashes(trim($_POST["senha"]));
        $atualizaSenha = $obj->alterarSenha($idUser,$senha);
    }
    # Redireciona para a tela com mensgem de sucesso.
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
            <?php if($idUser == $_SESSION["sess_id"]){?>
                <label>
                    Senha
                </label>
                <input type="password" required="required"  maxlength="12" class="form-control" name="senha" />
            <?php } ?>
            </div>
            
        </div>
    </div>            
</form>  
<?php require_once "rodape.php" ?>