<?php

class PermissaoDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return PermissaoMySql 
	 */
	public function load($perfilId, $funcionalidadeId){
		$sql = 'SELECT * FROM permissao WHERE perfil_id = ?  AND funcionalidade_id = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($perfilId);
		$sqlQuery->setNumber($funcionalidadeId);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM permissao';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM permissao ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param permissao primary key
 	 */
	public function delete($perfilId, $funcionalidadeId){
		$sql = 'DELETE FROM permissao WHERE perfil_id = ?  AND funcionalidade_id = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($perfilId);
		$sqlQuery->setNumber($funcionalidadeId);

		return $this->executeUpdate($sqlQuery);
	}
        
        public function deleteByFuncionalidadeId($funcId){
		$sql = 'DELETE FROM permissao WHERE funcionalidade_id = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($funcId);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param PermissaoMySql permissao
 	 */
	public function insert($permissao){
		$sql = 'INSERT INTO permissao ( perfil_id, funcionalidade_id) VALUES ( ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		

		
		$sqlQuery->set($permissao->perfilId);

		$sqlQuery->setNumber($permissao->funcionalidadeId);

		$this->executeInsert($sqlQuery);
                return true;
		//$permissao->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param PermissaoMySql permissao
 	 */
	public function update($permissao){
		$sql = 'UPDATE permissao SET  WHERE perfil_id = ?  AND funcionalidade_id = ? ';
		$sqlQuery = new SqlQuery($sql);
		

		
		$sqlQuery->setNumber($permissao->perfilId);

		$sqlQuery->setNumber($permissao->funcionalidadeId);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM permissao';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}



	
	/**
	 * Read row
	 *
	 * @return PermissaoMySql 
	 */
	protected function readRow($row){
		$permissao = new Permissao();
		
		$permissao->perfilId = $row['perfil_id'];
		$permissao->funcionalidadeId = $row['funcionalidade_id'];

		return $permissao;
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
	 * @return PermissaoMySql 
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