<?php

ini_set( 'display_errors', 'on' );

require_once('includes.php');


$evento = Funcoes::noInjection( $_GET[ 'evento' ] );

switch ( $evento )
{

   case 'autoCompleteRelatorios':
      {
         $xLinhaRep = array();
         $xArrayRep = array();
         $xListaRep = null;
         $xRep = null;
         $xRepDao = new RepDAO();
         $xUsuario = new Usuario();
         $xUsuario = Funcoes::getUsuario();

         $xRepForm = Funcoes::noInjection( $_GET[ 'term' ] );

         $xListaRep = $xRepDao->queryByDescrPerfil( $xRepForm, $xUsuario->perfilPermissao );

         for ( $i = 0; $i < count( $xListaRep ); $i++ )
         {
            $xRep = new Rep();
            $xRep = $xListaRep[ $i ];

            $xLinhaRep[ "id" ] = utf8_encode( $xRep->id );
            $xLinhaRep[ "value" ] = utf8_encode( $xRep->id . '=' . $xRep->descricao );
            $xLinhaRep[ "label" ] = utf8_encode( $xRep->id . '=' . $xRep->descricao );
            array_push( $xArrayRep, $xLinhaRep );
         }


         $json = json_encode( $xArrayRep );
         echo $json;
         return;
      }
      
   case 'autoCompleteGenerico':
      {
         $xTermo = Funcoes::noInjection( $_GET[ 'term' ] );
         $xQuery = $_GET[ 'query' ];
         
         $xQuery = str_replace('?', $xTermo, $xQuery);
         
         $xRepParametroDao = new RepParametroDAO();
         $xArrayRep = array();

         $xLista = $xRepParametroDao->executaQueryForAutoComplet($xQuery);

         for ( $i = 0; $i < count( $xLista ); $i++ )
         {            
            $xLinhaRep[ "id" ] = utf8_encode( $xLista[$i]['id'] );
            $xLinhaRep[ "value" ] = utf8_encode( $xLista[$i]['id'] );
            $xLinhaRep[ "label" ] = utf8_encode( $xLista[$i]['id'] . '=' . $xLista[$i]['descricao'] );
            array_push( $xArrayRep, $xLinhaRep );
         }

         $json = json_encode( $xArrayRep );
         echo $json;
         return;
      }

   case 'parametros':
      {
         $xId = Funcoes::noInjection( $_GET[ 'rep_id' ] );
         $xJson = array();
         $xRepParam = null;
         $xListaParam = null;
         $xRepParamDao = new RepParametroDAO();

         $xListaParam = $xRepParamDao->queryByRepId( $xId );

         for ( $i = 0; $i < count( $xListaParam ); $i++ )
         {
            $xRepParam = new RepParametro();
            $xRepParametroDao = new RepParametroDAO();
            $xRepParam = $xListaParam[ $i ];

            $xJson[ $i ][ 'label' ] = utf8_encode( $xRepParam->label );
            $xJson[ $i ][ 'name' ] = $xRepParam->name;
            $xJson[ $i ][ 'tipo' ] = $xRepParam->tipo;
            $xJson[ $i ][ 'valor' ] = $xRepParam->valor;
            $xJson[ $i ][ 'mascara' ] = $xRepParam->mascara;
            $xJson[ $i ][ 'obrigatorio' ] = $xRepParam->obrigatorio;
            $xJson[ $i ][ 'query' ] = $xRepParam->query;
            $xJson[ $i ][ 'hint' ] = $xRepParam->hint;
            
            if( $xJson[ $i ][ 'obrigatorio' ] == 1 ){
               $xJson[ $i ][ 'label' ] .= '*';
            }
            
			
            if( !Funcoes::isNuloVazioNaoSetado( $xJson[ $i ][ 'query' ] ) && $xJson[ $i ][ 'tipo' ] != 'AUTOCOMPLETE'){               
               $xValores = $xRepParametroDao->executaQuery( $xJson[ $i ][ 'query' ] );
               
               if( !Funcoes::isNuloVazioNaoSetado( $xValores ) ){
                  $xJson[ $i ][ 'valor' ] = $xValores;
               }
               else{
                  $xJson[ $i ][ 'valor' ] = 'Erro ao carregar valores da Query';
               }       
               
            }
            
            
         }

		 
         echo( json_encode( $xJson ) );
         return;
      }

   case 'gerar':
      {
         $app = array('pdf' => 'application/pdf',  
                      'doc' => 'application/msword',
                      'docx' => 'application/msword',
                      'rtf' => 'application/rtf',
                      'xls' => 'application/vnd.ms-excel',
                      'xlsx' => 'application/vnd.ms-excel'
                  );
      
         //método get
         if( !$_POST ){
            $xRepId = Funcoes::getSubstring( Funcoes::noInjection( $_GET[ 'rep' ] ), '=', '<' );
            $f = Funcoes::noInjection( $_GET[ 'P_FORMATO' ] );
            $xP = null;
            
            $xParams = array();
            $xParams = $_GET;
            unset( $xParams[ 'evento' ] );
            unset( $xParams[ 'rep' ] );
            unset( $xParams[ 'P_FORMATO' ] ); 
            $xP = $xParams['p'];
            unset( $xParams[ 'p' ] );
            
            $xParams[Funcoes::getSubstring($xP, '=', '<')] = Funcoes::getSubstring($xP, '=', '>');
            $xRepGerado = Relatorio::gerar( $xRepId, $xParams, $f );
            
            if( $xRepGerado != null ){
               header("Content-type:".$app[$f]);         
               header("Content-Disposition:attachment;filename='$xRepGerado'");
               readfile($xRepGerado);
            }
            else{
               echo('Relatório não gerado');
            }
            return;
            
         }else{
            $xRepId = Funcoes::getSubstring( Funcoes::noInjection( $_POST[ 'rep' ] ), '=', '<' );
            $f = Funcoes::noInjection( $_POST[ 'P_FORMATO' ] );
            $xParams = array();
            $xParams = $_POST;
            unset( $xParams[ 'rep' ] );
            unset( $xParams[ 'P_FORMATO' ] );
                                  
            Relatorio::gerar( $xRepId, $xParams, $f );
            echo('OK');
         }   

         return;
      }

   case 'gridGerado':
      {

         $xUsuario = new Usuario();
         $xUsuario = Funcoes::getUsuario();
         $xListaExtensao = array( 'pdf', 'rtf', 'xls', 'xlsx', 'docx', 'odt', 'ods', 'pptx', 'csv', 'html', 'xhtml', 'xml', 'jrprint', 'view' );
         $xArqLista = array();
         $xPath = '../Visao/Relatorios/gerados/' . $xUsuario->integranteId;

         if(!is_dir($xPath) ){
            $tabela = "{ \"aaData\": [ ";
            $tabela .=" ] }";
            echo($tabela);
            return;
         }
         
         $xDir = opendir( $xPath );

         while ( $xArq = readdir( $xDir ) )
         {
            $xExtArq = pathinfo( $xArq );

            if ( in_array( $xExtArq[ 'extension' ], $xListaExtensao ) )
            {
               $xArqLista[] = $xArq;
            }
         }


         $tabela = "{ \"aaData\": [ ";

         for ( $i = 0; $i < count( $xArqLista ); $i++ )
         {
            $xF = Funcoes::getSubstring($xArqLista[$i], '.', '<');
            
            $xDataGeracao = substr($xF, (strlen($xF) - 12), 12) ;
            $xDataGeracao = Funcoes::formataDtHoraView($xDataGeracao);
                        

            if ( $i == 0 )
            {
               $tabela .= "[";
               $tabela .= Funcoes::aspasDuplas( $xArqLista[$i]  ).',';
               $tabela .= Funcoes::aspasDuplas($xDataGeracao).',';
               $tabela .= Funcoes::aspasDuplas( "<a href='$xPath/$xArqLista[$i]' target='_blank' ><img src='../Visao/Resources/img/view.png'/></a>" );   
               $tabela .= "]";
               continue;
            }
               $tabela .= ",[";
               $tabela .= Funcoes::aspasDuplas( $xArqLista[$i]  ).','; 
               $tabela .= Funcoes::aspasDuplas($xDataGeracao).',';
               $tabela .= Funcoes::aspasDuplas( "<a href='$xPath/$xArqLista[$i]' target='_blank' ><img src='../Visao/Resources/img/view.png'/></a>" );   
               $tabela .= "]";
         }

         $tabela .=" ] }";

         echo($tabela);
         return;
      }
      
   
   default:
      {
         echo 'Evento ' . $evento . ' não válido.';
         return;
      }
}
?>