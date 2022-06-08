<?php

class PerfilViewDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return PerfilViewMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM perfil_view WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}
        
        public function loadByPerfilPagina($xAcessoPerfil, $xAcessoPagina){
		$sql = 'SELECT * FROM perfil_view WHERE perfil_id = ? AND view_arquivo_nome = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($xAcessoPerfil);
                $sqlQuery->set($xAcessoPagina);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM perfil_view';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM perfil_view ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param perfilView primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM perfil_view WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->executeUpdate($sqlQuery);
	}
        
        public function deleteByPerfilPagina($xAcessoPerfil, $xAcessoPagina){
            $sqlQuery = new SqlQuery( 'CALL proc_excluir_perfil_view(?, ?)' );
            $sqlQuery->set( $xAcessoPerfil );
            $sqlQuery->set( $xAcessoPagina );

            return QueryExecutor::executarProcedure($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param PerfilViewMySql perfilView
 	 */
	public function insert($perfilView){
		$sql = 'INSERT INTO perfil_view (perfil_id, view_arquivo_nome) VALUES (?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($perfilView->perfilId);
		$sqlQuery->set($perfilView->viewArquivoNome);

		$id = $this->executeInsert($sqlQuery);	
		$perfilView->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param PerfilViewMySql perfilView
 	 */
	public function update($perfilView){
		$sql = 'UPDATE perfil_view SET perfil_id = ?, view_arquivo_nome = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($perfilView->perfilId);
		$sqlQuery->set($perfilView->viewArquivoNome);

		$sqlQuery->set($perfilView->id);
		return $this->executeUpdate($sqlQuery);
	}
        

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM perfil_view';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByPerfilId($value){
		$sql = 'SELECT * FROM perfil_view WHERE perfil_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}
        
        public function jaExistePerfilEView($perfil, $pagina){
		$sql = 'SELECT IFNULL(COUNT(*),0) FROM perfil_view WHERE perfil_id = ? AND view_arquivo_nome = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($perfil);
                $sqlQuery->set($pagina);
		return $this->querySingleResult($sqlQuery);
	}

	public function queryByViewArquivoNome($value){
		$sql = 'SELECT * FROM perfil_view WHERE view_arquivo_nome = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByPerfilId($value){
		$sql = 'DELETE FROM perfil_view WHERE perfil_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByViewArquivoNome($value){
		$sql = 'DELETE FROM perfil_view WHERE view_arquivo_nome = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return PerfilViewMySql 
	 */
	protected function readRow($row){
		$perfilView = new PerfilView();
		
		$perfilView->id = $row['id'];
		$perfilView->perfilId = $row['perfil_id'];
		$perfilView->viewArquivoNome = $row['view_arquivo_nome'];

		return $perfilView;
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
	 * @return PerfilViewMySql 
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