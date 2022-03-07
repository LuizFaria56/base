<?php

/**
 * arquivo de configuracao de constantes do sistema
 */

# pasta do projeto
$pastaProjeto = "base";

# constantes do servidor
define('SERVER_NAME', "{$_SERVER['SERVER_NAME']}");
define('HTTP_HOST', "{$_SERVER['HTTP_HOST']}");
define('DOCUMENT_ROOT', "{$_SERVER['DOCUMENT_ROOT']}");

# constantes da aplicacao
define('URL_ROOT', "http://".HTTP_HOST);
define('URL_PAGE', "http://".HTTP_HOST."/{$pastaProjeto}");

# diretorio do projeto
if(substr(DOCUMENT_ROOT, -1) == '/') {
	define('DIR_PROJECT', DOCUMENT_ROOT."{$pastaProjeto}/");
} else {
	define('DIR_PROJECT', DOCUMENT_ROOT."/{$pastaProjeto}/");
}

# constantes de acesso ao banco de dados
define('DBSGBD', 'mysql');
define('DBCHARSET', 'utf8');
define('DBNAME', 'base');
define('DBHOST', SERVER_NAME);
define('DBUSER', 'root');
define('DBPASS', '');

# ativar exibicao de erros
define('SHOW_ERRORS', true);

# niveis de acesso: normal e administrador
define('USER_LEVEL', 0);
define('ADMIN_LEVEL', 9);

# constantes para paginacao: itens por pagina e paginas de navegacao
define('PG_ITEMS', 4);
define('PG_NAV', 5);
