<?php

# localizacao da classe
namespace App\Controller;

# indica utilizacao das classes Util e View
use Src\Classes\Util;
use Src\Classes\View;

/**
 * Classe controller do modulo Intranet
 */ 
class ControllerIntranet
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
	}

	# +-----------------------------------------------------------------------+
	# | remete a pagina inicial da area restrita                              |
	# +-----------------------------------------------------------------------+
	public function iniciar()
	{
		# verifica se a sessao esta ativa
		if(!isset($_SESSION['id'])) {
			Util::redirecionar('/home');
		}
		try {
			# carregar parametros para a view
			$parametros = array();
			$parametros = Util::getParametros();
			$parametros['voltarClass'] = 'intranet';
			$parametros['modulo'] = $this->modulo;
			$parametros['acao'] = 'iniciar';
			$parametros['subtitulo'] = 'Usuário: '.$_SESSION['nome'];

			$_SESSION['modulo'] = $this->modulo;
			$_SESSION['acao'] = 'iniciar';

			# chama a view principal (main.html)
			View::render(Util::getPasta().'main.html', $parametros);
		} catch (Exception $e) {
			throw new \Exception($e->getMessage());
		}
	}

	# +-----------------------------------------------------------------------+
	# | Logout: encerrar sessao e voltar para a pagina inicial                |
	# +-----------------------------------------------------------------------+
	public function logout()
	{
		# encerra sessao e retorna a pagina inicial
		session_unset();
		Util::redirecionar('/home');
	}

}
