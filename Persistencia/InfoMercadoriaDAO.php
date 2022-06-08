<?php

class InfoMercadoriaDAO{

        public function deleteByNmId($nmId){
		$sql = 'DELETE FROM info_mercadoria WHERE nota_mov_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($nmId);
		return $this->executeUpdate($sqlQuery);
	}
   
	public function load($id, $notaMovId){
		$sql = 'SELECT * FROM info_mercadoria WHERE id = ?  AND nota_mov_id = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->setNumber($notaMovId);

		return $this->getRow($sqlQuery);
	}
        
        public function listaInfoMercadoria($nmId){
		$sql = 'SELECT * FROM info_mercadoria WHERE nota_mov_id = ? ORDER BY especie';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($nmId);
		return QueryExecutor::execute($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM info_mercadoria';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM info_mercadoria ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param infoMercadoria primary key
 	 */
	public function delete($id, $notaMovId){
		$sql = 'DELETE FROM info_mercadoria WHERE id = ?  AND nota_mov_id = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->setNumber($notaMovId);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param InfoMercadoriaMySql infoMercadoria
 	 */
	public function insert($infoMercadoria){
		$sql = 'INSERT INTO info_mercadoria (especie, valor, embalagem, quantidade, nota_mov_id) VALUES (?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($infoMercadoria->especie);
		$sqlQuery->setNumber($infoMercadoria->valor);
		$sqlQuery->set($infoMercadoria->embalagem);
		$sqlQuery->setNumber($infoMercadoria->quantidade);
		$sqlQuery->setNumber($infoMercadoria->notaMovId);
                
                         
		$id = $this->executeInsert($sqlQuery);		
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param InfoMercadoriaMySql infoMercadoria
 	 */
	public function update($infoMercadoria){
		$sql = 'UPDATE info_mercadoria SET especie = ?, valor = ?, embalagem = ?, quantidade = ? WHERE id = ?  AND nota_mov_id = ? ';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($infoMercadoria->especie);
		$sqlQuery->set($infoMercadoria->valor);
		$sqlQuery->set($infoMercadoria->embalagem);
		$sqlQuery->set($infoMercadoria->quantidade);

		
		$sqlQuery->setNumber($infoMercadoria->id);

		$sqlQuery->setNumber($infoMercadoria->notaMovId);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM info_mercadoria';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByEspecie($value){
		$sql = 'SELECT * FROM info_mercadoria WHERE especie = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByValor($value){
		$sql = 'SELECT * FROM info_mercadoria WHERE valor = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByEmbalagem($value){
		$sql = 'SELECT * FROM info_mercadoria WHERE embalagem = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByQuantidade($value){
		$sql = 'SELECT * FROM info_mercadoria WHERE quantidade = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByEspecie($value){
		$sql = 'DELETE FROM info_mercadoria WHERE especie = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByValor($value){
		$sql = 'DELETE FROM info_mercadoria WHERE valor = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByEmbalagem($value){
		$sql = 'DELETE FROM info_mercadoria WHERE embalagem = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByQuantidade($value){
		$sql = 'DELETE FROM info_mercadoria WHERE quantidade = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return InfoMercadoriaMySql 
	 */
	protected function readRow($row){
		$infoMercadoria = new InfoMercadoria();
		
		$infoMercadoria->id = $row['id'];
		$infoMercadoria->especie = $row['especie'];
		$infoMercadoria->valor = $row['valor'];
		$infoMercadoria->embalagem = $row['embalagem'];
		$infoMercadoria->quantidade = $row['quantidade'];
		$infoMercadoria->notaMovId = $row['nota_mov_id'];

		return $infoMercadoria;
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
	 * @return InfoMercadoriaMySql 
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