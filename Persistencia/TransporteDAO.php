<?php

class TransporteDAO
{

   public function load( $id, $notaMovId )
   {
      $sql = 'SELECT * FROM transporte WHERE id = ?  AND nota_mov_id = ? ';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->setNumber( $id );
      $sqlQuery->setNumber( $notaMovId );

      return $this->getRow( $sqlQuery );
   }

   public function transporteByNmmId( $nmId )
   {
      $sql = 'SELECT * FROM transporte WHERE nota_mov_id = ? ';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->setNumber( $nmId );
      return $this->getRow( $sqlQuery );
   }

   public function deleteByNmId( $nmId )
   {
      $sql = 'DELETE FROM transporte WHERE nota_mov_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $nmId );
      return $this->executeUpdate( $sqlQuery );
   }

   /**
    * Get all records from table
    */
   public function queryAll()
   {
      $sql = 'SELECT * FROM transporte';
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
      $sql = 'SELECT * FROM transporte ORDER BY ' . $orderColumn;
      $sqlQuery = new SqlQuery( $sql );
      return $this->getList( $sqlQuery );
   }

   public function delete( $id, $notaMovId )
   {
      $sql = 'DELETE FROM transporte WHERE id = ?  AND nota_mov_id = ? ';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->setNumber( $id );
      $sqlQuery->setNumber( $notaMovId );

      return $this->executeUpdate( $sqlQuery );
   }

   public function insert( $transporte )
   {
      $sql = 'INSERT INTO transporte (transportadora, nr_viatura, nr_placa, endereco, motorista, local_entrega, nota_mov_id) '
           . 'VALUES (?, ?, ?, ?, ?, ?, ?)';
      $sqlQuery = new SqlQuery( $sql );

      $sqlQuery->set( $transporte->transportadora );
      $sqlQuery->set( $transporte->nrViatura );
      $sqlQuery->set( $transporte->nrPlaca );
      $sqlQuery->set( $transporte->endereco );
      $sqlQuery->set( $transporte->motorista );
      $sqlQuery->set( $transporte->localEntrega );
      $sqlQuery->setNumber( $transporte->notaMovId );

      $this->executeInsert( $sqlQuery );
      //$transporte->id = $id;
      //return $id;
   }

   public function update( $transporte )
   {
      $sql = 'UPDATE transporte '
           . 'SET transportadora = ?, nr_viatura = ?, nr_placa = ?, '
           . 'endereco = ?, motorista = ?, local_entrega = ? '
           . 'WHERE nota_mov_id = ? ';
      $sqlQuery = new SqlQuery( $sql );

      $sqlQuery->set( $transporte->transportadora );
      $sqlQuery->set( $transporte->nrViatura );
      $sqlQuery->set( $transporte->nrPlaca );
      $sqlQuery->set( $transporte->endereco );
      $sqlQuery->set( $transporte->motorista );
      $sqlQuery->set( $transporte->localEntrega );

      $sqlQuery->setNumber( $transporte->notaMovId );

      return $this->executeUpdate( $sqlQuery );
   }

   /**
    * Delete all rows
    */
   public function clean()
   {
      $sql = 'DELETE FROM transporte';
      $sqlQuery = new SqlQuery( $sql );
      return $this->executeUpdate( $sqlQuery );
   }

   public function queryByTransportadora( $value )
   {
      $sql = 'SELECT * FROM transporte WHERE transportadora = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByNrViatura( $value )
   {
      $sql = 'SELECT * FROM transporte WHERE nr_viatura = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByNrPlaca( $value )
   {
      $sql = 'SELECT * FROM transporte WHERE nr_placa = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByEndereco( $value )
   {
      $sql = 'SELECT * FROM transporte WHERE endereco = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByMotorista( $value )
   {
      $sql = 'SELECT * FROM transporte WHERE motorista = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByLocalEntrega( $value )
   {
      $sql = 'SELECT * FROM transporte WHERE local_entrega = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function deleteByTransportadora( $value )
   {
      $sql = 'DELETE FROM transporte WHERE transportadora = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByNrViatura( $value )
   {
      $sql = 'DELETE FROM transporte WHERE nr_viatura = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByNrPlaca( $value )
   {
      $sql = 'DELETE FROM transporte WHERE nr_placa = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByEndereco( $value )
   {
      $sql = 'DELETE FROM transporte WHERE endereco = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByMotorista( $value )
   {
      $sql = 'DELETE FROM transporte WHERE motorista = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByLocalEntrega( $value )
   {
      $sql = 'DELETE FROM transporte WHERE local_entrega = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   /**
    * Read row
    *
    * @return TransporteMySql 
    */
   protected function readRow( $row )
   {
      $transporte = new Transporte();

      $transporte->id = $row[ 'id' ];
      $transporte->transportadora = $row[ 'transportadora' ];
      $transporte->nrViatura = $row[ 'nr_viatura' ];
      $transporte->nrPlaca = $row[ 'nr_placa' ];
      $transporte->endereco = $row[ 'endereco' ];
      $transporte->motorista = $row[ 'motorista' ];
      $transporte->localEntrega = $row[ 'local_entrega' ];
      $transporte->notaMovId = $row[ 'nota_mov_id' ];

      return $transporte;
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
    * @return TransporteMySql 
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