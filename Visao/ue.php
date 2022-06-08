<!DOCTYPE html>
<html>
    <head>
        <?php include('./Resources/tplImportCss.php') ?>
        <?php include('../Controle/includes.php') ?>
        <?php Funcoes::acessaView('ue.php') ?>
        <title>Cadastro de U.E.</title>
    </head>

    
        <?php include('./Resources/tplMenu.php') ?>
        <?php include('./Resources/tplImportJs.php') ?>
        <!-- Início da Região de Conteúdo -->
        
        <!-- Barra de Ferramentas -->        
        <div class="row barraFerramenta" > 
            &nbsp;&nbsp;
            <button name="btnInserirUe" id="btnInserirUe" class="tooltipped" data-tooltip="Inserir UE" <?php echo(Funcoes::permite( 'ue.php', 'inserirUe' ) == 'n' ? "hidden='hidden'" : '' );  ?> >
                <img style="height: 22px;" src="Resources/img/inserir.png" />
            </button>
            <button name="btnSalvarUe" id="btnSalvarUe" class="tooltipped" data-tooltip="Salvar UE" <?php echo(Funcoes::permite( 'ue.php', 'salvarUe' ) == 'n' ? "hidden='hidden'" : '' );  ?> >
                <img style="height: 22px;" src="Resources/img/salvar.png" />
            </button>
            <button name="btnExcluirUe" id="btnExcluirUe" class="tooltipped" data-tooltip="Excluir UE" <?php echo(Funcoes::permite( 'ue.php', 'excluirUe' ) == 'n' ? "hidden='hidden'" : '' );  ?> >
                <img style="height: 22px;" src="Resources/img/excluir.png" />
            </button>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <button name="btnLimparUe" id="btnLimparUe" class="tooltipped" data-tooltip="Limpar Formulário UE">
                <img style="height: 22px;" src="Resources/img/limpar.png" />
            </button>
        </div>

        <div class="row">
            <div class="conteudo">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div id="divPesquisa" class="collapsible-header active"><i class="material-icons">search</i>Pesquisa</div>
                        
                        <div class="collapsible-body">                            
                            <form id="frmPesquisa">
                                <div class="row">
                                    <div class="input-field col s2">
                                        <select id="campo" name="campo">
                                            <option value="" disabled selected>Campo</option>
                                            <option value="id">Código da UE</option>
                                            <option value="descricao">Descrição</option>
                                        </select>                                         
                                    </div>
                                    <div class="input-field col s2">
                                        <select id="criterio" name="criterio">
                                            <option value="" disabled selected>Critério</option>
                                            <option value="LIKE">Contém</option>
                                        </select> 
                                    </div>
                                    <div class="input-field col s2">
                                        <label for="valor">Valor</label>
                                        <input id="valor" name="valor" type="text" class="validate" maxlength="30"/>                        
                                    </div>
                                    <div class="input-field col s2">
                                        <div class="waves-effect waves-light btn" id="btnPesquisarUe">pesquisar</div>
                                    </div>

                                </div>
                            </form>  

                            <table id="gridUe" cellpadding="0" cellspacing="0" border="0" class="highlight" style="font-size: 10px;">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Descrição</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>Código</th>
                                        <th>Descrição</th>
                                    </tr>
                                </tfoot>
                            </table> 
                            
                        </div>
                    </li>
                    
                    <li>
                        <div id="divFormulario" class="collapsible-header"><i class="material-icons">library_books</i>Formulário UE</div>
                        <div class="collapsible-body fonte11px ">
                            <form id="frmEdicaoUe">
                                <div class="row bordaRow ">                                                                    
                                    <div class="input-field col s2">
                                         <b>Código da UE:<b>
                                         <input type="text" id="ueId" name="ueId"/>
                                    </div>                                                                                                        
                                </div>
                                
                                <div class="row bordaRow ">  
                                    <div class="input-field col s5 fundoBranco">
                                        <b>Descrição:<b>
                                        <textarea id="descricao" name="descricao" class="materialize-textarea" maxlength="255" length="255"></textarea>
                                    </div>                                     
                                </div>                                
                            </form>  
                        </div>
                    </li>
                    
                </ul>                             
            </div>
        </div>  
        
        <script type="text/javascript">
           var ueId = null;
           var gridUe = null;
           var flagActionUe = null;
           var flagUeUltimos20 = true;
           
            function carregarGridUe() {
                var htmlId = "gridUe";
                var ajaxUrl = "../Controle/ueCTRL.php?evento=gridUe&valor=" + $('#valor').val() + "&campo=" + $('#campo').val() + "&criterio=" + $('#criterio').val(); 
                //carregar a grid com as 20 últimas solicitações
                if( flagUeUltimos20 ){
                    ajaxUrl = "../Controle/ueCTRL.php?evento=gridUe20";
                    flagUeUltimos20 = false;
                }
              
               var botoesEventos = [
                                        {
                                            extend: 'copy',
                                            text: 'Copiar'
                                        },
                                        {
                                            extend: 'print',
                                            text: 'Imprimir'
                                        },
                                        'excel',
                                        'pdf'
                                    ];
         
                 gridUe = grid( htmlId, ajaxUrl, botoesEventos, null, 10 );
            }
            
            function limparFormularioUe(){
               flagActionUe = 'inserirUe';
               $('#frmEdicaoUe').trigger("reset");             
            }
            
            function formularioUeValidado(e){
                if( !preenchido($('#ueId').val())  ){
                 alert('Digite o código da UE.');
                 $('#ueId').focus();
                 e.preventDefault();                                  
                 return false;
                }              
                
                if( !preenchido($('#descricao').val())  ){
                 alert('Digite a descrição da UE.');
                 $('#descricao').focus();
                 e.preventDefault();                                  
                 return false;
                }              

                return true;                
            }
           
            $(document).ready(function () {
            /*** A P P ***/
            $(".dropdown-button").dropdown();
            $('select').material_select();
            
            //*** I N I C I A L I Z A C A O ***
            desabilita('btnSalvarUe');
            desabilita('btnExcluirUe');
            desabilita('btnImprimirUe');
            carregarGridUe();
               
            $('select').material_select();                
            $('#descricao').characterCounter();
            
            //_____________________________________________________
            //*** E V E N T O S ***
            $('#divFormulario').click( function(e){                   
               if( flagActionUe == null ){
                  e.stopPropagation();
                  warningAlert('Clique no botão Inserir UE ou selecione uma UE da Pesquisa.');
                  return;
               }                  
            } );
               
            $('#divPesquisa').click( function(e){                   
               flagUeUltimos20 = true;
               carregarGridUe();
            } );
            
            //barra de ferramentas
            $('#btnInserirUe').click(function(){
               limparFormularioUe();
               flagActionUe = "inserirUe";
               $("#divFormulario").click();
               habilita('btnSalvarUe');                
               return;
            });                                                    
                              
            $('#btnSalvarUe').click(function(e){
                  if( formularioUeValidado(e) ){
                       $.ajax({
                        type: 'POST',
                        data: $('#frmEdicaoUe').serialize(),
                        url: "../Controle/ueCTRL.php?evento=salvarUe&opcao="+flagActionUe,
                        dataType: 'html',
                        success: function (msg) {                       

                            if( flagActionUe == 'editarUe' ){
                               //verifica se possui a funcionalidade de editar
                               if("<?php echo(Funcoes::permite( 'ue.php', 'editarUe')) ?>" == 'n' ){
                                  blackAlert('Permissão', 'Solicite a permissão editarUe para edição de UEs.');
                                  return;
                               }           
                             }
                             
                           if( msg.trim().substr(0, 2) == 'OK' ){
                              if( flagActionUe == 'inserirUe' ){
                                 ueId = msg.trim().substr(3, msg.length - 2 );
                                                                 
                                 flagActionUe = 'editarUe';
                                 
                                 habilita('btnExcluirUe');
                              }                                                         
                              successAlert('Ue, salva com sucesso.');
                           }
                           else{
                              errorAlert(msg);
                           }
                        },
                        error: function (msg) {
                           errorAlert('ERRO AJAX:' + msg);
                        }
                  });
                }
               });  
               
            $('#btnExcluirUe').click(function(e){
                function sim(){
                   if( preenchido(ueId) ){
                        $.ajax({
                         type: 'GET',
                         url: "../Controle/ueCTRL.php?evento=excluirUe&ueId="+ueId,
                         dataType: 'html',
                         success: function (msg) {                           
                            if( msg.trim().substr(0,2) == 'OK' ){
                               flagActionUe = null;
                               desabilita('bntExcluirUe');                                                                                                                       
                               successAlert('UE excluída com sucesso.');
                               e.preventDefault();
                               $('#divPesquisa').click(); 
                            }
                            else{
                               errorAlert(msg);
                            }
                         },
                         error: function (msg) {
                            errorAlert('ERRO AJAX:' + msg);
                         }
                         });
                   }
                   else{
                      warningAlert('UE não selecionada.');
                   }
                }
              //excluir UE, caso sim executa o código da function sim(), acima 
              confirm(sim, null);
            });       

            //pesquisa de Ue
            $("#btnPesquisarUe").click(function () {
                    //validar as entradas
                    if ( !preenchido( $('#campo').val() )  ||
                         !preenchido( $('#criterio').val() ) ||
                         !preenchido( $('#valor').val() ) )
                    {
                        errorAlert('Preencha todos os campos');
                        return;
                    } else {
                        flagUeUltimos20 = false;
                        carregarGridUe();
                    }

                });
                
            //seleção de Ue na grid
            $('#gridUe tbody').on('click', 'tr', function () {
                   ueId = gridUe.row({selected: true}).data()[0];
                                     
                   //ajax para chamar formulário
                   $.ajax({
                        type: 'POST',
                        url: "../Controle/ueCTRL.php?evento=carregarFormUe&ueId="+ueId,
                        dataType: 'json',
                        success: function (json) {          
                              //limpar formulários
                              $('#frmEdicaoUe').trigger("reset");
                                                                                                     
                              $('#ueId').val( json.id );
                              $('#descricao').val( json.descricao );
                                                

                              flagActionUe = 'editarUe';
                              $('#divFormulario').click();
                              habilita('btnSalvarUe');
                              habilita('btnExcluirUe');
                              habilita('btnImprimirUe');
                              
                              return;
                        },
                        error: function (xhr, status, error) {                           
                            errorAlert('ERRO AJAX:' + error);
                        }
                    });
                   
                }); 
                
            $("#btnLimparUe").click(function(){      
               limparFormularioUe();                
                  
               });      
            });            
        </script>            
    
</html>