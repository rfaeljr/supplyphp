<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once('includes.php');

$evento = Funcoes::noInjection($_GET['evento']);


switch ($evento) {
    case 'autenticar': {
            $loginRede = Funcoes::noInjection($_POST['loginRede']);
            $senhaRede = $_POST['senhaRede'];
  	   
            $lnkConexao = @ldap_connect(APPConfig::$ad);
			
			
			if($lnkConexao == null){
				echo("Erro na conexão ldap: " . ldap_error($lnkConexao));
                return;
			}
			
            //conexão AD
            if (!$lnkConexao) {
                echo("Não há conexão com o AD Domain.corp");
                return;
            }
            
            //autenticação no AD
            $ldapBind = @ldap_bind($lnkConexao, $loginRede . '@domain.corp', $senhaRede);
			
			if ($ldapBind == false) {
				$lnkConexao = @ldap_connect('10.157.16.5');
				$ldapBind = @ldap_bind($lnkConexao, $loginRede . '@domain.corp', $senhaRede) or die( ldap_error($lnkConexao) );
			}

            if ($ldapBind == false) {
                echo("Login de rede ou senha inválida!");
                return;
            }

            $resultado = @ldap_search($lnkConexao, APPConfig::$ldapTree, "(userprincipalname=$loginRede*)") ;                          
            $atributos = ldap_get_entries($lnkConexao, $resultado) ;    
            
		
			//Tenta novamente
			if ( $atributos['count'] == 0 ) {
				$resultado = @ldap_search($lnkConexao, 'OU=AAA,DC=bbb,DC=corp', "(userprincipalname=$loginRede*)") ;
				$atributos = ldap_get_entries($lnkConexao, $resultado);
			}		
			
                                                
            if ( $atributos['count'] == 0 ) {
                echo("Erro na busca das entradas(ldap_get_entries) ".ldap_error($lnkConexao));
                return;
            }
           	


            $integranteDao = new IntegranteDAO();
            $integrante = new Integrante();
            
            
            
            $integrante = $integranteDao->loadByNomeCPF($atributos[0]['displayname'][0], $atributos[0]['postofficebox'][0]);
            
            if ($integrante == null) {
                echo("Verifique o nome e o cpf cadastrado no Active Directory e no Sistema Supply" );
                return;
            }


            Funcoes::AbrirSessao();

            $usuario = new Usuario();
            $usuario->integranteId = $integrante->id;
            $usuario->matricula = $integrante->matricula;
            $usuario->uaId = $integrante->uaId;
            $usuario->perfilPermissao = $integrante->perfilId;

            $_SESSION['usuario'] = new Usuario();
            $_SESSION['usuario'] = serialize($usuario);
            //logout
            ldap_close($lnkConexao);

            echo('OK');
            return;
        }

    default: {
            echo 'Evento ' . $evento . ' não válido.';
            return;
        }
}
?>