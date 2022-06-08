<?php

class NotaMovDAO
{
   
   public function alterarStatus($nmId, $status, $dtHora, $integranteId){
      $sql = 'UPDATE nota_mov SET status = ?, dthora_alteracao = ?, alteracao_id = ? WHERE id = ?';
      $sqlQuery = new SqlQuery( $sql );

      $sqlQuery->set( $status );
      $sqlQuery->set( $dtHora );
      $sqlQuery->set( $integranteId );
      $sqlQuery->set( $nmId );
      
      $flag = $this->executeUpdate( $sqlQuery );
     
      return ($flag > 0);
   }
   
   public function listaNotaMov( $pNm, $pNf, $pSe, $pDtSolicitacao, $pListaNat, $pListaStatus ){
      $usuario = new Usuario();
      $usuario = Funcoes::getUsuario();
      $sql = "";
      
      $sql .= "SELECT 
                  id, 
                  notafiscal_num,
                  notafiscal_dtlancamento,
                  se_num,
                  IFNULL( DTHORA_SOLICITACAO, 0 ) AS dthora_solicitacao, 
                  IFNULL( DTHORA_ENTREGA, 0) AS dthora_entrega, 
                  solicitado_por_id, 
                  status,
                  fx_getNaturezaNm(ID) AS natureza,
                  IFNULL( ( SELECT CONCAT(CONCAT(U.UA_ALIAS,'='), U.DESCRICAO) FROM UA U WHERE U.ID = UA_ORIGEM_ID ), 'UA ORIGEM -SEM CADASTRO') AS ua_origem_id, 
                  IFNULL(( SELECT CONCAT(CONCAT(U.UA_ALIAS,'='), U.DESCRICAO) FROM UA U WHERE U.ID = UA_DESTINO_ID ), 'UA DESTINO -SEM CADASTRO') AS ua_destino_id,  
                  IFNULL( (SELECT IFNULL( SUM(QUANT_FORNECIDA * VLR_UNITARIO), 0.0) FROM NOTA_MOV_MAT N 
                  WHERE N.NOTA_MOV_ID = ID), 0) valor_total 
               FROM NOTA_MOV 
               WHERE ID LIKE '%$pNm%' AND
                     DTHORA_SOLICITACAO LIKE '%".Funcoes::formataDtDB($pDtSolicitacao)."%' ";
      
	  if($pNf != '' || $pNf != null){
		  $sql .= " AND notafiscal_num LIKE '$pNf' ";		  
	  } 

	  if($pSe != '' || $pSe != null){
		  $sql .= " AND se_num LIKE '$pSe' ";		  
	  } 
	  
      if($pListaNat != null){
         $sql .= " AND NATUREZA IN($pListaNat) ";
      }
      
      if($pListaStatus != null){
         $sql .= " AND STATUS IN($pListaStatus) ";
      }

      
      
      if( $usuario->perfilPermissao == 'COMUM' ){
         $sql .= " AND (INSERCAO_ID = $usuario->integranteId) ";
      }
      
      $sql .= "ORDER BY ID LIMIT 600 ";
      
      $sqlQuery = new SqlQuery( $sql ); 
      
      return $this->execute( $sqlQuery );

   }
   
   public function listaNotaMov40(  ){
      $usuario = new Usuario();
      $usuario = Funcoes::getUsuario();
      $sql = "";
            
      $sql = "SELECT 
               id,
               notafiscal_num,
               notafiscal_dtlancamento,
               se_num,
               ifnull( dthora_solicitacao,0 ) as dthora_solicitacao, 
               ifnull( dthora_entrega, 0) as dthora_entrega, 
               solicitado_por_id, 
               status,
               fx_getNaturezaNm(ID) as natureza, 
               ( select concat(concat(u.ua_alias,'='), u.descricao) from ua u where u.id = ua_origem_id ) as ua_origem_id, 
               ( select concat(concat(u.ua_alias,'='), u.descricao) from ua u where u.id = ua_destino_id ) as ua_destino_id, 
               (select ifnull( sum(quant_fornecida * vlr_unitario), 0.0) from nota_mov_mat n 
                where n.nota_mov_id = id) valor_total 
             FROM nota_mov 
             WHERE id >= (select abs(ifnull(max(nm.id),0) - 40) from nota_mov nm)";
      
      if( $usuario->perfilPermissao == 'COMUM' ){
         $sql .= " AND (insercao_id = $usuario->integranteId) ";
      }
      
      $sql .=" ORDER BY ID LIMIT 120 ";   
      
      
      $sqlQuery = new SqlQuery( $sql );  
      
      return $this->execute( $sqlQuery );

   }
   
