<?php

require_once "../Visao/Relatorios/src/JasperPHP/JasperPHP.php";
require_once('../Controle/includes.php');

/**
 * Description of Relatorio
 *
 * @author rafaelcosta
 */
class Relatorio
{

   public static function gerar( $pRepId, $pParam, $pFormato )
   {
      $xRep = new Rep();
      $xUsuario = new Usuario();

      $xRepDao = new RepDAO();
      $xUsuario = Funcoes::getUsuario();
      $xRep = $xRepDao->load( $pRepId );


      $xDirUsuario = __DIR__ . '/gerados/' . $xUsuario->integranteId;
      if ( !file_exists( $xDirUsuario ) )
      {
         mkdir( $xDirUsuario, 7777 );
      }


      $xArqJasper = __DIR__ . '/jasper/' . $xRep->arquivoJasper;
      $xArqSaida = str_replace( '.jasper', '', $xRep->arquivoJasper );
      $xArqSaida .= Funcoes::getDtHoraYMDHI();



      $jasperPhp = new JasperPHP\JasperPHP();

      $jasperPhp->process(
              $xArqJasper, ($xDirUsuario . '/' . $xArqSaida ), $pFormato, $pParam, array(
         'driver' => 'mysql',
         'username' => ConnectionProperty::getUser(),
         'password' => ConnectionProperty::getPassword(),
         'host' => ConnectionProperty::getHost(),    
         'database' => ConnectionProperty::getDatabase()
              )
      )->execute();

      return ($xDirUsuario .'/'.$xArqSaida.'.'.$pFormato );
   }

}
