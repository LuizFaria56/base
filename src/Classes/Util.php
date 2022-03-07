<?php

namespace Src\Classes;

/**
 * Classe com metodos e atributos de uso geral
 */
class Util
{
	
	# +-----------------------------------------------------------------------+
	# | atributos de modulo                                                   |
	# +-----------------------------------------------------------------------+
	# codigo define a rota do modulo
	static $codigo;
	# pasta que contem as paginas HTML
	static $pasta;
	# controller e function para exclusao
	static $deleteController;
	static $deleteFunction;
	# titulo que aparece na aba do navegador
	static $titulo;
	# descricao que aparece no cabecalho da pagina
	static $descricao;
	
	# metodos getters
	static function getCodigo() { return self::$codigo; }
	static function getPasta() { return self::$pasta; }
	static function getTitulo() { return self::$titulo; }
	static function getDeleteController() { return self::$deleteController; }
	static function getDeleteFunction() { return self::$deleteFunction; }
	static function getDescricao() { return self::$descricao; }
	#metodos setters
	static function setPasta($pasta) { self::$pasta = $pasta; }
	static function setDeleteController($deleteController) { self::$deleteController = $deleteController; }
	static function setDeleteFunction($deleteFunction) { self::$deleteFunction = $deleteFunction; }
	static function setCodigo($codigo) { self::$codigo = $codigo; }
	static function setTitulo($titulo) { self::$titulo = $titulo; }
	static function setDescricao($descricao) { self::$descricao = $descricao; }
	
	# modulo default
	static $defaultModule = 'home';
	static function getDefaultModule() { return self::$defaultModule; }
	static function setDefaultModule($defaultModule) { self::$defaultModule = $defaultModule; }

	# encontra codigo do modulo
	static function getModulo()
	{
		$tmp = self::urlParse();
		$result = $tmp[0];
		return $result;
	}

	# lista de modulos: cada modulo deve ser acrescentado aqui
	static $modulos = [
		['codigo'=>'home', 'pasta'=>'/home/', 'delCtrl'=>'', 'delMeth'=>'','titulo'=>'Home', 'descricao'=>'Aplicação MVC Base'],
		['codigo'=>'login', 'pasta'=>'/login/', 'delCtrl'=>'', 'delMeth'=>'', 'titulo'=>'Login', 'descricao'=>'Login para a Área Restrita'],
		['codigo'=>'intranet', 'pasta'=>'/intranet/', 'delCtrl'=>'', 'delMeth'=>'', 'titulo'=>'Intranet', 'descricao'=>'Área Restrita'],
		['codigo'=>'cadastro', 'pasta'=>'/cadastro/', 'delCtrl'=>'', 'delMeth'=>'', 'titulo'=>'Cadastro', 'descricao'=>'Dados Cadastrais'],
		['codigo'=>'user', 'pasta'=>'/user/', 'delCtrl'=>'/user', 'delMeth'=>'/excluir', 'titulo'=>'Usuário', 'descricao'=>'Manutenção de Usuários'],
		['codigo'=>'senha', 'pasta'=>'/senha/', 'delCtrl'=>'/senha', 'delMeth'=>'/excluir', 'titulo'=>'Senha', 'descricao'=>'Alterar Senha'],
		['codigo'=>'registro', 'pasta'=>'/registro/', 'delCtrl'=>'', 'delMeth'=>'', 'titulo'=>'Registro', 'descricao'=>'Registro na Aplicação']
	];
	static function getModulos() { return self::$modulos; }
	static function setModulos($modulos) { self::$modulos = $modulos; }
	
	# define os atributos do modulo
	static function setModuleValues()
	{
		$caminho = self::urlParse();
		$chave = array_search($caminho[0], array_column(self::getModulos(), 'codigo'));
		# se nao encontrar na lista, usa default
		if (strlen($chave) == 0) {
			$modulo = self::getDefaultModule();			
		} else {
			if (!empty($caminho[0])) {
				$modulo = $caminho[0];
			} else {
			$modulo = self::getDefaultModule();
			}
		}
		# inicia os atributos do modulo
		$lista = self::getModulos();
		foreach ($lista as $key => $value) {
			if ($value['codigo'] == $modulo) {
				self::setCodigo($value['codigo']);
				self::setPasta($value['pasta']);
				self::setDeleteController($value['delCtrl']);
				self::setDeleteFunction($value['delMeth']);
				self::setTitulo($value['titulo']);
				self::setDescricao($value['descricao']);
			}
		}
	}