   public function existeNm($nmId){
      $sql = 'SELECT ifnull(COUNT(*),0) FROM nota_mov WHERE id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $nmId );
      
      if( $this->querySingleResult($sqlQuery) > 0){
         return true;
      }
      return false;
   }


   
   /**
    * Get Domain object by primry key
    *
    * @param String $id primary key
    * @return NotaMovMySql 
    */
   public function load( $id )
   {
      $sql = 'SELECT * FROM nota_mov WHERE id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $id );
      return $this->getRow( $sqlQuery );
   }

   /**
    * Get all records from table
    */
   public function queryAll()
   {
      $sql = 'SELECT * FROM nota_mov';
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
      $sql = 'SELECT * FROM nota_mov ORDER BY ' . $orderColumn;
      $sqlQuery = new SqlQuery( $sql );
      return $this->getList( $sqlQuery );
   }

   public function delete( $nmId )
   {
      $transporteDao = new TransporteDAO();
      $notaMovMatDao = new NotaMovMatDAO();
      $infoMercadoriaDao = new InfoMercadoriaDAO();
      $flagQuant = 0;
      
      //Exclusão dos registros filhos
      /** Tabela transporte **/
      $transporteDao->deleteByNmId($nmId);      
      
      /** Tabela materias da nota **/
      $notaMovMatDao->deleteByNmId($nmId);
      
      /** Tabela informação da mercadoria **/
      $infoMercadoriaDao->deleteByNmId($nmId);

                
      $sql = 'DELETE FROM nota_mov WHERE id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $nmId );      
      $flagQuant = $this->executeUpdate( $sqlQuery );
      
      return ($flagQuant > 0? true : false);
   }

   /**
    * Insert record to table
    *
    * @param NotaMovMySql notaMov
    */
   public function insert( $notaMov, $transporte )
   {
      $sql = 'INSERT INTO nota_mov '
           . '(ua_origem_id, ua_destino_id, solicitado_por_id, '
           . 'responsavel_id, autorizado_por_id, status, '
           . 'fonte_recurso, natureza, sistema, '
           . 'dthora_solicitacao, dthora_autorizacao, dthora_entrega, '
           . 'dthora_recebido, recebido_por_nome, recebido_por_id, '
           . 'entregue_por_nome, entregue_por_id, informacoes_complementares, '
           . 'insercao_id, dthora_insercao, dthora_alteracao, alteracao_id, notafiscal_num, se_num, notafiscal_dtlancamento) '
           . 'VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
      $sqlQuery = new SqlQuery( $sql );

      $sqlQuery->set( $notaMov->uaOrigemId );
      $sqlQuery->set( $notaMov->uaDestinoId );
      $sqlQuery->set( $notaMov->requisitadoPorId );
      $sqlQuery->set( $notaMov->responsavelId );
      $sqlQuery->set( $notaMov->autorizadoPorId );
      $sqlQuery->set( $notaMov->status );
      $sqlQuery->set( $notaMov->fonteRecurso );
      $sqlQuery->set( $notaMov->natureza );
      $sqlQuery->set( $notaMov->sistema );
      $sqlQuery->set( $notaMov->dthoraSolicitacao );
      $sqlQuery->set( $notaMov->dthoraAutorizacao );
      $sqlQuery->set( $notaMov->dthoraEntrega );
      $sqlQuery->set( $notaMov->dthoraRecebido );
      $sqlQuery->set( $notaMov->recebidoPorNome );
      $sqlQuery->set( $notaMov->recebidoPorId );
      $sqlQuery->set( $notaMov->entreguePorNome );
      $sqlQuery->set( $notaMov->entreguePorId );
      $sqlQuery->set( $notaMov->informacoesComplementares );
      $sqlQuery->set( $notaMov->insercaoId );
      $sqlQuery->set( $notaMov->dthoraInsercao );
      $sqlQuery->set( $notaMov->dthoraAlteracao );
      $sqlQuery->set( $notaMov->alteracaoId );
      $sqlQuery->set( $notaMov->notafiscalNum );      
      $sqlQuery->set( $notaMov->seNum );
      $sqlQuery->set( $notaMov->notafiscalDtLancamento );
      
      //inserção da NM
      $nmId = ( $this->executeInsert( $sqlQuery ) );
            
      //inserção do transporte
      if($nmId > 0){         
         $transporte->notaMovId = $nmId;
         $trasporteDao = new TransporteDAO();
         
         $flagTransporte = false;
         
         $flagTransporte = trim($transporte->transportadora .
                           $transporte->nrViatura .
                           $transporte->nrPlaca .
                           $transporte->endereco .
                           $transporte->motorista .
                           $transporte->localEntrega);
         
         $flagTransporte = Funcoes::isNuloVazioNaoSetado($flagTransporte);
         
         if( $flagTransporte == false ){
            $trasporteDao->insert($transporte);         
         }
      }
      
      
      return $nmId;
   }

