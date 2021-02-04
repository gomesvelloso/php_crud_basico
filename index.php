<?php
require_once"topo.php";
$params = array();

if(isset($_GET["t"])){
    
    $pesquisa = html_entity_decode(addslashes(trim($_GET["t"])));
    $params["pesquisa"] = $pesquisa;
}

$listar = $obj->listar($params);
if(empty($listar)){
    $tr.='<tr>
           <td colspan="4" style="font-weight:bold; color#900">Nenhum usuário encontrado</td>
          </tr>';
}else{
    foreach($listar as $user){
        $display = "display: block";
        if($user->getId() == $_SESSION["sess_id"]){
            $display = "display:none";
        }
        $tr.='<tr>
                <td style="width:9%;">
                    <a href="atualizar.php?t='.$user->getId().'">
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    </a>
                </td>
                <td style="width:9%;">
                    <button  style="'.$display.'" type="submit" class="btn btn-danger" onclick="confirmar('.$user->getId().')">Excluir</button>
                </td>
                
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
            <input type="text" class="form-control" name="t" placeholder="Digite seu pesquisa e pressione a tecla ENTER ou o botão Pesquisar" />
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
            <?php echo $tr?>
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