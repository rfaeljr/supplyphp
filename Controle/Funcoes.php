<?php

date_default_timezone_set("America/Sao_Paulo");
setlocale(LC_ALL, 'pt_BR');

class Funcoes
{

   //adiciona aspas duplas em volta da 
   public static function aspasDuplas( $pDado )
   {
      return "\"" . $pDado . "\"";
   }

   public static function retirarSql( $pDado )
   {
      $html = array( "*", ",", ";", "DELETE", "INSERT", "CREATE", "DROP", "TRUNCATE", "FROM" );
      return str_replace( $html, '', $pDado );
   }

   public static function retirarAspas( $pDado )
   {
      $html = array( "'", "\"" );
      return str_replace( $html, '', $pDado );
   }

   public static function retirarTags( $pDado )
   {
      $html = array( '<', '>' );
      return str_replace( $html, '', $pDado );
   }
   
   public static function normalizar( $pDado ){
      $chars = array( "\n", "\r", "\r\n" );
      return trim( str_replace( $chars, '', $pDado ) );
   }
   
   public static function jsonStr( $pDado )
   {
      $pDado = str_replace( '"', '\"', $pDado );
	  return $pDado;
   }

   public static function retirarMascara( $pDado )
   {
      $carateres = array( '<', '>', '.', '/', '\\', '-', ';' );
      return str_replace( $carateres, '', $pDado );
   }

   public static function noInjection( $pDado )
   {
      return Funcoes::retirarSql( Funcoes::retirarAspas( $pDado ) );
   }

   public static function isNuloVazioNaoSetado( $pDado )
   {
      return (is_null( $pDado ) || empty( $pDado ) || !isset( $pDado ));
   }

   public static function isNumero( $pDado )
   {
      return (!is_nan( $pDado ));
   }

   public static function isLetra( $pDado )
   {
      return (is_string( $pDado ));
   }

   public static function getDataDB()
   {
      return date( 'Y-m-d' );
   }

   public static function getDtHoraDB()
   {
      return date( 'Y-m-d H:i' );
   }
   
   public static function getDtHoraYMDHI()
   {
      return date( 'YmdHi' );
   }

   public static function formataDtHoraDB( $pData )
   {
      if ( $pData == null || trim( $pData == '' ) || $pData == 0 )
      {
         return null;
      }

      $ano = substr( $pData, 6, 4 );
      $mes = substr( $pData, 3, 2 );
      $dia = substr( $pData, 0, 2 );
      $hora = substr( $pData, 11, 2 );
      $minuto = substr( $pData, 13, 2 );

      $pData = $ano . '-' . $mes . '-' . $dia . ' ' . $hora . ':' . $minuto;

      return $pData;
   }
   
   public static function formataDtDB( $pData )
   {
      if ( $pData == null || trim( $pData == '' ) || $pData == 0 )
      {
         return null;
      }

      $ano = substr( $pData, 6, 4 );
      $mes = substr( $pData, 3, 2 );
      $dia = substr( $pData, 0, 2 );

      $pData = $ano . '-' . $mes . '-' . $dia;

      return $pData;
   }

   public static function formataDtHoraView( $pData )
   {
      if ( $pData == null || trim( $pData == '' ) || $pData == 0 )
      {
         return 0;
      }
      $data = date_create( $pData );
      return date_format( $data, 'd/m/Y H:i' );
   }
   
   public static function formataDtView( $pData )
   {
      if ( $pData == null || trim( $pData == '' ) || $pData == 0 )
      {
         return 0;
      }
      $data = date_create( $pData );
      return date_format( $data, 'd/m/Y' );
   }
   

   public static function pad( $pData, $pTotal, $pCaractere, $pDirecao )
   {
      $pDirecao = ( ($pDirecao == '>') ? STR_PAD_RIGHT : STR_PAD_LEFT);

      $pRetorno = str_pad( $pData, $pTotal, $pCaractere, $pDirecao );

      return $pRetorno;
   }

   public static function formataCpf( $pCpf )
   {
      return substr( $pCpf, 0, 3 ) . '.' . substr( $pCpf, 3, 3 ) . '.' . substr( $pCpf, 6, 3 ) . '-' . substr( $pCpf, 9, 2 );
   }

   public static function getSubstring( $pString, $pCaratere, $pDirecao )
   {
      $posicao = strpos( $pString, $pCaratere );

      //caso não exista o caractere delimitador na string.
      if ( $posicao == false )
      {
         return $pString;
      }

      //para frente
      if ( $pDirecao == '>' )
      {
         return substr( $pString, $posicao + 1, strlen( $pString ) - ($posicao + 1) );
      }
      return substr( $pString, 0, $posicao );
   }

