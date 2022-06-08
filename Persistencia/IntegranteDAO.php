<?php

class IntegranteDAO {
    
   
    public function listarIntegrantes($pDado) {
        $sql  = "SELECT * FROM integrante ";
        $sql .= "WHERE matricula LIKE '%".$pDado."%' OR nome LIKE '%".$pDado."%' " ;  
        $sql .= "LIMIT 0, 10";
        $sqlQuery = new SqlQuery($sql);
        
        return $this->getList($sqlQuery);
    }

    public function load($pId) {
        $sql = 'SELECT * FROM integrante WHERE id = ? ';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->setNumber($pId);     


        return $this->getRow($sqlQuery);
    }
    

    public function existeMatricula($pMatr, $pUa){
      $sql = 'SELECT * FROM venus.integrante i 
              WHERE CONCAT(i.matricula, (SELECT a.ue_id FROM ua a WHERE a.id = i.ua_id) ) = 
                    CONCAT(?, (SELECT b.ue_id FROM ua b WHERE b.id = ?) ); ';
      $sqlQuery = new SqlQuery($sql);
      $sqlQuery->set($pMatr);    
      $sqlQuery->set($pUa); 

      return $this->getRow($sqlQuery);
    }
    

    public function getNomePorId($pId){
      $sql = 'SELECT nome FROM integrante WHERE id = ?';
      $sqlQuery = new SqlQuery($sql);
      $sqlQuery->setNumber($pId);      

      return $this->querySingleResult($sqlQuery);
    }
    
    public function getMatrPorId($pId){
      $sql = 'SELECT matricula FROM integrante WHERE id = ?';
      $sqlQuery = new SqlQuery($sql);
      $sqlQuery->setNumber($pId);      

      return $this->querySingleResult($sqlQuery);
    }
    
    public function getMatrNomePorId($pId){
      $sql = "SELECT concat(matricula, concat('=', nome)) FROM integrante WHERE id = ?";
      $sqlQuery = new SqlQuery($sql);
      $sqlQuery->setNumber($pId);      

      return $this->querySingleResult($sqlQuery);
    }
    
    public function getIdPorMatrUa($pMatr, $pUa){
      $sql = "SELECT id FROM integrante WHERE matricula = ? AND ua_id = ?";
      $sqlQuery = new SqlQuery($sql);
      $sqlQuery->setNumber($pMatr); 
      $sqlQuery->set($pUa); 

      return $this->querySingleResult($sqlQuery);
    }
    
    public function loadByNomeCPF($nome, $cpfRede) {
        $sql = "SELECT * FROM integrante WHERE nome = ?  AND lpad(cpf,11,'0') = ? ";
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->setString($nome);
        $sqlQuery->setString(Funcoes::retirarMascara($cpfRede));

        return $this->getRow($sqlQuery);
    }


    public function queryAll() {
        $sql = 'SELECT * FROM integrante';
        $sqlQuery = new SqlQuery($sql);
        return $this->getList($sqlQuery);
    }

    public function queryAllOrderBy($orderColumn) {
        $sql = 'SELECT * FROM integrante ORDER BY ' . $orderColumn;
        $sqlQuery = new SqlQuery($sql);
        return $this->getList($sqlQuery);
    }
    
    public function queryAllByMatrUaNome($xUa, $xNome) {
        $sql = "SELECT i.* FROM integrante i ";
        $sql.= "WHERE i.ua_id = ? AND i.nome LIKE ?  ORDER BY ua_id, nome";
        $sqlQuery = new SqlQuery($sql);

        $sqlQuery->set( $xUa );
        $sqlQuery->set('%'.$xNome.'%');
        
        return $this->getList($sqlQuery);
    }

    public function delete($pId) {
        $sql = 'DELETE FROM integrante WHERE id = ? ';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->setNumber($pId);

        return $this->executeUpdate($sqlQuery);
    }

    public function insert($integrante) {
        $sql = 'INSERT INTO integrante (nome, cpf, dt_admissao_foz, cargo, lider_nome, perfil_id, matricula, ua_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $sqlQuery = new SqlQuery($sql);

        $sqlQuery->set($integrante->nome);
        $sqlQuery->set($integrante->cpf);
        $sqlQuery->set($integrante->dtAdmissaoFoz);
        $sqlQuery->set($integrante->cargo);
        $sqlQuery->set($integrante->liderNome);
        $sqlQuery->set($integrante->perfilId);


        $sqlQuery->set($integrante->matricula);
        $sqlQuery->setNumber($integrante->uaId);
        $this->executeInsert($sqlQuery);

        return true;
    }

