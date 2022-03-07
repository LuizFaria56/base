<?php

namespace App\Model;
use Src\Classes\Model;

/**
 * Classe para acesso a tabela User
 */
class ModelUser extends Model
{
	# identificacao da tabela
	protected $table = 'user';

	# atributos da tabela
	protected $id;
	protected $nome;
	protected $email;
	protected $senha;
	protected $endereco;
	protected $cidade;
	protected $estado;
	protected $cep;
	protected $telefone;
	protected $nivel;
	
	# getters e setters
	protected function getId() { return $this->id; }
	protected function getNome() { return $this->nome; }
	protected function getEmail() { return $this->email; }
	protected function getSenha() { return $this->senha; }
	protected function getEndereco() { return $this->endereco; }
	protected function getCidade() { return $this->cidade; }
	protected function getEstado() { return $this->estado; }
	protected function getCep() { return $this->cep; }
	protected function getTelefone() { return $this->telefone; }
	protected function getNivel() { return $this->nivel; }
	
	protected function setId($id) { $this->id = $id; }
	protected function setNome($nome) { $this->nome = $nome; }
	protected function setEmail($email) { $this->email = $email; }
	protected function setSenha($senha) { $this->senha = $senha; }
	protected function setEndereco($endereco) { $this->endereco = $endereco; }
	protected function setCidade($cidade) { $this->cidade = $cidade; }
	protected function setEstado($estado) { $this->estado = $estado; }
	protected function setCep($cep) { $this->cep = $cep; }
	protected function setTelefone($telefone) { $this->telefone = $telefone; }
	protected function setNivel($nivel) { $this->nivel = $nivel; }

	# +-----------------------------------------------------------------------+
	# | INSERT: funcao para inserir dados no banco                            |
	# +-----------------------------------------------------------------------+
	protected function insert()
    {
		$result = null;
		$sql = "INSERT INTO ".$this->getTabela()." (nome, email, senha, endereco, cidade, estado, cep, telefone, nivel) VALUES (:nom, :ema, :sen, :edr, :cid, :est, :cep, :tel, :niv)";
		try {
			$this->db = $this->dbConn();
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(':nom', $this->nome, \PDO::PARAM_STR);
			$stmt->bindParam(':ema', $this->email, \PDO::PARAM_STR);
			$stmt->bindParam(':sen', $this->senha, \PDO::PARAM_STR);
			$stmt->bindParam(':edr', $this->endereco, \PDO::PARAM_STR);
			$stmt->bindParam(':cid', $this->cidade, \PDO::PARAM_STR);
			$stmt->bindParam(':est', $this->estado, \PDO::PARAM_STR);
			$stmt->bindParam(':cep', $this->cep, \PDO::PARAM_INT);
			$stmt->bindParam(':tel', $this->telefone, \PDO::PARAM_STR);
			$stmt->bindParam(':niv', $this->nivel, \PDO::PARAM_INT);
			$result = $stmt->execute();
		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
		return $result;
	}

	# +-----------------------------------------------------------------------+
	# | UPDATE: funcao para atualizar dados no banco                          |
	# +-----------------------------------------------------------------------+
	protected function update()
	{
		$result = null;
		$sql = "UPDATE ".$this->getTabela()." SET nome = :nom, email = :ema, endereco = :edr, cidade = :cid, estado = :est, cep = :cep, telefone = :tel, nivel = :niv WHERE ".$this->getPk()." = :id";
		try {
			$this->db = $this->dbConn();
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);
			$stmt->bindParam(':nom', $this->nome, \PDO::PARAM_STR);
			$stmt->bindParam(':ema', $this->email, \PDO::PARAM_STR);
			$stmt->bindParam(':edr', $this->endereco, \PDO::PARAM_STR);
			$stmt->bindParam(':cid', $this->cidade, \PDO::PARAM_STR);
			$stmt->bindParam(':est', $this->estado, \PDO::PARAM_STR);
			$stmt->bindParam(':cep', $this->cep, \PDO::PARAM_INT);
			$stmt->bindParam(':tel', $this->telefone, \PDO::PARAM_STR);
			$stmt->bindParam(':niv', $this->nivel, \PDO::PARAM_INT);
			$result = $stmt->execute();
		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
		return $result;
	}

	# +-----------------------------------------------------------------------+
	# | UPDATE SENHA: funcao para alterar senha no banco                      |
	# +-----------------------------------------------------------------------+
	protected function updateSenha()
	{
		$result = null;
		$sql = "UPDATE ".$this->getTabela()." SET senha = :sn WHERE ".$this->getPk()." = :id";
		try {
			$this->db = $this->dbConn();
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);
			$stmt->bindParam(':sn', $this->senha, \PDO::PARAM_STR);
			$result = $stmt->execute();
		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
		return $result;
	}

}