   /**
    * Update record in table
    *
    * @param NotaMovMySql notaMov
    */
   public function update( $notaMov, $transporte )
   {
      $sql = 'UPDATE nota_mov '
           . 'SET ua_origem_id = ?, ua_destino_id = ?, solicitado_por_id = ?, '
           . 'responsavel_id = ?, autorizado_por_id = ?, status = ?, '
           . 'fonte_recurso = ?, natureza = ?, sistema = ?, '
           . 'dthora_solicitacao = ?, dthora_autorizacao = ?, dthora_entrega = ?, '
           . 'dthora_recebido = ?, recebido_por_nome = ?, recebido_por_id = ?, '
           . 'entregue_por_nome = ?, entregue_por_id = ?, informacoes_complementares = ?, '
           . 'dthora_alteracao = ?, alteracao_id = ?, notafiscal_num = ?, se_num = ?, notafiscal_dtlancamento = ? '
           . 'WHERE id = ?';
      $sqlQuery = new SqlQuery( $sql );

      $sqlQuery->set( $notaMov->uaOrigemId );
      $sqlQuery->set( $notaMov->uaDestinoId );
      $sqlQuery->set( $notaMov->requisitadoPorId );
      $sqlQuery->set( $notaMov->responsavelId );
      $sqlQuery->set( $notaMov->autorizadoPorId );
      $sqlQuery->set( $notaMov->status );
      $sqlQuery->set( $notaMov->fonteRecurso );
      $sqlQuery->set( $notaMov->natureza );
      $sqlQuery->set( $notaMov->sistema );
      $sqlQuery->set( $notaMov->dthoraSolicitacao );
      $sqlQuery->set( $notaMov->dthoraAutorizacao );
      $sqlQuery->set( $notaMov->dthoraEntrega );
      $sqlQuery->set( $notaMov->dthoraRecebido );
      $sqlQuery->set( $notaMov->recebidoPorNome );
      $sqlQuery->set( $notaMov->recebidoPorId );
      $sqlQuery->set( $notaMov->entreguePorNome );
      $sqlQuery->set( $notaMov->entreguePorId );
      $sqlQuery->set( $notaMov->informacoesComplementares );
      //$sqlQuery->set( $notaMov->insercaoId );
      //$sqlQuery->set( $notaMov->dthoraInsercao );
      $sqlQuery->set( $notaMov->dthoraAlteracao );
      $sqlQuery->set( $notaMov->alteracaoId );
      $sqlQuery->set( $notaMov->notafiscalNum );
      $sqlQuery->set( $notaMov->seNum );
      $sqlQuery->set( $notaMov->notafiscalDtLancamento );

      $sqlQuery->set( $notaMov->id );
      $this->executeUpdate( $sqlQuery );
      
      //alteração do transporte
      $transporte->notaMovId = $notaMov->id;
      $trasporteDao = new TransporteDAO();
      $trasporteDao->update($transporte);
      
      return;
   }

   /**
    * Delete all rows
    */
   public function clean()
   {
      $sql = 'DELETE FROM nota_mov';
      $sqlQuery = new SqlQuery( $sql );
      return $this->executeUpdate( $sqlQuery );
   }

