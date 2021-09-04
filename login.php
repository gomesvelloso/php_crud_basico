<?php
/*
* Script responsável por pelo formulário de login do usuário no sistema
* @since 2021-08-01
* @author Dennis Henrique
*/


session_start();
# Se já tiver uma sessão ativa, redireciona para a tela de listagem
if(isset($_SESSION["sess_id"])){
    header("location:/");exit;    
}else{
    # Se tiver alguma mensagem de erro, recuperar para exibir na tela.
    $msgErro = null;
    if(isset($_SESSION["alert-danger"])){
        $msgErro = '<span class="alert alert-danger" style="padding:5px;">'.$_SESSION["alert-danger"].'</span>';
        unset($_SESSION["alert-danger"]);
    }
}
# Verifica se é mobile para saber vai deixar a area de login grande ou pequena
$class_login = 'col-md-8';
$iphone  = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$ipad    = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry   = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod    = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
$symbian =  strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");
if ($iphone || $ipad || $android || $palmpre || $ipod || $berry || $symbian == true){
  $class_login = 'col-md-12';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Área de Login</title>
        <meta name="viewport" content="width=device=width, initial-scale=1"/>
        <script src="js/jquery.min.js"></script>
        <link href="css/bootstrap.css" rel="stylesheet" id="bootstrap-css">
        <script src="js/bootstrap.min.js"></script>
        </head>
        <body>
            <div class="container">
                <div class="row justify-content-center align-items-center" style="height:100vh">
                    <div class="<?php echo $class_login?>">
                        <div class="card">
                            <div class="card-body">
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="<?php echo $class_login?>">
                                    <h3>Login</h3>
                                    </div>
                                </div>
                                <form method="post" action="valida_login.php" autocomplete="off">
                                    <div class="form-group">
                                        <input type="email" id="inputEmail" class="form-control" name="login" placeholder="Login" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Senha" required="required" onkeypress="capLock(event)" />
                                    </div>
                                    <button type="submit" id="sendlogin" class="btn btn-primary btn-block">Login</button>
                                    <div class="form-group" style="margin-top:15px;">
                                        <?php echo $msgErro?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </body>
</html>
<?php exit;?>