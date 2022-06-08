<!DOCTYPE html>
<html>
    <head>
        <?php include('./Resources/tplImportCss.php') ?>
        <?php include('../Controle/includes.php') ?>
        <?php Funcoes::acessaView('notamov.php') ?>        
        <title>Sistema de Nota Fiscal de Movimentação</title>
    </head>
    <body class="fonte11px">
        <?php include('./Resources/tplMenu.php') ?>
        <!-- conteudo -->
        <div class="row barraFerramenta" > 
            &nbsp;&nbsp;
            <button name="btnInserirNm" id="btnInserirNm" class="tooltipped" data-tooltip="Inserir NM" <?php echo(Funcoes::permite( 'notamov.php', 'inserirNM' ) == 'n' ? "hidden='hidden'" : '' );  ?> >
               <img style="height: 22px;" src="Resources/img/inserir.png" />
            </button>
            
            <button name="btnSalvarNm" id="btnSalvarNm" class="tooltipped" data-tooltip="Salvar NM" <?php echo(Funcoes::permite( 'notamov.php', 'salvarNM' ) == 'n' ? "hidden='hidden'" : '' );  ?> >
               <img style="height: 22px;" src="Resources/img/salvar.png" />
            </button>
            <button name="btnExcluirNm" id="btnExcluirNm" class="tooltipped" data-tooltip="Excluir NM" <?php echo(Funcoes::permite( 'notamov.php', 'excluirNM' ) == 'n' ? "hidden='hidden'" : '' );  ?> >
               <img style="height: 22px;" src="Resources/img/excluir.png" />
            </button>
            <button name="btnImprimirNm" id="btnImprimirNm" class="tooltipped" data-tooltip="Imprimir NM" <?php echo(Funcoes::permite( 'notamov.php', 'imprimirNM' ) == 'n' ? "hidden='hidden'" : '' );  ?> >
               <img style="height: 22px;" src="Resources/img/imprimir.png" />
            </button>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <button name="btnLimparNm" id="btnLimparNm" class="tooltipped" data-tooltip="Limpar Formulário NM">
               <img style="height: 22px;" src="Resources/img/limpar.png" />
            </button>
        </div>
        <div class="row">
            <div class="conteudo">
                <ul class="collapsible" data-collapsible="accordion">
                    <!-- Pesquisa -->
                    <li>
                        <div id="divPesquisa" class="collapsible-header active"><i class="material-icons">search</i>Pesquisa</div>
                        <div class="collapsible-body">                            
                            <form id="frmPesquisa">
                                <div class="row bordaRow">                                   
                                       <div class="input-field col s1">
                                            <label for="frmPesqNm">Nº da NM:</label>
                                            <input id="frmPesqNm" name="frmPesqNm" type="text" class="validate" maxlength="15"/>                        
                                       </div>
                                       <div class="input-field col s1">                                           
                                            <label for="frmPesqNf">Nº NF:</label>
                                            <input id="frmPesqNf" name="frmPesqNf" type="text" class="validate" maxlength="15"/>                        
                                       </div>
                                       <div class="input-field col s1">
                                            <label for="frmPesqSe">Nº SE:</label>
                                            <input id="frmPesqSe" name="frmPesqSe" type="text" class="validate" maxlength="15"/>                        
                                       </div>
                                       <div class="input-field col s1">
                                          <label for="frmPesqDtSolic">Data Solicitação:</label>
                                          <input id="frmPesqDtSolic" name="frmPesqDtSolic" type="text" >
                                       </div>
                                      
                                   <div class="input-field col s3">
                                      Status:
                                      <p style="margin-top: -35px;">
                                          <input type="checkbox" name='frmPesqStatusSolic' id="frmPesqStatusSolic" />
                                          <label for="frmPesqStatusSolic">Solicitada</label>
                                          
                                          <input type="checkbox" name='frmPesqStatusAnalise' id="frmPesqStatusAnalise" />
                                          <label for="frmPesqStatusAnalise">Em análise</label>
                                          
                                          <input type="checkbox" name='frmPesqStatusAtParcial' id="frmPesqStatusAtParcial" />
                                          <label for="frmPesqStatusAtParcial">Atendida Parcial</label>
                                          
                                          <input type="checkbox" name='frmPesqStatusAtend' id="frmPesqStatusAtend" />
                                          <label for="frmPesqStatusAtend">Atendida</label>
                                          
                                          <input type="checkbox" name='frmPesqStatusCancel' id="frmPesqStatusCancel" />
                                          <label for="frmPesqStatusCancel">Cancelada</label>
                                                                                                                              
                                          <input type="checkbox" name='frmPesqStatusTodos' id="frmPesqStatusTodos" />
                                          <label for="frmPesqStatusTodos" style="color: #0059A9; font-weight: bold; ">Todos</label>
                                      </p>
                                   </div> 
                                   <div class="input-field col s3">
                                      Natureza:
                                      <p style="margin-top: -35px;">
                                          <input type="checkbox" name='frmPesqNatBaixa' id="frmPesqNatBaixa" />
                                          <label for="frmPesqNatBaixa">Baixa</label>
                                          
                                          <input type="checkbox" name='frmPesqNatTransfer' id="frmPesqNatTransfer" />
                                          <label for="frmPesqNatTransfer">Transferência</label>
                                          
                                          <input type="checkbox" name='frmPesqNatDev' id="frmPesqNatDev" />
                                          <label for="frmPesqNatDev">Devolução</label>
                                          
                                          <input type="checkbox" name='frmPesqNatRem' id="frmPesqNatRem" />
                                          <label for="frmPesqNatRem">Simples Remessa</label>
                                          
                                          <input type="checkbox" name='frmPesqNatNf' id="frmPesqNatNf" />
                                          <label for="frmPesqNatNf">NF</label>
                                          
                                          <input type="checkbox" name='frmPesqNatOutros' id="frmPesqNatOutros" />
                                          <label for="frmPesqNatOutros">Outros</label>
                                          
                                          <input type="checkbox" name='frmPesqNatTodas' id="frmPesqNatTodas" />
                                          <label for="frmPesqNatTodas" style="color: #0059A9; font-weight: bold;">Todas</label>
                                      </p>
                                   </div>                                     
                                    <div class="input-field col s1">
                                        <div class="waves-effect waves-light btn" id="btnPesquisarNm">pesquisar</div>
                                    </div> 
                                    
                                </div>
                            </form>  
                            <div class="bordaRow" style="padding: 6px;">
                              <table id="gridNm" cellpadding="0" cellspacing="0" border="0" class="highlight" style="font-size: 10px;">
                                  <thead>
                                      <tr>
                                          <th>Núm.</th>
                                          <th>NF</th>
                                          <th>NF Dt Lançamento</th>  
                                          <th>SE</th>
                                          <th>Data Solicitação</th>
                                          <th>Data Entrega</th>
                                          <th>Requisitado por</th>
                                          <th>Status</th>
                                          <th>Natureza</th>
                                          <th>Ua.Origem</th>
                                          <th>Ua.Destino</th>
                                          <th>Valor Total</th>                             
                                      </tr>
                                  </thead>
                                  <tbody></tbody>
                                  <tfoot>
                                      <tr>
                                          <th>Núm.</th>
                                          <th>NF</th>
                                          <th>NF Dt Lançamento</th>
                                          <th>SE</th>
                                          <th>Data Solicitação</th>
                                          <th>Data Entrega</th>
                                          <th>Requisitado por</th>
                                          <th>Status</th>
                                          <th>Natureza</th>
                                          <th>Ua.Origem</th>
                                          <th>Ua.Destino</th>
                                          <th>Valor Total</th>                               
                                      </tr>
                                  </tfoot>
                              </table> 
                            </div>    
                              
                        </div>
                    </li>
                    <!-- Formulário de Nm -->
                    <li>
                        <div id="divFormulario" class="collapsible-header"><i class="material-icons">library_books</i>Formulário NM</div>
                        <div class="collapsible-body fonte11px ">
                            <form id="frmEdicaoNm">
                                <div class="row bordaRow ">
                                    <div class="input-field col s2">
                                        <div class="obrigatorio"><b>Fonte de recursos(*):<b></div><br/>
                                        <input name="fonteRecurso" type="radio" id="fonte1" value="P"/>
                                        <label for="fonte1">Próprio</label>
                                    
                                        <input name="fonteRecurso" type="radio" id="fonte2" value="T"/>
                                        <label for="fonte2">Terceiros</label>     
                                    </div>
                                    <div class="input-field col s4">
                                        <div class="obrigatorio"><b>Natureza da operação(*):<b></div><br/>
                                        <input name="natureza" type="radio" id="nat1" value="B" />
                                        <label for="nat1">Baixa</label>
                                    
                                        <input name="natureza" type="radio" id="nat2" value="T"/>
                                        <label for="nat2">Transferência</label>  
                                        
                                        <input name="natureza" type="radio" id="nat3" value="D"/>
                                        <label for="nat3">Devolução</label>
                                    
                                        <input name="natureza" type="radio" id="nat4" value="R"/>
                                        <label for="nat4">Simples Remessa</label>
                                        
                                        <input name="natureza" type="radio" id="nat6" value="N"/>
                                        <label for="nat6">NF</label>
                                        
                                        <input name="natureza" type="radio" id="nat5" value="O"/>
                                        <label for="nat5">Outros</label>
                                    </div>
                                    
                                    <div class="input-field col s2">
                                        <div class="obrigatorio"><b>Sistema(*):<b></div><br/>
                                        <input name="sistema" type="radio" id="sist1" value="A"/>
                                        <label for="sist1">Água</label>
                                        
                                        <input name="sistema" type="radio" id="sist2" value="E"/>
                                        <label for="sist2">Esgoto</label>
                                        
                                        <input name="sistema" type="radio" id="sist3" value="O"/>
                                        <label for="sist3">Outros</label>
                                    </div>                                     
                                    
                                    <div class="input-field col s2">
                                         <b>Status NM:</b> 
                                         <input  type="text" name="status" id="status" readonly/>                                        
                                    </div>  
                                    
                                    <div class="input-field col s2">
                                         <b>Número NM:<b>
                                         <input type="text" id="notaMaterialId" name="notaMaterialId" value="" readonly/>
                                    </div>
                                    <div class="input-field col s1">
                                         <b>Número NF:<b>
                                         <input type="text" id="notaMaterialNf" name="notaMaterialNf"/>
                                    </div>
                                    <div class="input-field col s2">
                                         <b>Dt Lançamento NF:<b>
                                         <input type="text" id="notaMaterialNfDtLanc" name="notaMaterialNfDtLanc"/>
                                    </div>
                                    <div class="input-field col s1">
                                         <b>Número SE:<b>
                                         <input type="text" id="notaMaterialSe" name="notaMaterialSe"/>
                                    </div>
                                    
                                                                    
                                </div>
                                <div class="row bordaRow ">  
                                    <div class="input-field col s5 fundoBranco">
                                        <b>Informações complementares:<b>
                                        <textarea name="infoComplementar" id="infoComplementar" class="materialize-textarea" maxlength="255" length="255"></textarea>                                        
                                    </div>                                     
                                </div>
                                <!-- Grid de produtos-->
                                <div class="row bordaRow">
                                    Produtos:                                 
                                    <table id="gridMateriais" cellpadding="0" cellspacing="0" border="0" class="col s12 highlight" style="font-size: 10px">
                                        <thead>
                                            <tr>
                                                <th>Sequência</th>
                                                <th>Grupo+Código</th>
                                                <th>Descrição do Produto</th>
                                                <th>Mês</th>
                                                <th>Unidade</th>
                                                <th>Quantidade Solicitada</th>
                                                <th>Quantidade Fornecida</th>
                                                <th>Valor unitário</th>
                                                <th>Valor Total</th>                             
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Sequência</th>
                                                <th>Grupo+Código</th>
                                                <th>Descrição do Produto</th>
                                                <th>Mês</th>
                                                <th>Unidade</th>
                                                <th>Quantidade Solicitada</th>
                                                <th>Quantidade Fornecida</th>
                                                <th>Valor unitário</th>
                                                <th>Valor Total</th>                                
                                            </tr>
                                        </tfoot>
                                    </table> 
                                                                      
                                </div>  
                                <div class="row bordaRow" style="font-size: 10px;">
								    <div class="row">										
										<div class="input-field offset-s1 col s5">
                                            <div class="obrigatorio">Ua origem(*):</div><i class="material-icons">call_made</i>
                                            <input id="uaOrigem" name="uaOrigem" type="text" class="validate" maxlength="30"/>  
                                        </div>
										<div class="input-field col s5">
                                            <div class="obrigatorio">Ua destino(*):</div><i class="material-icons">call_received</i>
                                            <input id="uaDestino" name="uaDestino" type="text" class="validate" maxlength="30"/>  
                                        </div>
									</div>
                                    <div class="row">                                        
                                        <div class="input-field offset-s1 col s2">
                                            Transportadora:
                                            <input id="transportadora" name="transportadora" type="text" class="validate" maxlength="255"/>  
                                        </div>
                                        <div class="input-field col s2">
                                            Endereço:
                                            <input id="transpEndereco" name="transpEndereco" type="text" class="validate" maxlength="150"/>  
                                        </div>
                                        <div class="input-field col s2">
                                            Motorista:
                                            <input id="transpMotorista" name="transpMotorista" type="text" class="validate" maxlength="150"/>  
                                        </div>
                                        <div class="input-field col s1">
                                            N.Viatura:
                                            <input id="transpViatura" name="transpViatura" type="text" class="validate" maxlength="30"/>  
                                        </div>
                                        <div class="input-field col s1">
                                            N.Placa:
                                            <input id="transpPlaca" name="transpPlaca" type="text" class="validate" maxlength="10"/>  
                                        </div>
                                        <div class="input-field col s2">
                                            Local entrega:
                                            <input id="transpLocalEntrega" name="transpLocalEntrega" type="text" class="validate" maxlength="150"/>  
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col offset-s1 s10 bordaRow">
                                            Informações da Mercadoria:
                                            <table id="gridInfoMercadoria" cellpadding="0" cellspacing="0" border="0" class="col s12 highlight" style="font-size: 10px">
                                                <thead>
                                                    <tr>
                                                        <th>Id.</th>
                                                        <th>Espécie.</th>
                                                        <th>Valor</th>
                                                        <th>Embalagem</th>
                                                        <th>Qtde</th>                            
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Id.</th>
                                                        <th>Espécie.</th>
                                                        <th>Valor</th>
                                                        <th>Embalagem</th>
                                                        <th>Qtde</th>                            
                                                    </tr>
                                                </tfoot>
                                            </table> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                    
                                    <div class="col s3 bordaRow">
                                        <input type="hidden" id="solicitadoPorId" name="solicitadoPorId" />
                                        <div class="obrigatorio">Requisição(*):</div>
                                        <div class="row">
                                            <div class="input-field">
                                                Data:
                                                <input type="text" id="requisicaoData" name="requisicaoData"  />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field">
                                                Nome:
                                                <input id="requisicaoNome" name="requisicaoNome" type="text" readonly />  
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field">
                                                Matrícula:
                                                <input id="requisicaoMatricula" name="requisicaoMatricula" type="text" maxlength="10"/>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s3 bordaRow">
                                        <input type="hidden" id="autorizadoPorId" name="autorizadoPorId" />
                                        Autorização:
                                        <div class="row">
                                            <div class="input-field">
                                                Data:
                                                <input id="autorizacaoData" name="autorizacaoData" type="text">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field">
                                                Nome:
                                                <input id="autorizacaoNome" name="autorizacaoNome"  type="text" readonly/>  
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field">
                                                Matrícula:
                                                <input id="autorizacaoMatricula" name="autorizacaoMatricula"  type="text"  maxlength="10"/>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s3 bordaRow">
                                        Entrega:
                                        <div class="row">
                                            <div class="input-field">
                                                Data:
                                                <input id="entregaData" name="entregaData" type="text" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field">
                                                Nome:
                                                <input id="entregaNome" name="entregaNome"  type="text" class="validate" maxlength="150"/>  
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field">
                                                Matrícula:
                                                <input id="entregaMatricula" name="entregaMatricula"  type="text" class="validate" maxlength="10"/>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s3 bordaRow">
                                        Recebido:
                                        <div class="row">
                                            <div class="input-field">
                                                Data:
                                                <input id="recebidoData" name="recebidoData" type="text" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field">
                                                Nome:
                                                <input id="recebidoNome" name="recebidoNome" type="text" class="validate" maxlength="150"/>  
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field">
                                                Matrícula:
                                                <input id="recebidoMatricula" name="recebidoMatricula" type="text" class="validate" maxlength="10"/>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="obrigatorio">Campos obrigatórios*:</div>
                                </div>
                            </form>  
                        </div>
                    </li>
                </ul>
                
               
                
            </div>
        </div>
        <!-- formulario produtos -->
        <div class="row">
            <div id="divFrmProduto">
                <form id="frmProdutoNm">                    
                    <input type="hidden" id="prdAcao" name="prdAcao"/> 
                    <input type="hidden" id="prdSequencia" name="prdSequencia"/>
                    <div class="row">    
                        <div class="input-field col s4">
                            Número da nota:
                            <input id="prdNrNota" name="prdNrNota" type="text" readonly/>  
                        </div>
                        
                        <div class="bordered">
                           <div class="input-field col s1">
                              Grupo:
                              <input id="prdGrupo" name="prdGrupo" type="text" maxlength="3"/>  
                           </div> 

                           <div class="input-field col s7">
                              Cod. ou Descrição:
                              <input id="prdMaterialId" name="prdMaterialId" type="text" maxlength="30"/>  
                           </div> 
                        </div>    
                    </div>
                    <div class="row">                    
                        <div class="input-field  col s5">
                           Quantidade solicitada:
                           <input id="prdQtdSolicitada" name="prdQtdSolicitada" <?php echo(Funcoes::permite( 'notamov.php', 'quantidadeSolicitada' ) == 'n' ? "readonly" : '' );  ?>  type="text" maxlength="11"/>  
                        </div>
                    
                        <div class="input-field  col s5">
                            Quantidade fornecida:
                            <input id="prdQtdFornecida" name="prdQtdFornecida" <?php echo(Funcoes::permite( 'notamov.php', 'quantidadeFornecida' ) == 'n' ? "readonly" : '' );  ?> type="text" maxlength="11"/>  
                        </div>
                    </div>
                    <div class="row">    
                        <div class="input-field  col s5">
                            Valor unitário:
                            <input id="prdVlrUnitario" name="prdVlrUnitario" type="text" maxlength="11"/>  
                        </div>
                    </div>
                    <div class="row" <?php echo(Funcoes::permite( 'notamov.php', 'salvarProduto' ) == 'n' ? "hidden='hidden'" : '' );  ?>>
                       <div class="waves-effect waves-light btn" id="btnSalvarProduto">salvar</div>
                    </div>    
                    
               </form>
            </div>
        </div>
        <!-- fim -->
        
        <!-- formulario informações mercadoria -->
        <div class="row">
            <div id="divFrmInfoMercadoria">
                <form id="frmInfoMercadoriaNm">                    
                    <input type="hidden" id="infoAcao" name="infoAcao"/> 
                    <input type="hidden" id="infoId" name="infoId"/> 
                    <div class="row">    
                        <div class="input-field  col s4">
                            Número da nota:
                            <input id="infoNrNota" name="infoNrNota" type="text" readonly/>  
                        </div>
                        <div class="input-field col s4">
                           <select id="infoEspecie" name="infoEspecie">
                               <option value="" disabled selected>Espécie</option>
                               <option value="Perecível">Perecível</option>
                               <option value="Não perecível">Não perecível</option>                              
                           </select> 
                        </div>
                    </div>

                    <div class="row">                    
                        <div class="input-field  col s6">
                           Embalagem:
                           <input id="infoEmbalagem" name="infoEmbalagem" type="text" maxlength="150"/>  
                        </div>
                    </div>
                    
                    <div class="row"> 
                        <div class="input-field  col s3">
                            Quantidade:
                            <input id="infoQuantidade" name="infoQuantidade" type="text" maxlength="11"/>  
                        </div>
                        
                        <div class="input-field  col s3">
                           Valor:
                           <input id="infoValor" name="infoValor" type="text" maxlength="11"/>  
                        </div>  
                    </div>
                    <div class="row" <?php echo(Funcoes::permite( 'notamov.php', 'salvarInfo' ) == 'n' ? "hidden='hidden'" : '' );  ?>>
                       <div class="waves-effect waves-light btn" id="btnSalvarInfo">salvar</div>
                    </div>    
                    
               </form>
            </div>
        </div>
        <!-- fim -->
        <div id="frmStatusNm">
            <b>Nota de movimentação:</b>
            <select id="statusNm" name="statusNm">
                <option value="S">Solicitada</option>
                <option value="A">Em análise</option>
                <option value="AP">Atendida parcial</option>
                <option value="AT">Atendida</option>
                <option value="C">Cancelada</option>
            </select> 
        </div>

        <?php include('./Resources/tplRodape.php') ?>
        <?php include('./Resources/tplImportJs.php') ?>
        <script type="text/javascript">
           var nmId = null;
           var gridNm = null;
           var gridMateriais = null;
           var gridInfoMercadoria = null;
           var xGrpMaterial = null;
           var frmProdutoNm = null;
           var frmInfoMercadoriaNm = null;
           var frmStatusNm = null;
           var flagActionNm = null;
           var flagNmUltimos40 = true;
                                

           function carregarGridNm(pNm, pNf, pSe, pDt, pListaNat, pListaStatus ) {
              var htmlId = "gridNm";
              var ajaxUrl = "../Controle/notamovCTRL.php?evento=gridNm&nm="+pNm+"&nf="+pNf+"&se="+pSe+"&dt="+pDt+"&listaNat="+pListaNat+"&listaStatus="+pListaStatus; 
              //carregar a grid com as 20 últimas solicitações
              if( flagNmUltimos40 ){
                 ajaxUrl = "../Controle/notamovCTRL.php?evento=gridNm40";
                 flagNmUltimos40 = false;
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
         
                gridNm = grid( htmlId, ajaxUrl, botoesEventos, null, 40 );
            }
           function carregarGridMateriais(nmId) {  
               var prdSequencia = null;
               var prdId = null;
               var prdDescricao = null;
               var prdMes = null;
               var prdUnidade = null;
               var prdQtdSolicitada = null;
               var prdQtdFornecida = null;
               var prdVlrUnitario = null;
               //-----
               
               var htmlId = "gridMateriais";
               var ajaxUrl = "../Controle/notamovCTRL.php?evento=gridMateriais&nmId="+nmId;
               var botoesEventos = [                          
                     'excel',
                     'pdf',
                     {
                        text: 'Novo',
                        action: function ( e, dt, node, config ) {
                           $('#prdAcao').val('INSERIR');
                           $('#prdNrNota').val( nmId );
                           frmProdutoNm.dialog( "open" );
                        }
                     }, 
                        
                     {
                        text: 'Editar',
                        action: function ( e, dt, node, config ) {    
                           if( nmId == null ){
                               errorAlert('Primeiro, salve a Nota de Movimentação.');
                               return;
                           }
                           
                           
                           prdId = dt.row({selected: true}).data();                             

                           if( prdId == null ){
                              alert("Selecione a linha a ser alterada.");
                              return;                                          
                           }
                           else{                                                           
                              prdSequencia = dt.row({selected: true}).data()[0];
                              prdId = dt.row({selected: true}).data()[1];
                              prdDescricao = dt.row({selected: true}).data()[2];                                                     
                              prdQtdSolicitada = dt.row({selected: true}).data()[5];
                              prdQtdFornecida = dt.row({selected: true}).data()[6];
                              prdVlrUnitario = dt.row({selected: true}).data()[7];
                              
                              $('#prdNrNota').val( nmId );
                              $('#prdSequencia').val( prdSequencia );
                              $('#prdMaterialId').val( prdId +'='+ prdDescricao );
                              $('#prdQtdSolicitada').val( prdQtdSolicitada );
                              $('#prdQtdFornecida').val( prdQtdFornecida );
                              $('#prdVlrUnitario').val( prdVlrUnitario );
                                                           
                              
                              $('#prdAcao').val('EDITAR');
                              frmProdutoNm.dialog( "open" );
                           }

                        }
                     },                        
                     {
                        text: 'Excluir',
                        action: function ( e, dt, node, config ) {
                           var seq = null;
                           var matId = null;
                           

                           if( dt.row({selected: true}).data() == null ){
                              alert("Selecione a linha a ser excluída.");
                              return;                                          
                           }
                           else{
                              //excluir produto e atualizar grid 
                              seq = dt.row({selected: true}).data()[0];
                              matId = dt.row({selected: true}).data()[1];
                                      
                              $.ajax({
                                 type: 'GET',
                                 url: "../Controle/notamovCTRL.php?evento=excluirProdutoNm&nmId="+nmId+"&matId="+matId+"&seq="+seq,
                                 dataType: 'html',
                                 success: function (msg) {                             
                                    if( msg.trim() == 'OK' ){
                                      carregarGridMateriais(nmId);                                                                  
                                      successAlert('Produto excluído com sucesso.');                                      
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

                        }
                     },
                     {
                        text: 'Soma',
                        action: function(){
                           infoAlert( 'Somatório de todos os Produtos',  Math.floor( gridMateriais.column( 8 ).data().sum() * 100) / 100  );
                        }
                     }
                        
               ];
                    
               var colDefs = [ { "targets": [ 0 ], "visible": false } ];
               
               gridMateriais = gridCorMateriais( htmlId, ajaxUrl, botoesEventos, colDefs);
               
            }            
           function carregarGridInfoMercadoria(nmId) {  
              var htmlId = "gridInfoMercadoria";
              var ajaxUrl = "../Controle/notamovCTRL.php?evento=gridInfoMercadoria&nmId="+nmId;
              var botoesEventos = [                          
                     'excel',
                     'pdf',
                     {
                        text: 'Novo',
                        action: function ( e, dt, node, config ) {
                           $('#infoAcao').val('INSERIR');
                           $('#infoNrNota').val( nmId );
                           frmInfoMercadoriaNm.dialog( "open" );
                        }
                     }, 
                        
                     {
                        text: 'Editar',
                        action: function ( e, dt, node, config ) { 
                           var infoId = dt.row({selected: true}).data();
                           var infoEspecie = null;
                           var infoValor = null;
                           var infoEmbalagem = null;
                           var infoQuantidade = null;

                           if( infoId == null ){
                              alert("Selecione a linha a ser alterada.");
                              return;                                          
                           }
                           else{
                              infoId = dt.row({selected: true}).data()[0];
                              infoEspecie = dt.row({selected: true}).data()[1];
                              infoValor = dt.row({selected: true}).data()[2];
                              infoEmbalagem = dt.row({selected: true}).data()[3];                                                     
                              infoQuantidade = dt.row({selected: true}).data()[4];
                              
                              $('#infoId').val( infoId );
                              $('#infoNrNota').val( nmId );                                               
                                                           
                              $('#infoEspecie').val(infoEspecie);
                              $('#infoEspecie').material_select();
                              
                              
                              $('#infoValor').val( infoValor );
                              $('#infoEmbalagem').val( infoEmbalagem );
                              $('#infoQuantidade').val( infoQuantidade );
                                                                                        
                              
                              $('#infoAcao').val('EDITAR');
                              frmInfoMercadoriaNm.dialog( "open" );
                           }

                        }
                     },                        
                     {
                        text: 'Excluir',
                        action: function ( e, dt, node, config ) {
                           var id = dt.row({selected: true}).data();
                           

                           if( id == null ){
                              alert("Selecione a linha a ser excluída.");
                              return;                                          
                           }
                           else{
                              //excluir informações da mercadoria e atualizar grid 
                              id = dt.row({selected: true}).data()[0];
                              
                                      
                              $.ajax({
                                 type: 'GET',
                                 url: "../Controle/notamovCTRL.php?evento=excluirInfoMercadoriaNm&nmId="+nmId+"&id="+id,
                                 dataType: 'html',
                                 success: function (msg) {                             
                                    if( msg.trim() == 'OK' ){
                                      carregarGridInfoMercadoria(nmId);                                                                  
                                      successAlert('Registro excluído com sucesso.');                                      
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

                        }
                     }
                        
               ];
              var colDefs = [ { "targets": [ 0 ], "visible": false } ];
              
              gridInfoMercadoria = grid(htmlId,ajaxUrl,botoesEventos,colDefs,6);
            }            
           function limparFormularioNm(){
              nmId = null;
              flagActionNm = 'inserirNm';
              $('#frmEdicaoNm').trigger("reset");
             
              if( gridMateriais != null ){
                gridMateriais.rows().remove().draw();
                gridMateriais.buttons().disable();
              }

              if( gridInfoMercadoria != null ){
                 gridInfoMercadoria.rows().remove().draw();
                 gridInfoMercadoria.buttons().disable();
              }
           }            
           function formularioNmValidado(e){
              var xIdx = -1;
              
               if( !( $('#fonte1').prop( 'checked' ) || $('#fonte2').prop( 'checked' ))  ){
                  alert('Selecione a fonte de recursos.');
                  return false;
               } 
               
               if( !(   $('#nat1').prop( 'checked' ) || 
                        $('#nat2').prop( 'checked' ) ||
                        $('#nat3').prop( 'checked' ) || 
                        $('#nat4').prop( 'checked' ) ||
                        $('#nat5').prop( 'checked' ) ||
                        $('#nat6').prop( 'checked' )
                     ) 
               )
               {
                  alert('Selecione a natureza da operação.');
                  return false;
               } 
               
               if( !(   $('#sist1').prop( 'checked' ) || 
                        $('#sist2').prop( 'checked' ) ||
                        $('#sist3').prop( 'checked' ) 
                     )  
               )
               {
                  alert('Selecione o sistema.');
                  return false;
               } 
               
               xIdx = $('#uaOrigem').val().indexOf('=');
               if( !preenchido($('#uaOrigem').val()) || xIdx == -1  ){
                  alert('Digite a UA de origem.');
                  $('#uaOrigem').focus();
                  e.preventDefault();                                  
                  return false;
               } 
               
               xIdx = $('#uaDestino').val().indexOf('=');
               if( !preenchido($('#uaDestino').val()) || xIdx == -1  ){
                  alert('Digite a UA de Destino.');
                  $('#uaDestino').focus();
                  e.preventDefault();                                  
                  return false;
               }                             
               
               if( !preenchido($('#requisicaoData').val())  ){
                  alert('Digite a data de requisição.');
                  $('#requisicaoData').focus();
                  e.preventDefault();                                  
                  return false;
               } 
               
               if( !preenchido($('#requisicaoNome').val())  ){ 
                  alert('Digite a matrícula de  requisição.');  
                  $('#requisicaoMatricula').focus();
                  e.preventDefault();                                  
                  return false;
               } 
               
               return true;
           }  
           
            
           $(document).ready(function () {         
               /*** A P P ***/                
               $(".dropdown-button").dropdown();   

               //_____________________________________________________
               //CheckBoxes Natureza
               $('#frmPesqNatBaixa').prop('checked', true);
               $('#frmPesqNatTransfer').prop('checked', true);
               $('#frmPesqNatDev').prop('checked', true);
               $('#frmPesqNatRem').prop('checked', true);
               $('#frmPesqNatNf').prop('checked', true);
               $('#frmPesqNatOutros').prop('checked', true);
               $('#frmPesqNatTodas').prop('checked', true);
               //CheckBoxes Status
               $('#frmPesqStatusSolic').prop('checked', true);
               $('#frmPesqStatusAnalise').prop('checked', true);
               $('#frmPesqStatusAtParcial').prop('checked', true);
               $('#frmPesqStatusAtend').prop('checked', true);
               $('#frmPesqStatusCancel').prop('checked', true);
               $('#frmPesqStatusTodos').prop('checked', true);
               
               
                   
               //*** I N I C I A L I Z A C A O ***
               desabilita('btnSalvarNm');
               desabilita('btnExcluirNm');
               desabilita('btnImprimirNm');
               carregarGridNm();
               
               $('select').material_select();                
               $('#infoComplementar').characterCounter();
               
               $('#frmPesqDtSolic').datetimepicker({ 
                  format:'d/m/Y',
                  startDate:'+1971/05/01',
                  mask:true
               });
               $('#notaMaterialNfDtLanc').datetimepicker({ 
                  format:'d/m/Y',
                  startDate:'+2000/01/01',
                  mask:true
               }); 
               $('#requisicaoData').datetimepicker({ 
                  format:'d/m/Y H:i',
                  startDate:'+1971/05/01',
                  mask:true
               }); 
               $('#autorizacaoData').datetimepicker({ 
                  format:'d/m/Y H:i',
                  startDate:'+1971/05/01',
                  mask:true
               }); 
               $('#entregaData').datetimepicker({ 
                  format:'d/m/Y H:i',
                  startDate:'+1971/05/01',
                  mask:true
               });
               $('#recebidoData').datetimepicker({ 
                  format:'d/m/Y H:i',
                  startDate:'+1971/05/01',
                  mask:true
               });  
               $.datetimepicker.setLocale('pt-BR');  

               //formúlario modal de produtos
               frmProdutoNm = $('#divFrmProduto').dialog({
                  title: "Formulário de produtos da Nm",
                  autoOpen: false,
                  height: 600,
                  width: 800,
                  modal: true,
                  close: function( event, ui ) { $("#frmProdutoNm").trigger("reset");  }
               });
               //formulário modal de informações da mercadoria
               frmInfoMercadoriaNm = $('#divFrmInfoMercadoria').dialog({
                  title: "Formulário de Informações da Mercadoria",
                  autoOpen: false,
                  height: 500,
                  width: 520,
                  modal: true,
                  close: function( event, ui ) { $("#frmInfoMercadoriaNm").trigger("reset");  }
               });               
               frmStatusNm = $('#frmStatusNm').dialog({
                  title: "Alterar Status da Nota de Movimentação",
                  autoOpen: false,
                  height: 350,
                  width: 300,
                  modal: true
               });
               
               
               $('#prdQtdSolicitada').blur(function(){
                  $('#prdQtdFornecida').val($('#prdQtdSolicitada').val());
               });                
               $('#prdQtdFornecida').blur(function(){
                  if($('#prdQtdSolicitada').val() < 0.01 ){
                     $('#prdQtdSolicitada').val($('#prdQtdFornecida').val());
                  }                  
               });                
               $("#prdGrupo").dblclick(function(){
                  $("#prdGrupo").val('');
               });               
               $("#prdMaterialId").dblclick(function(){
                  $("#prdMaterialId").val('');
               }); 
               
               $("#prdMaterialId").dblclick(function(){
                  $("#prdMaterialId").val('');
               });
               $("#prdMaterialId").autocomplete({
                  minLength: 1,
                  source: function(request, response) {
                     $.ajax({
                        url: "../Controle/notamovCTRL.php?evento=autoCompleteMateriais",
                        dataType: "json",
                        data: {
                           term: request.term, 
                           grp: $('#prdGrupo').val()
                        },
                        success: function(data) {
                           response(data);
                        }
                     });
                  },
                  select: function( event, ui ) {
                     var xPreco = ui.item.preco;
                     if( xPreco > 0  ){
                        $('#prdVlrUnitario').prop('readonly', true);
                     }
                     else{
                        $('#prdVlrUnitario').prop('readonly', false);
                        $('#prdVlrUnitario').val('');
                     }
                     $('#prdVlrUnitario').val(xPreco);
                  }
               }); 
               
               $('#requisicaoMatricula').dblclick(function(){
                  $('#requisicaoMatricula').val('');
               });
               $('#requisicaoMatricula').autocomplete({
                  source: "../Controle/notamovCTRL.php?evento=autoCompleteIntegrante",
                  minLength: 3,
                  select: function( event, ui ) {
                     var id = ui.item.id;
                     $('#solicitadoPorId').val(id);
                     var i = ui.item.label.search("=");
                     $("#requisicaoNome").val( ui.item.label.substring( (i + 1), ui.item.label.lenght  ) );                       
                     }
                  });
                  
               $('#autorizacaoMatricula').dblclick(function(){
                  $('#autorizacaoMatricula').val('');
               })   
               $('#autorizacaoMatricula').autocomplete({
                  source: "../Controle/notamovCTRL.php?evento=autoCompleteIntegrante",
                  minLength: 3,
                  select: function( event, ui ) {
                     var id = ui.item.id;
                     $('#autorizadoPorId').val(id);
                     var i = ui.item.label.search("=");
                     $("#autorizacaoNome").val( ui.item.label.substring( (i + 1), ui.item.label.lenght  ) );                       
                     }
                  }); 
               
               $('#uaOrigem').dblclick(function(){
                  $('#uaOrigem').val('');
               });
               $('#uaOrigem').autocomplete({
                 source: "../Controle/notamovCTRL.php?evento=autoCompleteUa",
                 minLength: 1,
                 select: function( event, ui ) {
                    var i = ui.item.label.search("=");
                    $("#uaOrigem").val( ui.item.label.substring( (i + 1), ui.item.label.lenght  ) );                       
                    }
                 });  
               
               $('#uaDestino').dblclick(function(){
                    $('#uaDestino').val('');
                });
               $('#uaDestino').autocomplete({
                 source: "../Controle/notamovCTRL.php?evento=autoCompleteUa",
                 minLength: 1,
                 select: function( event, ui ) {
                    var i = ui.item.label.search("=");
                    $("#uaDestino").val( ui.item.label.substring( (i + 1), ui.item.label.lenght  ) );                       
                    }
                 });
               
               //máscaras
               $('#prdQtdSolicitada').mask("00000000.00",{reverse: true});
               $('#prdQtdFornecida').mask("00000000.00",{reverse: true});
               $('#prdVlrUnitario').mask("00000000.00",{reverse: true});
               $('#infoQuantidade').mask("00000000.00",{reverse: true});
               $('#infoValor').mask("00000000.00",{reverse: true});
                              
               //_____________________________________________________
               //*** E V E N T O S ***
               $('#frmPesqNatTodas').click(function(){
                  var xCheck = $(this).prop('checked');
                  
                  if(xCheck){
                     $('#frmPesqNatBaixa').prop('checked', true);
                     $('#frmPesqNatTransfer').prop('checked', true);
                     $('#frmPesqNatDev').prop('checked', true);
                     $('#frmPesqNatRem').prop('checked', true);
                     $('#frmPesqNatNf').prop('checked', true);
                     $('#frmPesqNatOutros').prop('checked', true);
                  }else{
                     $('#frmPesqNatBaixa').prop('checked', false);
                     $('#frmPesqNatTransfer').prop('checked', false);
                     $('#frmPesqNatDev').prop('checked', false);
                     $('#frmPesqNatRem').prop('checked', false);
                     $('#frmPesqNatNf').prop('checked', false);
                     $('#frmPesqNatOutros').prop('checked',false);
                  }
                  
               });
               $('#frmPesqStatusTodos').click(function(){
                  var xCheck = $(this).prop('checked');
                  
                  if(xCheck){
                      $('#frmPesqStatusSolic').prop('checked', true);
                      $('#frmPesqStatusAnalise').prop('checked', true);
                      $('#frmPesqStatusAtParcial').prop('checked', true);
                      $('#frmPesqStatusAtend').prop('checked', true);
                      $('#frmPesqStatusCancel').prop('checked', true);
                  }else{
                      $('#frmPesqStatusSolic').prop('checked', false);
                      $('#frmPesqStatusAnalise').prop('checked', false);
                      $('#frmPesqStatusAtParcial').prop('checked', false);
                      $('#frmPesqStatusAtend').prop('checked', false);
                      $('#frmPesqStatusCancel').prop('checked', false);
                  }
                  
               });
               
               $('#status').click(function(){
                  frmStatusNm.dialog( "open" );
               });               
               $('#statusNm').change(function(){                                   
                  var xStatus = $('#statusNm').val();
                  var xTitle = '';
                  
                                                  
                  
                  switch(xStatus){
                     case 'S': { xTitle = 'S=Solicitada'; } break;
                     case 'A': { xTitle = 'A=Em análise'; } break;  
                     case 'AP': { xTitle = 'AP=Atendida Parcial'; } break;
                     case 'AT': { xTitle = 'AT=Atendida'; } break;
                     case 'C': { xTitle = 'C=Cancelada'; } ;
                  }   
                  
                  //Perfil suprimentos ou ADM
                  if( flagActionNm == 'inserirNm'  ){
                     //verifica se possui a funcionalidade
                     if( '<?php echo(Funcoes::permite( 'notamov.php', 'statusInicialNM')) ?>' == 'n' ){
                        blackAlert('Permissão', 'Somente os perfils [ADM] e [SUPRIMENTO] podem alterar o status de uma NM, ainda não cadastrada.');                        
                     }else{
                        $('#status').val(xTitle);                        
                     }
                     return;
                  }
                  
                                  
                  if( flagActionNm == 'editarNm'  ){
                     if( !preenchido(nmId)){
                        warningAlert('Selecione a NM primeiro.');
                        return;
                     }
                  }
                  
                  $.ajax({
                        type: 'GET',
                        url: "../Controle/notamovCTRL.php?evento=alterarStatusNm&nmId="+nmId+"&status="+xStatus,
                        dataType: 'html',
                        success: function (msg) { 
                           if(msg.trim() == 'OK'){
                              $('#status').val(xTitle);
                              frmStatusNm.dialog('close');
                              successAlert('Status da Nota de Movimentação alterado.');
                              return;
                           }
                           else{
                              frmStatusNm.dialog('close');
                              errorAlert(msg);
                              return;
                           }
                        },
                        error: function (msg) {
                           frmStatusNm.dialog('close');
                           errorAlert('ERRO AJAX:' + msg);
                        }
                     });
               });               
               $('#divFormulario').click( function(e){                   
                  if( flagActionNm == null ){
                     e.stopPropagation();
                     warningAlert('Clique no botão Inserir Nm ou selecione uma Nm da Pesquisa.');
                     return;
                  }                  
               } );               
               $('#divPesquisa').click( function(e){                   
                  flagNmUltimos40 = true;
                  carregarGridNm();
               } );               
               //barra de ferramentas
               $('#btnInserirNm').click(function(){
                  limparFormularioNm();
                  flagActionNm = "inserirNm";
                  $("#divFormulario").click();
                  habilita('btnSalvarNm');                
                  return;
               });                             
               $('#btnSalvarNm').click(function(e){
                  if( flagActionNm == 'EDITAR'  ){
                     //verifica se possui a funcionalidade de editar
                     if( '<?php echo(Funcoes::permite( 'notamov.php', 'editarNM')) ?>' == 'n' ){
                        blackAlert('Permissão', 'Solicite a permissão editarNM para edição de NMs.');
                        return;
                     }           
                  }   
                  
                  
                  if( formularioNmValidado(e) ){
                       $.ajax({
                        type: 'POST',
                        data: $('#frmEdicaoNm').serialize(),
                        url: "../Controle/notamovCTRL.php?evento=salvarNm&opcao="+flagActionNm,
                        dataType: 'html',
                        success: function (msg) {                       
                           
                           if( msg.trim().substr(0, 2) == 'OK' ){
                              if( flagActionNm == 'inserirNm' ){
                                 nmId = msg.trim().substr(3, msg.length - 2 );
                                 
                                 carregarGridMateriais(nmId);
                                 carregarGridInfoMercadoria(nmId);                                 
                                 
                                 flagActionNm = 'editarNm';
                                 
                                 $('#notaMaterialId').val(nmId);
                                 $('#status').val('S=Solicitada');                                 
                                 habilita('btnImprimirNm');
                                 habilita('btnExcluirNm');
                              }                                                         
                              successAlert('Nota de Movimentação, salva com sucesso.');
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
               $('#btnExcluirNm').click(function(e){
                  function sim(){
                     if( preenchido(nmId) ){
                          $.ajax({
                           type: 'GET',
                           url: "../Controle/notamovCTRL.php?evento=excluirNm&nmId="+nmId,
                           dataType: 'html',
                           success: function (msg) {                           
                              if( msg.trim().substr(0,2) == 'OK' ){
                                 flagActionNm = null;
                                 desabilita('bntExcluirNm');                                                                                                                       
                                 successAlert('Nota de Movimentação, excluída com sucesso.');
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
                        warningAlert('Nota Fiscal não selecionada.');
                     }
                  }
                 //excluir NM, caso sim executa o código da function sim(), acima 
                 confirm(sim, null);
               });                 
               $('#btnImprimirNm').click(function(){  
                  var url = '../Controle/notamovCTRL.php?evento=nmPossuiProduto&nmId='+nmId;
                  
                  $.get(url, function (dados) {  
                        if( dados.trim() == 'NAO' ){
                            errorAlert('Não se permite impressão de NM\'s sem material cadastrado.');                            
                            return;
                        }
                        window.open('../Controle/relatoriosCTRL.php?evento=gerar&rep=2&P_FORMATO=pdf&p=P_NM_ID='+nmId);
                        
                    }).fail(function (xhr, textStatus, errorThrown) {
                        errorAlert(xhr.responseText);
                        return;
                    });
                                    
                  
               });               
               //pesquisa de Nm
               $("#btnPesquisarNm").click(function () {
                    var xFrmPesqNm = $('#frmPesqNm').val();
                    var xFrmPesqNf = $('#frmPesqNf').val();
                    var xFrmPesqSe = $('#frmPesqSe').val();                    
                    
                    var xFrmPesqDtSolic = $('#frmPesqDtSolic').val();
                    var xListaNat = '';
                    var xListaStatus = '';
                    
                    var xFrmPesqNatBaixa = $('#frmPesqNatBaixa').prop('checked');
                    var xFrmPesqNatTransfer = $('#frmPesqNatTransfer').prop('checked');
                    var xFrmPesqNatDev = $('#frmPesqNatDev').prop('checked');
                    var xFrmPesqNatRem = $('#frmPesqNatRem').prop('checked');
                    var xFrmPesqNatNf = $('#frmPesqNatNf').prop('checked');
                    var xFrmPesqNatOutros = $('#frmPesqNatOutros').prop('checked');
                    
                    var xFrmPesqStatusSolic = $('#frmPesqStatusSolic').prop('checked');
                    var xFrmPesqStatusAnalise = $('#frmPesqStatusAnalise').prop('checked');
                    var xFrmPesqStatusAtParcial = $('#frmPesqStatusAtParcial').prop('checked');
                    var xFrmPesqStatusAtend = $('#frmPesqStatusAtend').prop('checked');
                    var xFrmPesqStatusCancel = $('#frmPesqStatusCancel').prop('checked');
                                       
                    //Natureza
                    if( xFrmPesqNatBaixa ){
                       xListaNat +="'B'"; 
                    }
                    
                    if( xFrmPesqNatTransfer ){
                       xListaNat += xListaNat != '' ? ",'T'" : "'T'" ; 
                    }
                    
                    if( xFrmPesqNatDev ){
                       xListaNat += xListaNat != '' ? ",'D'" : "'D'"; 
                    }
                    
                    if( xFrmPesqNatRem ){
                       xListaNat += xListaNat != '' ? ",'R'" : "'R'"; 
                    }
                    
                    if( xFrmPesqNatNf ){
                       xListaNat += xListaNat != '' ? ",'N'" : "'N'";  
                    }
                    
                    if( xFrmPesqNatOutros ){
                       xListaNat += xListaNat != '' ? ",'O'" : "'O'"; 
                    }
                                     
                    
                    
                    //Status
                    if( xFrmPesqStatusSolic ){
                       xListaStatus += xListaStatus != '' ? ",'S'" : "'S'"; 
                    }
                    
                    if( xFrmPesqStatusAnalise ){
                       xListaStatus += xListaStatus != '' ? ",'A'" : "'A'"; 
                    }
                    
                    if( xFrmPesqStatusAtParcial ){
                       xListaStatus += xListaStatus != '' ? ",'AP'" : "'AP'"; 
                    }
                    
                    if( xFrmPesqStatusAtend ){
                       xListaStatus += xListaStatus != '' ? ",'AT'" : "'AT'"; 
                    }
                    
                    if( xFrmPesqStatusCancel ){
                       xListaStatus += xListaStatus != '' ? ",'C'" : "'C'"; 
                    }
                    
                    
                    carregarGridNm(xFrmPesqNm, xFrmPesqNf, xFrmPesqSe, xFrmPesqDtSolic, xListaNat, xListaStatus );
                    

                });
               //seleção de Nm na grid
               $('#gridNm tbody').on('click', 'tr', function () {
                   nmId = gridNm.row({selected: true}).data()[0];
                                     
                   //ajax para chamar formulário
                   $.ajax({
                        type: 'POST',
                        url: "../Controle/notamovCTRL.php?evento=carregarFormNm&nmId="+nmId,
                        dataType: 'json',
                        success: function (json) {          
                              //limpar formulários
                              $('#frmEdicaoNm').trigger("reset");
            
                              
                              carregarGridMateriais( nmId );
                              carregarGridInfoMercadoria( nmId );
                              
                              json.fonteRecurso == 'P' ? $("#fonte1").prop("checked", true) : $("#fonte2").prop("checked", true);
                              
                              switch(json.natureza){
                                 case 'B': { $('#nat1').prop("checked", true); break; }
                                 case 'T': { $('#nat2').prop("checked", true); break; }
                                 case 'D': { $('#nat3').prop("checked", true); break; }
                                 case 'R': { $('#nat4').prop("checked", true); break; }
                                 case 'O': { $('#nat5').prop("checked", true); break; }
                                 case 'N': { $('#nat6').prop("checked", true); break; }   
                              }
                              
                              switch(json.sistema){
                                 case 'A': { $('#sist1').prop("checked", true); break; }
                                 case 'E': { $('#sist2').prop("checked", true); break; }
                                 case 'O': { $('#sist3').prop("checked", true); break; }
                              }
                              
                              $('#notaMaterialId').val( json.id );
                              $('#notaMaterialNf').val(json.notafiscal_num);
                              $('#notaMaterialNfDtLanc').val(json.notafiscal_dtlancamento);
                              $('#notaMaterialSe').val(json.se_num);
                                   
                                   
                              switch(json.status){
                                 case 'S': { $('#status').val('S=Solicitada'); } break;
                                 case 'A': { $('#status').val('A=Em análise'); } break;  
                                 case 'AP': { $('#status').val('AP=Atendida Parcial'); } break;
                                 case 'AT': { $('#status').val('AT=Atendida'); } break;
                                 case 'C': { $('#status').val('C=Cancelada'); desabilita('btnSalvaNm'); } ;
                              }
                              
                              
                              //$('#dtEmissao').val(json.dthoraSolicitacao);
                              
                              $('#infoComplementar').val(json.informacoesComplementares);
                              
                                                                                 
                              
                              $('#uaOrigem').val(json.uaOrigem);
                              $('#uaDestino').val(json.uaDestino);
                              
                              $('#transportadora').val(json.transportadora);
                              $('#transpEndereco').val(json.endereco);
                              $('#transpMotorista').val(json.motorista);
                              $('#transpViatura').val(json.nrViatura);
                              $('#transpPlaca').val(json.nrPlaca);
                              $('#transpLocalEntrega').val(json.localEntrega);
                              
                                                           
                              //requisicao
                              $('#solicitadoPorId').val( json.reqPorId );
                              $('#requisicaoMatricula').val( json.reqMatricula );
                              $('#requisicaoNome').val( json.reqNome );
                              $('#requisicaoData').val( json.reqDtHora );
                              
                              //autorização
                              $('#autorizacaoPorId').val( json.autPorId );
                              $('#autorizacaoMatricula').val( json.autMatricula );
                              $('#autorizacaoNome').val( json.autNome );
                              $('#autorizacaoData').val( json.autDtHora );
                              
                              //entrega                              
                              $('#entregaMatricula').val( json.entMatricula );
                              $('#entregaNome').val( json.entNome );
                              $('#entregaData').val( json.entDtHora );
                              //recebido
                              $('#recebidoMatricula').val( json.recebPorId );
                              $('#recebidoNome').val( json.recebNome );
                              $('#recebidoData').val( json.recebDtHora );

                              flagActionNm = 'editarNm';
                              $('#divFormulario').click();
                              habilita('btnSalvarNm');
                              habilita('btnExcluirNm');
                              habilita('btnImprimirNm');
                              return;

                        },
                        error: function (xhr, status, error) {                           
                            errorAlert('ERRO AJAX:' + error);
                        }
                    });
                   
                });  
                
               $("#btnLimparNm").click(function(){      
                  limparFormularioNm();                
               });                  
             
               $('#btnSalvarProduto').click( function(){
                  //validações do frmProdutoNm
                  if( !preenchido($('#prdNrNota').val())  ){
                     alert('Selecione a nota de movimentação primeiro.');
                     return;
                  }             
                  
                  if( !preenchido($('#prdMaterialId').val())  ){
                     alert('Preencha o campo produto.');
                     return;
                  }   
                  
                  if( !preenchido($('#prdQtdSolicitada').val())  ){
                     alert('Preencha o campo quantidade solicitada.');
                     return;
                  } 
                  
                  if( !preenchido($('#prdVlrUnitario').val())  ){
                     alert('Preencha o campo valor unitário.');
                     return;
                  }
                  
                  
                  $.ajax({
                        type: 'POST',
                        data: $('#frmProdutoNm').serialize(),
                        url: "../Controle/notamovCTRL.php?evento=salvarProdutoNm",
                        dataType: 'html',
                        success: function (msg) {                             
                            if( msg.trim() == 'OK' ){
                              carregarGridMateriais(nmId);                                                           
                              successAlert('Produto salvo com sucesso.');
                              frmProdutoNm.dialog( "close" );
                            }
                            else{
                                errorAlert(msg);
                            }                            
                        },
                        error: function (msg) {
                            errorAlert('ERRO AJAX:' + msg);
                        }
                    });
                                  
               } );
               $('#btnSalvarInfo').click( function(){
                  //validações do frmProdutoNm
                  if( !preenchido($('#infoEspecie').val())  ){
                     alert('Selecione a espécie da mercadoria.');
                     return;
                  }             
                  
                  if( !preenchido($('#infoEmbalagem').val())  ){
                     alert('Digite a embalagem.');
                     return;
                  }   
                  
                  if( !preenchido($('#infoQuantidade').val())  ){
                     alert('Digite a quantidade.');
                     return;
                  } 
                  
                  if( !preenchido($('#infoValor').val())  ){
                     alert('Digite o valor.');
                     return;
                  }
                  
                  
                  $.ajax({
                        type: 'POST',
                        data: $('#frmInfoMercadoriaNm').serialize(),
                        url: "../Controle/notamovCTRL.php?evento=salvarInfoMercadoriaNm",
                        dataType: 'html',
                        success: function (msg) {                             
                            if( msg.trim() == 'OK' ){
                              carregarGridInfoMercadoria(nmId);                                                            
                              successAlert('Informação salva com sucesso.');
                              frmInfoMercadoriaNm.dialog( "close" );
                            }
                            else{
                                errorAlert(msg);
                            }                            
                        },
                        error: function (msg) {
                            errorAlert('ERRO AJAX:' + msg);
                        }
                    });
                                  
               } );
               //_____________________________________________________
               
            });
        </script>
    </body>
</html>
