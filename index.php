<?php
/*
* Script responável por listar os usuários cadastrados na base de dados.
* Ele pode receber parâmetros via GET para fazer alguma consulta personalizada.
* @since 2021-08-01
* @author Dennis Henrique
*/
require_once "topo.php";

# Crio a variável $params que será um array onde guardará os possíveis filtro na consulta.
$params = array();

# Se foi setado o GET para filtrar, adiciona o valor no array, no indice pesquisa.
if(isset($_GET["t"])){
    $pesquisa = html_entity_decode(addslashes(trim($_GET["t"])));
    $params["pesquisa"] = $pesquisa;
}

# Crio a variável $listagem como null. Ela será usada no foreach para criar a lista de usuários
$listagem = null;

# Executa o método listar para recuperar os usuários do banco de dados.
$listar = $obj->listar($params);

# Se a consulta retornar vazia, exibe uma linha com mensagem que nenhum usuário foi encontrado.
if(empty($listar)){
    $listagem.='<tr>
           <td colspan="4" style="font-weight:bold; color#900">Nenhum usuário encontrado</td>
          </tr>';
}else{
    # Achou usuários no BD.
    foreach($listar as $user){
        
        $botaoExcluir = null;

        # Se o usuário do laço de repetição não for o usuário logado, exibe o botõe para Excluir.
        if($user->getId() != $_SESSION["sess_id"]){
            $botaoExcluir = '<button type="submit" class="btn btn-danger" onclick="confirmar('.$user->getId().')">Excluir</button>';
        }
        # Crio a linha na tabela com os dados do usuário
        $listagem.='<tr>
                <td style="width:9%;">
                    <a href="atualizar.php?t='.$user->getId().'">
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </a>
                </td>
                <td style="width:9%;">'.$botaoExcluir.'</td>
                
                <td style="width:41%;">
                    '.$user->getNome().'
                </td>
                <td style="width:41%;">
                    '.$user->getEmail().'
                </td>
              </tr>';
    }
}
?>
<div class="row">
    <div class="col-md-12"  style="margin-top:30px; text-align:center;">
        <h2>LISTA DE USUÁRIOS</h2>
        <hr/>
    </div>
</div>
<div class="row" style="margin-top:11px">
    <div class="col-md-9" style="margin-top: 10px;">
        <form id="form_pesquisa" action="index.php" method="get">
            <input type="text" class="form-control" name="t" placeholder="Digite sua pesquisa e pressione a tecla ENTER ou o botão Pesquisar" />
        </form>
    </div>
    <div class="col-md-3" style="text-align: right;margin-top: 10px;">
        <button style="" class="btn btn-primary" onclick="document.getElementById('form_pesquisa').submit()">Pesquisar</button>
        <button class="btn btn-success" onclick="location.href='novo.php'">Novo Usuário</button>
    </div> 
</div>
<div class="row" style="margin-top: 10px;">
    <div class="col-md-12">
        <table class="table table-striped table-bordered">
            <?php echo $listagem?>
        </table>
    </div>
</div>
<div class="<?php echo $class_id?>" style="padding: 5px;">
    <?php echo $msg?>
</div>
<script>
    function confirmar(id){
        var confirma = confirm("Deseja realmente apagar o usuário?");
        if(confirma == true){
            location.href="apagar.php?t="+id;
        }
    }
</script>
<?php require_once "rodape.php"; ?>