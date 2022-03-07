<?php

# localizacao da classe
namespace App\Controller;

# indica utilizacao das classes Util e View
use Src\Classes\Util;
use Src\Classes\View;

use Symfony\Component\Finder\Finder;

/**
 * Classe controller do modulo Home
 */ 
class ControllerHome
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

		# testes do finder
/*
		$finder = new Finder();
		// find all files in the current directory
		echo DIR_PROJECT . ' <br>';
		$finder->depth('== 0')->files()->in(DIR_PROJECT)->contains('FlateDecode');
		foreach ($finder as $file) {
		    $absoluteFilePath = $file->getRealPath();
		    $fileNameWithExtension = $file->getRelativePathname();
		    echo $fileNameWithExtension . '<br>';
		}
		die;
		//Util::printData($finder);
*/
	}

	# 
	# +-----------------------------------------------------------------------+
	# | metodo inicial: remete a pagina inicial do modulo                     |
	# +-----------------------------------------------------------------------+
	public function iniciar()
	{
		try {
			# carregar parametros para a view
			$parametros = array();
			$parametros = Util::getParametros();
			$parametros['modulo'] = $this->modulo;
			$parametros['acao'] = 'iniciar';
			# chama a view principal (main.html)
			View::render(Util::getPasta().'main.html', $parametros);
		} catch(Exception $e) {
			throw new \Exception($e->getMessage());
		}
	}

}
