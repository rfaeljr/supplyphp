<?php


class NotaMovMatDAO
{

  public function existeMaterialParaNm($nmId){
      $sql = 'SELECT ifnull(COUNT(*),0) FROM nota_mov_mat WHERE nota_mov_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $nmId );
      
      if( $this->querySingleResult($sqlQuery) > 0){
         return true;
      }
      return false;
   }
   
   public function deleteByNmId( $nmId )
   {
      $sql = 'DELETE FROM nota_mov_mat WHERE nota_mov_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $nmId );
      return $this->executeUpdate( $sqlQuery );
   }

   public function load( $sequencia, $materialId, $notaMovId )
   {
      $sql = 'SELECT * FROM nota_mov_mat WHERE sequencia = ?  AND material_id = ?  AND nota_mov_id = ? ';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->setNumber( $sequencia );
      $sqlQuery->setNumber( $materialId );
      $sqlQuery->setNumber( $notaMovId );

      return $this->getRow( $sqlQuery );
   }

 
   public function queryAll()
   {
      $sql = 'SELECT * FROM nota_mov_mat';
      $sqlQuery = new SqlQuery( $sql );
      return $this->getList( $sqlQuery );
   }


   public function queryAllOrderBy( $orderColumn )
   {
      $sql = 'SELECT * FROM nota_mov_mat ORDER BY ' . $orderColumn;
      $sqlQuery = new SqlQuery( $sql );
      return $this->getList( $sqlQuery );
   }

 
   public function delete( $sequencia, $materialId, $notaMovId )
   {
      $sql = 'DELETE FROM nota_mov_mat '
           . 'WHERE sequencia = ?  AND material_id = fx_materialId(?, ?)  AND nota_mov_id = ? ';
      
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $sequencia );
      $sqlQuery->set( Funcoes::getSubstring( $materialId, ' ', '<' ) );
      $sqlQuery->set( Funcoes::getSubstring( $materialId, ' ', '>' ) );
      $sqlQuery->set( $notaMovId );
     
