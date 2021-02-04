<?php
 require_once "topinho.php";
?>
<html>
    <head>
        <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Usuários Empresa</title>
    </head>
    <body>
        <div class="container">
        <div class="row">
            <div class="col-md-10" style="margin-top: 10px; font-weight: bold;">
                Olá, <?php echo $_SESSION["sess_nome"];?>
            </div>
            <div class="col-md-2" style="margin-top: 10px; text-align:right; font-weight: bold;">
                <button class="btn btn-default" onclick="location.href='logout.php'">Sair</button>
            </div>
            
        </div>