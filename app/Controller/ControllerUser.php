<?php

namespace App\Controller;

use App\Model\ModelUser;
use Src\Classes\Util;
use Src\Classes\View;

/**
 * Classe controller do modulo User
 */
class ControllerUser extends ModelUser
{

	# codigo do modulo
	protected $modulo;
	protected function getModulo() { return $this->modulo; }
	protected function setModulo($modulo) { $this->modulo = $modulo; }

	# paginacao
	protected $pagination = array();
	protected $pageLst = array();

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
	public function iniciar($page = 1)
	{
		# verifica nivel de acesso 
		if ($_SESSION['nivel'] != ADMIN_LEVEL) {
			Util::redirecionar('/intranet');
		}
		# prepara dados para paginacao
		$tableCnt = $this->selectCount();
		Util::setPagination($tableCnt['total'], $page);
		$this->pagination = Util::getPagination();
		$this->pageLst = Util::getPageLst();
		# carrega elementos da tabela
		$lista = $this->tableByLimit($this->pagination['offset'], $this->pagination['limit']);
		try {
			# carrega parametros para a view
			$parametros = array();
			$parametros = Util::getParametros();
			$parametros['voltarClass'] = 'intranet';
			$parametros['modulo'] = $this->modulo;
			$parametros['acao'] = 'iniciar';
			$parametros['tabela'] = $this->getTabela();
			$parametros['lista'] = $lista;
			$parametros['pagination'] = $this->pagination;
			$parametros['pageLst'] = $this->pageLst;
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
		# senha deve ser criptografada (senha padrao: 1o. nome)
		$aux = explode(' ', $_POST['nome']);
		$senha = Util::clearString($aux[0]);
		$pass = password_hash($senha, PASSWORD_DEFAULT);
		# carrega parametros do POST nos atributos do Model
		$this->setNome($_POST['nome']);
		$this->setEmail($_POST['email']);
		$this->setSenha($pass);
		$this->setEndereco($_POST['endereco']);
		$this->setCidade($_POST['cidade']);
		$this->setEstado($_POST['estado']);
		$this->setCep($_POST['cep']);
		$this->setTelefone($_POST['telefone']);
		$this->setNivel($_POST['nivel']);
		# faz insert
		$result = $this->insert();
		if($result == false) {
			throw new \Exception('Problema inserindo registro no banco.');
		} else  {
			Util::redirecionar('/'.$this->modulo.'/iniciar/'.$_POST['currentPage']);
		}
	}

	# +-----------------------------------------------------------------------+
	# | recebe PK e carrega dados para a view                                 |
	# +-----------------------------------------------------------------------+
	public function alterar($pk, $page = 1)
	{
		# verifica nivel de acesso
		if ($_SESSION['nivel'] != ADMIN_LEVEL) {
			Util::redirecionar('/intranet');
		}
		# prepara dados para paginacao
		$tableCnt = $this->selectCount();
		Util::setPagination($tableCnt['total'], $page);
		$this->pagination = Util::getPagination();
		$this->pageLst = Util::getPageLst();
		# carrega elementos da tabela
		$lista = $this->tableByLimit($this->pagination['offset'], $this->pagination['limit']);
		# carrega objeto para ser alterado
		$objeto = $this->selectByPk($pk);
		try {
			# carrega parametros para a view
			$parametros = array();
			$parametros = Util::getParametros();

			$parametros['modulo'] = $this->modulo;
			$parametros['acao'] = 'alterar';
			$parametros['tabela'] = $this->getTabela();
			$parametros['voltarClass'] = $this->modulo.'/iniciar/'.$this->pagination['currentPage'];
			$parametros['voltarIcon'] = 'reply';
			$parametros['lista'] = $lista;
			$parametros['objeto'] = $objeto;
			$parametros['pagination'] = $this->pagination;
			$parametros['pageLst'] = $this->pageLst;
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
			Util::redirecionar('/'.$this->modulo.'/iniciar/'.$_POST['currentPage']);
		}
	}

	# +-----------------------------------------------------------------------+
	# | recebe uma PK para excluir da tabela                                    |
	# +-----------------------------------------------------------------------+
	public function excluir($pk, $page = 1)
	{
		$result = $this->delete($pk);
		if($result == false) {
			throw new \Exception('Problema excluindo registro do banco.');
		} else  {
			Util::redirecionar('/'.$this->modulo.'/iniciar/'.$page);
		}
	}

}
