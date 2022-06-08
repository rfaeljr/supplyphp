<?php

class UaDAO{

      public function listarUas($pValor){
         $sql  ="SELECT * FROM ua ";
         $sql .="WHERE ua_alias LIKE '%".$pValor."%' OR descricao LIKE '%".$pValor."%' OR ue_id LIKE '%".$pValor."%' " ;  
         $sql .="LIMIT 0, 30";
         $sqlQuery = new SqlQuery($sql);   
         return $this->getList($sqlQuery);                
      }

      public function listaUa( $campo, $criterio, $valor ){
       $valor = $criterio == 'LIKE'? "'%$valor%'" : $valor;

       $sql = "SELECT id, descricao, ua_alias, ue_id FROM ua WHERE  $campo $criterio $valor";

       $sqlQuery = new SqlQuery( $sql );  

       return $this->execute( $sqlQuery );

    }

      public function listaUa20(  ){

       $sql = "SELECT 
                id, descricao, ua_alias, ue_id
              FROM ua
              LIMIT 20";

       $sqlQuery = new SqlQuery( $sql );  

       return $this->execute( $sqlQuery );

    }

      public function existeUa($uaId){
       $sql = 'SELECT ifnull(COUNT(*),0) FROM ua WHERE id = ?';
       $sqlQuery = new SqlQuery( $sql );
       $sqlQuery->set( $uaId );

       if( $this->querySingleResult($sqlQuery) > 0){
          return true;
       }
       return false;
    }
      
   
	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return UaMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM ua WHERE id = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM ua';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM ua ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param ua primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM ua WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UaMySql ua
 	 */
	public function insert($ua){
		$sql = 'INSERT INTO ua ( ua_alias, ue_id, descricao) VALUES ( ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		
//		$sqlQuery->setNumber($ua->id);
                $sqlQuery->set($ua->uaAlias);
		$sqlQuery->set($ua->ueId);
		$sqlQuery->set($ua->descricao);

		return $this->executeInsert($sqlQuery);	
		//$ua->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param UaMySql ua
 	 */
	public function update($ua){
		$sql = 'UPDATE ua SET ua_alias = ?, ue_id = ?, descricao = ?  WHERE  id = ? ';
		$sqlQuery = new SqlQuery($sql);
		

		
                $sqlQuery->set($ua->uaAlias);
		$sqlQuery->set($ua->ueId);
		$sqlQuery->set($ua->descricao);
		$sqlQuery->setNumber($ua->id);
                
		return $this->executeUpdate($sqlQuery);
//                return $sqlQuery->getQuery();
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM ua';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}



	
	/**
	 * Read row
	 *
	 * @return UaMySql 
	 */
	protected function readRow($row){
		$ua = new Ua();
		
		$ua->id = $row['id'];
                $ua->uaAlias = $row['ua_alias'];
		$ua->ueId = $row['ue_id'];
		$ua->descricao = $row['descricao'];

		return $ua;
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
	 * @return UaMySql 
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