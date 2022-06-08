<?php

ini_set( 'display_errors', 'on' );

require_once('includes.php');


$evento = Funcoes::noInjection( $_GET[ 'evento' ] );

switch ( $evento )
{
   case 'salvarUe': {
         $ue = new Ue();  //Camada Modelo
         $UeDAO = new UeDAO(); //Camada Persistência

         $opcao = Funcoes::noInjection( $_GET[ 'opcao' ] ); 
        
        if ( $opcao == 'inserirUe' ) {
          $ue->id = $_POST[ 'ueId' ];  
          $ue->descricao = utf8_decode($_POST[ 'descricao' ]);  
          
          $UeDAO->insert( $ue );

          echo('OK');
          
          return ;
          
        }

        if ( $opcao == 'editarUe'){
            $ue->id = $_POST[ 'ueId' ];

            if ( !$UeDAO->existeUe( $ue->id ) ) {
               echo('Ue inexistente.');
               return;
            }
   
            $ue->descricao = utf8_decode($_POST[ 'descricao' ]);  
            
            $flag = $UeDAO->update($ue);

            if ( $flag )
            {
               echo('OK');
            }
            else
            {
               echo('Erro ao editar nota de material.');
            }
            return;
            
        }
        
        return;
        
    }
   case 'excluirUe':
      {
         $ueDao = new UeDAO();
         $usuario = new Usuario();
         $usuario = Funcoes::getUsuario();

         if ( $usuario == null )
         {
            echo('Usuário não autenticado. ' . '<a src=../home.php>login</a>');
            return;
         }

         //dados do formulário         
         $ueId = Funcoes::noInjection( $_GET[ 'ueId' ] );

         $ueDao->delete( $ueId );
         echo('OK');
         return;
      }
   case 'gridUe':
      {

         $criterio = Funcoes::noInjection( $_GET[ 'criterio' ] );
         $campo = Funcoes::noInjection( $_GET[ 'campo' ] );
         $valor = Funcoes::noInjection( $_GET[ 'valor' ] );


         $ueDAO = new UeDAO();

         $resultado = $ueDAO->listaUe( $campo, $criterio, $valor );
                
         $tabela = "{ \"aaData\": [ ";

         for ( $i = 0; $i < count( $resultado ); $i++ )
         {

            if ( $i == 0 )
            {
               $tabela .= "[";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'descricao' ] ) );
               $tabela .= "]";
               continue;
            }
            $tabela .= ",[";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'descricao' ] ) );
            $tabela .= "]";
            continue;
         }

         $tabela .=" ] }";

         echo($tabela);
         return;
      }
   case 'gridUe20':
      {
         $ueDao = new UeDAO();

         $resultado = $ueDao->listaUe20();


         $tabela = "{ \"aaData\": [ ";

         for ( $i = 0; $i < count( $resultado ); $i++ )
         {

            if ( $i == 0 )
            {
               $tabela .= "[";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'descricao' ] ) );
               $tabela .= "]";
               continue;
            }
            $tabela .= ",[";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'descricao' ] ) );
            $tabela .= "]";
            continue;
         }

         $tabela .=" ] }";

         echo($tabela);
         return;
      }
   case 'carregarFormUe':
      {
         $ueId = Funcoes::noInjection( $_GET[ 'ueId' ] );

         $ue = new Ue();
         $ueDao = new UeDAO();
         $ueJson = array();

         $ue = $ueDao->load( $ueId );
         

         $ueJson[ "id" ] = $ue->id;
    
         $ueJson[ "descricao" ] = utf8_encode($ue->descricao);

         echo( json_encode( $ueJson ) );
         return;
      }
  
}
?>
