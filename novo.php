<?php
/*
* Script responável pela criação de um novo usuário na base de dados.
* Ele verifica sempre se o e-mail já existe.
*  Se já existir, retorna para a tela avisando.
* @since 2021-08-01
* @author Dennis Henrique
*/
require_once "topo.php";

# Defino as variáveis como null
$nome = $email = $senha = $idUser = null;

# Se foi setado o post, recupero os dados do formulário para gravar no banco de dados.
if(isset($_POST["nome"])){
    $nome  = addslashes($_POST["nome"]);
    $email = addslashes(trim($_POST["email"]));
    $senha = addslashes(trim($_POST["senha"]));
        
    # Verifico se o e-mail já existe na base de dados.
    $dados = $obj->listar(array("email"=>$email));
    if(!empty($dados)){
        # Se existe, retorna para a tela com mensagem de erro.
        $_SESSION["alert-danger"]= "Este e-mail já existe na base de dados. [E-mail: $email]. Verifique na listagem de usuários cadastrados.";
        header("location: /");exit;
    }
    
    $obj->setNome(ucwords($nome));
    $obj->setEmail($email);
    $obj->setSenha($senha);
    
    # Executa o método para criar o regitro do usuário.
    $salva = $obj->criar();
    
    # Retorna para a tela com mensagem de sucesso.
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
                <input type="password" class="form-control" maxlength="12" required="required" name="senha" />
            </div>
        </div>
    </div>
</form>  
<?php require_once "rodape.php"; ?>