<!DOCTYPE html>
<html>
    <head>
        <?php include('./Resources/tplImportCss.php') ?>
        <?php include('../Controle/includes.php') ?>
        
        <title>Relatórios</title>
    </head>
    <body>
        <?php include('./Resources/tplMenu.php') ?>
        <!-- conteudo -->
        <div class="row">
            <ul class="tabs z-depth-1">
                <li class="tab col s2 "><a  href="#tabRep">1-Relatórios</a></li>
                <li class="tab col s2 "><a  href="#tabRepGerado">2-Gerados</a></li>                 
            </ul>
            <!-- 1-Página -->
            <div id="tabRep" class="col s11">
                <br/>
                <div class="row bordaRow">
                  <form id="frmRep">
                     <div class="col s2"> 
                        Selecione o Relatório: 
                        <input type="text" id="rep" name="rep" />  
                     </div>                     
                     <div class="col s3">
                         <div id="divFrmRep">
                         </div>    
                     </div>                     
                     <div class="input-field col s2">
                       <div class="waves-effect waves-light btn" id="btnExecutar">Gerar</div>
                     </div>
                     
                  </form>
                </div>
            </div>

            <!-- 2-Funcionalidade -->
            <div id="tabRepGerado" class="col s11">
                <br/>
                <div class="row bordaRow">
                    <table id="gridGerado" cellpadding="0" cellspacing="0" border="0" class="col s8 offset-l2 highlight" style="font-size: 10px">
                        <thead>
                            <tr>
                                <th>Relatório Gerado</th>
                                <th>Data Geração</th> 
                                <th>Visualizar</th>  
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th>Relatório Gerado</th>
                                <th>Data Geração</th> 
                                <th>Visualizar</th>  
                            </tr>
                        </tfoot>
                    </table> 
                </div>
            </div>
            <div id="divLoad">
               <img src="Resources/img/load.gif"/>
            </div>

        </div>

        <?php include('./Resources/tplRodape.php') ?>
        <?php include('./Resources/tplImportJs.php') ?>
        <script type="text/javascript">

           $(document).ready(function () { 
                  var xGridGerado = null;
                  var xLoad = null;
                  
                  function carregarGridGerado() {
                     var htmlId = "gridGerado";
                     var ajaxUrl = "../Controle/relatoriosCTRL.php?evento=gridGerado"; 
     
                     var botoesEventos = [ ];
         
                     xGridGerado = grid( htmlId, ajaxUrl, botoesEventos, null, 10 );
                  }

                  $(".dropdown-button").dropdown();
                  $('ul.tabs').tabs();
                  $('#divFrmRep').hide();

                  xLoad = $('#divLoad').dialog({
                      title: "Processando",
                      autoOpen: false,
                      height: 120,
                      width: 220,
                      modal: true
                  });

                  $('#rep').dblclick(function(){
                     $('#rep').val('');
                     $('#divFrmRep').hide();
                  });
                  $('#rep').blur(function(){
                     if(!preenchido($('#rep').val())){
                        $('#divFrmRep').hide();
                     }
                  });         

                  $('#rep').autocomplete({
                     source: "../Controle/relatoriosCTRL.php?evento=autoCompleteRelatorios",
                     minLength: 1,
                     select: function( event, ui ) {
                        var xId = ui.item.id;
                        var xPosicao = -1;
                        var xValue = '';
                        
                        //lógica para adicionar os parâmetros
                        $.get( "../Controle/relatoriosCTRL.php?evento=parametros&rep_id="+xId, function( xData ) {                       
                           $('#divFrmRep').empty('');

                           $.each($.parseJSON(xData), function(idx, obj) {
                              $('#divFrmRep').append("<div class='input-field col s2' >");
                              
                              if(obj.tipo == 'TEXTO'){                              
                                    $('#divFrmRep').append("<label for='"+obj.name+"' >"+obj.label+"</label>");
                                    $('#divFrmRep').append("<input id='"+obj.name+"' title='"+obj.hint+"' name='"+obj.name+"' type='text' value='"+obj.valor+"' />");                              

                                    if(preenchido(obj.mascara)){
                                       $('#'+obj.name).mask(obj.mascara,{reverse: false});
                                    }
                              }
                              
                              if(obj.tipo == 'LISTA'){
                                 var valores = obj.valor.split(';');
                                 $('#divFrmRep').append("<label for='"+obj.name+"' >"+obj.label+"</label>");
                                 $('#divFrmRep').append("<select id='"+obj.name+"' name='"+obj.name+"' ></select>");
                                      $('#' + obj.name).material_select();
                                      for (var i = 0; i < valores.length; i++) {                                         
                                         xPosicao = valores[i].indexOf('=');                                        
                                         
                                         if(xPosicao != -1){
                                            xValue = valores[i].substring(0, xPosicao);
                                            $('#' + obj.name).append("<option value='" + xValue + "'>" + valores[i] + "</option>");
                                         }
                                         else{
                                            $('#' + obj.name).append("<option value='" + valores[i] + "'>" + valores[i] + "</option>");
                                         }
                                      }
                                      $('#' + obj.name).material_select();
                              }
                              
                              if(obj.tipo == 'AUTOCOMPLETE'){
                                 $('#divFrmRep').append("<label for='"+obj.name+"' >"+obj.label+"</label>");
                                 $('#divFrmRep').append("<input id='"+obj.name+"' title='"+obj.hint+"' name='"+obj.name+"' type='text' />");                              

                                 if(preenchido(obj.mascara)){
                                    $('#'+obj.name).mask(obj.mascara,{reverse: false});
                                 }
                                 
                                 $("#"+obj.name).autocomplete({
                                       minLength: 3,
                                       source: function(request, response) {
                                          $.ajax({
                                             url: "../Controle/relatoriosCTRL.php?evento=autoCompleteGenerico",
                                             dataType: "json",
                                             data: {
                                                term: request.term, 
                                                query: obj.query
                                             },
                                             success: function(data) {
                                                response(data);
                                             }
                                          });
                                       }
                                 });   
                                 
                              }
                              
                              $('#divFrmRep').append("</div>");

                           });
                           $('#divFrmRep').show();

                        });
                      }
                  });
                  $('#btnExecutar').click(function () {                      
                      var xIdx = -1;
                      var xFlag = false;
                      
                      
                      if (!preenchido($('#rep').val())) {
                          warningAlert('Selecione o relatório');
                          return;
                      }
                      
                      //busca pelos campos obrigatórios no form
                      $('#frmRep label').each(function(){
                        xIdx = $(this).text().indexOf('*');
                        
                        if( xIdx != -1 ){
                           if ( !preenchido( $('#'+$(this).prop('for')).val() ) ) {
                              xFlag = true;
                              warningAlert('Preencha o campo: '+$(this).text());
                              return;
                           }
                        }
                      });

                      if(xFlag){
                        return;
                      }
                      
                      $.ajax({
                          type: 'POST',
                          url: "../Controle/relatoriosCTRL.php?evento=gerar",
                          dataType: 'html',
                          data: $('#frmRep').serialize(),
                          beforeSend: function () {
                              xLoad.dialog("open");
                          },
                          success: function (msg) {
                              xLoad.dialog("close");
                              if (msg.trim() == 'OK') {
                                  successAlert('Relatório gerado com sucesso.');
                              } else {
                                  errorAlert(msg);
                              }
                              carregarGridGerado();
                          },
                          error: function (xhr, status, error) {
                              xLoad.dialog("close");
                              errorAlert('ERRO AJAX:' + error);
                          }
                      });
                  });

                  $('#acessoPerfil').material_select();
                  $('#intPerfil').material_select();
                  $('.tooltipped').tooltip({delay: 50});
                  
                  carregarGridGerado();

                  $('#gridGerado tbody').on('click', 'tr', function () {
                      var xArquivo = xGridGerado.row({selected: true}).data()[0];
                      //link
                  });
                
               });
        </script>
    </body>
</html>