    public function update($integrante) {
        $sql = 'UPDATE integrante '
             . 'SET nome = ?, cpf = ?, dt_admissao_foz = ?, '
             . 'cargo = ?, lider_nome = ?, perfil_id = ?, matricula = ?, ua_id = ? WHERE id = ? ';
        $sqlQuery = new SqlQuery($sql);

        $sqlQuery->set($integrante->nome);
        $sqlQuery->set($integrante->cpf);
        $sqlQuery->set($integrante->dtAdmissaoFoz);
        $sqlQuery->set($integrante->cargo);
        $sqlQuery->set($integrante->liderNome);
        $sqlQuery->set($integrante->perfilId);
        $sqlQuery->set($integrante->matricula);
        $sqlQuery->setNumber($integrante->uaId);
        
        $sqlQuery->setNumber($integrante->id);
        
        $this->executeUpdate($sqlQuery);
        
        return true;
    }

    public function clean() {
        $sql = 'DELETE FROM integrante';
        $sqlQuery = new SqlQuery($sql);
        return $this->executeUpdate($sqlQuery);
    }

    public function queryByNome($value) {
        $sql = 'SELECT * FROM integrante WHERE nome = ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($value);
        return $this->getList($sqlQuery);
    }

    public function queryByCpf($value) {
        $sql = 'SELECT * FROM integrante WHERE cpf = ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($value);
        return $this->getList($sqlQuery);
    }

    public function queryByDtAdmissaoFoz($value) {
        $sql = 'SELECT * FROM integrante WHERE dt_admissao_foz = ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($value);
        return $this->getList($sqlQuery);
    }

    public function queryByCargo($value) {
        $sql = 'SELECT * FROM integrante WHERE cargo = ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($value);
        return $this->getList($sqlQuery);
    }

    public function queryByLiderNome($value) {
        $sql = 'SELECT * FROM integrante WHERE lider_nome = ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($value);
        return $this->getList($sqlQuery);
    }

    public function queryByPerfilId($value) {
        $sql = 'SELECT * FROM integrante WHERE perfil_id = ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($value);
        return $this->getList($sqlQuery);
    }

    public function deleteByNome($value) {
        $sql = 'DELETE FROM integrante WHERE nome = ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($value);
        return $this->executeUpdate($sqlQuery);
    }

    public function deleteByCpf($value) {
        $sql = 'DELETE FROM integrante WHERE cpf = ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($value);
        return $this->executeUpdate($sqlQuery);
    }

    public function deleteByDtAdmissaoFoz($value) {
        $sql = 'DELETE FROM integrante WHERE dt_admissao_foz = ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($value);
        return $this->executeUpdate($sqlQuery);
    }

    public function deleteByCargo($value) {
        $sql = 'DELETE FROM integrante WHERE cargo = ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($value);
        return $this->executeUpdate($sqlQuery);
    }

    public function deleteByLiderNome($value) {
        $sql = 'DELETE FROM integrante WHERE lider_nome = ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($value);
        return $this->executeUpdate($sqlQuery);
    }

    public function deleteByPerfilId($value) {
        $sql = 'DELETE FROM integrante WHERE perfil_id = ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($value);
        return $this->executeUpdate($sqlQuery);
    }

    protected function readRow($row) {
        $integrante = new Integrante();

        $integrante->id = $row['id'];
        $integrante->matricula = $row['matricula'];
        $integrante->uaId = $row['ua_id'];
        $integrante->nome = $row['nome'];
        $integrante->cpf = $row['cpf'];
        $integrante->dtAdmissaoFoz = $row['dt_admissao_foz'];
        $integrante->cargo = $row['cargo'];
        $integrante->liderNome = $row['lider_nome'];
        $integrante->perfilId = $row['perfil_id'];

        return $integrante;
    }

    protected function getList($sqlQuery) {
        $tab = QueryExecutor::execute($sqlQuery);
        $ret = array();
        for ($i = 0; $i < count($tab); $i++) {
            $ret[$i] = $this->readRow($tab[$i]);
        }
        return $ret;
    }

    protected function getRow($sqlQuery) {
        $tab = QueryExecutor::execute($sqlQuery);
        if (count($tab) == 0) {
            return null;
        }
        return $this->readRow($tab[0]);
    }

    protected function execute($sqlQuery) {
        return QueryExecutor::execute($sqlQuery);
    }

    protected function executeUpdate($sqlQuery) {
        return QueryExecutor::executeUpdate($sqlQuery);
    }

    protected function querySingleResult($sqlQuery) {
        return QueryExecutor::queryForString($sqlQuery);
    }

    protected function executeInsert($sqlQuery) {
        return QueryExecutor::executeInsert($sqlQuery);
    }

}

?>