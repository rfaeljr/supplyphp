<?php

class UeDAO{

        public function listarUes($pValor){
         $sql  ="SELECT * FROM ue ";
         $sql .="WHERE descricao LIKE '%".$pValor."%' OR id LIKE '%".$pValor."%' " ;  
         $sql .="LIMIT 0, 30";
         $sqlQuery = new SqlQuery($sql);   
         return $this->getList($sqlQuery);                
      }
    
        public function listaUe( $campo, $criterio, $valor ){
      $valor = $criterio == 'LIKE'? "'%$valor%'" : $valor;
      
      $sql = "SELECT id, descricao FROM ue WHERE  $campo $criterio $valor";
      
      $sqlQuery = new SqlQuery( $sql );  
           
      return $this->execute( $sqlQuery );

   }
   
        public function listaUe20(  ){
            
      $sql = "SELECT 
               id, descricao
             FROM ue 
             LIMIT 20";
      
      $sqlQuery = new SqlQuery( $sql );  
      
      return $this->execute( $sqlQuery );

   }
    
        public function existeUe($ueId){
      $sql = 'SELECT ifnull(COUNT(*),0) FROM ue WHERE id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $ueId );
      
      if( $this->querySingleResult($sqlQuery) > 0){
         return true;
      }
      return false;
   }

   /**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return UeMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM ue WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM ue';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM ue ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param ue primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM ue WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UeMySql ue
 	 */
	public function insert($ue){
		$sql = 'INSERT INTO ue (id, descricao) VALUES (?,?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($ue->id);
		$sqlQuery->set($ue->descricao);

		$this->executeInsert($sqlQuery);	
		return;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param UeMySql ue
 	 */
	public function update($ue){
		$sql = 'UPDATE ue SET descricao = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($ue->descricao);

		$sqlQuery->set($ue->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM ue';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByDescricao($value){
		$sql = 'SELECT * FROM ue WHERE descricao = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByDescricao($value){
		$sql = 'DELETE FROM ue WHERE descricao = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return UeMySql 
	 */
	protected function readRow($row){
		$ue = new Ue();
		
		$ue->id = $row['id'];
		$ue->descricao = $row['descricao'];

		return $ue;
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
	 * @return UeMySql 
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