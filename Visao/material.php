<!DOCTYPE html>
<html>
    <head>
        <?php include('./Resources/tplImportCss.php') ?>
        <?php include('../Controle/includes.php') ?>
        <?php Funcoes::acessaView('material.php') ?>
        <title>Cadastro de Material</title>
    </head>    
    
    <?php include('./Resources/tplMenu.php') ?>
    <?php include('./Resources/tplImportJs.php') ?>
    <!-- Início da Região de Conteúdo -->    
    
    <!-- Barra de Ferramentas -->        
    <div class="row barraFerramenta" > 
        &nbsp;&nbsp;
        <button name="btnInserirMaterial" id="btnInserirMaterial" class="tooltipped" data-tooltip="Inserir Material" <?php echo(Funcoes::permite( 'material.php', 'inserirMaterial' ) == 'n' ? "hidden='hidden'" : '' );  ?> >
            <img style="height: 22px;" src="Resources/img/inserir.png" />
        </button>
        <button name="btnSalvarMaterial" id="btnSalvarMaterial" class="tooltipped" data-tooltip="Salvar Material" <?php echo(Funcoes::permite( 'material.php', 'salvarMaterial' ) == 'n' ? "hidden='hidden'" : '' );  ?> >
            <img style="height: 22px;" src="Resources/img/salvar.png" />
        </button>
        <button name="btnExcluirMaterial" id="btnExcluirMaterial" class="tooltipped" data-tooltip="Excluir Material" <?php echo(Funcoes::permite( 'material.php', 'excluirMaterial' ) == 'n' ? "hidden='hidden'" : '' );  ?> >
            <img style="height: 22px;" src="Resources/img/excluir.png" />
        </button>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <button name="btnLimparMaterial" id="btnLimparMaterial" class="tooltipped" data-tooltip="Limpar Formulário Material">
            <img style="height: 22px;" src="Resources/img/limpar.png" />
        </button>
    </div>
    
    <div class="row">
        <div class="conteudo">
            <ul class="collapsible" data-collapsible="accordion">
                <!-- Form de Pesquisa -->                 
                <li>
                    <div id="divPesquisa" class="collapsible-header active"><i class="material-icons">search</i>Pesquisa</div>
                    <div class="collapsible-body">                            
                        <form id="frmPesquisa">
                            <div class="row">
                                <div class="input-field col s2">
                                    <select id="campo" name="campo">
                                        <option value="" disabled selected>Campo</option>
                                        <option value="codigo">Código do Material</option>
                                        <option value="descricao">Descrição</option>
                                        <option value="grupo">Grupo</option>
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
                                    <div class="waves-effect waves-light btn" id="btnPesquisarMaterial">pesquisar</div>
                                </div>

                            </div>
                        </form>  

                        <table id="gridMaterial" cellpadding="0" cellspacing="0" border="0" class="highlight" style="font-size: 10px;">
                            <thead>
                                <tr>
                                    <th>Código Interno</th>
                                    <th>Grupo</th>
                                    <th>Código Produto</th>
                                    <th>Descrição</th>
                                    <th>Unidade</th>
                                    <th>Preço Médio</th>
                                </tr>
                            </thead>
                            
                            <tbody></tbody>
                            
                            <tfoot>
                                <tr>
                                    <th>Código Interno</th>
                                    <th>Grupo</th>
                                    <th>Código Produto</th>
                                    <th>Descrição</th>
                                    <th>Unidade</th>
                                    <th>Preço Médio</th>
                                </tr>
                            </tfoot>
                        </table> 
                            
                    </div>
                </li>
                
                <!-- Form de Edição -->                                     
                <li>
                    <div id="divFormulario" class="collapsible-header"><i class="material-icons">library_books</i>Formulário Material</div>
                    <div class="collapsible-body fonte11px ">
                        <form id="frmEdicaoMaterial">
                            <div class="row bordaRow ">                                                                    
                                <div class="input-field col s2">
                                     <b>Código interno do Material:<b>
                                     <input type="text" id="materialId" name="materialId" value="999999" readonly/>
                                </div>                                                                                                        
                            </div>
                                                           
                            <div class="row bordaRow ">  
                                <div class="input-field col s2 fundoBranco">
                                    <b>Grupo:<b>
                                    <input type = "text" id="materialGrupo" name="materialGrupo" maxlength="6" length="6"/>
                                </div>                                     
                            </div>
                            
                            <div class="row bordaRow ">  
                                <div class="input-field col s2 fundoBranco">
                                    <b>Código:<b>
                                    <input type = "text" id="materialCodigo" name="materialCodigo" maxlength="50" length="50" />
                                </div>                                     
                            </div>

                            <div class="row bordaRow ">  
                                <div class="input-field col s5 fundoBranco">
                                    <b>Descrição:<b>
                                    <textarea id="materialDescricao" name="materialDescricao" class="materialize-textarea" maxlength="255" length="255"></textarea>
                                </div>                                     
                            </div>

                            <div class="row bordaRow ">  
                                <div class="input-field col s2 fundoBranco">
                                    <b>Unidade:<b>
                                        <select id="materialUnidade" name="materialUnidade">
                                            <option value="" disabled selected>Selecione</option>
                                            <option value="BALDE">Balde</option>
                                            <option value="BL">Bloco</option>
                                            <option value="BR">Barra</option>
                                            <option value="CJ">Conjunto</option>
                                            <option value="CM">Centímetro</option>
                                            <option value="CT">CT</option>
                                            <option value="CX">Caixa</option>
                                            <option value="FD">Fardo</option>
                                            <option value="FL">Folha</option>
                                            <option value="FR">Frasco</option>
                                            <option value="GL">Galão</option>
                                            <option value="GLB">GLB</option>
                                            <option value="JG">Jogo</option>
                                            <option value="KG">Kilograma</option>
                                            <option value="L">Litro</option>
                                            <option value="LT">Lata</option>
                                            <option value="M">Metro</option>
                                            <option value="M2">Metro Quadrado</option>
                                            <option value="M3">Metro Cúbico</option>
                                            <option value="MIL">Milheiro</option>
                                            <option value="ML">Mililitro</option>
                                            <option value="MT">MT</option>
                                            <option value="PA">PA</option>
                                            <option value="PAR">PAR</option>
                                            <option value="PC">Peça</option>
                                            <option value="PCT">Pacote</option>
                                            <option value="PR">PR</option>
                                            <option value="QT">QT</option>
                                            <option value="RL">Rolo</option>
                                            <option value="RM">Resma</option>
                                            <option value="SC">Saco</option>
                                            <option value="SV">Serviço</option>
                                            <option value="T">Tonelada</option>
                                            <option value="TB">TB</option>
                                            <option value="TN">TN</option>
                                            <option value="UN">Unidade</option>
                                            <option value="UND">UND</option>
                                        <!-- Freitas-->
                                        </select> 
                                </div>                                     
                            </div>

                            <div class="row bordaRow ">                                                                    
                                <div class="input-field col s2">
                                     <b>Preço Médio:<b>
                                     <input type="text" id="materialprecoMedio" name="materialprecoMedio"/>
                                </div>                                                                                                        
                            </div>

                        </form>  
                    </div>
                </li>
                    
            </ul>                             
        </div>
    </div>  
    
    <script type="text/javascript">
        var materialId = null;
        var gridMaterial = null;
        var flagActionMaterial = null;
        var flagMaterialUltimos20 = true;
           
        function carregarGridMaterial() {
            var htmlId = "gridMaterial";
            var ajaxUrl = "../Controle/materialCTRL.php?evento=gridMaterial&valor=" + $('#valor').val() + "&campo=" + $('#campo').val() + "&criterio=" + $('#criterio').val(); 
            //carregar a grid com as 20 últimas solicitações
            if( flagMaterialUltimos20 ){
                ajaxUrl = "../Controle/materialCTRL.php?evento=gridMaterial20";
                flagMaterialUltimos20 = false;
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
         
            gridMaterial = grid( htmlId, ajaxUrl, botoesEventos, null, 10 );
        }
            
        function limparFormularioMaterial(){
            flagActionMaterial = 'inserirMaterial';
            $('#frmEdicaoMaterial').trigger("reset");             
        }
            
        function formularioMaterialValidado(e){               
            if( !preenchido($('#materialGrupo').val())  ){
                alert('Digite o grupo do Material.');
                $('#materialGrupo').focus();
                e.preventDefault();                                  
                return false;
            }              

            if( !preenchido($('#materialCodigo').val())  ){
                alert('Digite o código do Material.');
                $('#materialCodigo').focus();
                e.preventDefault();                                  
                return false;
            }              

            if( !preenchido($('#materialDescricao').val())  ){
                alert('Digite a descrição do Material.');
                $('#materialDescricao').focus();
                e.preventDefault();                                  
                return false;
            }              

            if( !preenchido($('#materialUnidade').val())  ){
                alert('Digite a unidade do Material.');
                $('#materialUnidade').focus();
                e.preventDefault();                                  
                return false;
            }              

            if( !preenchido($('#materialprecoMedio').val())  ){
                alert('Digite o preço médio do Material.');
                $('#materialprecoMedio').focus();
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
        desabilita('btnSalvarMaterial');
        desabilita('btnExcluirMaterial');
        desabilita('btnImprimirMaterial');
        carregarGridMaterial();
               
        $('select').material_select();                
        $('#materialDescricao').characterCounter();
              
            
        //_____________________________________________________
        //*** E V E N T O S ***
        $('#divFormulario').click( function(e){                   
            if( flagActionMaterial == null ){
                e.stopPropagation();
                warningAlert('Clique no botão Inserir Material ou selecione um Material na Pesquisa.');
                return;
            }                  
        } );
               
        $('#divPesquisa').click( function(e){                   
            flagMaterialUltimos20 = true;
            carregarGridMaterial();
        } );
            
        //barra de ferramentas
        $('#btnInserirMaterial').click(function(){
            limparFormularioMaterial();
            flagActionMaterial = "inserirMaterial";
            $("#divFormulario").click();
            habilita('btnSalvarMaterial');                
            return;
        });                                                    
                              
        $('#btnSalvarMaterial').click(function(e){               
            if( formularioMaterialValidado(e) ){
                $.ajax({
                type: 'POST',
                data: $('#frmEdicaoMaterial').serialize(),
                url: "../Controle/materialCTRL.php?evento=salvarMaterial&opcao="+flagActionMaterial,
                dataType: 'html',
                success: function (msg) {                                                     
                           
                if( flagActionMaterial == 'editarMaterial' ){
                   //verifica se possui a funcionalidade de editar
                   if( "<?php echo(Funcoes::permite( 'material.php', 'editarMaterial')) ?>" == 'n' ){
                      blackAlert('Permissão', 'Solicite a permissão editarMaterial para edição de Materiais.');
                      return;
                   }           
                }
                           
                if( msg.trim().substr(0, 2) == 'OK' ){
                    if( flagActionMaterial == 'inserirMaterial' ){
                        materialId = msg.trim().substr(3, msg.length - 2 );
                                                                 
                        flagActionMaterial = 'editarMaterial';
                                 
                        habilita('btnExcluirMaterial');
                    }
                    successAlert('Material, salvo com sucesso.');
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
               
        $('#btnExcluirMaterial').click(function(e){
            function sim(){
                if( preenchido(materialId) ){
                    $.ajax({
                        type: 'GET',
                        url: "../Controle/materialCTRL.php?evento=excluirMaterial&materialId="+materialId,
                        dataType: 'html',
                        success: function (msg) {                           
                            if( msg.trim().substr(0,2) == 'OK' ){
                               flagActionMaterial = null;
                               desabilita('bntExcluirMaterial');                                                                                                                       
                               successAlert('Material excluído com sucesso.');
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
                      warningAlert('Material não selecionado.');
                   }
                }
              //excluir Material, caso sim executa o código da function sim(), acima 
              confirm(sim, null);
            });       

        //pesquisa de Material
        $("#btnPesquisarMaterial").click(function () {
                    //validar as entradas
                    if ( !preenchido( $('#campo').val() )  ||
                         !preenchido( $('#criterio').val() ) ||
                         !preenchido( $('#valor').val() ) )
                    {
                        errorAlert('Preencha todos os campos');
                        return;
                    } else {
                        flagMaterialUltimos20 = false;
                        carregarGridMaterial();
                    }

                });
                
        //seleção de Material na grid
        $('#gridMaterial tbody').on('click', 'tr', function () {
               materialId = gridMaterial.row({selected: true}).data()[0];

               //ajax para chamar formulário
               $.ajax({
                    type: 'POST',
                    url: "../Controle/materialCTRL.php?evento=carregarFormMaterial&materialId="+materialId,
                    dataType: 'json',
                    success: function (json) {          
                          //limpar formulários
                          $('#frmEdicaoMaterial').trigger("reset");

                          $('#materialId').val( json.id );
                          $('#materialGrupo').val( json.grupo );
                          $('#materialCodigo').val( json.codigo );
                          $('#materialDescricao').val( json.descricao );
                          $('#materialprecoMedio').val( json.preco_medio );
                          $('#materialUnidade').val( json.unidade );
                          
//                          alert(json.unidade);
                          $('#materialUnidade').material_select();                
                          
                          flagActionMaterial = 'editarMaterial';
                          $('#divFormulario').click();
                          habilita('btnSalvarMaterial');
                          habilita('btnExcluirMaterial');
                          habilita('btnImprimirMaterial');

                          return;
                    },
                    error: function (xhr, status, error) {                           
                        errorAlert('ERRO AJAX:' + error);
                    }
                });

            }); 

        $("#btnLimparMaterial").click(function(){      
           limparFormularioMaterial();                

           });      
        });            
        </script>            

</html>
