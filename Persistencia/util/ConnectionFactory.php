<?php

class ConnectionFactory{
	
	
	static public function getConnection(){
		$conn = @mysql_connect(ConnectionProperty::getHost(), ConnectionProperty::getUser(), ConnectionProperty::getPassword());
		@mysql_select_db(ConnectionProperty::getDatabase());
		if(!$conn){
			throw new Exception('Não conexão com o Banco de dados.');
		}
		return $conn;
	}


	static public function close($connection){
		@mysql_close($connection);
	}
}
?>