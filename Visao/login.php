<!DOCTYPE html>
<html>
    <head>
        <?php include('./Resources/tplImportCss.php') ?>
		<link rel='shortcut icon' type='image/x-icon' href='/Resources/img/favicon.ico' />
        <title>login</title>
    </head>
    <body class="fundoCinza">
        <!-- conteudo -->
        <div class="row vertlarge2">            
            <form id="frm" class="col s4 offset-s4">
                <fieldset class="borda fundoBranco">
					<div class="row">
						<img src="Resources/img/brk_ambiental.png"/>
					</div>
                    <div class="row">						
                        <div class="input-field">
                            <i class="material-icons prefix">assignment_ind</i>
                            <label for="loginRede"><b>Usuário de rede</b></label>
                            <input id="loginRede" name="loginRede" type="text" class="validate" maxlength="30"/>                        
                        </div>                   
                    </div>
                    <div class="row">
                        <div class="input-field">
                            <i class="material-icons prefix">https</i>
                            <label for="senhaRede"><b>Senha de rede</b></label>
                            <input id="senhaRede" name="senhaRede" type="password" class="validate" maxlength="30"/>                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col offset-s1">
                            <div id="btnLogin" class="btn waves-effect waves-light">ENVIAR
                                <i class="material-icons right">send</i>
                            </div>  
                        </div>
                    </div>
                </fieldset>
            </form> 
        </div>
        <div class="row">
            <div class="col s3 offset-s4"></div>
        </div>
        <?php include('./Resources/tplImportJs.php') ?>

        <script type="text/javascript">
            $(document).ready(function () {
                //<enter> default para o botao enviar                
                $(document).keypress(function(e){
                    if(e.which == 13){
                        $('#btnLogin').click();
                    }
                });
                
                $('#btnLogin').click(function ()
                {     
                    var loginRede = $('#loginRede').val();
                    var senhaRede = $('#senhaRede').val();
                    
                                       
                    if ( !preenchido(loginRede)  || !preenchido(senhaRede) )   
                    {
                        errorAlert('Digite login e senha de rede.');
                        return;
                    }
                    
                    $.ajax({
                        type: 'POST',
                        data: $('#frm').serialize(),
                        url: "../Controle/loginCTRL.php?evento=autenticar",
                        dataType: 'html',
                        success: function (msg) {                             
                            if( msg.trim() == 'OK' ){                           
                                window.location.href = "principal.php";
                            }
                            else{
                                errorAlert('ERRO:' + msg);
                            }                            
                        },
                        error: function (msg) {
                            errorAlert('ERRO AJAX:' + msg);
                        }
                    });
                }
                );

            });
        </script>
    </body>
</html>


