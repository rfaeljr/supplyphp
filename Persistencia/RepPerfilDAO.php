<?php

class RepPerfilDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return RepPerfilMySql 
	 */
	public function load($repId, $perfilId){
		$sql = 'SELECT * FROM rep_perfil WHERE rep_id = ?  AND perfil_id = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($repId);
		$sqlQuery->setNumber($perfilId);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM rep_perfil';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM rep_perfil ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param repPerfil primary key
 	 */
	public function delete($repId, $perfilId){
		$sql = 'DELETE FROM rep_perfil WHERE rep_id = ?  AND perfil_id = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($repId);
		$sqlQuery->setNumber($perfilId);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param RepPerfilMySql repPerfil
 	 */
	public function insert($repPerfil){
		$sql = 'INSERT INTO rep_perfil ( rep_id, perfil_id) VALUES ( ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		

		
		$sqlQuery->setNumber($repPerfil->repId);

		$sqlQuery->setNumber($repPerfil->perfilId);

		$this->executeInsert($sqlQuery);	
		//$repPerfil->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param RepPerfilMySql repPerfil
 	 */
	public function update($repPerfil){
		$sql = 'UPDATE rep_perfil SET  WHERE rep_id = ?  AND perfil_id = ? ';
		$sqlQuery = new SqlQuery($sql);
		

		
		$sqlQuery->setNumber($repPerfil->repId);

		$sqlQuery->setNumber($repPerfil->perfilId);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM rep_perfil';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}



	
	/**
	 * Read row
	 *
	 * @return RepPerfilMySql 
	 */
	protected function readRow($row){
		$repPerfil = new RepPerfil();
		
		$repPerfil->repId = $row['rep_id'];
		$repPerfil->perfilId = $row['perfil_id'];

		return $repPerfil;
	}
	
	protected function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRow($tab[$i]);
		}
		return $ret;
	}
	
	/**
	 * Get row
	 *
	 * @return RepPerfilMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		return QueryExecutor::execute($sqlQuery);
	}
	
		
	/**
	 * Execute sql query
	 */
	protected function executeUpdate($sqlQuery){
		return QueryExecutor::executeUpdate($sqlQuery);
	}

	/**
	 * Query for one row and one column
	 */
	protected function querySingleResult($sqlQuery){
		return QueryExecutor::queryForString($sqlQuery);
	}

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>