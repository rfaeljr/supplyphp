CREATE DATABASE  IF NOT EXISTS `dbsupply` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dbsupply`;
-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: dbsupply
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.8-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `funcionalidade`
--

DROP TABLE IF EXISTS `funcionalidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `funcionalidade` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `view_arquivo_nome` varchar(30) NOT NULL,
  `acao` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unico` (`view_arquivo_nome`,`acao`),
  CONSTRAINT `fk_funcionalidade_view` FOREIGN KEY (`view_arquivo_nome`) REFERENCES `view` (`arquivo_nome`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `info_mercadoria`
--

DROP TABLE IF EXISTS `info_mercadoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `info_mercadoria` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `especie` varchar(150) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `embalagem` varchar(150) NOT NULL,
  `quantidade` decimal(10,2) NOT NULL,
  `nota_mov_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`,`nota_mov_id`),
  KEY `fk_info_mercadoria_nota_mov1_idx` (`nota_mov_id`),
  CONSTRAINT `fk_info_mercadoria_nota_mov1` FOREIGN KEY (`nota_mov_id`) REFERENCES `nota_mov` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `integrante`
--

DROP TABLE IF EXISTS `integrante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `integrante` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `matricula` varchar(10) NOT NULL,
  `ua_id` bigint(20) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `dt_admissao_foz` date NOT NULL,
  `cargo` varchar(150) NOT NULL,
  `lider_nome` varchar(150) DEFAULT NULL,
  `perfil_id` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `integrante_ua_unique` (`matricula`,`ua_id`),
  UNIQUE KEY `idx_cpf` (`cpf`),
  KEY `fk_perfil_idx` (`perfil_id`),
  KEY `fk_integrante_ua_idx` (`ua_id`),
  CONSTRAINT `fk_integrante_perfil` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_integrante_ua` FOREIGN KEY (`ua_id`) REFERENCES `ua` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2187 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `material`
--

