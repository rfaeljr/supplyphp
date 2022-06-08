<?php

class MaterialDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return MaterialMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM material WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM material';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
       
        public function listarMateriais($pGrp, $pDescr){
         $sql  ="SELECT * FROM material ";
         $sql .="WHERE grupo LIKE '%".$pGrp."%' AND ( codigo LIKE '".$pDescr."%' OR descricao LIKE '%".$pDescr."%') " ;  
         $sql .="LIMIT 0, 100";
         $sqlQuery = new SqlQuery($sql);   
         return $this->getList($sqlQuery);                
      }
   
        public function listarTodosMateriais( $campo, $criterio, $valor ){
         $valor = $criterio == 'LIKE'? "'%$valor%'" : $valor;
         
         $sql = "SELECT id, grupo, codigo, descricao, unidade, preco_medio FROM material WHERE  $campo $criterio $valor";
         $sql .="LIMIT 0, 100";
      
         $sqlQuery = new SqlQuery( $sql );  
      
         return $this->execute( $sqlQuery );
      }

      public function listaMaterial20(  ){
            
      $sql = "SELECT 
               id, grupo, codigo, descricao, unidade, preco_medio
             FROM material 
             LIMIT 100";
      
      $sqlQuery = new SqlQuery( $sql );  
      
      return $this->execute( $sqlQuery );

   }
    
        public function existeMaterial($materialId){
      $sql = 'SELECT ifnull(COUNT(*),0) FROM material WHERE id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $materialId );
      
      if( $this->querySingleResult($sqlQuery) > 0){
         return true;
      }
      return false;
   }
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM material ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param material primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM material WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param MaterialMySql material
 	 */
	public function insert($material){
		$sql = 'INSERT INTO material (grupo, codigo, descricao, unidade, preco_medio) VALUES (?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($material->grupo);
		$sqlQuery->set($material->codigo);
		$sqlQuery->set($material->descricao);
		$sqlQuery->set($material->unidade);
		$sqlQuery->set($material->precoMedio);

		$id = $this->executeInsert($sqlQuery);	
		$material->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param MaterialMySql material
 	 */
	public function update($material){
		$sql = 'UPDATE material SET grupo = ?, codigo = ?, descricao = ?, unidade = ?, preco_medio = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($material->grupo);
		$sqlQuery->set($material->codigo);
		$sqlQuery->set($material->descricao);
		$sqlQuery->set($material->unidade);
		$sqlQuery->set($material->precoMedio);

		$sqlQuery->set($material->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM material';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByGrupo($value){
		$sql = 'SELECT * FROM material WHERE grupo = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCodigo($value){
		$sql = 'SELECT * FROM material WHERE codigo = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDescricao($value){
		$sql = 'SELECT * FROM material WHERE descricao = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUnidade($value){
		$sql = 'SELECT * FROM material WHERE unidade = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPrecoMedio($value){
		$sql = 'SELECT * FROM material WHERE preco_medio = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByGrupo($value){
		$sql = 'DELETE FROM material WHERE grupo = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCodigo($value){
		$sql = 'DELETE FROM material WHERE codigo = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDescricao($value){
		$sql = 'DELETE FROM material WHERE descricao = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUnidade($value){
		$sql = 'DELETE FROM material WHERE unidade = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPrecoMedio($value){
		$sql = 'DELETE FROM material WHERE preco_medio = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return MaterialMySql 
	 */
	protected function readRow($row){
		$material = new Material();
		
		$material->id = $row['id'];
		$material->grupo = $row['grupo'];
		$material->codigo = $row['codigo'];
		$material->descricao = $row['descricao'];
		$material->unidade = $row['unidade'];
		$material->precoMedio = $row['preco_medio'];

		return $material;
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
	 * @return MaterialMySql 
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