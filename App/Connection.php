<?php

namespace App;

class Connection {

	public static function getDb() {
		echo $_SERVER["SERVER_NAME"];
		exit;
		try {

			if ($_SERVER["SERVER_NAME"] == "cannesresidence.com.br"){
				$conn = new \PDO(
					"mysql:host=mysql.cannesresidence.com.br:3306;dbname=cannesresidenc;charset=utf8",
					"cannesresi_add1",
					"Rbt824655",
					array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") 
				);
			} else {
				$conn = new \PDO(
					"mysql:host=localhost:3306;dbname=controle_de_acesso;charset=utf8",
					"root",
					"",
					array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") 
				);
			} 

			//$conn = new \PDO(
			//	"mysql:host=localhost:3306;dbname=controle_de_acesso;charset=utf8",
			//	"root",
			//	"",
			//	array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") 
			//);

			return $conn;
			
		} catch (\PDOException $e) {
			echo "<p style='color:#ff0000'>Erro: ".$e->getCode().'<br> Detalhes do erro: '.$e->getMessage()."</p>";
		}
	}
}
$conn = Connection::getDb();
?>