DROP TABLE IF EXISTS `material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `material` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `grupo` int(6) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `unidade` varchar(6) NOT NULL,
  `preco_medio` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `material_grupo_codigo_idx1` (`grupo`,`codigo`),
  UNIQUE KEY `material_id_idx1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50001 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nota_mov`
--

DROP TABLE IF EXISTS `nota_mov`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nota_mov` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ua_origem_id` bigint(20) NOT NULL,
  `ua_destino_id` bigint(20) NOT NULL,
  `solicitado_por_id` bigint(20) NOT NULL,
  `responsavel_id` bigint(20) DEFAULT NULL,
  `autorizado_por_id` bigint(20) DEFAULT NULL,
  `status` varchar(3) NOT NULL,
  `fonte_recurso` varchar(3) NOT NULL,
  `natureza` varchar(3) NOT NULL,
  `sistema` varchar(3) NOT NULL,
  `dthora_solicitacao` datetime NOT NULL,
  `dthora_autorizacao` datetime DEFAULT NULL,
  `dthora_entrega` datetime DEFAULT NULL,
  `dthora_recebido` datetime DEFAULT NULL,
  `recebido_por_nome` varchar(150) DEFAULT NULL,
  `recebido_por_id` bigint(20) DEFAULT NULL,
  `entregue_por_nome` varchar(150) DEFAULT NULL,
  `entregue_por_id` bigint(20) DEFAULT NULL,
  `informacoes_complementares` varchar(255) DEFAULT NULL,
  `insercao_id` bigint(20) NOT NULL,
  `dthora_insercao` datetime NOT NULL,
  `dthora_alteracao` datetime DEFAULT NULL,
  `alteracao_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_nota_mov_ua1_idx` (`ua_origem_id`),
  KEY `fk_nota_mov_ua2_idx` (`ua_destino_id`),
  KEY `fk_nota_mov_integrante1_idx` (`solicitado_por_id`),
  KEY `fk_nota_mov_integrante6_idx` (`insercao_id`),
  KEY `fk_nota_mov_integrante7_idx` (`alteracao_id`),
  CONSTRAINT `fk_nota_mov_integrante1` FOREIGN KEY (`solicitado_por_id`) REFERENCES `integrante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_nota_mov_integrante2` FOREIGN KEY (`insercao_id`) REFERENCES `integrante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_nota_mov_integrante3` FOREIGN KEY (`alteracao_id`) REFERENCES `integrante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_nota_mov_ua1` FOREIGN KEY (`ua_origem_id`) REFERENCES `ua` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_nota_mov_ua2` FOREIGN KEY (`ua_destino_id`) REFERENCES `ua` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nota_mov_mat`
--

DROP TABLE IF EXISTS `nota_mov_mat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nota_mov_mat` (
  `sequencia` bigint(20) NOT NULL AUTO_INCREMENT,
  `material_id` bigint(20) NOT NULL,
  `nota_mov_id` bigint(20) NOT NULL,
  `quant_solicitada` decimal(10,2) NOT NULL,
  `quant_fornecida` decimal(10,2) DEFAULT NULL,
  `vlr_unitario` decimal(10,2) NOT NULL,
  `insercao_id` bigint(20) NOT NULL,
  `dthora_insercao` datetime NOT NULL,
  `alteracao_id` bigint(20) NOT NULL,
  `dthora_alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`sequencia`,`material_id`,`nota_mov_id`),
  UNIQUE KEY `nota_mov_mat_unico_idx` (`nota_mov_id`,`material_id`),
  KEY `fk_nota_mov_mat_material1_idx` (`material_id`),
  KEY `fk_nota_mov_mat_nota_mov1_idx` (`nota_mov_id`),
  KEY `fk_nota_mov_mat_integrante1_idx` (`insercao_id`),
  KEY `fk_nota_mov_mat_integrante2_idx` (`alteracao_id`),
  CONSTRAINT `fk_nota_mov_mat_integrante1` FOREIGN KEY (`insercao_id`) REFERENCES `integrante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_nota_mov_mat_integrante2` FOREIGN KEY (`alteracao_id`) REFERENCES `integrante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_nota_mov_mat_material1` FOREIGN KEY (`material_id`) REFERENCES `material` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_nota_mov_mat_nota_mov1` FOREIGN KEY (`nota_mov_id`) REFERENCES `nota_mov` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `perfil`
--

DROP TABLE IF EXISTS `perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil` (
  `id` varchar(30) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `perfil_view`
--

DROP TABLE IF EXISTS `perfil_view`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil_view` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `perfil_id` varchar(30) NOT NULL,
  `view_arquivo_nome` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_perfil_id_idx` (`perfil_id`),
  KEY `fk_view_arquivo_nome_idx` (`view_arquivo_nome`),
  CONSTRAINT `fk_perfil_view_perfil` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfil_view_view` FOREIGN KEY (`view_arquivo_nome`) REFERENCES `view` (`arquivo_nome`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `permissao`
--

DROP TABLE IF EXISTS `permissao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissao` (
  `perfil_id` varchar(30) NOT NULL,
  `funcionalidade_id` bigint(20) NOT NULL,
  PRIMARY KEY (`perfil_id`,`funcionalidade_id`),
  KEY `fk_funcionalidade_permissao_idx` (`funcionalidade_id`),
  CONSTRAINT `fk_permissao_funcionalidade` FOREIGN KEY (`funcionalidade_id`) REFERENCES `funcionalidade` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_permissao_perfil` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rep`
--

DROP TABLE IF EXISTS `rep`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rep` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `arquivo_jasper` varchar(60) NOT NULL,
  `descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rep_parametro`
--

DROP TABLE IF EXISTS `rep_parametro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rep_parametro` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rep_id` bigint(20) NOT NULL,
  `ordem` tinyint(2) NOT NULL,
  `label` varchar(60) NOT NULL DEFAULT 'Campo',
  `name` varchar(30) NOT NULL,
  `tipo` varchar(20) NOT NULL DEFAULT 'TEXT',
  `valor` varchar(255) DEFAULT NULL,
  `mascara` varchar(10) DEFAULT NULL,
  `obrigatorio` tinyint(1) NOT NULL DEFAULT '0',
  `query` varchar(255) DEFAULT NULL,
  `hint` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rep_id_idx` (`rep_id`),
  CONSTRAINT `fk_parametro_rep_id` FOREIGN KEY (`rep_id`) REFERENCES `rep` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rep_perfil`
--

DROP TABLE IF EXISTS `rep_perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rep_perfil` (
  `rep_id` bigint(20) NOT NULL,
  `perfil_id` varchar(30) NOT NULL,
  PRIMARY KEY (`rep_id`,`perfil_id`),
  KEY `fk_rep_perfil_perfil_id_idx` (`perfil_id`),
  CONSTRAINT `fk_rep_perfil_perfil_id` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rep_perfil_rep_id` FOREIGN KEY (`rep_id`) REFERENCES `rep` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `transporte`
--

DROP TABLE IF EXISTS `transporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transporte` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `transportadora` varchar(255) NOT NULL,
  `nr_viatura` varchar(30) NOT NULL,
  `nr_placa` varchar(10) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `motorista` varchar(150) NOT NULL,
  `local_entrega` varchar(150) NOT NULL,
  `nota_mov_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`,`nota_mov_id`),
  UNIQUE KEY `transporte_nota_mov_idx` (`nota_mov_id`),
  KEY `fk_transporte_nota_mov1_idx` (`nota_mov_id`),
  CONSTRAINT `fk_transporte_nota_mov1` FOREIGN KEY (`nota_mov_id`) REFERENCES `nota_mov` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ua`
--

DROP TABLE IF EXISTS `ua`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ua` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ua_alias` varchar(30) NOT NULL,
  `ue_id` varchar(30) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ua_ue_unique` (`ua_alias`,`ue_id`),
  KEY `fk_ua_ue_idx` (`ue_id`),
  CONSTRAINT `fk_ua_ue` FOREIGN KEY (`ue_id`) REFERENCES `ue` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13034 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ue`
--

DROP TABLE IF EXISTS `ue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ue` (
  `id` varchar(30) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `descricao_UNIQUE` (`descricao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `view`
--

DROP TABLE IF EXISTS `view`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `view` (
  `arquivo_nome` varchar(30) NOT NULL,
  `url` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`arquivo_nome`),
  UNIQUE KEY `arquivo_nome_UNIQUE` (`arquivo_nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'dbsupply'
--
/*!50003 DROP FUNCTION IF EXISTS `fx_acesso_view` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fx_acesso_view`(pPerfil_id VARCHAR(30), 
								 pView_nome VARCHAR(30) ) RETURNS tinyint(1)
BEGIN
	DECLARE xQuant INT;
	SET xQuant = 0;
    
	SELECT IFNULL(count(*),0) INTO xQuant  
    FROM perfil_view pv
	WHERE pv.perfil_id = pPerfil_id AND
		  pv.view_arquivo_nome = pView_nome;
	
    RETURN xQuant;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fx_getMatrNomePorId` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fx_getMatrNomePorId`(pId INTEGER) RETURNS varchar(120) CHARSET utf8
BEGIN
	DECLARE xMatrNome VARCHAR(120) DEFAULT 0;
	
	SELECT IFNULL(concat(matricula, concat('=', nome)), 0) INTO xMatrNome 
	FROM INTEGRANTE 
	WHERE id = pId;
	
	RETURN xMatrNome;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fx_getMatrPorId` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fx_getMatrPorId`(pId INTEGER) RETURNS int(11)
BEGIN
	DECLARE xMatr VARCHAR(10) DEFAULT 0;
	
	SELECT IFNULL(matricula, 0) INTO xMatr 
	FROM INTEGRANTE 
	WHERE id = pId;
	
	RETURN xMatr;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fx_getNaturezaNm` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fx_getNaturezaNm`( pNmId bigint ) RETURNS varchar(60) CHARSET utf8
BEGIN
	DECLARE xNatureza varchar(3) DEFAULT '';
    
	
    
	SELECT natureza INTO xNatureza 
	FROM nota_mov n 
	WHERE n.id = pNmId;
	
	
	CASE  xNatureza
		WHEN 'B' THEN RETURN 'B=Baixa'; 
		WHEN 'T' THEN RETURN 'T=Transferência';
		WHEN 'D' THEN RETURN 'D=Devolução'; 
        WHEN 'R' THEN RETURN 'R=Simples Remessa'; 
		WHEN 'N' THEN RETURN 'N=Nota Fiscal'; 
		WHEN 'O' THEN RETURN 'O=Outros';
		ELSE
			RETURN CONCAT(xNatureza, concat('=','Natureza não cadastrada')); 
	END CASE;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fx_getStatusNm` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fx_getStatusNm`( pNmId bigint ) RETURNS varchar(60) CHARSET utf8
BEGIN
	DECLARE xStatus varchar(3) DEFAULT '';
    
	
    
	SELECT status INTO xStatus 
	FROM nota_mov n 
	WHERE n.id = pNmId;
	
	
	CASE  xStatus
		WHEN 'S' THEN RETURN 'S=Solicitada'; 
		WHEN 'A' THEN RETURN 'A=Em Análise';
		WHEN 'AP' THEN RETURN 'AP=Atendida Parcial'; 
		WHEN 'AT' THEN RETURN 'AT=Atendida'; 
		WHEN 'C' THEN RETURN 'C=Cancelada';
		ELSE
			RETURN CONCAT(xStatus, concat('=','Status não cadastrado')); 
	END CASE;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fx_getUaId` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fx_getUaId`(pUe varchar(30), pUaAlias varchar(30)) RETURNS bigint(20)
BEGIN
	DECLARE xId BIGINT DEFAULT 0;
	
	SELECT IFNULL(id,0) INTO xId FROM ua 
	WHERE ue_id = pUe AND ua_alias = pUaAlias;

RETURN xId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fx_materialId` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fx_materialId`( pGrupo INT, pCodigo VARCHAR(50) ) RETURNS int(11)
BEGIN
	DECLARE xId INT;
	SET xId = 0;
    
	SELECT m.id INTO xId FROM material m WHERE m.grupo = pGrupo AND m.codigo = pCodigo;
	
    RETURN IFNULL(xId, 0);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fx_permissao` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fx_permissao`(pPerfil_id VARCHAR(30), 
								pView_nome VARCHAR(30),
                                pAcao VARCHAR(60) ) RETURNS tinyint(1)
BEGIN
	DECLARE xQuant INT;
	SET xQuant = 0;
    
	SELECT IFNULL(count(*),0) INTO xQuant  
    FROM permissao p
	WHERE p.perfil_id = pPerfil_id AND
		  p.funcionalidade_id = (SELECT f.id FROM funcionalidade f 
								 WHERE f.view_arquivo_nome = pView_nome AND 
									   f.acao = pAcao );
	
    RETURN xQuant;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fx_qtdeMaterial` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fx_qtdeMaterial`( pMaterialId BIGINT, pIntId BIGINT, pAnoMes VARCHAR(7), pStatusNm VARCHAR(3)  ) RETURNS int(11)
BEGIN
	DECLARE xQtde INT DEFAULT 0; 
	
	SELECT IFNULL(SUM(a.quant_fornecida), 0) INTO xQtde FROM NOTA_MOV_MAT a
	WHERE a.nota_mov_id IN(SELECT b.id FROM nota_mov b 
							WHERE b.solicitado_por_id = pIntId AND 
                            CONCAT( YEAR(b.dthora_solicitacao), CONCAT('/', MONTH(b.dthora_solicitacao)) ) = pAnoMes AND
							b.status = pStatusNm
                            ) 
	 AND a.material_id = pMaterialId; 
    
	
    RETURN xQtde;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_excluir_perfil_view` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_excluir_perfil_view`(pPerfil VARCHAR(30), pView_nome VARCHAR(30))
BEGIN	
    DECLARE xId INT;
    DECLARE xFim INT;
    DECLARE cursor_funcionalidade CURSOR FOR 
		SELECT IFNULL(f.id, 0) AS id
		FROM funcionalidade f 
		WHERE f.view_arquivo_nome = pView_nome; 
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SELECT 'ERRO NA PROCEDURE proc_excluir_perfilView';
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET xFim = 1;
    
    SET xId = 0;
    SET xFim = 0;

    
    START TRANSACTION;
    SET autocommit=0;

    OPEN  cursor_funcionalidade;
	xloop:LOOP 
		FETCH cursor_funcionalidade INTO xId ;
		
        IF xFim = 1 THEN
			LEAVE xloop;
        END IF;
        DELETE FROM permissao WHERE perfil_id = pPerfil AND funcionalidade_id = xId;
	END LOOP xloop;
    CLOSE cursor_funcionalidade; 
    

    DELETE FROM perfil_view  WHERE perfil_id = pPerfil AND view_arquivo_nome = pView_nome;
    COMMIT; 


END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `proc_excluir_view` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_excluir_view`(pView_nome VARCHAR(30))
BEGIN	
    DECLARE xId INT;
    DECLARE xFim INT;
    DECLARE cursor_funcionalidade CURSOR FOR 
		SELECT IFNULL(f.id, 0) AS id
		FROM funcionalidade f 
		WHERE f.view_arquivo_nome = pView_nome; 
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SELECT 'ERRO NA PROCEDURE proc_excluir_view';
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET xFim = 1;
    
    SET xId = 0;
    SET xFim = 0;

    
    START TRANSACTION;
    SET autocommit=0;

    OPEN  cursor_funcionalidade;
	xloop:LOOP 
		FETCH cursor_funcionalidade INTO xId ;
		
        IF xFim = 1 THEN
			LEAVE xloop;
        END IF;
        DELETE FROM permissao WHERE funcionalidade_id = xId;
	END LOOP xloop;
    CLOSE cursor_funcionalidade;   
    

    
    DELETE FROM funcionalidade WHERE view_arquivo_nome = pView_nome;
    DELETE FROM perfil_view  WHERE view_arquivo_nome = pView_nome;
    DELETE FROM dbnm.view  WHERE arquivo_nome = pView_nome;
    COMMIT; 


END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-04 11:36:53
