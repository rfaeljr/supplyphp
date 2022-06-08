<?php

class DAOFactory{
	
	/**
	 * @return InfoMercadoriaDAO
	 */
	public static function getInfoMercadoriaDAO(){
		return new InfoMercadoriaMySqlExtDAO();
	}

	/**
	 * @return IntegranteDAO
	 */
	public static function getIntegranteDAO(){
		return new IntegranteMySqlExtDAO();
	}

	/**
	 * @return MaterialDAO
	 */
	public static function getMaterialDAO(){
		return new MaterialMySqlExtDAO();
	}

	/**
	 * @return NotaMovDAO
	 */
	public static function getNotaMovDAO(){
		return new NotaMovMySqlExtDAO();
	}

	/**
	 * @return NotaMovMatDAO
	 */
	public static function getNotaMovMatDAO(){
		return new NotaMovMatMySqlExtDAO();
	}

	/**
	 * @return TransporteDAO
	 */
	public static function getTransporteDAO(){
		return new TransporteMySqlExtDAO();
	}

	/**
	 * @return UaDAO
	 */
	public static function getUaDAO(){
		return new UaMySqlExtDAO();
	}

	/**
	 * @return UeDAO
	 */
	public static function getUeDAO(){
		return new UeMySqlExtDAO();
	}


}
?>