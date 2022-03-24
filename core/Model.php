<?php

namespace Core;

use PDO;
use PDOException;

/**
 * Base model
 */
abstract class Model
{

	# atributo unico para conexao
	private static $conn;

	# atributos da tabela: nome e PK
	protected $table;
	protected $pk;
	# getters e setters
   public function getTable() { return $this->table; }
	public function getPk() { return $this->pk; }
   public function setTable($table) { $this->table = $table; }
	public function setPk($pk) { $this->pk = $pk; }

	# +----------------------------------------------------+
   # | realiza a conexao com o banco de dados             |
   # +----------------------------------------------------+
	public function dbConn() {
		# abre a conexao apenas se ainda não foi aberta
		if(self::$conn == null) {
			try {
				self::$conn =  new \PDO( DBSGBD.":host=".DBHOST.";charset=".DBCHARSET.";"."dbname=".DBNAME, DBUSER, DBPASS);
			} catch (PDOException $err) {
				return $err->getMessage();
			}
		}
		return self::$conn;
	}

	# +----------------------------------------------------+
   # | obtem todos os registros da tabela                 |
   # +----------------------------------------------------+
	public function getList() 
   {
		$result = null;
		$sql = "SELECT * FROM ".$this->getTable();
		try {
			$db = $this->dbConn();
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);	
		} catch (PDOException $err) {
			return $err->getMessage();
		}
		return $result;
   }

   # +----------------------------------------------------+
   # | obtem apenas um registro da tabela                 |
   # +----------------------------------------------------+
	public function getObject($pk)
	{
		$result = null;
		$sql = "SELECT * FROM ".$this->getTable()." WHERE ".$this->getPk()." = :pk";
		try {
			$db = $this->dbConn();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':pk', $pk, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $err) {
			return $err->getMessage();
		}
		return $result;
	}

   # +----------------------------------------------------+
   # | exclui um registro da tabela                       |
   # +----------------------------------------------------+
	public function delete($pk)
	{
		$result = null;
		$sql = "DELETE FROM ".$this->getTable()." WHERE ".$this->getPk()." = :pk";
		try {
			$db = $this->dbConn();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':pk', $pk, PDO::PARAM_INT);
			$result = $stmt->execute();	
		} catch (PDOException $err) {
			return $err->getMessage();
		}
		return $result;
	}

}
