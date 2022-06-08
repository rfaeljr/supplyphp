<?php

class ViewDAO
{

   public static function permissaoFuncionalidade( $perfilId, $viewId, $funcionalidade )
   {
      $viewDao = new ViewDAO();
      $sql = 'SELECT fx_permissao(?, ?, ?)';
      $sqlQuery = new SqlQuery( $sql );

      $sqlQuery->set( $perfilId );
      $sqlQuery->set( $viewId );
      $sqlQuery->set( $funcionalidade );

      if ( $viewDao->querySingleResult( $sqlQuery ) > 0 )
      {
         return true;
      }
      return false;
   }

   public static function acessoView( $perfilId, $viewId )
   {
      $viewDao = new ViewDAO();
      $sql = 'SELECT fx_acesso_view(?, ?)';
      $sqlQuery = new SqlQuery( $sql );

      $sqlQuery->set( $perfilId );
      $sqlQuery->set( $viewId );

      if ( $viewDao->querySingleResult( $sqlQuery ) > 0 )
      {
         return true;
      }
      return false;
   }

   public function excluirView( $viewArquivo )
   {      
      $sqlQuery = new SqlQuery( 'CALL proc_excluir_view(?)' );
      $sqlQuery->set( $viewArquivo );
      
      return QueryExecutor::executarProcedure($sqlQuery);
   }
   
   
   /**
    * Get Domain object by primry key
    *
    * @param String $id primary key
    * @return ViewMySql 
    */
   public function load( $id )
   {
      $sql = 'SELECT * FROM view WHERE arquivo_nome = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $id );
      return $this->getRow( $sqlQuery );
   }

   /**
    * Get all records from table
    */
   public function queryAll()
   {
      $sql = 'SELECT * FROM view';
      $sqlQuery = new SqlQuery( $sql );
      return $this->getList( $sqlQuery );
   }

   /**
    * Get all records from table ordered by field
    *
    * @param $orderColumn column name
    */
   public function queryAllOrderBy( $orderColumn )
   {
      $sql = 'SELECT * FROM view ORDER BY ' . $orderColumn;
      $sqlQuery = new SqlQuery( $sql );
      return $this->getList( $sqlQuery );
   }

   /**
    * Delete record from table
    * @param view primary key
    */
   public function delete( $arquivo_nome )
   {
      $sql = 'DELETE FROM view WHERE arquivo_nome = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $arquivo_nome );
      return $this->executeUpdate( $sqlQuery );
   }

   /**
    * Insert record to table
    *
    * @param ViewMySql view
    */
   public function insert( $view )
   {
      $sql = 'INSERT INTO view (arquivo_nome, url, descricao) VALUES (?, ?, ?)';
      $sqlQuery = new SqlQuery( $sql );

      $sqlQuery->set( $view->arquivoNome );
      $sqlQuery->set( $view->url );
      $sqlQuery->set( $view->descricao );

      $this->executeInsert( $sqlQuery );
      
      return true;
   }

   /**
    * Update record in table
    *
    * @param ViewMySql view
    */
   public function update( $view )
   {
      $sql = 'UPDATE view SET url = ?, descricao = ? WHERE arquivo_nome = ?';
      $sqlQuery = new SqlQuery( $sql );

      $sqlQuery->set( $view->url );
      $sqlQuery->set( $view->descricao );
      $sqlQuery->set( $view->arquivoNome );
      
      return $this->executeUpdate( $sqlQuery );
   }

   /**
    * Delete all rows
    */
   public function clean()
   {
      $sql = 'DELETE FROM view';
      $sqlQuery = new SqlQuery( $sql );
      return $this->executeUpdate( $sqlQuery );
   }

   public function queryByUrl( $value )
   {
      $sql = 'SELECT * FROM view WHERE url = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByDescricao( $value )
   {
      $sql = 'SELECT * FROM view WHERE descricao = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function deleteByUrl( $value )
   {
      $sql = 'DELETE FROM view WHERE url = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByDescricao( $value )
   {
      $sql = 'DELETE FROM view WHERE descricao = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   /**
    * Read row
    *
    * @return ViewMySql 
    */
   protected function readRow( $row )
   {
      $view = new View();

      $view->arquivoNome = $row[ 'arquivo_nome' ];
      $view->url = $row[ 'url' ];
      $view->descricao = $row[ 'descricao' ];

      return $view;
   }

   protected function getList( $sqlQuery )
   {
      $tab = QueryExecutor::execute( $sqlQuery );
      $ret = array();
      for ( $i = 0; $i < count( $tab ); $i++ )
      {
         $ret[ $i ] = $this->readRow( $tab[ $i ] );
      }
      return $ret;
   }

   /**
    * Get row
    *
    * @return ViewMySql 
    */
   protected function getRow( $sqlQuery )
   {
      $tab = QueryExecutor::execute( $sqlQuery );
      if ( count( $tab ) == 0 )
      {
         return null;
      }
      return $this->readRow( $tab[ 0 ] );
   }

   /**
    * Execute sql query
    */
   protected function execute( $sqlQuery )
   {
      return QueryExecutor::execute( $sqlQuery );
   }

   /**
    * Execute sql query
    */
   protected function executeUpdate( $sqlQuery )
   {
      return QueryExecutor::executeUpdate( $sqlQuery );
   }

   /**
    * Query for one row and one column
    */
   protected function querySingleResult( $sqlQuery )
   {
      return QueryExecutor::queryForString( $sqlQuery );
   }

   /**
    * Insert row to table
    */
   protected function executeInsert( $sqlQuery )
   {
      return QueryExecutor::executeInsert( $sqlQuery );
   }

}

?>