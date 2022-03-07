<?php

namespace Src\Classes;

use Src\Classes\Connection;

/**
 * Classe basica para as classes model
 */
abstract class Model extends Connection
{
	# atributos
	protected $tabela;
	protected $view;
	protected $pk;
	protected $fk;
	protected $orderBy;

	# metodos getters
	public function getTabela() { return $this->tabela; }
	public function getView() { return $this->view; }
	public function getPk() { return $this->pk; }
	public function getFk() { return $this->fk; }
	public function getOrderBy() { return $this->orderBy; }

	# metodos setters
	public function setTabela($tabela) { $this->tabela = $tabela; }
	public function setView($view) { $this->view = $view; }
	public function setPk($pk) { $this->pk = $pk; }
	public function setFk($fk) { $this->fk = $fk; }
	public function setOrderBy($orderBy) { $this->orderBy = $orderBy; }

    # +-----------------------------------------------------------------------+
    # | seleciona todos os registros da tabela                                |
    # +-----------------------------------------------------------------------+
	protected function selectAll()
	{
		$sql = "SELECT * FROM ".$this->getTabela()." ORDER BY ".$this->getOrderBy();
		$this->db = $this->dbConn();
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $result;		
	}

    # +-----------------------------------------------------------------------+
    # | SELECT publico: seleciona todos os registros                          |
    # +-----------------------------------------------------------------------+
	public function getList()
	{
		$list = $this->selectAll();
		return $list;
	}

    # +-----------------------------------------------------------------------+
    # | recebe PK para selecionar um unico registro da tabela                 |
    # +-----------------------------------------------------------------------+
	protected function selectByPk($pk)
	{
		$sql = "SELECT * FROM ".$this->getTabela()." WHERE ".$this->getPk()." = :pk";
		$this->db = $this->dbConn();
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':pk', $pk, \PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $result;		
	}

    # +-----------------------------------------------------------------------+
    # | recebe FK para selecionar os registro referentes a FK                 |
    # +-----------------------------------------------------------------------+
	protected function selectByFk($fk)
	{
		$sql = "SELECT * FROM ".$this->getTabela()." WHERE ".$this->getFk()." = :fk ORDER BY ".$this->getOrderBy();
		$this->db = $this->dbConn();
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':fk', $fk, \PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $result;
	}

    # +-----------------------------------------------------------------------+
    # | recebe chave e valor e seleciona os registros que atendem a condicao  |
    # +-----------------------------------------------------------------------+
	protected function selectByKey($key, $value)
	{
		$sql = "SELECT * FROM ".$this->getTabela()." WHERE ".$key." = :vl ORDER BY ".$this->getOrderBy();
		$this->db = $this->dbConn();
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':vl', $value, \PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $result;
	}

    # +-----------------------------------------------------------------------+
    # | seleciona quantidade total de registros da tabela                     |
    # +-----------------------------------------------------------------------+
	protected function selectCount()
	{
		$result = array();
		$sql = "SELECT COUNT(1) AS total FROM ".$this->getTabela();
		try {
			$this->db = $this->dbConn();
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(\PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
		return $result;
	}

    # +-----------------------------------------------------------------------+
    # | SELECT da tabela por intervalo (LIMIT)                                |
    # +-----------------------------------------------------------------------+
	protected function tableByLimit($inicio = 0, $qtd = PG_ITEMS)
	{
		$result = array();
		$sql = "SELECT * FROM ".$this->getTabela()." ORDER BY ".$this->getOrderBy()." LIMIT :ini, :qtd";
		try {
			$this->db = $this->dbConn();
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(':ini', $inicio, \PDO::PARAM_INT);
			$stmt->bindParam(':qtd', $qtd, \PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
		return $result;		
	}

    # +-----------------------------------------------------------------------+
    # | recebe PK para excluir um registro da tabela                          |
    # +-----------------------------------------------------------------------+
	protected function delete($pk)
	{
		$sql = "DELETE FROM ".$this->getTabela()." WHERE ".$this->getPk()." = :pk";
		$this->db = $this->dbConn();
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':pk', $pk, \PDO::PARAM_STR);
		$result = $stmt->execute();
        return $result;
	}

}
