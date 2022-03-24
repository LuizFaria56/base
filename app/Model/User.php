<?php

namespace App\Model;

use PDO;
use PDOException;
use Core\Model;

class User extends Model
{
	
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
	public function getId() { return $this->id; }
	public function getNome() { return $this->nome; }
	public function getEmail() { return $this->email; }
	public function getSenha() { return $this->senha; }
	public function getEndereco() { return $this->endereco; }
	public function getCidade() { return $this->cidade; }
	public function getEstado() { return $this->estado; }
	public function getCep() { return $this->cep; }
	public function getTelefone() { return $this->telefone; }
	public function getNivel() { return $this->nivel; }
	
	public function setId($id) { $this->id = $id; }
	public function setNome($nome) { $this->nome = $nome; }
	public function setEmail($email) { $this->email = $email; }
	public function setSenha($senha) { $this->senha = $senha; }
	public function setEndereco($endereco) { $this->endereco = $endereco; }
	public function setCidade($cidade) { $this->cidade = $cidade; }
	public function setEstado($estado) { $this->estado = $estado; }
	public function setCep($cep) { $this->cep = $cep; }
	public function setTelefone($telefone) { $this->telefone = $telefone; }
	public function setNivel($nivel) { $this->nivel = $nivel; }
	
    # +----------------------------------------------------+
    # | construtor: inicia variaveis para a tabela         |
    # +----------------------------------------------------+
	 public function __construct()
	{
		$this->setTable('user');
		$this->setPk('id');
	}
	
    # +----------------------------------------------------+
    # | insere dados minimos da pagina de registro         |
    # +----------------------------------------------------+
	 public function register()
	{
		$result = null;
		$sql = "INSERT INTO ".$this->getTable()." (nome, email, senha, nivel) VALUES (:nome, :email, :senha, :nivel)";
		try {
			$db = $this->dbConn();
			$stmt = $db->prepare($sql);
	        $stmt->bindParam(':nome', $this->nome, PDO::PARAM_STR);
	        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
	        $stmt->bindParam(':senha', $this->senha, PDO::PARAM_STR);
	        $stmt->bindParam(':nivel', $this->nivel, PDO::PARAM_INT);
        	$result = $stmt->execute();
      } catch (PDOException $err) {
			return $err->getMessage();
		}
      return $result;
	}

    # +----------------------------------------------------+
    # | insere dados completos da pagina de cadastro       |
    # +----------------------------------------------------+
	 public function insert()
	{
		$result = null;
		$sql = "INSERT INTO ".$this->getTable()." (nome, email, senha, endereco, cidade, estado, cep, telefone, nivel) VALUES (:nome, :email, :senha, :endereco, :cidade, :estado, :cep, :telefone, :nivel)";
		try {
			$db = $this->dbConn();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':nome', $this->nome, PDO::PARAM_STR);
			$stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
			$stmt->bindParam(':senha', $this->senha, PDO::PARAM_STR);
			$stmt->bindParam(':endereco', $this->endereco, PDO::PARAM_STR);
			$stmt->bindParam(':cidade', $this->cidade, PDO::PARAM_STR);
			$stmt->bindParam(':estado', $this->estado, PDO::PARAM_STR);
			$stmt->bindParam(':cep', $this->cep, PDO::PARAM_STR);
			$stmt->bindParam(':telefone', $this->telefone, PDO::PARAM_STR);
			$stmt->bindParam(':nivel', $this->nivel, PDO::PARAM_INT);
        	$result = $stmt->execute();
      } catch (PDOException $err) {
			return $err->getMessage();
		}
      return $result;
	}

    # +----------------------------------------------------+
    # | atualiza dados cadastrados                         |
    # +----------------------------------------------------+
	 public function update()
	{
		$result = null;
		$sql = "UPDATE ".$this->getTable()." SET nome = :nome, email = :email, endereco = :endereco, cidade = :cidade, estado = :estado, cep = :cep, telefone = :telefone, nivel = :nivel WHERE ".$this->getPk()." = :pk";
		try {
			$db = $this->dbConn();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':nome', $this->nome, PDO::PARAM_STR);
			$stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
			$stmt->bindParam(':endereco', $this->endereco, PDO::PARAM_STR);
			$stmt->bindParam(':cidade', $this->cidade, PDO::PARAM_STR);
			$stmt->bindParam(':estado', $this->estado, PDO::PARAM_STR);
			$stmt->bindParam(':cep', $this->cep, PDO::PARAM_STR);
			$stmt->bindParam(':telefone', $this->telefone, PDO::PARAM_STR);
			$stmt->bindParam(':nivel', $this->nivel, PDO::PARAM_INT);
			$stmt->bindParam(':pk', $this->id, PDO::PARAM_INT);
        	$result = $stmt->execute();
      } catch (PDOException $err) {
			return $err->getMessage();
		}
      return $result;
	}

	# +----------------------------------------------------+
   # | atualiza senha                                     |
   # +----------------------------------------------------+
	public function updateSenha()
	{
		$result = null;
		$sql = "UPDATE ".$this->getTable()." SET senha = :senha WHERE ".$this->getPk()." = :pk";
		try {
			$db = $this->dbConn();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':senha', $this->senha, PDO::PARAM_STR);
			$stmt->bindParam(':pk', $this->id, PDO::PARAM_INT);
        	$result = $stmt->execute();
      } catch (PDOException $err) {
			return $err->getMessage();
		}
      return $result;
	}

	public function getByEmail($email)
	{
		$result = null;
		$sql = "SELECT * FROM ".$this->getTable()." WHERE email = :email";
		try {
			$db = $this->dbConn();
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $err) {
			return $err->getMessage();
		}
		return $result;
	}

}