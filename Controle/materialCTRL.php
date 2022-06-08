<?php

ini_set( 'display_errors', 'on' );

require_once('includes.php');


$evento = Funcoes::noInjection( $_GET[ 'evento' ] );

switch ( $evento )
{
   case 'salvarMaterial': {
         $material = new Material();  //Camada Modelo
         $MaterialDAO = new MaterialDAO(); //Camada Persistência

         $opcao = Funcoes::noInjection( $_GET[ 'opcao' ] ); 
        
        if ( $opcao == 'inserirMaterial' ) {
          $material->id = $_POST[ 'materialId' ];  
          $material->grupo = $_POST[ 'materialGrupo' ];  
          $material->codigo = utf8_decode($_POST[ 'materialCodigo' ]);  
          $material->descricao = utf8_decode($_POST[ 'materialDescricao' ]);  
          $material->unidade = utf8_decode($_POST[ 'materialUnidade' ]);  
          $material->precoMedio = $_POST[ 'materialprecoMedio' ];  
          
          $MaterialDAO->insert( $material );

          echo('OK');
          
          return ;
          
        }

        if ( $opcao == 'editarMaterial'){
            $material->id = $_POST[ 'materialId' ];

            if ( !$MaterialDAO->existeMaterial( $material->id ) ) {
               echo('Material inexistente.');
               return;
            }
   
            $material->grupo = $_POST[ 'materialGrupo' ];  
            $material->codigo = utf8_decode($_POST[ 'materialCodigo' ]);  
            $material->descricao = utf8_decode($_POST[ 'materialDescricao' ]);  
            $material->unidade = utf8_decode($_POST[ 'materialUnidade' ]);  
            $material->precoMedio = $_POST[ 'materialprecoMedio' ];  
            
            $flag = $MaterialDAO->update($material);

            if ( $flag )
            {
               echo('OK');
            }
            else
            {
               echo('Erro ao editar material.');
            }
            return;
            
        }
        
        return;
        
    }
   case 'excluirMaterial':
      {
         $materialDao = new MaterialDAO();
         $usuario = new Usuario();
         $usuario = Funcoes::getUsuario();

         if ( $usuario == null )
         {
            echo('Usuário não autenticado. ' . '<a src=../home.php>login</a>');
            return;
         }

         //dados do formulário         
         $materialId = Funcoes::noInjection( $_GET[ 'materialId' ] );

         $materialDao->delete( $materialId );
         echo('OK');
         return;
      }
   case 'gridMaterial':
      {

         $criterio = Funcoes::noInjection( $_GET[ 'criterio' ] );
         $campo = Funcoes::noInjection( $_GET[ 'campo' ] );
         $valor = Funcoes::noInjection( $_GET[ 'valor' ] );


         $materialDAO = new MaterialDAO();

         $resultado = $materialDAO->listarTodosMateriais( $campo, $criterio, $valor );
                
         $tabela = "{ \"aaData\": [ ";

         for ( $i = 0; $i < count( $resultado ); $i++ )
         {

            if ( $i == 0 )
            {
               $tabela .= "[";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'grupo' ] ) ). ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'codigo' ] ) ). ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::jsonStr($resultado[ $i ][ 'descricao' ]) ) ). ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'unidade' ] ) ). ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'preco_medio' ] ) );
               $tabela .= "]";
               continue;
            }
            $tabela .= ",[";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'grupo' ] ) ). ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'codigo' ] ) ). ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::jsonStr($resultado[ $i ][ 'descricao' ]) ) ). ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'unidade' ] ) ). ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'preco_medio' ] ) );
            $tabela .= "]";
            continue;
         }

         $tabela .=" ] }";

         echo($tabela);
         return;
      }
   case 'gridMaterial20':
      {
         $materialDao = new MaterialDAO();

         $resultado = $materialDao->listaMaterial20();


         $tabela = "{ \"aaData\": [ ";

         for ( $i = 0; $i < count( $resultado ); $i++ )
         {

            if ( $i == 0 )
            {
               $tabela .= "[";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'grupo' ] ) ). ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'codigo' ] ) ). ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::jsonStr($resultado[ $i ][ 'descricao' ]) ) ). ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'unidade' ] ) ). ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'preco_medio' ] ) );
               $tabela .= "]";
               continue;
            }
            $tabela .= ",[";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'grupo' ] ) ). ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'codigo' ] ) ). ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::jsonStr($resultado[ $i ][ 'descricao' ]) ) ). ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'unidade' ] ) ). ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'preco_medio' ] ) );
            $tabela .= "]";
            continue;
         }

         $tabela .=" ] }";

         echo($tabela);
         return;
      }
   case 'carregarFormMaterial':
      {
         $materialId = Funcoes::noInjection( $_GET[ 'materialId' ] );

         $material = new Material();
         $materialDao = new MaterialDAO();
         $materialJson = array();

         $material = $materialDao->load( $materialId );
         

         $materialJson[ "id" ] = $material->id;
    
         $materialJson[ "descricao" ] = utf8_encode($material->descricao);
         $materialJson[ "grupo" ] = $material->grupo;
         $materialJson[ "codigo" ] = utf8_encode($material->codigo);
         $materialJson[ "unidade" ] = utf8_encode($material->unidade);
         $materialJson[ "preco_medio" ] = $material->precoMedio;

         echo( json_encode( $materialJson ) );
         return;
      }
   case 'listaDeUnidades':
   {
      $materialDao = new MaterialDAO();
      $listaUnidade = $materialDao->listarUnidades();
      $html = "<option value='' disabled selected>Selecione</option>";

      foreach ( $listaUnidade as $unidade )
      {
         $html .= "<option value='" . $unidade->sigla . "'>" . utf8_encode($unidade->descricao) . "</option>";
      }
      echo($html);
      return;
   }

  
}
?>
