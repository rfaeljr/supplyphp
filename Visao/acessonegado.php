<!DOCTYPE html>
<html>
    <head>
        <?php include('./Resources/tplImportCss.php') ?>
        <title>403 - Acesso negado </title>
    </head>
    <body>

        <!-- conteudo -->
        <div class="row">
            <div class="col s8 offset-l3">
                <div class="vertlarge0"/>
                <img src="Resources/img/403.png"/><br/>
                <div class="col s4 offset-l3 acessoNegado">Acesso negado
                    <br/><a href="login.php">Faça login aqui!</a>
                </div>
            </div>
        </div>
        <?php include('./Resources/tplImportJs.php') ?>
        <script type="text/javascript">
           $(document).ready(function () {

           });
        </script>
    </body>
</html>
