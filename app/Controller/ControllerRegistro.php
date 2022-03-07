<?php

namespace App\Controller;

use App\Model\ModelUser;
use Src\Classes\Util;
use Src\Classes\View;

/**
 * Classe controller do modulo Registro
 */
class ControllerRegistro extends ModelUser
{

	# codigo do modulo
	protected $modulo;
	protected function getModulo() { return $this->modulo; }
	protected function setModulo($modulo) { $this->modulo = $modulo; }

	# +-----------------------------------------------------------------------+
	# | construtor: define variaveis do modulo e tabela e parametros da view  |
	# +-----------------------------------------------------------------------+
	public function __construct()
	{
		$this->modulo = Util::getModulo();
		Util::setModuleValues();
		Util::setParametros();

		# usa o codigo da tabela
		$tb = $this->table;
		$table = Util::getTableAttribute($tb);
		$this->setTabela($table['table']);
		$this->setView($table['view']);
		$this->setPk($table['pk']);
		$this->setFk($table['fk']);
		$this->setOrderBy($table['orderBy']);
	}

	# +-----------------------------------------------------------------------+
	# | metodo inicial: remete a pagina inicial                               |
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
	# | resebe um POST do formulario para inserir na tabela                   |
	# +-----------------------------------------------------------------------+
	public function adicionar()
	{
		# senha deve ser criptografada
		$pass = password_hash($_POST['senha'], PASSWORD_DEFAULT);
		# carrega parametros do POST nos atributos do Model
		$this->setNome($_POST['nome']);
		$this->setEmail($_POST['email']);
		$this->setSenha($pass);
		# os visitantes terao sempre nivel de acesso basico
		$this->setNivel(USER_LEVEL);
		# faz insert
		$result = $this->insert();
		if($result == false) {
			throw new \Exception('Problema inserindo registro no banco.');
		} else  {
			Util::redirecionar('/'.$this->modulo.'/iniciar');
		}
	}

}
