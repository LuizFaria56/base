<?php

namespace Src\Classes;

# indica o uso da classe Util
use Src\Classes\Util;

/**
 * Classe para definir rota da requisicao
 */
class Route
{
	
	# define uma classe Controller default
	private $defaultController = "ControllerHome";
	private $rota;

    # +-----------------------------------------------------------------------+
    # | Metodo que retorna a rota                                             |
    # +-----------------------------------------------------------------------+
	public function getRota()
	{
		# obtem url no formato de array
		$url = Util::urlParse();
		# o primeiro elemento indica a classe Controller
		$ctrl = $url[0];
		$result = '';
		# obtem array com as possíveis rotas:
		$this->rota = require_once DIR_PROJECT."app/routes.php";
		# se a rota informada não consta da lista, usa default
		if(array_key_exists($ctrl, $this->rota)) {
			# se não encontra arquivo php usa default
			if(file_exists(DIR_PROJECT."app/Controller/{$this->rota[$ctrl]}.php")) {
				$result = $this->rota[$ctrl];
			} else {
				$result = $this->defaultController;
			}
		} else {
			$result = $this->defaultController;
		}
		# retorna a classe a ser executada
		return $result;
	}

}
