<?php

ini_set( 'display_errors', 'on' );

require_once('includes.php');


$evento = Funcoes::noInjection( $_GET[ 'evento' ] );

switch ( $evento )
{
   case 'salvarUa': {
         $ua = new Ua();  //Camada Modelo
         $UaDAO = new UaDAO(); //Camada Persistência

         $opcao = Funcoes::noInjection( $_GET[ 'opcao' ] ); 
        
        if ( $opcao == 'inserirUa' ) {
          $ua->id = $_POST[ 'ua_id' ];  
          $ua->descricao = utf8_decode($_POST[ 'descricao' ]);  
          $ua->uaAlias = utf8_decode($_POST[ 'ua_alias' ]);  
          $ua->ueId = utf8_decode($_POST[ 'ue_id' ]);  
          
          $UaId = $UaDAO->insert( $ua );

          echo('OK-' .$UaId);
          
          return ;
          
        }

        if ( $opcao == 'editarUa'){
            $ua->id = $_POST[ 'ua_id' ];

            if ( !$UaDAO->existeUa( $ua->id ) ) {
               echo('Ua inexistente.');
               return;
            }
   
            $ua->uaAlias = utf8_decode($_POST[ 'ua_alias' ]);  
            $ua->ueId = utf8_decode($_POST[ 'ue_id' ]);  
            $ua->descricao = utf8_decode($_POST[ 'descricao' ]);  
            
            $flag = $UaDAO->update($ua);
//            echo $flag;
//            return;
            
            if ( $flag )
            {
               echo('OK');
            }
            else
            {
               echo('Erro ao editar ua.');
            }
            return;
            
        }
        
        return;
        
    }
    
   case 'excluirUa':
      {
         $uaDao = new UaDAO();
         $usuario = new Usuario();
         $usuario = Funcoes::getUsuario();

         if ( $usuario == null )
         {
            echo('Usuário não autenticado. ' . '<a src=../home.php>login</a>');
            return;
         }

         //dados do formulário         
         $uaId = Funcoes::noInjection( $_GET[ 'uaId' ] );

         $uaDao->delete( $uaId );
         echo('OK');
         return;
      }
      
   case 'gridUa':
      {

         $criterio = Funcoes::noInjection( $_GET[ 'criterio' ] );
         $campo = Funcoes::noInjection( $_GET[ 'campo' ] );
         $valor = Funcoes::noInjection( $_GET[ 'valor' ] );


         $uaDAO = new UaDAO();

         $resultado = $uaDAO->listaUa( $campo, $criterio, $valor );
                
         $tabela = "{ \"aaData\": [ ";

         for ( $i = 0; $i < count( $resultado ); $i++ )
         {

            if ( $i == 0 )
            {
               $tabela .= "[";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'ua_alias' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'ue_id' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'descricao' ] ) ) ;
               $tabela .= "]";
               continue;
            }
            $tabela .= ",[";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'ua_alias' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'ue_id' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'descricao' ] ) ) ;
            $tabela .= "]";
            continue;
         }

         $tabela .=" ] }";

         echo($tabela);
         return;
      }
      
   case 'gridUa20':
      {
         $uaDao = new UaDAO();

         $resultado = $uaDao->listaUa20();


         $tabela = "{ \"aaData\": [ ";

         for ( $i = 0; $i < count( $resultado ); $i++ )
         {

            if ( $i == 0 )
            {
               $tabela .= "[";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'ua_alias' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'ue_id' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'descricao' ] ) ) ;
               $tabela .= "]";
               continue;
            }
            $tabela .= ",[";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'ua_alias' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'ue_id' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'descricao' ] ) ) ;
            $tabela .= "]";
            continue;
         }

         $tabela .=" ] }";

         echo($tabela);
         return;
      }
      
   case 'carregarFormUa':
      {
         $uaId = Funcoes::noInjection( $_GET[ 'uaId' ] );

         $ua = new Ua();
         $ue = new Ue();
         $uaDao = new UaDAO();
         $ueDAO = new UeDAO();
         $uaJson = array();

         $ua = $uaDao->load( $uaId );
         $ue = $ueDAO->load($ua->ueId);

         $uaJson[ "id" ] = $ua->id;
    
         $uaJson[ "descricao" ] = utf8_encode($ua->descricao);

         $uaJson[ "ua_alias" ] = utf8_encode($ua->uaAlias);

         $uaJson[ "ue_id" ] = utf8_encode($ua->ueId);
         
         $uaJson[ "descricaoUE" ] = utf8_encode($ue->descricao);

         echo( json_encode( $uaJson ) );
         return;
      }
  
   case 'autoCompleteUe':
      {
         $linhaUe = array();
         $arrayUe = array();
         $listaUes = null;
         $ue = null;
         $ueDao = new UeDAO();
         $parametro = Funcoes::noInjection( $_GET[ 'term' ] );

         $listaUes = $ueDao->listarUes( $parametro );

         for ( $i = 0; $i < count( $listaUes ); $i++ )
         {
            $ue = new Ue();
            $ue = $listaUes[ $i ];


            $linhaUe[ "id" ] = utf8_encode( $ue->id );
            $linhaUe[ "value" ] = utf8_encode( $ue->descricao );
            $linhaUe[ "label" ] = utf8_encode( $ue->descricao );

            array_push( $arrayUe, $linhaUe );
         }


         $json = json_encode( $arrayUe );
         echo $json;
         return;
      }
      
}
?>
