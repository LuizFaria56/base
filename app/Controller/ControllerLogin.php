<?php

# localizacao da classe
namespace App\Controller;

# indica utilizacao das classes ModelUser, Util e View
use App\Model\ModelUser;
use Src\Classes\Util;
use Src\Classes\View;

/**
 * classe controller do modulo login
 */ 
class ControllerLogin extends ModelUser
{

	# codigo do modulo
	protected $modulo;
	protected function getModulo() { return $this->modulo; }
	protected function setModulo($modulo) { $this->modulo = $modulo; }

	# +-----------------------------------------------------------------------+
	# | construtor: define variaveis do modulo e parametros da view           |
	# +-----------------------------------------------------------------------+
	public function __construct()
	{
		$this->modulo = Util::getModulo();
		Util::setModuleValues();
		Util::setParametros();
		$tb = $this->table;
		$table = Util::getTableAttribute($tb);
		$this->setTabela($table['table']);
		$this->setView($table['view']);
		$this->setPk($table['pk']);
		$this->setFk($table['fk']);
		$this->setOrderBy($table['orderBy']);
	}

	# +-----------------------------------------------------------------------+
	# | funcao inicial default apresenta o formulario de login                |
	# +-----------------------------------------------------------------------+
	public function iniciar()
	{
		try {
			# carrega parametros para a view
			$parametros = array();
			$parametros = Util::getParametros();

			$parametros['modulo'] = $this->modulo;
			$parametros['acao'] = 'iniciar';

			View::render(Util::getPasta().'main.html', $parametros);
		} catch (Exception $e) {
			throw new \Exception($e->getMessage());
		}
	}

	# +-----------------------------------------------------------------------+
	# | funcao para validar email/senha                                       |
	# +-----------------------------------------------------------------------+
	public function validar()
	{
		$user = $this->selectByKey('email', $_POST['email']);
		$obj = $user[0];
		if (password_verify($_POST['senha'], $obj['senha'])) {
			$_SESSION['id'] = $obj['id'];
			$_SESSION['nome'] = $obj['nome'];
			$_SESSION['email'] = $obj['email'];
			$_SESSION['nivel'] = $obj['nivel'];
			$_SESSION['modulo'] = $this->modulo;
			$_SESSION['acao'] = 'validar';
			Util::redirecionar('/intranet');
		} else {
			Util::redirecionar('/'.$this->modulo);
		}
	}

}