      return $this->executeUpdate( $sqlQuery );
   }

   /**
    * Insert record to table
    *
    * @param NotaMovMatMySql notaMovMat
    */
   public function insert( $notaMovMat )
   {
      $sql = 'INSERT INTO nota_mov_mat (quant_solicitada, '
              . 'quant_fornecida, '
              . 'vlr_unitario, '
              . 'insercao_id, '
              . 'dthora_insercao, '
              . 'alteracao_id, '
              . 'dthora_alteracao, '
              . 'sequencia, '
              . 'material_id, '
              . 'nota_mov_id)';
      $sql .= 'VALUES (?, ?, ?, ?, ?, ?, ?, '
              . '(select max(n.sequencia) + 1 from nota_mov_mat n where n.nota_mov_id = ?), '
              . 'fx_materialId(?, ?) , ?)';
      $sqlQuery = new SqlQuery( $sql );

      $sqlQuery->set( $notaMovMat->quantSolicitada );
      $sqlQuery->set( $notaMovMat->quantSolicitada );
      $sqlQuery->set( $notaMovMat->vlrUnitario );
      $sqlQuery->set( $notaMovMat->insercaoId );
      $sqlQuery->set( $notaMovMat->dthoraInsercao );
      $sqlQuery->set( $notaMovMat->alteracaoId );
      $sqlQuery->set( $notaMovMat->dthoraAlteracao );


      $sqlQuery->setNumber( $notaMovMat->notaMovId );


      $sqlQuery->set( Funcoes::getSubstring( $notaMovMat->materialId, '+', '<' ) );
      $sqlQuery->set( Funcoes::getSubstring( $notaMovMat->materialId, '+', '>' ) );

      $sqlQuery->setNumber( $notaMovMat->notaMovId );


      $id = $this->executeInsert( $sqlQuery );
      return $id;
   }

   /**
    * Update record in table
    *
    * @param NotaMovMatMySql notaMovMat
    */
   public function update( $notaMovMat )
   {
      $sql = 'UPDATE nota_mov_mat SET material_id = fx_materialId(?, ?),  quant_solicitada = ?, quant_fornecida = ?, '
                                   . 'vlr_unitario = ?, alteracao_id = ?, dthora_alteracao = ? '
           . 'WHERE sequencia = ?  AND nota_mov_id = ? ';
      $sqlQuery = new SqlQuery( $sql );

      $sqlQuery->set( Funcoes::getSubstring( $notaMovMat->materialId, '+', '<' ) );
      $sqlQuery->set( Funcoes::getSubstring( $notaMovMat->materialId, '+', '>' ) );
      
      $sqlQuery->set( $notaMovMat->quantSolicitada );
      $sqlQuery->set( $notaMovMat->quantFornecida );
      $sqlQuery->set( $notaMovMat->vlrUnitario );
      $sqlQuery->set( $notaMovMat->alteracaoId );
      $sqlQuery->set( $notaMovMat->dthoraAlteracao );
      //parametros do where
      $sqlQuery->setNumber( $notaMovMat->sequencia );
      $sqlQuery->setNumber( $notaMovMat->notaMovId );

      return $this->executeUpdate( $sqlQuery );
   }

   /**
    * Delete all rows
    */
   public function clean()
   {
      $sql = 'DELETE FROM nota_mov_mat';
      $sqlQuery = new SqlQuery( $sql );
      return $this->executeUpdate( $sqlQuery );
   }

   public function queryByQuantSolicitada( $value )
   {
      $sql = 'SELECT * FROM nota_mov_mat WHERE quant_solicitada = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function listaMateriasDaNota( $nmId )
   {
      $sql = 'SELECT * FROM nota_mov_mat WHERE nota_mov_id = ? ORDER BY sequencia';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $nmId );
      return $this->getList( $sqlQuery );
   }

   public function queryByQuantFornecida( $value )
   {
      $sql = 'SELECT * FROM nota_mov_mat WHERE quant_fornecida = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByVlrUnitario( $value )
   {
      $sql = 'SELECT * FROM nota_mov_mat WHERE vlr_unitario = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByMatriculaInsercao( $value )
   {
      $sql = 'SELECT * FROM nota_mov_mat WHERE insercao_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByDthoraInsercao( $value )
   {
      $sql = 'SELECT * FROM nota_mov_mat WHERE dthora_insercao = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByMatriculaAlteracao( $value )
   {
      $sql = 'SELECT * FROM nota_mov_mat WHERE alteracao_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByDthoraAlteracao( $value )
   {
      $sql = 'SELECT * FROM nota_mov_mat WHERE dthora_alteracao = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function deleteByQuantSolicitada( $value )
   {
      $sql = 'DELETE FROM nota_mov_mat WHERE quant_solicitada = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByQuantFornecida( $value )
   {
      $sql = 'DELETE FROM nota_mov_mat WHERE quant_fornecida = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByVlrUnitario( $value )
   {
      $sql = 'DELETE FROM nota_mov_mat WHERE vlr_unitario = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByMatriculaInsercao( $value )
   {
      $sql = 'DELETE FROM nota_mov_mat WHERE insercao_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByDthoraInsercao( $value )
   {
      $sql = 'DELETE FROM nota_mov_mat WHERE dthora_insercao = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByMatriculaAlteracao( $value )
   {
      $sql = 'DELETE FROM nota_mov_mat WHERE alteracao_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByDthoraAlteracao( $value )
   {
      $sql = 'DELETE FROM nota_mov_mat WHERE dthora_alteracao = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   /**
    * Read row
    *
    * @return NotaMovMatMySql 
    */
   protected function readRow( $row )
   {
      $notaMovMat = new NotaMovMat();

      $notaMovMat->sequencia = $row[ 'sequencia' ];
      $notaMovMat->materialId = $row[ 'material_id' ];
      $notaMovMat->notaMovId = $row[ 'nota_mov_id' ];
      $notaMovMat->quantSolicitada = $row[ 'quant_solicitada' ];
      $notaMovMat->quantFornecida = $row[ 'quant_fornecida' ];
      $notaMovMat->vlrUnitario = $row[ 'vlr_unitario' ];
      $notaMovMat->insercaoId = $row[ 'insercao_id' ];
      $notaMovMat->dthoraInsercao = $row[ 'dthora_insercao' ];
      $notaMovMat->alteracaoId = $row[ 'alteracao_id' ];
      $notaMovMat->dthoraAlteracao = $row[ 'dthora_alteracao' ];

      return $notaMovMat;
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
    * @return NotaMovMatMySql 
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