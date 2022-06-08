<?php

class RepParametroDAO
{

   public function executaQuery( $pQuery )
   {
      $xSqlQuery = new SqlQuery($pQuery);
      $xResultSet = QueryExecutor::execute( $xSqlQuery );
      $xItem = array();
      $xRet = '';
      
      for ( $i = 0; $i < count( $xResultSet ); $i++ )
      {
         $xItem[ $i ] = $xResultSet[ $i ]['id'].'='.$xResultSet[ $i ]['descricao'];
      }
      
      
      
      for($j = 0; $j < count( $xItem ); $j++){
         if( $j == 0){
            $xRet .= $xItem[$j];
            continue;            
         }
         $xRet .= ';'.$xItem[$j];
      }

      return $xRet;
   }
   
   public function executaQueryForAutoComplet( $pQuery )
   {
      $xSqlQuery = new SqlQuery($pQuery);

      $xResultSet = QueryExecutor::execute( $xSqlQuery );
      
      return $xResultSet;
   }
   
   public function load( $id )
   {
      $sql = 'SELECT * FROM rep_parametro WHERE id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $id );
      return $this->getRow( $sqlQuery );
   }

   /**
    * Get all records from table
    */
   public function queryAll()
   {
      $sql = 'SELECT * FROM rep_parametro';
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
      $sql = 'SELECT * FROM rep_parametro ORDER BY ' . $orderColumn;
      $sqlQuery = new SqlQuery( $sql );
      return $this->getList( $sqlQuery );
   }

   /**
    * Delete record from table
    * @param repParametro primary key
    */
   public function delete( $id )
   {
      $sql = 'DELETE FROM rep_parametro WHERE id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $id );
      return $this->executeUpdate( $sqlQuery );
   }

   /**
    * Insert record to table
    *
    * @param RepParametroMySql repParametro
    */
   public function insert( $repParametro )
   {
      $sql = 'INSERT INTO rep_parametro (rep_id, label, name, tipo, valor, mascara) VALUES (?, ?, ?, ?, ?, ?)';
      $sqlQuery = new SqlQuery( $sql );

      $sqlQuery->set( $repParametro->repId );
      $sqlQuery->set( $repParametro->label );
      $sqlQuery->set( $repParametro->name );
      $sqlQuery->set( $repParametro->tipo );
      $sqlQuery->set( $repParametro->valor );
      $sqlQuery->set( $repParametro->mascara );

      $id = $this->executeInsert( $sqlQuery );
      $repParametro->id = $id;
      return $id;
   }

   public function queryByRepId( $value )
   {
      $sql = 'SELECT * FROM rep_parametro WHERE rep_id = ? ORDER BY ordem';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   /**
    * Read row
    *
    * @return RepParametroMySql 
    */
   protected function readRow( $row )
   {
      $repParametro = new RepParametro();

      $repParametro->id = $row[ 'id' ];
      $repParametro->repId = $row[ 'rep_id' ];
      $repParametro->label = $row[ 'label' ];
      $repParametro->name = $row[ 'name' ];
      $repParametro->tipo = $row[ 'tipo' ];
      $repParametro->valor = $row[ 'valor' ];
      $repParametro->mascara = $row[ 'mascara' ];
      $repParametro->obrigatorio = $row[ 'obrigatorio' ];
      $repParametro->query = $row[ 'query' ];
      $repParametro->hint = $row[ 'hint' ];

      return $repParametro;
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
    * @return RepParametroMySql 
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