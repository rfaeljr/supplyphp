<?php

ini_set( 'display_errors', 'on' );

require_once('includes.php');


$evento = Funcoes::noInjection( $_GET[ 'evento' ] );

switch ( $evento )
{
   //autocomplete   
   case 'autoCompleteMateriais':
      {
         $linhaMaterial = array();
         $arrayMaterial = array();
         $listaMateriais = null;
         $material = null;
         $materialDao = new MaterialDAO();

         $xGrp = Funcoes::noInjection( $_GET[ 'grp' ] );
         $descr = Funcoes::noInjection( $_GET[ 'term' ] );

         $listaMateriais = $materialDao->listarMateriais( $xGrp, $descr );

         for ( $i = 0; $i < count( $listaMateriais ); $i++ )
         {
            $material = new Material();
            $material = $listaMateriais[ $i ];

            $linhaMaterial[ "id" ] = utf8_encode( $material->grupo . '+' . $material->codigo );
            $linhaMaterial[ "value" ] = utf8_encode( $material->grupo . '+' . $material->codigo . '=' . $material->descricao . '(' . $material->unidade . ')' );
            $linhaMaterial[ "label" ] = utf8_encode( $material->grupo . '+' . $material->codigo . '=' . $material->descricao . '(' . $material->unidade . ')' );
            $linhaMaterial[ "preco" ] = $material->precoMedio;
            array_push( $arrayMaterial, $linhaMaterial );
         }


         $json = json_encode( $arrayMaterial );
         echo $json;
         return;
      }
   case 'autoCompleteIntegrante':
      {
         $linhaIntegrante = array();
         $arrayIntegrante = array();
         $listaIntegrantes = null;
         $integrante = null;
         $integranteDao = new integranteDAO();
         $parametro = Funcoes::noInjection( $_GET[ 'term' ] );

         $listaIntegrantes = $integranteDao->listarIntegrantes( $parametro );

         for ( $i = 0; $i < count( $listaIntegrantes ); $i++ )
         {
            $integrante = new Integrante();
            $integrante = $listaIntegrantes[ $i ];

            $linhaIntegrante[ "id" ] = utf8_encode( $integrante->id );
            $linhaIntegrante[ "value" ] = utf8_encode( $integrante->matricula );
            $linhaIntegrante[ "label" ] = utf8_encode( $integrante->matricula . '=' . $integrante->nome );

            array_push( $arrayIntegrante, $linhaIntegrante );
         }


         $json = json_encode( $arrayIntegrante );
         echo $json;
         return;
      }
   case 'autoCompleteUa':
      {
         $linhaUa = array();
         $arrayUa = array();
         $listaUas = null;
         $ua = null;
         $uaDao = new UaDAO();
         $parametro = Funcoes::noInjection( $_GET[ 'term' ] );

         $listaUas = $uaDao->listarUas( $parametro );

         for ( $i = 0; $i < count( $listaUas ); $i++ )
         {
            $ua = new Ua();
            $ue = new Ue();
            $ueDao = new UeDAO();
            $ua = $listaUas[ $i ];

            $ue = $ueDao->load( $ua->ueId );

            $linhaUa[ "id" ] = utf8_encode( $ua->id );
            $linhaUa[ "value" ] = utf8_encode( $ua->id . '=' . $ua->uaAlias . '-' . $ua->descricao );
            $linhaUa[ "label" ] = utf8_encode( $ua->id . '=' . $ue->descricao . '.' . $ua->uaAlias . '-' . $ua->descricao );

            array_push( $arrayUa, $linhaUa );
         }


         $json = json_encode( $arrayUa );
         echo $json;
         return;
      }

   case 'alterarStatusNm':
      {
         $nmId = Funcoes::noInjection( $_GET[ 'nmId' ] );
         $status = Funcoes::noInjection( $_GET[ 'status' ] );

         $usuario = new Usuario();
         $nm = new NotaMov();
         $nmDao = new NotaMovDAO();
         $nm = $nmDao->load( $nmId );

         $usuario = Funcoes::getUsuario();
         $dtHora = Funcoes::getDtHoraDB();


         //Usuário comum não pode alterar o Status da Nm
         if ( $usuario->perfilPermissao == 'COMUM' )
         {
            echo('Usuário com perfil COMUM não pode alterar o Status de Nota de Movimentação.');
            return;
         }


         //Nm com Status de Cancelada apenas o ADM pode alterar o Status
         if ( ($nm->status == 'C') && ($usuario->perfilPermissao != 'ADM') )
         {
            echo('Nota de movimentação, encontra-se C=Cancelada.<br/> Apenas o Administrador do Sistema pode alterá-la.');
            return;
         }

         $nmDao->alterarStatus( $nmId, $status, $dtHora, $usuario->integranteId );
         echo('OK');
         return;
      }

   case 'gridNm':
      {
         $xNm = Funcoes::noInjection( $_GET[ 'nm' ] );
         $xDtSolicitacao = Funcoes::noInjection( $_GET[ 'dt' ] );
         $xNf = Funcoes::noInjection( $_GET[ 'nf' ] );
         $xSe = Funcoes::noInjection( $_GET[ 'se' ] );
         $xListaNat = $_GET[ 'listaNat' ];
         $xListaStatus = $_GET[ 'listaStatus' ];


         $notaMovDao = new NotaMovDAO();
         $integranteDao = new IntegranteDAO();

         $resultado = $notaMovDao->listaNotaMov( $xNm, $xNf, $xSe, $xDtSolicitacao, $xListaNat, $xListaStatus );

         $tabela = "{ \"aaData\": [ ";

         for ( $i = 0; $i < count( $resultado ); $i++ )
         {

            if ( $i == 0 )
            {
               $tabela .= "[";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'notafiscal_num' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::formataDtView( $resultado[ $i ][ 'notafiscal_dtlancamento' ] ) ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'se_num' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::formataDtHoraView( $resultado[ $i ][ 'dthora_solicitacao' ] ) ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::formataDtHoraView( $resultado[ $i ][ 'dthora_entrega' ] ) ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $integranteDao->getMatrNomePorId( $resultado[ $i ][ 'solicitado_por_id' ] ) ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( Funcoes::getStatusNm( $resultado[ $i ][ 'status' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'natureza' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'ua_origem_id' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'ua_destino_id' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'valor_total' ] ) );
               $tabela .= "]";
               continue;
            }
            $tabela .= ",[";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'notafiscal_num' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::formataDtView( $resultado[ $i ][ 'notafiscal_dtlancamento' ] ) ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'se_num' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::formataDtHoraView( $resultado[ $i ][ 'dthora_solicitacao' ] ) ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::formataDtHoraView( $resultado[ $i ][ 'dthora_entrega' ] ) ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $integranteDao->getMatrNomePorId( $resultado[ $i ][ 'solicitado_por_id' ] ) ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( Funcoes::getStatusNm( $resultado[ $i ][ 'status' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'natureza' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'ua_origem_id' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'ua_destino_id' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'valor_total' ] ) );
            $tabela .= "]";
            continue;
         }

         $tabela .=" ] }";

         echo( Funcoes::normalizar( $tabela ) );
         return;
      }
   case 'gridNm40':
      {
         $notaMovDao = new NotaMovDAO();
         $integranteDao = new IntegranteDAO();

         $resultado = $notaMovDao->listaNotaMov40();


         $tabela = "{ \"aaData\": [ ";

         for ( $i = 0; $i < count( $resultado ); $i++ )
         {

            if ( $i == 0 )
            {
               $tabela .= "[";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'notafiscal_num' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::formataDtView( $resultado[ $i ][ 'notafiscal_dtlancamento' ] ) ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'se_num' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::formataDtHoraView( $resultado[ $i ][ 'dthora_solicitacao' ] ) ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::formataDtHoraView( $resultado[ $i ][ 'dthora_entrega' ] ) ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $integranteDao->getMatrNomePorId( $resultado[ $i ][ 'solicitado_por_id' ] ) ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( Funcoes::getStatusNm( $resultado[ $i ][ 'status' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'natureza' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'ua_origem_id' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'ua_destino_id' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( trim( utf8_encode( $resultado[ $i ][ 'valor_total' ] ) ) );
               $tabela .= "]";
               continue;
            }
            $tabela .= ",[";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'notafiscal_num' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::formataDtView( $resultado[ $i ][ 'notafiscal_dtlancamento' ] ) ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'se_num' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::formataDtHoraView( $resultado[ $i ][ 'dthora_solicitacao' ] ) ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::formataDtHoraView( $resultado[ $i ][ 'dthora_entrega' ] ) ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $integranteDao->getMatrNomePorId( $resultado[ $i ][ 'solicitado_por_id' ] ) ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( Funcoes::getStatusNm( $resultado[ $i ][ 'status' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'natureza' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'ua_origem_id' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'ua_destino_id' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( trim( utf8_encode( $resultado[ $i ][ 'valor_total' ] ) ) );
            $tabela .= "]";
            continue;
         }

         $tabela .=" ] }";

         echo( Funcoes::normalizar( $tabela ) );
         return;
      }
   case 'carregarFormNm':
      {
         $nmId = Funcoes::noInjection( $_GET[ 'nmId' ] );

         $notaMov = new NotaMov();
         $notaMovDao = new NotaMovDAO();
         $transporte = new Transporte();
         $transporteDao = new TransporteDAO();
         $integranteDao = new IntegranteDAO();
         $uaOrigem = new Ua();
         $uaDestino = new Ua();
         $uaDao = new UaDAO();
         $nmJson = array();

         $notaMov = $notaMovDao->load( $nmId );
         $transporte = $transporteDao->transporteByNmmId( $nmId );
         $uaOrigem = $uaDao->load( $notaMov->uaOrigemId );
         $uaDestino = $uaDao->load( $notaMov->uaDestinoId );


         $nmJson[ "id" ] = $notaMov->id;
         $nmJson[ "notafiscal_num" ] = $notaMov->notafiscalNum;
         $nmJson[ "notafiscal_dtlancamento" ] = Funcoes::formataDtView( $notaMov->notafiscalDtLancamento );
         $nmJson[ "se_num" ] = $notaMov->seNum;
         $nmJson[ "uaOrigem" ] = ($uaOrigem->id . '=' . $uaOrigem->uaAlias . '-' . utf8_encode( $uaOrigem->descricao ));
         $nmJson[ "uaDestino" ] = ($uaDestino->id . '=' . $uaDestino->uaAlias . '-' . utf8_encode( $uaDestino->descricao ));

         //requisição
         $nmJson[ "reqPorId" ] = $notaMov->requisitadoPorId;
         $nmJson[ "reqMatricula" ] = $integranteDao->getMatrPorId( $notaMov->requisitadoPorId );
         $nmJson[ "reqNome" ] = utf8_encode( $integranteDao->getNomePorId( $notaMov->requisitadoPorId ) );
         $nmJson[ "reqDtHora" ] = Funcoes::formataDtHoraView( $notaMov->dthoraSolicitacao );
         //autorizacao
         $nmJson[ "autPorId" ] = $notaMov->autorizadoPorId;
         $nmJson[ "autMatricula" ] = $integranteDao->getMatrPorId( $notaMov->autorizadoPorId );
         $nmJson[ "autNome" ] = ($notaMov->autorizadoPorId == null ? '' : utf8_encode( $integranteDao->getNomePorId( $notaMov->autorizadoPorId ) ) );
         $nmJson[ "autDtHora" ] = Funcoes::formataDtHoraView( $notaMov->dthoraAutorizacao );
         //entrega
         $nmJson[ "entMatricula" ] = utf8_encode( $notaMov->entreguePorId );
         $nmJson[ "entNome" ] = utf8_encode( $notaMov->entreguePorNome );
         $nmJson[ "entDtHora" ] = Funcoes::formataDtHoraView( $notaMov->dthoraEntrega );
         //recebido
         $nmJson[ "recebPorId" ] = $notaMov->recebidoPorId;
         $nmJson[ "recebNome" ] = utf8_encode( $notaMov->recebidoPorNome );
         $nmJson[ "recebDtHora" ] = Funcoes::formataDtHoraView( $notaMov->dthoraRecebido );

         $nmJson[ "responsavelId" ] = $notaMov->responsavelId;

         $nmJson[ "status" ] = $notaMov->status;
         $nmJson[ "fonteRecurso" ] = $notaMov->fonteRecurso;
         $nmJson[ "natureza" ] = $notaMov->natureza;
         $nmJson[ "sistema" ] = $notaMov->sistema;

         $nmJson[ "informacoesComplementares" ] = utf8_encode( $notaMov->informacoesComplementares );

         $nmJson[ "insercaoId" ] = $notaMov->insercaoId;
         $nmJson[ "dthoraInsercao" ] = $notaMov->dthoraInsercao;

         $nmJson[ "dthoraAlteracao" ] = $notaMov->dthoraAlteracao;
         $nmJson[ "alteracaoId" ] = $notaMov->alteracaoId;


         if ( $transporte != null )
         {
            $nmJson[ "transportadora" ] = utf8_encode( $transporte->transportadora );
            $nmJson[ "nrViatura" ] = utf8_encode( $transporte->nrViatura );
            $nmJson[ "nrPlaca" ] = utf8_encode( $transporte->nrPlaca );
            $nmJson[ "endereco" ] = utf8_encode( $transporte->endereco );
            $nmJson[ "motorista" ] = utf8_encode( $transporte->motorista );
            $nmJson[ "localEntrega" ] = utf8_encode( $transporte->localEntrega );
         }
         else
         {
            $nmJson[ "transportadora" ] = '';
            $nmJson[ "nrViatura" ] = '';
            $nmJson[ "nrPlaca" ] = '';
            $nmJson[ "endereco" ] = '';
            $nmJson[ "motorista" ] = '';
            $nmJson[ "localEntrega" ] = '';
         }





         echo( json_encode( $nmJson ) );
         return;
      }
   case 'salvarNm':
      {
         $notaMov = new NotaMov();
         $notaMovDao = new NotaMovDAO();
         $usuario = new Usuario();
         $usuario = Funcoes::getUsuario();

         $opcao = Funcoes::noInjection( $_GET[ 'opcao' ] );


         //inserir
         if ( $opcao == 'inserirNm' )
         {
            $notaMov->notafiscalNum = $_POST[ 'notaMaterialNf' ];
            $notaMov->notafiscalDtLancamento = Funcoes::formataDtDB($_POST[ 'notaMaterialNfDtLanc' ]);
            $notaMov->seNum = $_POST[ 'notaMaterialSe' ];
            $notaMov->uaOrigemId = Funcoes::getSubstring( $_POST[ 'uaOrigem' ], '=', '<' );
            $notaMov->uaDestinoId = Funcoes::getSubstring( $_POST[ 'uaDestino' ], '=', '<' );
            $notaMov->requisitadoPorId = $_POST[ 'solicitadoPorId' ];
            $notaMov->responsavelId = null;
            $notaMov->autorizadoPorId = $_POST[ 'autorizadoPorId' ];
            $xStatus = Funcoes::getSubstring( $_POST[ 'status' ], '=', '<' );
            $notaMov->status = ( Funcoes::isNuloVazioNaoSetado( $xStatus ) == true ? 'S' : $xStatus );
            $notaMov->fonteRecurso = $_POST[ 'fonteRecurso' ];
            $notaMov->natureza = $_POST[ 'natureza' ];
            $notaMov->sistema = $_POST[ 'sistema' ];
            $notaMov->dthoraSolicitacao = Funcoes::formataDtHoraDB( $_POST[ 'requisicaoData' ] );
            $notaMov->dthoraAutorizacao = Funcoes::formataDtHoraDB( $_POST[ 'autorizacaoData' ] );
            $notaMov->dthoraEntrega = Funcoes::formataDtHoraDB( $_POST[ 'entregaData' ] );
            $notaMov->dthoraRecebido = Funcoes::formataDtHoraDB( $_POST[ 'recebidoData' ] );
            $notaMov->recebidoPorNome = utf8_decode( $_POST[ 'recebidoNome' ] );
            $notaMov->recebidoPorId = $_POST[ 'recebidoMatricula' ];

            $notaMov->entreguePorNome = utf8_decode( $_POST[ 'entregaNome' ] );
            $notaMov->entreguePorId = $_POST[ 'entregaMatricula' ];

            $notaMov->informacoesComplementares = utf8_decode( $_POST[ 'infoComplementar' ] );

            $notaMov->insercaoId = $usuario->integranteId;
            $notaMov->dthoraInsercao = Funcoes::getDtHoraDB();
            $notaMov->dthoraAlteracao = $notaMov->dthoraInsercao;
            $notaMov->alteracaoId = $notaMov->insercaoId;


            //dados do transporte
            $transporte = new Transporte();
            $transporte->transportadora = utf8_decode( $_POST[ "transportadora" ] );
            $transporte->nrViatura = utf8_decode( $_POST[ "transpViatura" ] );
            $transporte->nrPlaca = utf8_decode( $_POST[ "transpPlaca" ] );
            $transporte->endereco = utf8_decode( $_POST[ "transpEndereco" ] );
            $transporte->motorista = utf8_decode( $_POST[ "transpMotorista" ] );
            $transporte->localEntrega = utf8_decode( $_POST[ "transpLocalEntrega" ] );

            $nmId = $notaMovDao->insert( $notaMov, $transporte );

            if ( $nmId > 0 )
            {
               echo('OK-' . $nmId);
            }
            else
            {
               echo('Erro ao editar nota de material.');
            }

            return;
         }

         if ( $opcao == "editarNm" )
         {
            $notaMov->id = $_POST[ 'notaMaterialId' ];

            $nm = new NotaMov();
            $nm = $notaMovDao->load( $notaMov->id );

            //Usuário com perfil comum e status da NM diferente de S=Solicitada
            if ( ($nm->status != 'S') && ($usuario->perfilPermissao == 'COMUM') )
            {
               echo('Nota de movimentação com status diferente de S=Solicitada,<br/> somente usuário com perfil de SUPRIMENTO OU ADM podem alterar a NM.');
               return;
            }

            //Nm com Status de Cancelada apenas o ADM pode alterar o Status
            if ( ($nm->status == 'C') && ($usuario->perfilPermissao != 'ADM') )
            {
               echo('Nota de movimentação, encontra-se C=Cancelada.<br/> Apenas o Administrador do Sistema pode alterá-la.');
               return;
            }

            if ( !$notaMovDao->existeNm( $notaMov->id ) )
            {
               echo('Número da Nota de Material inexistente.');
               return;
            }

            $notaMov->notafiscalNum = $_POST[ 'notaMaterialNf' ];
            $notaMov->notafiscalDtLancamento = Funcoes::formataDtDB($_POST[ 'notaMaterialNfDtLanc' ]);
            $notaMov->seNum = $_POST[ 'notaMaterialSe' ];
            $notaMov->uaOrigemId = Funcoes::getSubstring( $_POST[ 'uaOrigem' ], '=', '<' );
            $notaMov->uaDestinoId = Funcoes::getSubstring( $_POST[ 'uaDestino' ], '=', '<' );
            $notaMov->requisitadoPorId = $_POST[ 'solicitadoPorId' ];
            $notaMov->responsavelId = null;
            $notaMov->autorizadoPorId = $_POST[ 'autorizadoPorId' ];
            $notaMov->status = Funcoes::getSubstring( $_POST[ 'status' ], '=', '<' );
            $notaMov->fonteRecurso = $_POST[ 'fonteRecurso' ];
            $notaMov->natureza = $_POST[ 'natureza' ];
            $notaMov->sistema = $_POST[ 'sistema' ];

            $notaMov->dthoraSolicitacao = Funcoes::formataDtHoraDB( $_POST[ 'requisicaoData' ] );

            $notaMov->dthoraAutorizacao = Funcoes::formataDtHoraDB( $_POST[ 'autorizacaoData' ] );
            $notaMov->dthoraEntrega = Funcoes::formataDtHoraDB( $_POST[ 'entregaData' ] );
            $notaMov->dthoraRecebido = Funcoes::formataDtHoraDB( $_POST[ 'recebidoData' ] );
            $notaMov->recebidoPorNome = utf8_decode( $_POST[ 'recebidoNome' ] );
            $notaMov->recebidoPorId = $_POST[ 'recebidoMatricula' ];

            $notaMov->entreguePorNome = utf8_decode( $_POST[ 'entregaNome' ] );
            $notaMov->entreguePorId = $_POST[ 'entregaMatricula' ];

            $notaMov->informacoesComplementares = utf8_decode( $_POST[ 'infoComplementar' ] );

            $notaMov->dthoraAlteracao = Funcoes::getDtHoraDB();
            $notaMov->alteracaoId = $usuario->integranteId;


            //dados do transporte
            $transporte = new Transporte();
            $transporte->transportadora = utf8_decode( $_POST[ "transportadora" ] );
            $transporte->nrViatura = utf8_decode( $_POST[ "transpViatura" ] );
            $transporte->nrPlaca = utf8_decode( $_POST[ "transpPlaca" ] );
            $transporte->endereco = utf8_decode( $_POST[ "transpEndereco" ] );
            $transporte->motorista = utf8_decode( $_POST[ "transpMotorista" ] );
            $transporte->localEntrega = utf8_decode( $_POST[ "transpLocalEntrega" ] );


            $notaMovDao->update( $notaMov, $transporte );

            echo('OK');
            return;
         }

         return;
      }
   case 'excluirNm':
      {
         $notaMovDao = new NotaMovDAO();
         $usuario = new Usuario();
         $usuario = Funcoes::getUsuario();

         if ( $usuario == null )
         {
            echo('Usuário não autenticado. ' . '<a src=../home.php>login</a>');
            return;
         }

         //dados do formulário         
         $nmId = Funcoes::noInjection( $_GET[ 'nmId' ] );
         $notaMovDao->alterarStatus( $nmId, 'C', Funcoes::getDtHoraDB(), $usuario->integranteId );

         //$notaMovDao->delete( $nmId );
         echo('OK');
         return;
      }


   case 'gridMateriais':
      {
         $nmId = Funcoes::noInjection( $_GET[ 'nmId' ] );

         $notaMovMatDao = new NotaMovMatDAO();
         $materialDao = new MaterialDAO();
         $material = new Material();

         $materiasDaNota = $notaMovMatDao->listaMateriasDaNota( $nmId );

         $tabela = "{ \"aaData\": [ ";

         for ( $i = 0; $i < count( $materiasDaNota ); $i++ )
         {
            $material = $materialDao->load( $materiasDaNota[ $i ]->materialId );

            if ( $i == 0 )
            {
               $tabela .= "[";
               $tabela .= Funcoes::aspasDuplas( $materiasDaNota[ $i ]->sequencia ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::pad( $material->grupo, 3, '0', '<' ) . '+' . $material->codigo ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( str_replace( '"', '', $material->descricao ) ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( Funcoes::formataDtHoraView( utf8_encode( $materiasDaNota[ $i ]->dthoraInsercao ) ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $material->unidade ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $materiasDaNota[ $i ]->quantSolicitada ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $materiasDaNota[ $i ]->quantFornecida ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $materiasDaNota[ $i ]->vlrUnitario ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $materiasDaNota[ $i ]->quantFornecida * $materiasDaNota[ $i ]->vlrUnitario ) );
               $tabela .= "]";
               continue;
            }
            $tabela .= ",[";
            $tabela .= Funcoes::aspasDuplas( $materiasDaNota[ $i ]->sequencia ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( Funcoes::pad( $material->grupo, 3, '0', '<' ) . '+' . $material->codigo ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( str_replace( '"', '', $material->descricao ) ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( Funcoes::formataDtHoraView( utf8_encode( $materiasDaNota[ $i ]->dthoraInsercao ) ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $material->unidade ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $materiasDaNota[ $i ]->quantSolicitada ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $materiasDaNota[ $i ]->quantFornecida ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $materiasDaNota[ $i ]->vlrUnitario ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $materiasDaNota[ $i ]->quantFornecida * $materiasDaNota[ $i ]->vlrUnitario ) );
            $tabela .= "]";
         }

         $tabela .=" ] }";

         echo( Funcoes::normalizar( $tabela ) );
         return;
      }
   case 'salvarProdutoNm':
      {

         $notaMovMat = new NotaMovMat();
         $notaMovMatDao = new NotaMovMatDAO();
         $usuario = new Usuario();
         $usuario = Funcoes::getUsuario();

         if ( $usuario == null )
         {
            echo('Usuário não autenticado. ' . '<a src=../home.php>login</a>');
            return;
         }

         $nm = new NotaMov();
         $nmDao = new NotaMovDAO();
         $nm = $nmDao->load( $_POST[ 'prdNrNota' ] );

         //Usuário com perfil comum e status da NM diferente de S=Solicitada
         if ( ($nm->status != 'S') && ($usuario->perfilPermissao == 'COMUM') )
         {
            echo('Nota de movimentação com status diferente de S=Solicitada,<br/> somente usuário com perfil de SUPRIMENTO OU ADM podem alterar a NM.');
            return;
         }

         //Nm com Status de Cancelada apenas o ADM pode alterar o Status
         if ( ($nm->status == 'C') && ($usuario->perfilPermissao != 'ADM') )
         {
            echo('Nota de movimentação, encontra-se C=Cancelada.<br/> Apenas o Administrador do Sistema pode alterá-la.');
            return;
         }

         //dados do formulário         
         $prdAcao = $_POST[ 'prdAcao' ];
         $notaMovMat->notaMovId = Funcoes::noInjection( $_POST[ 'prdNrNota' ] );
         $notaMovMat->materialId = Funcoes::noInjection( Funcoes::getSubstring( $_POST[ 'prdMaterialId' ], '=', '<' ) );
         $notaMovMat->sequencia = Funcoes::noInjection( $_POST[ 'prdSequencia' ] );
         $notaMovMat->quantSolicitada = Funcoes::noInjection( $_POST[ 'prdQtdSolicitada' ] );
         $notaMovMat->quantFornecida = Funcoes::noInjection( $_POST[ 'prdQtdFornecida' ] );
         $notaMovMat->vlrUnitario = Funcoes::noInjection( $_POST[ 'prdVlrUnitario' ] );
         $notaMovMat->insercaoId = $usuario->integranteId;
         $notaMovMat->alteracaoId = $usuario->integranteId;
         $notaMovMat->dthoraInsercao = Funcoes::getDtHoraDB();
         $notaMovMat->dthoraAlteracao = Funcoes::getDtHoraDB();


         switch ( $prdAcao )
         {
            case 'INSERIR':
               {
                  if ( $notaMovMatDao->insert( $notaMovMat ) > 0 )
                  {
                     $notaMov = new NotaMov();
                     $notaMovDao = new NotaMovDAO();

                     $integranteId = $notaMovMat->alteracaoId;
                     $notaMov = $notaMovDao->load( $notaMovMat->notaMovId );
                     $status = ($notaMov->status == 'A' ? 'S' : $notaMov->status);

                     $notaMovDao->alterarStatus( $notaMov->id, $status, $notaMovMat->dthoraInsercao, $integranteId );

                     echo('OK');
                     return;
                  }
                  else
                  {
                     echo('Falha na inserção do registro.');
                     return;
                  }
               }
            case 'EDITAR':
               {
                  if ( $notaMovMatDao->update( $notaMovMat ) > 0 )
                  {
                     $notaMov = new NotaMov();
                     $notaMovDao = new NotaMovDAO();

                     $notaMov = $notaMovDao->load( $notaMovMat->notaMovId );
                     $status = ($notaMov->status == 'A' ? 'S' : $notaMov->status);

                     $notaMovDao->alterarStatus( $notaMov->id, $status, $notaMovMat->dthoraAlteracao, $notaMovMat->alteracaoId );

                     echo('OK');
                     return;
                  }
                  else
                  {
                     echo('Falha na atualização do registro.');
                     return;
                  }
               }
            default:
               {
                  echo 'Ação não válida.';
                  return;
               }
         }
      }
   case 'excluirProdutoNm':
      {
         $notaMovMatDao = new NotaMovMatDAO();
         $usuario = new Usuario();
         $usuario = Funcoes::getUsuario();

         if ( $usuario == null )
         {
            echo('Usuário não autenticado. ' . '<a src=../home.php>login</a>');
            return;
         }

         $nm = new NotaMov();
         $nmDao = new NotaMovDAO();
         $nm = $nmDao->load( $_GET[ 'nmId' ] );

         //Usuário com perfil comum e status da NM diferente de S=Solicitada
         if ( ($nm->status != 'S') && ($usuario->perfilPermissao == 'COMUM') )
         {
            echo('Nota de movimentação com status diferente de S=Solicitada,<br/> somente usuário com perfil de SUPRIMENTO OU ADM podem alterar a NM.');
            return;
         }

         //Nm com Status de Cancelada apenas o ADM pode alterar o Status
         if ( ($nm->status == 'C') && ($usuario->perfilPermissao != 'ADM') )
         {
            echo('Nota de movimentação, encontra-se C=Cancelada.<br/> Apenas o Administrador do Sistema pode alterá-la.');
            return;
         }

         //dados do formulário         
         $nmId = Funcoes::noInjection( $_GET[ 'nmId' ] );
         $matId = Funcoes::noInjection( $_GET[ 'matId' ] );
         $seq = Funcoes::noInjection( $_GET[ 'seq' ] );

         $notaMovMatDao->delete( $seq, $matId, $nmId );

         $notaMov = new NotaMov();
         $notaMovDao = new NotaMovDAO();

         $notaMov = $notaMovDao->load( $nmId );
         $status = ($notaMov->status == 'A' ? 'S' : $notaMov->status);
         $notaMovDao->alterarStatus( $nmId, $status, Funcoes::getDtHoraDB(), $usuario->integranteId );

         echo('OK');
         return;
      }
   case 'nmPossuiProduto':
      {
         $nmId = Funcoes::noInjection( $_GET[ 'nmId' ] );
         $notaMovMatDao = new NotaMovMatDAO();

         if ( $notaMovMatDao->existeMaterialParaNm( $nmId ) == true )
         {
            echo('SIM');
            return;
         }
         echo('NAO');
         return;
      }

   case 'gridInfoMercadoria':
      {
         $nmId = Funcoes::noInjection( $_GET[ 'nmId' ] );

         $infoMercadoriaDao = new InfoMercadoriaDAO();
         $resultado = $infoMercadoriaDao->listaInfoMercadoria( $nmId );


         $tabela = "{ \"aaData\": [ ";

         for ( $i = 0; $i < count( $resultado ); $i++ )
         {

            if ( $i == 0 )
            {
               $tabela .= "[";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'especie' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'valor' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'embalagem' ] ) ) . ",";
               $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'quantidade' ] ) );
               $tabela .= "]";
               continue;
            }
            $tabela .= ",[";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'id' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'especie' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'valor' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'embalagem' ] ) ) . ",";
            $tabela .= Funcoes::aspasDuplas( utf8_encode( $resultado[ $i ][ 'quantidade' ] ) );
            $tabela .= "]";
            continue;
         }

         $tabela .=" ] }";

         echo( Funcoes::normalizar( $tabela ) );
         return;
      }
   case 'salvarInfoMercadoriaNm':
      {

         $infoMercadoria = new InfoMercadoria();
         $infoMercadoriaDao = new InfoMercadoriaDAO();
         $usuario = new Usuario();
         $usuario = Funcoes::getUsuario();

         if ( $usuario == null )
         {
            echo('Usuário não autenticado. ' . '<a src=../home.php>login</a>');
            return;
         }

         $nm = new NotaMov();
         $nmDao = new NotaMovDAO();
         $nm = $nmDao->load( $_POST[ 'infoNrNota' ] );

         //Usuário com perfil comum e status da NM diferente de S=Solicitada
         if ( ($nm->status != 'S') && ($usuario->perfilPermissao == 'COMUM') )
         {
            echo('Nota de movimentação com status diferente de S=Solicitada,<br/> somente usuário com perfil de SUPRIMENTO OU ADM podem alterar a NM.');
            return;
         }

         //Nm com Status de Cancelada apenas o ADM pode alterar o Status
         if ( ($nm->status == 'C') && ($usuario->perfilPermissao != 'ADM') )
         {
            echo('Nota de movimentação, encontra-se C=Cancelada.<br/> Apenas o Administrador do Sistema pode alterá-la.');
            return;
         }

         //dados do formulário         
         $infoAcao = $_POST[ 'infoAcao' ];
         $infoMercadoria->notaMovId = $_POST[ 'infoNrNota' ];
         $infoMercadoria->id = $_POST[ 'infoId' ];
         $infoMercadoria->especie = utf8_decode( $_POST[ 'infoEspecie' ] );
         $infoMercadoria->embalagem = utf8_decode( $_POST[ 'infoEmbalagem' ] );
         $infoMercadoria->quantidade = $_POST[ 'infoQuantidade' ];
         $infoMercadoria->valor = $_POST[ 'infoValor' ];


         switch ( $infoAcao )
         {
            case 'INSERIR':
               {
                  if ( $infoMercadoriaDao->insert( $infoMercadoria ) > 0 )
                  {
                     $notaMov = new NotaMov();
                     $notaMovDao = new NotaMovDAO();

                     $integranteId = $usuario->integranteId;
                     $notaMov = $notaMovDao->load( $infoMercadoria->notaMovId );
                     $status = ($notaMov->status == 'A' ? 'S' : $notaMov->status);

                     $notaMovDao->alterarStatus( $notaMov->id, $status, Funcoes::getDtHoraDB(), $integranteId );

                     echo('OK');
                     return;
                  }
                  else
                  {
                     echo('Falha na inserção do registro.');
                     return;
                  }
               }
            case 'EDITAR':
               {
                  if ( $infoMercadoriaDao->update( $infoMercadoria ) > 0 )
                  {
                     $notaMov = new NotaMov();
                     $notaMovDao = new NotaMovDAO();

                     $integranteId = $usuario->integranteId;
                     $notaMov = $notaMovDao->load( $infoMercadoria->notaMovId );
                     $status = ($notaMov->status == 'A' ? 'S' : $notaMov->status);

                     $notaMovDao->alterarStatus( $notaMov->id, $status, Funcoes::getDtHoraDB(), $integranteId );

                     echo('OK');
                     return;
                  }
                  else
                  {
                     echo('Falha na atualização do registro.');
                     return;
                  }
               }
            default:
               {
                  echo 'Ação não válida.';
                  return;
               }
         }
      }
   case 'excluirInfoMercadoriaNm':
      {
         $infoMercadoriaDao = new InfoMercadoriaDAO();
         $usuario = new Usuario();
         $usuario = Funcoes::getUsuario();

         if ( $usuario == null )
         {
            echo('Usuário não autenticado. ' . '<a src=../home.php>login</a>');
            return;
         }

         $nm = new NotaMov();
         $nmDao = new NotaMovDAO();
         $nm = $nmDao->load( $_GET[ 'nmId' ] );

         //Usuário com perfil comum e status da NM diferente de S=Solicitada
         if ( ($nm->status != 'S') && ($usuario->perfilPermissao == 'COMUM') )
         {
            echo('Nota de movimentação com status diferente de S=Solicitada,<br/> somente usuário com perfil de SUPRIMENTO OU ADM podem alterar a NM.');
            return;
         }

         //Nm com Status de Cancelada apenas o ADM pode alterar o Status
         if ( ($nm->status == 'C') && ($usuario->perfilPermissao != 'ADM') )
         {
            echo('Nota de movimentação, encontra-se C=Cancelada.<br/> Apenas o Administrador do Sistema pode alterá-la.');
            return;
         }

         //dados do formulário         
         $nmId = Funcoes::noInjection( $_GET[ 'nmId' ] );
         $id = Funcoes::noInjection( $_GET[ 'id' ] );


         if ( $infoMercadoriaDao->delete( $id, $nmId ) > 0 )
         {
            $notaMov = new NotaMov();
            $notaMovDao = new NotaMovDAO();

            $integranteId = $usuario->integranteId;
            $notaMov = $notaMovDao->load( $nmId );
            $status = ($notaMov->status == 'A' ? 'S' : $notaMov->status);

            $notaMovDao->alterarStatus( $notaMov->id, $status, Funcoes::getDtHoraDB(), $integranteId );
            echo('OK');
            return;
         }
         else
         {
            echo('Registro não excluído');
            return;
         }
      }

   default:
      {
         echo 'Evento ' . $evento . ' não válido.';
         return;
      }
}
?>