	# +-----------------------------------------------------------------------+
	# | lista generica de parametros                                          |
	# +-----------------------------------------------------------------------+
	static $parametros = array();
	static function getParametros() { return self::$parametros; }
	# preenche valores basicos da lista de parametros
	static function setParametros()
	{
		self::$parametros['urlPage'] = URL_PAGE;
		self::$parametros['voltarClass'] = 'home';
		self::$parametros['voltarIcon'] = 'home';
		self::$parametros['sessao'] = $_SESSION;
		self::$parametros['codigo'] = self::getCodigo();
		self::$parametros['pasta'] = self::getPasta();
		self::$parametros['deleteController'] = URL_PAGE.self::getDeleteController();
		self::$parametros['deleteFunction'] = self::getDeleteFunction();
		self::$parametros['titulo'] = self::getTitulo();
		self::$parametros['descricao'] = self::getDescricao();
		self::$parametros['userLevel'] = USER_LEVEL;
		self::$parametros['adminLevel'] = ADMIN_LEVEL;
		self::$parametros['pgAcao'] = 'iniciar';
	}

	# +-----------------------------------------------------------------------+
	# | lista de tabelas: cada tabela deve ser colocada nesta lista           |
	# +-----------------------------------------------------------------------+
	static $tables = [
			['table'=>'user', 'view'=>'', 'pk'=>'id', 'fk'=>'', 'orderBy'=>'nome'],
		];
	static function getTables() { return self::$tables; }
	static function setTables($tables) { self::$tables = $tables; }
	# define tabela
	static function getTableAttribute($tabela)
	{
		$key = array_search($tabela, array_column(self::getTables(), 'table'));
		return self::$tables[$key];
	}

	# +-----------------------------------------------------------------------+
	# | paginacao                                                             |
	# +-----------------------------------------------------------------------+
	static $pagination = array();
	static $pageLst = array();
	static function getPagination() { return self::$pagination; }
	static function getPageLst() { return self::$pageLst; }
	
	# Metodo para preencher valores para paginacao
	static function setPagination($results, $currentPage, $limit = PG_ITEMS)
	{
		$pages = $results > 0 ? ceil($results / $limit) : 1;
		$offset = ($limit * ($currentPage - 1));
		$start = ($currentPage - 3);
		$end = $start > 0 ? ($start + PG_NAV - 1) : PG_NAV;
		self::$pagination = [
			'limit'=>$limit,
			'results'=>$results,
			'pages'=>$pages,
			'currentPage'=>$currentPage,
			'offset'=> $offset,
			'start'=>$start,
			'end'=>$end
		];
		self::setPageLst($pages, $currentPage);
	}
	
	# Metodo responsavel por retornar as opcoes de paginas disponiveis
	static function setPageLst($pages, $currentPage)
	{
		# se houver apenas uma pagina: NÃO RETORNA PAGINAS
		if($pages == 1) return [];
		# retorna PAGINAS
		$pageLst = array();
		for($i = 1; $i <= $pages; $i++){
		  $pageLst[] = [
		    'page'    => $i,
		    'current' => $i == $currentPage
		  ];
		}
		self::$pageLst = $pageLst;
	}

	# +-----------------------------------------------------------------------+
	# | divide uma url em elementos de um array                               |
	# +-----------------------------------------------------------------------+
	# formato esperado: projeto/modulo/acao/argumento1/argumento2...
	public static function urlParse()
	{
		# obtem url (nome definido em .htaccess)
		$url = $_GET['url'];
		# elimina possíveis espacos em branco do final
		$url = rtrim($url);
		# separa cada parte da url num array (/ como separador)
		$caminho = explode("/", $url, FILTER_SANITIZE_URL);
		# retorna o array
		return $caminho;
	}
	
	# +-----------------------------------------------------------------------+
	# | funcao para redirecionar                                              |
	# +-----------------------------------------------------------------------+
	static function redirecionar($rota)
	{
		header('Location: '.URL_PAGE.$rota);
	}

	# +-----------------------------------------------------------------------+
	# | funcao auxiliar para listar dados na tela (debug)                     |
	# +-----------------------------------------------------------------------+
	static function printData($data)
	{
        echo '<pre>DEBUG: <br>';
        if(is_array($data) || is_object($data)){
            print_r($data);
        } else {
            echo $data;
        }
        die('<p>TERMINADO</p>');
        echo '</pre>';
    }

	# +-----------------------------------------------------------------------+
	# | funcao para retirar acentos e converter para minusculas               |
	# +-----------------------------------------------------------------------+
	static function clearString($texto)
	{
		$comAcentos = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú');
		$semAcentos = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', '0', 'U', 'U', 'U');
		$aux = str_replace($comAcentos, $semAcentos, $texto);
		$result = strtolower($aux);
		return $result;
	}

}
