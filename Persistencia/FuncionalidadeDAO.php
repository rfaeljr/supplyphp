<?php

class FuncionalidadeDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return FuncionalidadeMySql 
	 */
	public function load($viewNome, $acao){
		$sql = 'SELECT * FROM funcionalidade WHERE view_arquivo_nome = ? AND acao = ?';
		$sqlQuery = new SqlQuery($sql);
		
                $sqlQuery->set($viewNome);
                $sqlQuery->set($acao);               
                
		return $this->getRow($sqlQuery);
	}
        
        public function loadById($funcId){
		$sql = 'SELECT * FROM funcionalidade WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
                
                $sqlQuery->setNumber($funcId);               
                
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM funcionalidade';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
        public function queryByPerfilPagina($xPerfil, $xPagina){
		$sql = 'SELECT f.* FROM permissao p, funcionalidade f '.
                       'WHERE p.perfil_id = ? AND p.funcionalidade_id = f.id AND f.view_arquivo_nome = ?';
		$sqlQuery = new SqlQuery($sql);
                
                $sqlQuery->set($xPerfil);
                $sqlQuery->set($xPagina);
		return $this->getList($sqlQuery);
	}
        
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM funcionalidade ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param funcionalidade primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM funcionalidade WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
                
                //Excluir os registros da tabela permissao
                $permissaoDao = new PermissaoDAO();
                $permissaoDao->deleteByFuncionalidadeId($id);
                $this->executeUpdate($sqlQuery);
                
		return true;
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param FuncionalidadeMySql funcionalidade
 	 */
	public function insert($funcionalidade){
		$sql = 'INSERT INTO funcionalidade (view_arquivo_nome, acao) VALUES (?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($funcionalidade->viewArquivoNome);
		$sqlQuery->set($funcionalidade->acao);

		$id = $this->executeInsert($sqlQuery);	
		$funcionalidade->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param FuncionalidadeMySql funcionalidade
 	 */
	public function update($funcionalidade){
		$sql = 'UPDATE funcionalidade SET view_arquivo_nome = ?, acao = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($funcionalidade->viewArquivoNome);
		$sqlQuery->set($funcionalidade->acao);
		$sqlQuery->setNumber($funcionalidade->id);
          
           	return $this->executeUpdate($sqlQuery);
	}
        


	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM funcionalidade';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByViewArquivoNome($pagina, $notIn){
		$sql = "SELECT * FROM funcionalidade WHERE view_arquivo_nome = ? AND id $notIn";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($pagina);
		return $this->getList($sqlQuery);
	}

	public function queryByAcao($value){
		$sql = 'SELECT * FROM funcionalidade WHERE acao = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByViewArquivoNome($value){
		$sql = 'DELETE FROM funcionalidade WHERE view_arquivo_nome = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByAcao($value){
		$sql = 'DELETE FROM funcionalidade WHERE acao = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return FuncionalidadeMySql 
	 */
	protected function readRow($row){
		$funcionalidade = new Funcionalidade();
		
		$funcionalidade->id = $row['id'];
		$funcionalidade->viewArquivoNome = $row['view_arquivo_nome'];
		$funcionalidade->acao = $row['acao'];

		return $funcionalidade;
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
	 * @return FuncionalidadeMySql 
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