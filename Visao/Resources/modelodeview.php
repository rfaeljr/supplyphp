<!DOCTYPE html>
<html>
    <head>
        <?php include('./Resources/tplImportCss.php') ?>
        <?php include('../Controle/includes.php') ?>
        <?php Funcoes::acessaView('notamov.php') ?>
        <title>page9999 - XXXXXXX</title>
    </head>
    <body>
        <?php include('./tplMenu.php') ?>
        <!-- conteudo -->
        <div class="row">

        </div>
        <?php include('./tplRodape.php') ?>
        <?php include('./tplImportJs.php') ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".dropdown-button").dropdown();
            });
        </script>
    </body>
</html>
