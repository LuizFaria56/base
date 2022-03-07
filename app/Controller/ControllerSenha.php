<?php

# localizacao da classe
namespace App\Controller;

# indica utilizacao das classes ModelUser, Util e View
use App\Model\ModelUser;
use Src\Classes\Util;
use Src\Classes\View;

/**
 * Classe controller do modulo Login
 */
class ControllerSenha extends ModelUser
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
	# | funcao inicial default apresenta o formulario para alteracao de senha |
	# +-----------------------------------------------------------------------+
	public function iniciar()
	{
		$objeto = $this->selectByPk($_SESSION['id']);
		try {
			# carrega parametros para a view
			$parametros = array();
			$parametros = Util::getParametros();
			$parametros['voltarClass'] = 'intranet';
			$parametros['modulo'] = $this->modulo;
			$parametros['acao'] = 'iniciar';

			View::render(Util::getPasta().'main.html', $parametros);
		} catch (Exception $e) {
			throw new \Exception($e->getMessage());
		}
	}

	# +-----------------------------------------------------------------------+
	# | funcao para gravar alteracao senha                                    |
	# +-----------------------------------------------------------------------+
	public function atualizar()
	{
		if ($_POST['confirmacao'] != $_POST['senha']) {
			Util::redirecionar('/'.$this->modulo.'/iniciar');
		}
		# senha deve ser criptografada
		$pass = password_hash($_POST['senha'], PASSWORD_DEFAULT);
		# carrega parametros do POST nos atributos do Model
		$this->setId($_POST['id']);
		$this->setSenha($pass);
		# faz update
		$result = $this->updateSenha();
		if($result == false) {
			throw new \Exception('Problema gravando registro no banco.');
		} else  {
			Util::redirecionar('/'.$this->modulo.'/iniciar');
		}		
	}

}