   public function queryByUaOrigem( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE ua_origem_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByUaDestino( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE ua_destino_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryBySolicitadoPorMatricula( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE solicitado_por_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByResponsavelMatricula( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE responsavel_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByAutorizadoPorMatricula( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE autorizado_por_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByStatus( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE status = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByFonteRecurso( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE fonte_recurso = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByNatureza( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE natureza = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryBySistema( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE sistema = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByDthoraSolicitacao( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE dthora_solicitacao = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByDthoraAutorizacao( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE dthora_autorizacao = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByDthoraEntrega( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE dthora_entrega = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByDthoraRecebido( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE dthora_recebido = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByRecebidoPorNome( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE recebido_por_nome = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByRecebidoPorMatricula( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE recebido_por_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByEntreguePorNome( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE entregue_por_nome = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByEntreguePorMatricula( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE entregue_por_matricula = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByInformacoesComplementares( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE informacoes_complementares = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByMatriculaInsercao( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE insercao_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByDthoraInsercao( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE dthora_insercao = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByDthoraAlteracao( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE dthora_alteracao = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function queryByMatriculaAlteracao( $value )
   {
      $sql = 'SELECT * FROM nota_mov WHERE alteracao_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->getList( $sqlQuery );
   }

   public function deleteByUaOrigem( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE ua_origem_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByUaDestino( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE ua_destino_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteBySolicitadoPorMatricula( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE solicitado_por_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByResponsavelMatricula( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE responsavel_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByAutorizadoPorMatricula( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE autorizado_por_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByStatus( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE status = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByFonteRecurso( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE fonte_recurso = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByNatureza( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE natureza = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteBySistema( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE sistema = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByDthoraSolicitacao( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE dthora_solicitacao = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByDthoraAutorizacao( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE dthora_autorizacao = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByDthoraEntrega( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE dthora_entrega = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByDthoraRecebido( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE dthora_recebido = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByRecebidoPorNome( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE recebido_por_nome = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByRecebidoPorMatricula( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE recebido_por_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByEntreguePorNome( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE entregue_por_nome = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByEntreguePorMatricula( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE entregue_por_matricula = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByInformacoesComplementares( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE informacoes_complementares = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByMatriculaInsercao( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE insercao_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByDthoraInsercao( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE dthora_insercao = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByDthoraAlteracao( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE dthora_alteracao = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   public function deleteByMatriculaAlteracao( $value )
   {
      $sql = 'DELETE FROM nota_mov WHERE alteracao_id = ?';
      $sqlQuery = new SqlQuery( $sql );
      $sqlQuery->set( $value );
      return $this->executeUpdate( $sqlQuery );
   }

   /**
    * Read row
    *
    * @return NotaMovMySql 
    */
   protected function readRow( $row )
   {
      $notaMov = new NotaMov();

      $notaMov->id = $row[ 'id' ];
      $notaMov->uaOrigemId = $row[ 'ua_origem_id' ];
      $notaMov->uaDestinoId = $row[ 'ua_destino_id' ];
      $notaMov->requisitadoPorId = $row[ 'solicitado_por_id' ];
      $notaMov->responsavelId = $row[ 'responsavel_id' ];
      $notaMov->autorizadoPorId = $row[ 'autorizado_por_id' ];
      $notaMov->status = $row[ 'status' ];
      $notaMov->fonteRecurso = $row[ 'fonte_recurso' ];
      $notaMov->natureza = $row[ 'natureza' ];
      $notaMov->sistema = $row[ 'sistema' ];
      $notaMov->dthoraSolicitacao = $row[ 'dthora_solicitacao' ];
      $notaMov->dthoraAutorizacao = $row[ 'dthora_autorizacao' ];
      $notaMov->dthoraEntrega = $row[ 'dthora_entrega' ];
      $notaMov->dthoraRecebido = $row[ 'dthora_recebido' ];
      $notaMov->recebidoPorNome = $row[ 'recebido_por_nome' ];
      $notaMov->recebidoPorId = $row[ 'recebido_por_id' ];
      $notaMov->entreguePorNome = $row[ 'entregue_por_nome' ];
      $notaMov->entreguePorId = $row[ 'entregue_por_id' ];
      $notaMov->informacoesComplementares = $row[ 'informacoes_complementares' ];
      $notaMov->insercaoId = $row[ 'insercao_id' ];
      $notaMov->dthoraInsercao = $row[ 'dthora_insercao' ];
      $notaMov->dthoraAlteracao = $row[ 'dthora_alteracao' ];
      $notaMov->alteracaoId = $row[ 'alteracao_id' ];
      $notaMov->notafiscalNum = $row[ 'notafiscal_num' ];
      $notaMov->notafiscalDtLancamento = $row[ 'notafiscal_dtlancamento' ];
      $notaMov->seNum = $row[ 'se_num' ];

      return $notaMov;
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
    * @return NotaMovMySql 
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