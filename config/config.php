<?php

# constantes do servidor
define('REQUEST_SCHEME', "{$_SERVER['REQUEST_SCHEME']}");
define('SERVER_NAME', "{$_SERVER['SERVER_NAME']}");
define('HTTP_HOST', "{$_SERVER['HTTP_HOST']}");
define('DOCUMENT_ROOT', "{$_SERVER['DOCUMENT_ROOT']}");

# outras constantes
define('ROOT_PROJECT', "base");
define('URL_ROOT', REQUEST_SCHEME.'://'.SERVER_NAME);
define('URL_PROJECT', REQUEST_SCHEME.'://'.SERVER_NAME.'/'.ROOT_PROJECT);
define('SHOW_ERRORS', true);

define('USER_LEVEL', 0);
define('ADMIN_LEVEL', 9);

# constantes de acesso ao banco de dados
define('DBSGBD', 'mysql');
define('DBCHARSET', 'utf8');
define('DBNAME', 'base');
define('DBHOST', SERVER_NAME);
define('DBUSER', 'root');
define('DBPASS', '');
