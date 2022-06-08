<?php

ini_set( 'display_errors', 'on' );

require_once('includes.php');


$evento = Funcoes::noInjection( $_GET[ 'evento' ] );

switch ( $evento )
{

   //1-Páginas
   case 'views':
      {
         $viewDao = new ViewDAO();

         $listaViews = $viewDao->queryAll();

         $tabela = "{ \"aaData\": [ ";

         for ( $i = 0; $i < count( $listaViews ); $i++ )
         {
            $view = new View();
            $view = $listaViews[ $i ];

            if ( $i == 0 )
            {
               $tabela .= "[";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $view->arquivoNome ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $view->url ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $view->descricao ) );
               $tabela .= "]";
               continue;
            }
            $tabela .= ",[";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $view->arquivoNome ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $view->url ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $view->descricao ) );
            $tabela .= "]";
            continue;
         }

         $tabela .=" ] }";

         echo($tabela);
         return;
      }
   case 'inserirView':
      {
         $view = new View();
         $viewDao = new ViewDAO();

         $xViewArquivo = utf8_decode( Funcoes::noInjection( $_POST[ 'viewArquivo' ] ) );
         $xViewUrl = utf8_decode( Funcoes::noInjection( $_POST[ 'viewUrl' ] ) );
         $xViewDescricao = utf8_decode( Funcoes::noInjection( $_POST[ 'viewDescricao' ] ) );

         $view->arquivoNome = $xViewArquivo;
         $view->url = $xViewUrl;
         $view->descricao = $xViewDescricao;


         $flagView = new View();
         $flagView = $viewDao->load( $view->arquivoNome );

         //verifica se já existe a página cadastrada
         if ( $flagView != null )
         {
            echo("Página <b>$xViewArquivo</b> já está cadastrada");
            return;
         }


         $flag = $viewDao->insert( $view );


         if ( $flag )
         {
            echo('OK');
         }
         else
         {
            echo("Erro ao inserir a página <b>$xViewArquivo</b>");
         }

         return;
      }
   case 'editarView':
      {
         $view = new View();
         $viewDao = new ViewDAO();

         $xViewArquivo = utf8_decode( Funcoes::noInjection( $_POST[ 'viewArquivo' ] ) );
         $xViewUrl = utf8_decode( Funcoes::noInjection( $_POST[ 'viewUrl' ] ) );
         $xViewDescricao = utf8_decode( Funcoes::noInjection( $_POST[ 'viewDescricao' ] ) );

         $view->arquivoNome = $xViewArquivo;
         $view->url = $xViewUrl;
         $view->descricao = $xViewDescricao;


         $flagView = new View();
         $flagView = $viewDao->load( $xViewArquivo );

         //verifica se já existe a página cadastrada
         if ( $flagView == null )
         {
            echo("Página <b>$xViewArquivo</b> não cadastrada");
            return;
         }



         $flag = $viewDao->update( $view );


         if ( $flag )
         {
            echo('OK');
         }
         else
         {
            echo("Erro ao editar a página <b>$xViewArquivo</b>");
         }

         return;
      }
   case 'excluirView':
      {
         $flagView = new View();
         $viewDao = new ViewDAO();

         $xViewArquivo = utf8_decode( Funcoes::noInjection( $_GET[ 'viewArquivo' ] ) );

         $flagView = $viewDao->load( $xViewArquivo );
         //verifica se já existe a página cadastrada
         if ( $flagView == null )
         {
            echo("Página <b>$xViewArquivo</b> não cadastrada");
            return;
         }


         $flag = $viewDao->excluirView( $xViewArquivo );


         if ( $flag )
         {
            echo('OK');
         }
         else
         {
            echo("Erro ao excluir a página <b>$xViewArquivo</b>.");
         }

         return;
      }


   //2-Funcionalidade
   case 'funcs':
      {
         $funcDao = new FuncionalidadeDAO();

         $listaFuncs = $funcDao->queryAll();

         $tabela = "{ \"aaData\": [ ";

         for ( $i = 0; $i < count( $listaFuncs ); $i++ )
         {
            $func = new Funcionalidade();
            $func = $listaFuncs[ $i ];

            if ( $i == 0 )
            {
               $tabela .= "[";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $func->id ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $func->viewArquivoNome ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $func->acao ) );
               $tabela .= "]";
               continue;
            }
            $tabela .= ",[";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $func->id ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $func->viewArquivoNome ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $func->acao ) );
            $tabela .= "]";
            continue;
         }

         $tabela .=" ] }";

         echo($tabela);
         return;
      }
   case 'inserirFunc':
      {
         $func = new Funcionalidade();
         $funcDao = new FuncionalidadeDAO();

         $xFuncPagina = utf8_decode( Funcoes::noInjection( $_POST[ 'funcPagina' ] ) );
         $xFuncAcao = utf8_decode( Funcoes::noInjection( $_POST[ 'funcAcao' ] ) );


         $func->viewArquivoNome = $xFuncPagina;
         $func->acao = $xFuncAcao;


         $flagFunc = new Funcionalidade();
         $flagFunc = $funcDao->load( $func->viewArquivoNome, $func->acao );

         //verifica se já existe a funcionalidade cadastrada
         if ( $flagFunc != null )
         {
            echo("Funcionalidade <b>$xFuncAcao</b> já está cadastrada");
            return;
         }


         $flag = $funcDao->insert( $func );


         if ( $flag > 0 )
         {
            echo('OK');
         }
         else
         {
            echo("Erro ao inserir a funcionalidade <b>$xFuncAcao</b>");
         }

         return;
      }
   case 'editarFunc':
      {
         $func = new Funcionalidade();
         $funcDao = new FuncionalidadeDAO();

         $xFuncId = Funcoes::noInjection( $_POST[ 'funcId' ] );
         $xFuncPagina = utf8_decode( Funcoes::noInjection( $_POST[ 'funcPagina' ] ) );
         $xFuncAcao = utf8_decode( Funcoes::noInjection( $_POST[ 'funcAcao' ] ) );

         $func->id = $xFuncId;
         $func->viewArquivoNome = $xFuncPagina;
         $func->acao = $xFuncAcao;


         $flagFunc = new Funcionalidade();
         $flagFunc = $funcDao->load( $func->viewArquivoNome, $func->acao );

         //verifica se já existe a funcionalidade cadastrada
         if ( $flagFunc != null )
         {
            echo("Funcionalidade <b>$xFuncAcao</b> já cadastrada.");
            return;
         }


         $flag = $funcDao->update( $func );

         if ( $flag > 0 )
         {
            echo('OK');
         }
         else
         {
            echo("Erro ao editar a funcionalidade <b>$xFuncAcao</b>");
         }

         return;
      }
   case 'excluirFunc':
      {
         $funcDao = new FuncionalidadeDAO();
         $xFuncId = Funcoes::noInjection( $_GET[ 'funcId' ] );

         $flagFunc = new Funcionalidade();
         $flagFunc = $funcDao->loadById( $xFuncId );

         //verifica se a funcionalidade está cadastrada
         if ( $flagFunc == null )
         {
            echo("Funcionalidade <b>$xFuncId</b> não cadastrada.");
            return;
         }


         $flag = $funcDao->delete( $xFuncId );

         if ( $flag > 0 )
         {
            echo('OK');
         }
         else
         {
            echo("Erro ao excluir a funcionalidade <b>$xFuncId</b>");
         }

         return;
      }


   //3-Acesso a páginas
   case 'perfilView':
      {

         $perfil = Funcoes::noInjection( $_GET[ 'perfil' ] );
         $perfilViewDao = new PerfilViewDAO();

         $paginasPorPerfil = $perfilViewDao->queryByPerfilId( $perfil );

         $tabela = "{ \"aaData\": [ ";

         for ( $i = 0; $i < count( $paginasPorPerfil ); $i++ )
         {
            $pageView = new PerfilView();
            $pageView = $paginasPorPerfil[ $i ];

            if ( $i == 0 )
            {
               $tabela .= "[";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $pageView->id ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $pageView->viewArquivoNome ) );
               $tabela .= "]";
               continue;
            }
            $tabela .= ",[";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $pageView->id ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $pageView->viewArquivoNome ) );
            $tabela .= "]";
            continue;
         }

         $tabela .=" ] }";

         echo($tabela);
         return;
      }
   case 'listaDePaginas':
      {
         $viewDao = new ViewDAO();
         $listaViews = $viewDao->queryAll();
         $html = "<option value='' disabled selected>Selecione</option>";

         foreach ( $listaViews as $view )
         {
            $html .= "<option value='" . $view->arquivoNome . "'>" . $view->arquivoNome . "</option>";
         }
         echo($html);
         return;
      }
   case 'inserirAcessoPagina':
      {
         $perfilView = new PerfilView();
         $perfilViewDao = new PerfilViewDAO();

         $xPerfil = Funcoes::noInjection( $_POST[ 'acessoPerfil' ] );
         $xPagina = Funcoes::noInjection( $_POST[ 'acessoPagina' ] );

         $perfilView->perfilId = $xPerfil;
         $perfilView->viewArquivoNome = $xPagina;

         //verifica se já existe a página cadastrada para o perfil
         if ( $perfilViewDao->jaExistePerfilEView( $xPerfil, $xPagina ) > 0 )
         {
            echo("Página <b>$xPagina</b> já está associada ao perfil <b>$xPerfil</b>");
            return;
         }


         $flag = $perfilViewDao->insert( $perfilView );


         if ( $flag > 0 )
         {
            echo('OK');
         }
         else
         {
            echo("Erro aos associar a página <b>$xPagina</b> ao perfil <b>$xPerfil</b>");
         }

         return;
      }
   case 'excluirAcessoPagina':
      {
         $perfilView = new PerfilView();
         $perfilViewDao = new PerfilViewDAO();

         $xAcessoPerfil = Funcoes::noInjection( $_POST[ 'acessoPerfil' ] );
         $xAcessoPagina = Funcoes::noInjection( $_POST[ 'acessoPagina' ] );


         //verifica se já existe a página cadastrada para o perfil
         $perfilView = $perfilViewDao->loadByPerfilPagina( $xAcessoPerfil, $xAcessoPagina );
         if ( $perfilView == null )
         {
            echo("Registro não existe");
            return;
         }


         $flag = $perfilViewDao->deleteByPerfilPagina( $xAcessoPerfil, $xAcessoPagina );


         if ( $flag > 0 )
         {
            echo('OK');
         }
         else
         {
            echo("Erro aos excluir a página <b>$xPagina</b> ao perfil <b>$xPerfil</b>");
         }

         return;
      }
   case 'permissaoAcesso':
      {
         $xPerfil = utf8_decode( Funcoes::noInjection( $_GET[ 'perfil' ] ) );
         $xPagina = utf8_decode( Funcoes::noInjection( $_GET[ 'pagina' ] ) );

         $htmlSim = "<br/>";
         $htmlNao = "<br/>";

         //
         $funcDao = new FuncionalidadeDAO();
         $listaSim = $funcDao->queryByPerfilPagina( $xPerfil, $xPagina );

         $notIn = "NOT IN(";
         for ( $i = 0; $i < count( $listaSim ); $i++ )
         {
            $func = new Funcionalidade();
            $func = $listaSim[ $i ];

            $notIn .= ( $i != (count( $listaSim ) - 1) ? "$func->id," : "$func->id" );
         }
         $notIn .= ")";

         if ( count( $listaSim ) < 1 )
         {
            $notIn = "";
         }

         $listaNao = $funcDao->queryByViewArquivoNome( $xPagina, $notIn );


         foreach ( $listaSim as $permitida )
         {
            $htmlSim .= "<input type='checkbox' id='chk$permitida->id'  value='$permitida->id' name='chk$permitida->id' checked='checked' />";
            $htmlSim .= "<label for='chk$permitida->id'>$permitida->acao</label><br/>";
         }

         foreach ( $listaNao as $nPermitida )
         {
            $htmlNao .= "<input type='checkbox' id='chk$nPermitida->id' value='$nPermitida->id' name='chk$nPermitida->id'/>";
            $htmlNao .= "<label for='chk$nPermitida->id'>$nPermitida->acao</label><br/>";
         }

         echo $htmlSim . '<hr/>' . $htmlNao;
         return;
      }
   case 'permissaoSalvar':
      {
         $xPermissao = new Permissao();
         $xFlag = new Permissao();
         $xPermissaoDao = new PermissaoDAO();


         $xFuncId = utf8_decode( Funcoes::noInjection( $_GET[ 'funcId' ] ) );
         $xPerfil = utf8_decode( Funcoes::noInjection( $_GET[ 'perfil' ] ) );
         $xOp = utf8_decode( Funcoes::noInjection( $_GET[ 'op' ] ) );

         if ( $xOp == "inserir" )
         {
            //verificar se já foi cadastrado
            $xFlag = $xPermissaoDao->load( $xPerfil, $xFuncId );

            if ( $xFlag != null )
            {
               echo 'OK';
               return;
            }
            else
            {
               $xPermissao->perfilId = $xPerfil;
               $xPermissao->funcionalidadeId = $xFuncId;

               if ( $xPermissaoDao->insert( $xPermissao ) )
               {
                  echo 'OK';
                  return;
               }
               else
               {
                  echo("Erro ao inserir a funcionalidade <b>$xFuncId</b> ao perfil <b>$xPerfil</b>");
                  return;
               }
            }
         }
         if ( $xOp == "excluir" )
         {
            //verificar se já foi cadastrado
            $xFlag = $xPermissaoDao->load( $xPerfil, $xFuncId );

            if ( $xFlag != null )
            {
               if ( $xPermissaoDao->delete( $xPerfil, $xFuncId ) > 0 )
               {
                  echo 'OK';
                  return;
               }
               else
               {
                  echo("Erro ao excluir a funcionalidade <b>$xFuncId</b> do perfil <b>$xPerfil</b>");
                  return;
               }
            }
            echo("Exclusão negada, funcionalidade <b>$xFuncId</b> não permitida ao perfil  <b>$xPerfil</b>");
            return;
         }
      }

   //4-Integrante      
   case 'integrante':
      {
         $xIntMatr = Funcoes::noInjection( $_GET[ 'intMatr' ] );
         $xUa = Funcoes::getSubstring(Funcoes::noInjection( $_GET['intUa'] ), '=', '<');
         
         $xIntegranteDao = new IntegranteDAO();
         $xIntegrante = new Integrante();
         $xIntId = $xIntegranteDao->getIdPorMatrUa($xIntMatr, $xUa);
         
         $xJson = array();

         $xIntegrante = $xIntegranteDao->load($xIntId);

         if ( $xIntegrante != null )
         {
            $xUa = new Ua();
            $xUaDao = new UaDAO();

            $xUa = $xUaDao->load( $xIntegrante->uaId );

            $xJson[ "matricula" ] = $xIntegrante->matricula;
            $xJson[ "ua" ] = ($xUa->id . '=' . $xUa->uaAlias . '-' . $xUa->descricao);
            $xJson[ "nome" ] = $xIntegrante->nome;
            $xJson[ "cpf" ] = Funcoes::formataCpf( Funcoes::pad( $xIntegrante->cpf, 11, '0', '<' ) );
            $xJson[ "dtAdmissao" ] = Funcoes::formataDtView( $xIntegrante->dtAdmissaoFoz );
            $xJson[ "cargo" ] = $xIntegrante->cargo;
            $xJson[ "liderNome" ] = $xIntegrante->liderNome;
            $xJson[ "perfil" ] = $xIntegrante->perfilId;

            echo( json_encode( $xJson ) );
            return;
         }
         else{
            $xJson[ "ua" ] = '';
            $xJson[ "nome" ] = '';
            $xJson[ "cpf" ] = '';
            $xJson[ "dtAdmissao" ] = '';
            $xJson[ "cargo" ] = '';
            $xJson[ "liderNome" ] = '';
            $xJson[ "perfil" ] = '';
            echo( json_encode( $xJson ) );
            return;
         }
         
      }
   case 'gridIntegrantes':
      {
         $xIntegrantesDao = new IntegranteDAO();
         $xUaFrm = Funcoes::noInjection( Funcoes::getSubstring( $_GET['ua'] , '=', '<')  );
         $xNome = Funcoes::noInjection( $_GET['nome'] );
         
         $xListaIntegrantes = $xIntegrantesDao->queryAllByMatrUaNome($xUaFrm, $xNome);

         $tabela = "{ \"aaData\": [ ";

         for ( $i = 0; $i < count( $xListaIntegrantes ); $i++ )
         {
            $xInt = new Integrante();
            $xInt = $xListaIntegrantes[ $i ];
            
            $xUaDao = new UaDAO();
            $xUa = new Ua();
            $xUa = $xUaDao->load( $xInt->uaId );

            if ( $i == 0 )
            {
               $tabela .= "[";
                  $tabela .= Funcoes::aspasDuplas($xInt->id). ",";
                  $tabela .= Funcoes::aspasDuplas( utf8_encode( $xInt->matricula ) ) . ",";
                  $tabela .= Funcoes::aspasDuplas( utf8_encode( ($xUa->id . '=' . $xUa->uaAlias . '-' . $xUa->descricao) ) ) . ",";
                  $tabela .= Funcoes::aspasDuplas( utf8_encode( $xInt->nome ) ). ",";
                  $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::formataCpf( Funcoes::pad($xInt->cpf, 11, '0', '<') ) ) ). ",";
                  $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::formataDtView( $xInt->dtAdmissaoFoz ) ) ). ",";
                  $tabela .= Funcoes::aspasDuplas( utf8_encode( $xInt->cargo ) ). ",";
                  $tabela .= Funcoes::aspasDuplas( utf8_encode( $xInt->liderNome ) ). ",";                  
                  $tabela .= Funcoes::aspasDuplas( utf8_encode( $xInt->perfilId ) );
               $tabela .= "]";
               continue;
            }
            $tabela .= ",[";
                  $tabela .= Funcoes::aspasDuplas( $xInt->id ). ",";
                  $tabela .= Funcoes::aspasDuplas( utf8_encode( $xInt->matricula ) ) . ",";
                  $tabela .= Funcoes::aspasDuplas( utf8_encode( ($xUa->id . '=' . $xUa->uaAlias . '-' . $xUa->descricao) ) ) . ",";
                  $tabela .= Funcoes::aspasDuplas( utf8_encode( $xInt->nome ) ). ",";
                  $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::formataCpf( Funcoes::pad($xInt->cpf, 11, '0', '<') ) ) ). ",";
                  $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::formataDtView( $xInt->dtAdmissaoFoz ) ) ). ",";
                  $tabela .= Funcoes::aspasDuplas( utf8_encode( $xInt->cargo ) ). ",";
                  $tabela .= Funcoes::aspasDuplas( utf8_encode( $xInt->liderNome ) ). ",";                  
                  $tabela .= Funcoes::aspasDuplas( utf8_encode( $xInt->perfilId ) );
            $tabela .= "]";
            continue;
         }

         $tabela .=" ] }";

         echo($tabela);
         return;
      } 
   case 'inserirInt':
      {
         $xInt = new Integrante();
         $xIntDao = new IntegranteDAO();

         $xInt->matricula = Funcoes::noInjection( $_POST['intMatricula'] );
         $xInt->uaId = Funcoes::noInjection( Funcoes::getSubstring($_POST['intUa'], '=', '<') );
         $xInt->nome = Funcoes::noInjection( $_POST['intNome'] );
		 $xInt->nome = utf8_decode($xInt->nome);
         $xInt->perfilId = Funcoes::noInjection( $_POST['intPerfil'] );
         $xInt->cpf = Funcoes::noInjection( Funcoes::retirarMascara( $_POST['intCpf'] ) );
         $xInt->dtAdmissaoFoz = Funcoes::noInjection( Funcoes::formataDtDB( $_POST['intDtAdmissao'] ) );
         $xInt->cargo = Funcoes::noInjection( $_POST['intCargo'] );
         $xInt->liderNome = Funcoes::noInjection( $_POST['intLider'] );


         $flagInt = new Integrante();
         $flagInt = $xIntDao->existeMatricula($xInt->matricula, $xInt->uaId);

		 if (! Funcoes::isNuloVazioNaoSetado($flagInt)) {
			 //verifica se já existe o integrante cadastrado
			 if ( $flagInt->matricula > 0 )
			 {
				echo("OP:INSERT.Matrícula <b>$flagInt->matricula</b> já cadastrada para o integrante: ".$flagInt->nome);
				return;
			 }
		 }

         $flag = $xIntDao->insert( $xInt );

         if ( $flag )
         {
            echo('OK');
         }
         else
         {
            echo("Erro ao inserir o integrante");
         }

         return;
      }
   case 'editarInt':
      {
         $xInt = new Integrante();
         $xIntDao = new IntegranteDAO();

         $xInt->id = Funcoes::noInjection( $_POST['intId'] );
         $xInt->matricula = Funcoes::noInjection( $_POST['intMatricula'] );
         $xInt->uaId = Funcoes::noInjection( Funcoes::getSubstring($_POST['intUa'], '=', '<') );
         $xInt->nome = Funcoes::noInjection( $_POST['intNome'] );
         $xInt->perfilId = Funcoes::noInjection( $_POST['intPerfil'] );
         $xInt->cpf = Funcoes::noInjection( Funcoes::retirarMascara( $_POST['intCpf'] ) );
         $xInt->dtAdmissaoFoz = Funcoes::noInjection( Funcoes::formataDtDB( $_POST['intDtAdmissao'] ) );
         $xInt->cargo = Funcoes::noInjection( $_POST['intCargo'] );
         $xInt->liderNome = Funcoes::noInjection( $_POST['intLider'] );
         
         //verifica se já existe o integrante cadastrado
         if ( $xInt->id == null )
         {
            echo("Integrante <b>$xInt->matricula</b> não cadastrada.");
            return;
         }
         
         $xIntFlag1 = new Integrante();
         $xIntFlag2 = new Integrante();
         
         $xIntFlag1 = $xIntDao->load($xInt->id);
         $xIntFlag2 = $xIntDao->existeMatricula($xInt->matricula, $xInt->uaId);
         
         
         if( $xIntFlag1->matricula != $xIntFlag2->matricula ){
            
            if( $xIntFlag2->matricula != null ){
               echo("OP: UPDATE. Matrícula <b>$xIntFlag2->matricula</b> já cadastrada para o integrante: ".$xIntFlag2->nome);
               return;
            }                        
         }
         

         $flag = $xIntDao->update($xInt);

         if ( $flag )
         {
            echo('OK');
         }
         else
         {
            echo("Erro ao editar o integrante");
         }

         return;
      }
   case 'excluirInt':
   {
      $xIntDao = new IntegranteDAO();

      $xMatricula = Funcoes::noInjection( $_GET['matr'] );
      $xUa = Funcoes::noInjection( Funcoes::getSubstring($_GET['ua'], '=', '<') );

      $flagMatr = new Integrante();
      $flagMatr = $xIntDao->load($xMatricula, $xUa);

      //verifica se já existe o integrante cadastrado
      if ( $flagMatr == null )
      {
         echo("Matrícula <b>$xMatricula</b> não cadastrada");
         return;
      }

      $flag = $xIntDao->delete($xMatricula, $xUa);

      if ( $flag )
      {
         echo('OK');
      }
      else
      {
         echo("Erro ao excluir o integrante");
      }

      return;
   }

   default:
      {
         echo 'Evento ' . $evento . ' não válido.';
         return;
      }
}
?>