<?php

class RepDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return RepMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM rep WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}
        
        public function queryByDescrPerfil($pDescr, $pPerfil){
		$sql = "SELECT * FROM rep "
                     . "WHERE descricao LIKE ? AND "
                     . "id IN(SELECT rep_id FROM rep_perfil WHERE perfil_id = ?)";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set('%'.$pDescr.'%');
                $sqlQuery->set($pPerfil);
		return $this->getList($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM rep';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM rep ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param rep primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM rep WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param RepMySql rep
 	 */
	public function insert($rep){
		$sql = 'INSERT INTO rep (arquivo_jasper, descricao) VALUES (?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($rep->arquivoJasper);
		$sqlQuery->set($rep->descricao);

		$id = $this->executeInsert($sqlQuery);	
		$rep->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param RepMySql rep
 	 */
	public function update($rep){
		$sql = 'UPDATE rep SET arquivo_jasper = ?, descricao = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($rep->arquivoJasper);
		$sqlQuery->set($rep->descricao);

		$sqlQuery->set($rep->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM rep';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByArquivoJasper($value){
		$sql = 'SELECT * FROM rep WHERE arquivo_jasper = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDescricao($value){
		$sql = 'SELECT * FROM rep WHERE descricao = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByArquivoJasper($value){
		$sql = 'DELETE FROM rep WHERE arquivo_jasper = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDescricao($value){
		$sql = 'DELETE FROM rep WHERE descricao = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return RepMySql 
	 */
	protected function readRow($row){
		$rep = new Rep();
		
		$rep->id = $row['id'];
		$rep->arquivoJasper = $row['arquivo_jasper'];
		$rep->descricao = $row['descricao'];

		return $rep;
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
	 * @return RepMySql 
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