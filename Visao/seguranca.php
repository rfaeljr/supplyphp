<!DOCTYPE html>
<html>
    <head>
        <?php include('./Resources/tplImportCss.php') ?>
        <?php include('../Controle/includes.php') ?>
        <?php Funcoes::acessaView( 'seguranca.php' ) ?> 
        <title>Segurança</title>
    </head>
    <body>
        <?php include('./Resources/tplMenu.php') ?>
        <!-- conteudo -->
        <div class="row">
            <ul class="tabs z-depth-1">
                <li class="tab col s2 <?php echo(Funcoes::permite( 'seguranca.php', 'tabPagina' ) == 'n' ? "disabled" : '' ); ?>" ><a  href="#tabView">1-Cadastro de Páginas</a></li>
                <li class="tab col s2 <?php echo(Funcoes::permite( 'seguranca.php', 'tabFuncionalidade' ) == 'n' ? "disabled" : '' ); ?>"><a  href="#tabFuncionalidade">2-Cadastro de Funcionalidades</a></li> 
                <li class="tab col s2"><a  class="active" href="#tabAcesso">3-Acesso a páginas</a></li> 
                <li class="tab col s2"><a  href="#tabIntegrante">4-Cadastro de Integrante</a></li>                    
            </ul>
            <!-- 1-Página -->
            <div id="tabView" class="col s11">
                <br/>
                <div class="row bordaRow">
                    <form id="frmView">                        
                        <div class="col s10">
                            <div class="input-field col s2">
                                <label for="viewArquivo">Arquivo nome:</label>
                                <input id="viewArquivo" name="viewArquivo" type="text" class="validate" maxlength="30"/>
                            </div>
                            <div class="input-field col s3">
                                <label for="viewUrl">Url:</label>
                                <input id="viewUrl" name="viewUrl" type="text" class="validate" maxlength="255"/>
                            </div>
                            <div class="input-field col s5">
                                <label for="viewDescricao">Descrição:</label>
                                <input id="viewDescricao" name="viewDescricao" type="text" class="validate" maxlength="255"/>
                            </div>
                        </div>    
                        <br/>
                        <div class="bordaRow col s1">
                            Ação<br/>
                            <a href="#">
                                <img id="btnViewInserir" style="height: 22px;" src="Resources/img/inserir.png" class="tooltipped" data-tooltip="Inserir" />
                            </a>                        
                            &nbsp;&nbsp;
                            <a href="#">
                                <img id="btnViewEditar" style="height: 22px;" src="Resources/img/editar.png" class="tooltipped" data-tooltip="Editar"/>
                            </a>
                            &nbsp;&nbsp;
                            <a href="#">
                                <img id="btnViewExcluir" style="height: 22px;" src="Resources/img/excluir.png" class="tooltipped" data-tooltip="Excluir"/>
                            </a>
                        </div>

                    </form>
                </div>
                <div class="row bordaRow">
                    <table id="gridView" cellpadding="0" cellspacing="0" border="0" class="col s10 highlight" style="font-size: 10px">
                        <thead>
                            <tr>
                                <th>Arquivo</th>
                                <th>Url</th>     
                                <th>Descrição</th>    
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th>Arquivo</th>
                                <th>Url</th>     
                                <th>Descrição</th>                                                                           
                            </tr>
                        </tfoot>
                    </table> 
                </div> 
            </div>

            <!-- 2-Funcionalidade -->
            <div id="tabFuncionalidade" class="col s11">
                <br/>
                <div class="row bordaRow">
                    <!--Formulário -->
                    <div class="col s9">
                        <form id="frmFunc">
                            <input id="funcId" name="funcId" type="hidden"/>                        
                            <div class="input-field col s3">
                                <select id="funcPagina" name="funcPagina">
                                </select> 
                                <label for="funcPagina">Página</label>
                            </div>
                            <div class="input-field col s5">
                                <label for="funcAcao">Funcionalidade:</label>
                                <input id="funcAcao" name="funcAcao" type="text" class="validate" maxlength="60"/>
                            </div>
                        </form>
                    </div>
                    <!-- Ação -->
                    <br/>
                    <div class="bordaRow col s1">
                        Ação:<br/>
                        <a href="#">
                            <img id="btnFuncInserir" style="height: 22px;" src="Resources/img/inserir.png" class="tooltipped" data-tooltip="Inserir" />
                        </a>                        
                        &nbsp;&nbsp;
                        <a href="#">
                            <img id="btnFuncEditar" style="height: 22px;" src="Resources/img/editar.png" class="tooltipped" data-tooltip="Editar"/>
                        </a>
                        &nbsp;&nbsp;
                        <a href="#">
                            <img id="btnFuncExcluir" style="height: 22px;" src="Resources/img/excluir.png" class="tooltipped" data-tooltip="Excluir"/>
                        </a>
                    </div>
                </div>
                <div class="row bordaRow">
                    <table id="gridFunc" cellpadding="0" cellspacing="0" border="0" class="col s10 highlight" style="font-size: 10px">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Página</th>     
                                <th>Funcionalidade</th>    
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Página</th>     
                                <th>Funcionalidade</th>                                                                           
                            </tr>
                        </tfoot>
                    </table> 
                </div>
            </div>
            <!-- 3-Acesso -->
            <div id="tabAcesso" class="col s11">
                <br/>
                <form id="frmAcesso">
                    <div class="row bordaRow col s11">
                        <div class="input-field col s4">
                            <select id="acessoPerfil" name="acessoPerfil">
                                <option value="" disabled selected>Selecione</option>
                                <option value="ADM">ADM=Administradores do Sistema</option>                                
                                <option value="SUPRIMENTO">SUPRIMENTO=Usuários do setor de Suprimento</option>
                                <option value="COMUM">COMUM=Usuário comuns do Sistema</option>
								<option value="VENUSCONSULTA">VENUSCONSULTA=Perfil apenas para consulta das NM'S</option>
                                <option value="DESENV">DESENV=Desenvolvedores do Sistema</option>
								<option value="TI">TI=Integrantes da Tecnologia da Informação</option>
                            </select> 
                            <label for="acessoPerfil">Perfil do Sistema</label>
                        </div>
                        <div class="input-field col s3">
                            <select id="acessoPagina" name="acessoPagina">
                            </select> 
                            <label for="acessoPagina">Página</label>
                        </div>                        
                        &nbsp;&nbsp;
                        <br/>
                        <div class="bordaRow col s1">
                            Ação<br/>
                            <a href="#">
                                <img id="btnAcessoInserir" style="height: 22px;" src="Resources/img/inserir.png" class="tooltipped" data-tooltip="Inserir" />
                            </a>                        
                            &nbsp;&nbsp;
                            <a href="#">
                                <img id="btnAcessoExcluir" style="height: 22px;" src="Resources/img/excluir.png" class="tooltipped" data-tooltip="Excluir"/>
                            </a>   
                        </div>
                    </div>
                </form>
                <!-- Grid de páginas -->
                <div class="row bordaRow col s11 ">                                
                    <table id="gridPaginas" cellpadding="0" cellspacing="0" border="0" class="highlight" style="font-size: 10px">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Página</th>                                                                  
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Página</th>                                                                         
                            </tr>
                        </tfoot>
                    </table> 
                </div>
                <!-- Formulário de funcionalidades da página -->
                <div class="row">
                    <div id="divFrmPermissao">
                        <form id="frmPermissao">
                            <div id="listaDeFuncionalidades">                               
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- 4-Integrante -->
            <div id="tabIntegrante" class="col s11">
                <br/>
                <form id="frmIntegrante">
                    <div class="row bordaRow col s11">
                        <div class="row">
                            <div class="input-field col s1">
                                <input type="hidden" id="intId" name="intId" />
                                <input type="text" maxlength="10" id="intMatricula" name="intMatricula" />
                                <label for="intMatricula">Matrícula</label>
                            </div>
                            <div class="input-field col s3">
                                <input type="text" id="intUa" name="intUa"/>
                                <label for="intUa">Unidade Administrativa</label>
                            </div>
                            <div class="input-field col s5">
                                <input type="text" maxlength="150" id="intNome" name="intNome"/>
                                <label for="intNome">Nome</label>
                            </div>
                            &nbsp;&nbsp;
                            <br/>
                            <div class="bordaRow col s2 offset-s1">
                                Ação<br/>
                                <a href="#">
                                    <img id="btnIntInserir" style="height: 22px;" src="Resources/img/inserir.png" class="tooltipped" data-tooltip="Inserir" />
                                </a>
                                <a href="#">
                                    <img id="btnIntEditar" style="height: 22px;" src="Resources/img/editar.png" class="tooltipped" data-tooltip="Editar"/>
                                </a>
                                <a href="#">
                                    <img id="btnIntPesquisar" style="height: 22px;" src="Resources/img/pesquisar.png" class="tooltipped" data-tooltip="Pesquisar por UA e/ou Nome"/>
                                </a>
                                <a href="#">
                                    <img id="btnIntLimparFrm" style="height: 22px;" src="Resources/img/limpar.png" class="tooltipped" data-tooltip="Limpar formulário"/>
                                </a>                               

                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s4">
                                <select id="intPerfil" name="intPerfil">
                                    <option value="" disabled selected>Selecione</option>
                                    <option value="ADM">ADM=Administradores do Sistema</option>                                
                                    <option value="SUPRIMENTO">SUPRIMENTO=Usuários do setor de Suprimento</option>
                                    <option value="COMUM">COMUM=Usuário comuns do Sistema</option>
									<option value="VENUSCONSULTA">VENUSCONSULTA=Perfil apenas para consulta das NM'S</option>
                                    <option value="DESENV">DESENV=Desenvolvedores do Sistema</option>
									<option value="TI">TI=Integrantes da Tecnologia da Informação</option>
                                </select> 
                                <label for="intPerfil">Perfil de Acesso</label>
                            </div>
                            <div class="input-field col s2">
                                <input type="text" id="intCpf" name="intCpf"/>
                                <label for="intCpf">Cpf</label>
                            </div> 
                            <div class="input-field col s2">
                                <input type="text" id="intDtAdmissao" name="intDtAdmissao"/>
                                <label for="intDtAdmissao">Data de Admissão</label>
                            </div> 
                        </div>    
                        <div class="row">
                            <div class="input-field col s4">
                                <input type="text" maxlength="150" id="intCargo" name="intCargo"/>
                                <label for="intCargo">Cargo</label>
                            </div> 
                            <div class="input-field col s4">
                                <input type="text" maxlength="150" id="intLider" name="intLider"/>
                                <label for="intLider">Líder</label>
                            </div> 
                        </div>  

                    </div>
                </form>
                <div class="row bordaRow col s11 ">                                
                    <table id="gridIntegrantes" cellpadding="0" cellspacing="0" border="0" class="col s10 highlight" style="font-size: 10px">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Matrícula</th>
                                <th>Unidade Administrativa</th> 
                                <th>Nome</th>
                                <th>Cpf</th>
                                <th>Data de Admissão Foz</th>
                                <th>Cargo</th>
                                <th>Líder Nome</th>
                                <th>Perfil de Permissão</th>                 
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Matrícula</th>
                                <th>Unidade Administrativa</th> 
                                <th>Nome</th>
                                <th>Cpf</th>
                                <th>Data de Admissão Foz</th>
                                <th>Cargo</th>
                                <th>Líder Nome</th>
                                <th>Perfil de Permissão</th>                                                                          
                            </tr>
                        </tfoot>
                    </table> 
                </div>
            </div>

        </div>

        <?php include('./Resources/tplRodape.php') ?>
        <?php include('./Resources/tplImportJs.php') ?>
        <script type="text/javascript">

           $(document).ready(function () {
               //declaração de functions
               function carregarGridView() {
                   var htmlId = "gridView";
                   var ajaxUrl = "../Controle/segurancaCTRL.php?evento=views";
                   var botoesEventos = [];
                   var colDefs = [{"targets": [0], "visible": true}];

                   xGridView = grid(htmlId, ajaxUrl, botoesEventos, colDefs, 6);
               }
               function carregarGridFunc() {
                   var htmlId = "gridFunc";
                   var ajaxUrl = "../Controle/segurancaCTRL.php?evento=funcs";
                   var botoesEventos = [];
                   var colDefs = [{"targets": [0], "visible": true}];

                   xGridFunc = grid(htmlId, ajaxUrl, botoesEventos, colDefs, 6);
               }
               function carregarGridPaginas(xPerfil) {
                   var htmlId = "gridPaginas";
                   var ajaxUrl = "../Controle/segurancaCTRL.php?evento=perfilView&perfil=" + xPerfil;
                   var botoesEventos = [];
                   var colDefs = [{"targets": [0], "visible": true}];

                   xGridPaginas = grid(htmlId, ajaxUrl, botoesEventos, colDefs, 6);
               }
               function carregarGridIntegrantes(xUa, xNome) {
                   var htmlId = "gridIntegrantes";
                   var ajaxUrl = "../Controle/segurancaCTRL.php?evento=gridIntegrantes&ua=" + xUa + "&nome=" + xNome;
                   var botoesEventos = [];
                   var colDefs = [{"targets": [0], "visible": false}];

                   xGridIntegrantes = grid(htmlId, ajaxUrl, botoesEventos, colDefs, 6);
               }
               function carregarCamposPagina() {
                   $.get("../Controle/segurancaCTRL.php?evento=listaDePaginas", function (data) {
                       $("#acessoPagina").html(data);
                       $("#funcPagina").html(data);

                       $('#acessoPagina').material_select();
                       $("#funcPagina").material_select();
                   });
               }

               //Inicialização
               var xGridView = null;
               var xGridFunc = null;
               var xGridPaginas = null;
               var xGridIntegrantes = null;
               //Form modal
               var xFrmPermissao = null;


               //formúlario modal de produtos
               xFrmPermissao = $('#divFrmPermissao').dialog({
                   title: "Permissões ",
                   autoOpen: false,
                   height: 500,
                   width: 600,
                   modal: true,
                   close: function (event, ui) {
                       $("#frmPermissao").trigger("reset");
                   }
               });

               $(".dropdown-button").dropdown();
               $('ul.tabs').tabs();
               $('#acessoPerfil').material_select();
               $('#intPerfil').material_select();
               $('.tooltipped').tooltip({delay: 50});

               carregarCamposPagina();
               carregarGridView();
               carregarGridFunc();

               //Eventos
               //1-Páginas
               $('#btnViewInserir').click(function () {
                   var xArquivo = $('#viewArquivo').val();
                   var xUrl = $('#viewUrl').val();
                   var xDescricao = $('#viewDescricao').val();

                   if (preenchido(xArquivo) == false) {
                       warningAlert("Preencha o campo arquivo nome");
                       return;
                   }

                   if (preenchido(xUrl) == false) {
                       warningAlert("Preencha o campo Url");
                       return;
                   }

                   if (preenchido(xDescricao) == false) {
                       warningAlert("Preencha o campo descricao");
                       return;
                   }


                   $.ajax({
                       type: 'POST',
                       data: $('#frmView').serialize(),
                       url: "../Controle/segurancaCTRL.php?evento=inserirView",
                       dataType: 'html',
                       success: function (msg) {
                           if (msg.trim() == 'OK') {
                               carregarCamposPagina();
                               $('#frmView').trigger("reset");
                               carregarGridView();
                               successAlert('Informação salva com sucesso.');
                           } else {
                               errorAlert(msg);
                           }
                       },
                       error: function (msg) {
                           errorAlert('ERRO AJAX:' + msg);
                       }
                   });


               });
               $('#btnViewEditar').click(function () {
                   var xArquivo = $('#viewArquivo').val();
                   var xUrl = $('#viewUrl').val();
                   var xDescricao = $('#viewDescricao').val();

                   if (preenchido(xArquivo) == false) {
                       warningAlert("Preencha o campo arquivo nome");
                       return;
                   }

                   if (preenchido(xUrl) == false) {
                       warningAlert("Preencha o campo Url");
                       return;
                   }

                   if (preenchido(xDescricao) == false) {
                       warningAlert("Preencha o campo descricao");
                       return;
                   }



                   $.ajax({
                       type: 'POST',
                       data: $('#frmView').serialize(),
                       url: "../Controle/segurancaCTRL.php?evento=editarView",
                       dataType: 'html',
                       success: function (msg) {
                           if (msg.trim() == 'OK') {
                               carregarCamposPagina();
                               $('#viewArquivo').prop('readonly', false);
                               $('#frmView').trigger("reset");
                               carregarGridView();
                               successAlert('Informação salva com sucesso.');
                           } else {
                               errorAlert(msg);
                           }
                       },
                       error: function (msg) {
                           errorAlert('ERRO AJAX:' + msg);
                       }
                   });


               });
               $('#btnViewExcluir').click(function () {
                   var xArquivo = $('#viewArquivo').val();
                   function excluirViewSim() {

                       $.ajax({
                           type: 'GET',
                           url: "../Controle/segurancaCTRL.php?evento=excluirView&viewArquivo=" + xArquivo,
                           dataType: 'html',
                           success: function (msg) {
                               if (msg.trim() == 'OK') {
                                   carregarCamposPagina();
                                   $('#viewArquivo').prop('readonly', false);
                                   $('#frmView').trigger("reset");
                                   carregarGridView();
                                   successAlert('Registro excluído com sucesso.');
                               } else {
                                   errorAlert(msg);
                               }
                           },
                           error: function (msg) {
                               errorAlert('ERRO AJAX:' + msg);
                           }
                       });
                   }

                   if (preenchido(xArquivo) == false) {
                       warningAlert("Selecione a página a ser excluída.");
                       return;
                   }
                   confirm(excluirViewSim, null);


               });
               $('#gridView tbody').on('click', 'tr', function () {
                   var xArquivoNome = xGridView.row({selected: true}).data()[0];
                   var xUrl = xGridView.row({selected: true}).data()[1];
                   var xDescricao = xGridView.row({selected: true}).data()[2];

                   $('#viewArquivo').val(xArquivoNome);
                   $('#viewUrl').val(xUrl);
                   $('#viewDescricao').val(xDescricao);

                   $('#viewDescricao').focus();
                   $('#viewUrl').focus();
                   $('#viewArquivo').prop('readonly', true);
                   $('#viewArquivo').focus();
               }
               );


               //2-Funcionalidades
               $('#btnFuncInserir').click(function () {
                   var xFuncPagina = $('#funcPagina').val();
                   var xFuncAcao = $('#funcAcao').val();

                   if (preenchido(xFuncPagina) == false) {
                       warningAlert("Preencha o campo página");
                       return;
                   }

                   if (preenchido(xFuncAcao) == false) {
                       warningAlert("Preencha o Ação");
                       return;
                   }


                   $.ajax({
                       type: 'POST',
                       data: $('#frmFunc').serialize(),
                       url: "../Controle/segurancaCTRL.php?evento=inserirFunc",
                       dataType: 'html',
                       success: function (msg) {
                           if (msg.trim() == 'OK') {
                               carregarCamposPagina();
                               $('#frmFunc').trigger("reset");
                               carregarGridFunc();
                               successAlert('Informação salva com sucesso.');
                           } else {
                               errorAlert(msg);
                           }
                       },
                       error: function (msg) {
                           errorAlert('ERRO AJAX:' + msg);
                       }
                   });


               });
               $('#btnFuncEditar').click(function () {
                   var xFuncId = $('#funcId').val();
                   var xPagina = $('#funcPagina').val();
                   var xAcao = $('#funcAcao').val();

                   if (preenchido(xFuncId) == false) {
                       warningAlert("Selecione a funcionalidade na tabela.");
                       return;
                   }

                   if (preenchido(xPagina) == false) {
                       warningAlert("Preencha o campo Página");
                       return;
                   }

                   if (preenchido(xAcao) == false) {
                       warningAlert("Preencha o campo funcionalidade");
                       return;
                   }

                   $.ajax({
                       type: 'POST',
                       data: $('#frmFunc').serialize(),
                       url: "../Controle/segurancaCTRL.php?evento=editarFunc",
                       dataType: 'html',
                       success: function (msg) {
                           if (msg.trim() == 'OK') {
                               $('#frmFunc').trigger("reset");
                               carregarGridFunc();
                               successAlert('Informação salva com sucesso.');
                           } else {
                               errorAlert(msg);
                           }
                       },
                       error: function (msg) {
                           errorAlert('ERRO AJAX:' + msg);
                       }
                   });


               });
               $('#btnFuncExcluir').click(function () {
                   var xFuncId = $('#funcId').val();
                   function excluirFuncSim() {
                       $.ajax({
                           type: 'GET',
                           url: "../Controle/segurancaCTRL.php?evento=excluirFunc&funcId=" + xFuncId,
                           dataType: 'html',
                           success: function (msg) {
                               if (msg.trim() == 'OK') {
                                   $('#frmFunc').trigger("reset");
                                   carregarGridFunc();
                                   successAlert('Registro excluído com sucesso.');
                               } else {
                                   errorAlert(msg);
                               }
                           },
                           error: function (msg) {
                               errorAlert('ERRO AJAX:' + msg);
                           }
                       });
                   }

                   if (preenchido(xFuncId) == false) {
                       warningAlert("Selecione a funcionalidade a ser excluída.");
                       return;
                   }
                   confirm(excluirFuncSim, null);
               });

               $('#gridFunc tbody').on('click', 'tr', function () {
                   $('#funcId').val(xGridFunc.row({selected: true}).data()[0]);
                   var xFuncPagina = xGridFunc.row({selected: true}).data()[1];
                   var xFuncAcao = xGridFunc.row({selected: true}).data()[2];

                   $('#funcPagina').val(xFuncPagina);
                   $('#funcAcao').val(xFuncAcao);


                   $('#funcPagina').focus();
                   $('#funcPagina').material_select();
                   $('#funcAcao').focus();

               }
               );


               //3-Acesso a páginas
               $("#acessoPerfil").change(function () {
                   var xPerfil = $('#acessoPerfil').val();

                   if (xPerfil != "") {
                       carregarGridPaginas(xPerfil);
                   }
               });
               $("#btnAcessoInserir").click(function () {
                   var xPerfil = $('#acessoPerfil').val();
                   var xPagina = $('#acessoPagina').val();

                   if (!preenchido(xPerfil)) {
                       warningAlert('Preencha o campo perfil');
                       return;
                   }

                   if (!preenchido(xPagina)) {
                       warningAlert('Preencha o campo página');
                       return;
                   }

                   $.ajax({
                       type: 'POST',
                       data: $('#frmAcesso').serialize(),
                       url: "../Controle/segurancaCTRL.php?evento=inserirAcessoPagina",
                       dataType: 'html',
                       success: function (msg) {
                           if (msg.trim() == 'OK') {
                               carregarGridPaginas(xPerfil);
                               successAlert('Informação salva com sucesso.');
                           } else {
                               errorAlert(msg);
                           }
                       },
                       error: function (msg) {
                           errorAlert('ERRO AJAX:' + msg);
                       }
                   });

               });
               $("#btnAcessoExcluir").click(function () {
                   var xAcessoPerfil = $('#acessoPerfil').val();
                   var xAcessoPagina = $('#acessoPagina').val();

                   function excluirAcessoSim() {
                       $.ajax({
                           data: $('#frmAcesso').serialize(),
                           type: 'POST',
                           url: "../Controle/segurancaCTRL.php?evento=excluirAcessoPagina",
                           dataType: 'html',
                           success: function (msg) {
                               if (msg.trim() == 'OK') {
                                   carregarGridPaginas(xAcessoPerfil);
                                   successAlert('Informação excluída com sucesso.');
                               } else {
                                   errorAlert(msg);
                               }
                           },
                           error: function (msg) {
                               errorAlert('ERRO AJAX:' + msg);
                           }
                       });
                   }
                   if (preenchido(xAcessoPerfil) == false) {
                       warningAlert('Preencha o campo perfil.');
                       return;
                   }

                   if (preenchido(xAcessoPagina) == false) {
                       warningAlert('Preencha o campo página.');
                       return;
                   }
                   confirm(excluirAcessoSim, null);

               });
               $("#gridPaginas tbody").on('click', 'tr', function () {
                   var xPerfil = $("#acessoPerfil").val();
                   var xPagina = xGridPaginas.row({selected: true}).data()[1];

                   if (preenchido(xPerfil) == false) {
                       warningAlert("Preencha o perfil");
                       return;
                   }

                   if (preenchido(xPagina) == false) {
                       warningAlert("Selecione a página na tabela.");
                       return;
                   }

                   //ajax para gerar os checkboxes das funcionalidades
                   $.get("../Controle/segurancaCTRL.php?evento=permissaoAcesso&perfil=" + xPerfil + "&pagina=" + xPagina, function (data) {
                       $("#listaDeFuncionalidades").html(data);
                   });

                   xFrmPermissao.dialog("open");
               }
               );
               $('body').on('click', '#frmPermissao input:checkbox', function () {
                   var xFuncId = $(this).val();
                   var xPerfil = $("#acessoPerfil").val();
                   var xOp = (($(this).prop("checked") == true) ? "inserir" : "excluir");

                   $.ajax({
                       type: "GET",
                       url: "../Controle/segurancaCTRL.php?evento=permissaoSalvar&funcId=" + xFuncId + "&perfil=" + xPerfil + "&op=" + xOp,
                       dataType: 'html',
                       success: function (msg) {
                           if (msg.trim() == 'OK') {
                               successAlert('Informação salva com sucesso.');
                           } else {
                               errorAlert(msg);
                           }
                       },
                       error: function (msg) {
                           errorAlert('ERRO AJAX:' + msg);
                       }
                   });


               });
               
               //4 - Integrante
               $('#intCpf').mask("000.000.000-00", {reverse: true});
               
               $('#intUa').autocomplete({
                   source: "../Controle/notamovCTRL.php?evento=autoCompleteUa",
                   minLength: 1,
                   select: function (event, ui) {
                       //limpar o formulário                     
                       $('#intUa').val('');
                       $('#intNome').val('');
                       $('#intPerfil').val('');
                       $('#intPerfil').material_select();
                       $('#intCpf').val('');
                       $('#intDtAdmissao').val('');
                       $('#intCargo').val('');
                       $('#intLider').val('');


                       var i = ui.item.label.search("=");
                       $("#intUa").val(ui.item.label.substring((i + 1), ui.item.label.lenght));
                   }
               });
               $('#intDtAdmissao').datetimepicker({
                   format: 'd/m/Y',
                   startDate: '+1971/05/01',
                   mask: true
               });
               
               $("#intNome").keyup(function () {
                  $("#intNome").val( $("#intNome").val().toUpperCase()  );
               });
               $("#intCargo").keyup(function () {
                  $("#intCargo").val( $("#intCargo").val().toUpperCase()  );
               });
               $("#intLider").keyup(function () {
                  $("#intLider").val( $("#intLider").val().toUpperCase()  );
               });
               
               $('#gridIntegrantes tbody').on('click', 'tr', function () {
                  var xId = xGridIntegrantes.row({selected: true}).data()[0];
                  var xMatr = xGridIntegrantes.row({selected: true}).data()[1];
                  var xUa = xGridIntegrantes.row({selected: true}).data()[2];
                  var xNome = xGridIntegrantes.row({selected: true}).data()[3];
                  var xCpf = xGridIntegrantes.row({selected: true}).data()[4];
                  var xDataAdmissao = xGridIntegrantes.row({selected: true}).data()[5];
                  var xCargo = xGridIntegrantes.row({selected: true}).data()[6];
                  var xLiderNome = xGridIntegrantes.row({selected: true}).data()[7];
                  var xPerfil = xGridIntegrantes.row({selected: true}).data()[8];

                  $('#intId').val(xId);
                  $('#intMatricula').val(xMatr);
                  $('#intUa').val(xUa);
                  $('#intNome').val(xNome);
                  $('#intPerfil').val(xPerfil);
                  $('#intCpf').val(xCpf);
                  $('#intDtAdmissao').val(xDataAdmissao);
                  $('#intCargo').val(xCargo);
                  $('#intLider').val(xLiderNome);

                  $('#intUa').focus();
                  $('#intNome').focus();
                  $('#intPerfil').focus();
                  $('#intPerfil').material_select();
                  $('#intCpf').focus();

                  $('#intCargo').focus();
                  $('#intLider').focus();
                  $('#intMatricula').focus();
               }
               );
               $('#btnIntPesquisar').click(function () {
                   var xUa = $('#intUa').val();
                   var xNome = $('#intNome').val();


                   if (preenchido(xUa) == false) {
                       warningAlert("Preencha a Unidade Administrativa");
                       return;
                   }

                   carregarGridIntegrantes(xUa, xNome);
               });               
               $("#btnIntInserir").click(function () {
                  
                  var xIntMatr = $('#intMatricula').val();
                  var xIntUa = $('#intUa').val();
                  var xIntNome = $('#intNome').val();
                  var xIntPerfil = $('#intPerfil').val();
                  var xIntCpf = $('#intCpf').val();
                  var xIntDtAdmissao = $('#intDtAdmissao').val();
                  var xIntCargo = $('#intCargo').val();
                  var xIntLider = $('#intLider').val();
                  

                  if (!preenchido(xIntMatr)) {
                      warningAlert('Preencha o campo matrícula');
                      return;
                  }

                  if (!preenchido(xIntUa)) {
                      warningAlert('Preencha o campo Unidade Administrativa');
                      return;
                  }

                  if (!preenchido(xIntNome)) {
                      warningAlert('Preencha o campo Nome');
                      return;
                  }

                  if (!preenchido(xIntPerfil)) {
                      warningAlert('Preencha o campo Perfil de Acesso');
                      return;
                  }

                  if (!preenchido(xIntCpf)) {
                      warningAlert('Preencha o campo Cpf');
                      return;
                  }

                  if (!preenchido(xIntDtAdmissao)) {
                      warningAlert('Preencha o campo data de admissão');
                      return;
                  }

                  if (!preenchido(xIntCargo)) {
                      warningAlert('Preencha o campo Cargo');
                      return;
                  }

                  
                  $.ajax({
                      type: 'POST',
                      data: $('#frmIntegrante').serialize(),
                      url: "../Controle/segurancaCTRL.php?evento=inserirInt",
                      dataType: 'html',
                      success: function (msg) {
                          if (msg.trim() == 'OK') {
                              carregarGridIntegrantes(xIntUa, '');
                              successAlert('Informação salva com sucesso.');
                          } else {
                              errorAlert(msg);
                          }
                      },
                      error: function (msg) {
                          errorAlert('ERRO AJAX:' + msg);
                      }
                  });

               });
               $("#btnIntEditar").click(function () {
                  var xIntId = $('#intId').val();
                  var xIntMatr = $('#intMatricula').val();
                  var xIntUa = $('#intUa').val();
                  var xIntNome = $('#intNome').val();
                  var xIntPerfil = $('#intPerfil').val();
                  var xIntCpf = $('#intCpf').val();
                  var xIntDtAdmissao = $('#intDtAdmissao').val();
                  var xIntCargo = $('#intCargo').val();
                  var xIntLider = $('#intLider').val();

                  if (!preenchido(xIntId)) {
                     warningAlert('Selecione o integrante');
                     return;
                  }


                  if (!preenchido(xIntMatr)) {
                     warningAlert('Preencha o campo matrícula');
                     return;
                  }

                  if (!preenchido(xIntUa)) {
                     warningAlert('Preencha o campo Unidade Administrativa');
                     return;
                  }

                  if (!preenchido(xIntNome)) {
                     warningAlert('Preencha o campo Nome');
                     return;
                  }

                  if (!preenchido(xIntPerfil)) {
                     warningAlert('Preencha o campo Perfil de Acesso');
                     return;
                  }

                  if (!preenchido(xIntCpf)) {
                     warningAlert('Preencha o campo Cpf');
                     return;
                  }

                  if (!preenchido(xIntDtAdmissao)) {
                     warningAlert('Preencha o campo data de admissão');
                     return;
                  }

                  if (!preenchido(xIntCargo)) {
                     warningAlert('Preencha o campo Cargo');
                     return;
                  }

                  

                  $.ajax({
                      type: 'POST',
                      data: $('#frmIntegrante').serialize(),
                      url: "../Controle/segurancaCTRL.php?evento=editarInt",
                      dataType: 'html',
                      success: function (msg) {
                          if (msg.trim() == 'OK') {
                              carregarGridIntegrantes(xIntUa, '');
                              successAlert('Informação salva com sucesso.');
                          } else {
                              errorAlert(msg);
                          }
                      },
                      error: function (msg) {
                          errorAlert('ERRO AJAX:' + msg);
                      }
                  });
               });
               $('#btnIntLimparFrm').click(function(){
                  $('#frmIntegrante').trigger("reset");
               });
               
               $("#btnIntExcluir").click(function () {
                   var xIntMatr = $('#intMatricula').val();
                   var xIntUa = $('#intUa').val();


                   if (!preenchido(xIntMatr)) {
                       warningAlert('Preencha o campo matrícula');
                       return;
                   }

                   if (!preenchido(xIntUa)) {
                       warningAlert('Preencha o campo Unidade Administrativa');
                       return;
                   }


                   $.ajax({
                       type: 'GET',
                       data: $('#frmIntegrante').serialize(),
                       url: "../Controle/segurancaCTRL.php?evento=excluirInt&matr="+xIntMatr+"&ua="+xIntUa,
                       dataType: 'html',
                       success: function (msg) {
                           if (msg.trim() == 'OK') {
                              //limpar o formulário                     
                              $("#frmIntegrante").trigger("reset");
                              $("$intPerfil").material_select();
                              
                              carregarGridIntegrantes(xIntUa, '');
                              successAlert('Informação excluída com sucesso.');
                           } else {
                               errorAlert(msg);
                           }
                       },
                       error: function (msg) {
                           errorAlert('ERRO AJAX:' + msg);
                       }
                   });

               });

           });
        </script>
    </body>
</html>