   public static function getUrl()
   {
      return $_SERVER[ 'HTTP_HOST' ];
   }

   public static function getNavegador()
   {
      return $_SERVER[ 'HTTP_USER_AGENT' ];
   }

   public static function getIpEstacao()
   {
      //verifica se não é vazio
      if ( !empty( $_SERVER[ 'HTTP_CLIENT_IP' ] ) )
      {
         $ip = $_SERVER[ 'HTTP_CLIENT_IP' ];
      }
      //verifica se vem de um proxy
      elseif ( !empty( $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] ) )
      {
         $ip = $_SERVER[ 'HTTP_X_FORWARDED_FOR' ];
      }
      else
      {
         $ip = $_SERVER[ 'REMOTE_ADDR' ];
      }
      //retorna ip
      return $ip;
   }

   public static function redirecionarPara( $pUrl )
   {
      header( 'Location: ' . $pUrl );
   }

   public static function isEmailValido( $pEmail )
   {
      if ( !preg_match( "/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/", $pEmail ) )
      {
         return false;
      }
      return true;
   }

   public static function enviarEmail( $pEmailOrigem, $pEmailDestino, $pTitulo, $pMensagem )
   {
      $headers = $pEmailOrigem;
      $headers .= "X-Mailer: PHP5" . "n";
      $headers .= "MIME-Version: 1.0" . "n";
      $headers .= "Content-type: text/html; charset=iso-8859-1" . "rn";
      mail( $pEmailDestino, $pTitulo, $pMensagem, $headers );
   }

   //verifica se o usuário está autenticado no sistema
   public static function getUsuario()
   {
      Funcoes::abrirSessao();
      if ( isset( $_SESSION[ 'usuario' ] ) )
      {
         return unserialize( $_SESSION[ 'usuario' ] );
      }
      return null;
   }
   
   public static function logOff(){
      Funcoes::abrirSessao();
      if ( isset( $_SESSION[ 'usuario' ] ) ){         
         $_SESSION[ 'usuario' ] = null;
         session_destroy();
      }      
      Funcoes::redirecionarPara('login.php');
      return;      
   }
   
   public static function getMatriculaNomeUsuario(){
      Funcoes::abrirSessao();
      if ( isset( $_SESSION[ 'usuario' ] ) )
      {
         $usuario = new Usuario();
         $integrante = new Integrante();
         $integranteDao = new IntegranteDao();
         
         $usuario = unserialize( $_SESSION[ 'usuario' ] );
         $integrante = $integranteDao->load($usuario->integranteId);
         
         return $integrante->matricula.'='.$integrante->nome.' [ '.$integrante->perfilId.' ] ';
         
      }
      return null;
   }

   //verifica se a sessão já está aberta, 
   //caso contrário abre-se uma nova
   public static function abrirSessao()
   {
      if ( !isset( $_SESSION ) )
      {
         session_start();
      }
   }
   
   public static function acessa($viewId){
      require_once('../Persistencia/ViewDAO.php');
      $usuario = new Usuario();
      $usuario = Funcoes::getUsuario();
      
      if($usuario == null){
         return 'n';
      }
            
      $flag = ViewDAO::acessoView($usuario->perfilPermissao, $viewId);
      
      return($flag == true ? 'y' : 'n'); 
   }

   public static function permite($viewId, $funcionalidade){
      require_once('../Persistencia/ViewDAO.php');
      $usuario = new Usuario();
      $usuario = Funcoes::getUsuario();
      
      if($usuario == null){
         return 'n';
      }
            
      $flag = ViewDAO::permissaoFuncionalidade($usuario->perfilPermissao, $viewId, $funcionalidade);
      
      return($flag == true ? 'y' : 'n');     
      
   }
   
   public static function acessaView($viewId){
      $usuario = new Usuario();
      $usuario = Funcoes::getUsuario();
      
      if($usuario == null){
         Funcoes::redirecionarPara('login.php');
         return;
      }
      
      if(Funcoes::acessa($viewId) == 'n'){
         Funcoes::redirecionarPara('acessonegado.php');
         return;
      }
   }
   

   public static function getStatusNm( $pDado )
   {
      switch ( trim( $pDado ) )
      {
         case 'S':
            {
               return "<font color=#04B404><b>S=Solicitada</b></font>";
            }
         case 'A':
            {
               return "<b>A=Em Análise</b>";
            }
         case 'AP':
            {
               return "<b>AP=Atendida Parcial</b>";
            }   
            
         case 'AT':
            {
               return "<font color=#2E2EFE><b>AT=Atendida</b></font>";
            }
         case 'C':
            {
               return "<font color=#DF0101><b>C=Cancelada</b></font>";
            }

         default:
            {
               return "<b>Status não cadastrado</b>";
            }
      }
   }

}
?>

