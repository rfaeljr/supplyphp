<!DOCTYPE html>
<html>
    <head>
        <?php include('./Resources/tplImportCss.php') ?>
        <?php include('../Controle/includes.php') ?>
        <?php Funcoes::acessaView('ua.php') ?>
        <title>Cadastro de U.A.</title>
    </head>

    
        <?php include('./Resources/tplMenu.php') ?>
        <?php include('./Resources/tplImportJs.php') ?>
        <!-- Início da Região de Conteúdo -->
        
        <!-- Barra de Ferramentas -->        
        <div class="row barraFerramenta" > 
            &nbsp;&nbsp;
            <button name="btnInserirUa" id="btnInserirUa" class="tooltipped" data-tooltip="Inserir UA" <?php echo(Funcoes::permite( 'ua.php', 'inserirUa' ) == 'n' ? "hidden='hidden'" : '' );  ?> >
                <img style="height: 22px;" src="Resources/img/inserir.png" />
            </button>
            <button name="btnSalvarUa" id="btnSalvarUa" class="tooltipped" data-tooltip="Salvar UA" <?php echo(Funcoes::permite( 'ua.php', 'salvarUa' ) == 'n' ? "hidden='hidden'" : '' );  ?> >
                <img style="height: 22px;" src="Resources/img/salvar.png" />
            </button>
            <button name="btnExcluirUa" id="btnExcluirUa" class="tooltipped" data-tooltip="Excluir UA" <?php echo(Funcoes::permite( 'ua.php', 'excluirUa' ) == 'n' ? "hidden='hidden'" : '' );  ?> >
                <img style="height: 22px;" src="Resources/img/excluir.png" />
            </button>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <button name="btnLimparUa" id="btnLimparUa" class="tooltipped" data-tooltip="Limpar Formulário UA">
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
                                            <option value="id">Código da UA</option>
                                            <option value="descricao">Descrição</option>
                                            <option value="ua_alias">Código Reduzido</option>
                                            <option value="ue_id">Código da UE</option>
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
                                        <div class="waves-effect waves-light btn" id="btnPesquisarUa">pesquisar</div>
                                    </div>

                                </div>
                            </form>  

                            <table id="gridUa" cellpadding="0" cellspacing="0" border="0" class="highlight" style="font-size: 10px;">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Código Reduzido</th>
                                        <th>UE</th>
                                        <th>Descrição</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>Código</th>
                                        <th>Código Reduzido</th>
                                        <th>UE</th>
                                        <th>Descrição</th>
                                    </tr>
                                </tfoot>
                            </table> 
                            
                        </div>
                    </li>
                    
                    <li>
                        <div id="divFormulario" class="collapsible-header"><i class="material-icons">library_books</i>Formulário UA</div>
                        <div class="collapsible-body fonte11px ">
                            <form id="frmEdicaoUa">
                                <div class="row bordaRow ">                                                                    
                                    <div class="input-field col s2">
                                         <b>Código da UA:<b>
                                         <input type="text" id="ua_id" name="ua_id" value="999999" readonly/>
                                    </div>                                                                                                        
                                </div>
                                
                                <div class="row bordaRow ">  
                                    <div class="input-field col s5 fundoBranco">
                                        <b>Descrição:<b>
                                        <textarea id="descricao" name="descricao" class="materialize-textarea" maxlength="255" length="255"></textarea>
                                    </div>                                     
                                </div>                                
                                
                                <div class="row bordaRow ">  
                                    <div class="input-field col s5 fundoBranco">
                                        <b>Código Reduzido:<b>
                                        <textarea id="ua_alias" name="ua_alias" class="materialize-textarea" maxlength="30" length="30"></textarea>
                                    </div>                                     
                                </div>                                
                                
                                <div class="row bordaRow ">  
                                    <div class="input-field col s2">
                                        <b>Código UE:<b>
                                        <input type="text" id="ue_id" name="ue_id" readonly/>
                                        
                                    </div>                                     
                                    <div class="input-field col s5 fundoBranco">
                                        <b>UE:<b>
                                        <input type="text" id="descricaoUE" name="descricaoUE"  maxlength="255"/>  
                                    </div>
                                </div>                                
                            </form>  
                        </div>
                    </li>
                    
                </ul>                             
            </div>
        </div>  
        <script type="text/javascript">
           var uaId = null;
           var gridUa = null;
           var flagActionUa = null;
           var flagUaUltimos20 = true;

           function carregarGridUa() {
              var htmlId = "gridUa";
              var ajaxUrl = "../Controle/uaCTRL.php?evento=gridUa&valor=" + $('#valor').val() + "&campo=" + $('#campo').val() + "&criterio=" + $('#criterio').val(); 
              //carregar a grid com as 20 últimas solicitações
              if( flagUaUltimos20 ){
                 ajaxUrl = "../Controle/uaCTRL.php?evento=gridUa20";
                 flagUaUltimos20 = false;
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
         
                gridUa = grid( htmlId, ajaxUrl, botoesEventos, null, 10 );
           }
           
           function limparFormularioUa(){
               flagActionUa = 'inserirUa';
               $('#frmEdicaoUa').trigger("reset");             
            }

           function formularioUaValidado(e){
                if( !preenchido($('#ue_id').val())  ){
                 alert('Digite o código da UE.');
                 $('#ue_id').focus();
                 e.preventDefault();                                  
                 return false;
                }              
                
                if( !preenchido($('#descricao').val())  ){
                 alert('Digite a descrição da UA.');
                 $('#descricao').focus();
                 e.preventDefault();                                  
                 return false;
                }              

                if( !preenchido($('#ua_alias').val())  ){
                 alert('Digite o código reduzido da UA.');
                 $('#ua_alias').focus();
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
            desabilita('btnSalvarUa');
            desabilita('btnExcluirUa');
            desabilita('btnImprimirUa');
            carregarGridUa();
               
            $('select').material_select();                
            $('#descricao').characterCounter();
            
            //autocomplete
            $('#descricaoUE').autocomplete({
                  source: "../Controle/uaCTRL.php?evento=autoCompleteUe",
                  minLength: 2,
                  select: function( event, ui ) {
                     var i = ui.item.label.search("-");
                     $("#descricaoUE").val( ui.item.label.substring( (i + 1), ui.item.label.lenght  ) );                       
                     $("#ue_id").val(ui.item.label.substring(0, (i )  ) );                       
                     }                  
               });               
               
            //_____________________________________________________
            //*** E V E N T O S ***
            $('#divFormulario').click( function(e){                   
               if( flagActionUa == null ){
                  e.stopPropagation();
                  warningAlert('Clique no botão Inserir UA ou selecione uma UA da Pesquisa.');
                  return;
               }                  
            } );
               
            $('#divPesquisa').click( function(e){                   
               flagUaUltimos20 = true;
               carregarGridUa();
            } );
            
            //barra de ferramentas
            $('#btnInserirUa').click(function(){
               limparFormularioUa();
               flagActionUa = "inserirUa";
               $("#divFormulario").click();
               habilita('btnSalvarUa');                
               return;
            });                                                    
                              
            $('#btnSalvarUa').click(function(e){
                  if( formularioUaValidado(e) ){
                       $.ajax({
                        type: 'POST',
                        data: $('#frmEdicaoUa').serialize(),
                        url: "../Controle/uaCTRL.php?evento=salvarUa&opcao="+flagActionUa,
                        dataType: 'html',
                        success: function (msg) {                       

                           if( flagActionUa == 'editarUa' ){
                              //verifica se possui a funcionalidade de editar
                              if( "<?php echo(Funcoes::permite( 'ua.php', 'editarUa')) ?>" == 'n' ){
                                 blackAlert('Permissão', 'Solicite a permissão editarUa para edição de UAs.');
                                 return;
                              }           
                           }

                           if( msg.trim().substr(0, 2) == 'OK' ){
                              if( flagActionUa == 'inserirUa' ){
                                 uaId  = msg.trim().substr(3, msg.length - 2 );
                                 $('#ua_id').val(uaId);
                                                                 
                                 flagActionUa = 'editarUa';
                                 
                                 habilita('btnExcluirUa');
                              }                                                         
                              successAlert('Ua, salva com sucesso.');
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
               
            $('#btnExcluirUa').click(function(e){
                function sim(){
                   if( preenchido(uaId) ){
                        $.ajax({
                         type: 'GET',
                         url: "../Controle/uaCTRL.php?evento=excluirUa&uaId="+uaId,
                         dataType: 'html',
                         success: function (msg) {                           
                            if( msg.trim().substr(0,2) == 'OK' ){
                               flagActionUa = null;
                               desabilita('bntExcluirUa');                                                                                                                       
                               successAlert('UA excluída com sucesso.');
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
                      warningAlert('UA não selecionada.');
                   }
                }
              //excluir UA, caso sim executa o código da function sim(), acima 
              confirm(sim, null);
            });       

            //pesquisa de Ua
            $("#btnPesquisarUa").click(function () {
                    //validar as entradas
                    if ( !preenchido( $('#campo').val() )  ||
                         !preenchido( $('#criterio').val() ) ||
                         !preenchido( $('#valor').val() ) )
                    {
                        errorAlert('Preencha todos os campos');
                        return;
                    } else {
                        flagUaUltimos20 = false;
                        carregarGridUa();
                    }

                });
                
            //seleção de Ua na grid
            $('#gridUa tbody').on('click', 'tr', function () {
                   uaId = gridUa.row({selected: true}).data()[0];
                                     
                   //ajax para chamar formulário
                   $.ajax({
                        type: 'POST',
                        url: "../Controle/uaCTRL.php?evento=carregarFormUa&uaId="+uaId,
                        dataType: 'json',
                        success: function (json) {          
                              //limpar formulários
                              $('#frmEdicaoUa').trigger("reset");
                                                                                                     
                              $('#ua_id').val( json.id );
                              $('#descricao').val( json.descricao );
                              $('#ue_id').val( json.ue_id );
                              $('#ua_alias').val( json.ua_alias );
                              $('#descricaoUE').val(json.descricaoUE);

                              flagActionUa = 'editarUa';
                              $('#divFormulario').click();
                              habilita('btnSalvarUa');
                              habilita('btnExcluirUa');
                              habilita('btnImprimirUa');
                              
                              return;
                        },
                        error: function (xhr, status, error) {                           
                            errorAlert('ERRO AJAX:' + error);
                        }
                    });
                   
                }); 
                
            $("#btnLimparUa").click(function(){      
               limparFormularioUa();                
                  
               });      
            });            

        </script>            
        
</html>