<?php

	//import dos arquivos util
	require_once('../Persistencia/util/Connection.php');
	require_once('../Persistencia/util/ConnectionFactory.php');
	require_once('../Persistencia/util/ConnectionProperty.php');
	require_once('../Persistencia/util/QueryExecutor.php');
	require_once('../Persistencia/util/Transaction.php');
	require_once('../Persistencia/util/SqlQuery.php');
	require_once('../Persistencia/util/ArrayList.php');
	require_once('../Persistencia/util/DAOFactory.php');
        
        
 	//import dos objetos da camada persistencia DAO
        require_once('../Persistencia/InfoMercadoriaDAO.php');
        require_once('../Persistencia/IntegranteDAO.php');
        require_once('../Persistencia/MaterialDAO.php');
        require_once('../Persistencia/NotaMovDAO.php');
        require_once('../Persistencia/NotaMovMatDAO.php');
        require_once('../Persistencia/TransporteDAO.php');
        require_once('../Persistencia/UaDAO.php');
        require_once('../Persistencia/UeDAO.php');
        require_once('../Persistencia/FuncionalidadeDAO.php');
        require_once('../Persistencia/PerfilDAO.php');
        require_once('../Persistencia/PerfilViewDAO.php');
        require_once('../Persistencia/PermissaoDAO.php');
        require_once('../Persistencia/ViewDAO.php');
        require_once('../Persistencia/RepDAO.php');
        require_once('../Persistencia/RepParametroDAO.php');
        require_once('../Persistencia/RepPerfilDAO.php');
                    
        
        
        //import dos objetos da camada modelo
        require_once('../Modelo/InfoMercadoria.php');
        require_once('../Modelo/Integrante.php');
        require_once('../Modelo/Material.php');
        require_once('../Modelo/NotaMov.php');
        require_once('../Modelo/NotaMovMat.php');
        require_once('../Modelo/Transporte.php');
        require_once('../Modelo/Ua.php');
        require_once('../Modelo/Ue.php');
        require_once('../Modelo/Usuario.php');
        require_once('../Modelo/Funcionalidade.php');
        require_once('../Modelo/Perfil.php');
        require_once('../Modelo/PerfilView.php');
        require_once('../Modelo/Permissao.php');
        require_once('../Modelo/View.php');
        require_once('../Modelo/Rep.php');
        require_once('../Modelo/RepParametro.php');
        require_once('../Modelo/RepPerfil.php');  
        
        //Relatorio
        require_once('../Visao/Relatorios/Relatorio.php'); 
        
        
        require_once('Funcoes.php');
        require_once('APPConfig.php');
?>