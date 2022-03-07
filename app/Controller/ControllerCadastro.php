<?php

namespace App\Controller;

use App\Model\ModelUser;
use Src\Classes\Util;
use Src\Classes\View;

/**
 * Classe controller do modulo Cadastro
 */
class ControllerCadastro extends ModelUser
{

	# codigo do modulo
	protected $modulo;
	protected function getModulo() { return $this->modulo; }
	protected function setModulo($modulo) { $this->modulo = $modulo; }

	# +-----------------------------------------------------------------------+
	# | define parametros e variaveis do modulo e da tabela                   |
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
		# carrega os dados do usuario
		$objeto = $this->selectByPk($_SESSION['id']);
		try {
			# carrega parametros para a view
			$parametros = array();
			$parametros = Util::getParametros();
			$parametros['voltarClass'] = 'intranet';
			$parametros['modulo'] = $this->modulo;
			$parametros['acao'] = 'iniciar';
			$parametros['objeto'] = $objeto;
			View::render(Util::getPasta().'main.html', $parametros);
		} catch (Exception $e) {
			throw new \Exception($e->getMessage());
		}
	}

	# +-----------------------------------------------------------------------+
	# | recebe POST do formulario para atualizar na tabela                    |
	# +-----------------------------------------------------------------------+
	public function atualizar()
	{
		# carrega parametros do POST nos atributos do Model
		$this->setId($_POST['id']);
		$this->setNome($_POST['nome']);		
		$this->setEmail($_POST['email']);
		$this->setEndereco($_POST['endereco']);
		$this->setCidade($_POST['cidade']);
		$this->setEstado($_POST['estado']);
		$this->setCep($_POST['cep']);
		$this->setTelefone($_POST['telefone']);
		$this->setNivel($_POST['nivel']);
		# faz update
		$result = $this->update();
		if($result == false) {
			throw new \Exception('Problema gravando registro no banco.');
		} else  {
			Util::redirecionar('/intranet');
		}		
	}

}
