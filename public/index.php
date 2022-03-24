<?php

# carrega autoload e config
require_once(dirname(__DIR__).'/src/vendor/autoload.php');
require_once(dirname(__DIR__).'/config/config.php');

# inicia sessao
session_start();

# estabelece timezone
date_default_timezone_set('America/Sao_Paulo');

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'home', 'action' => 'index']);
$router->add('{controller}', ['controller' => '{controller}', 'action' => 'index']);
$router->add('{controller}/{action}', ['controller' => '{controller}', 'action' => '{action}']);
$router->add('{controller}/{action}/{arg:\w+}', ['controller' => '{controller}', 'action' => '{action}', 'arg' => '{arg}']);
$router->add('{controller}/{action}/{key:\w+}/{value:\w+}', ['controller' => '{controller}', 'action' => '{action}', 'key' => '{key}', 'value' => '{value}']);

$router->dispatch($_SERVER['QUERY_STRING']);

# exibir constantes
/*
$constantes = [
	'ROOT_PROJECT' => ROOT_PROJECT,
	'URL_ROOT' => URL_ROOT,
	'URL_PROJECT' => URL_PROJECT,
	'REQUEST_SCHEME' => REQUEST_SCHEME,
	'SERVER_NAME' => SERVER_NAME,
	'HTTP_HOST' => HTTP_HOST,
	'DOCUMENT_ROOT' => DOCUMENT_ROOT
];
echo '<pre>';
print_r($constantes);
echo '</pre>';
*/

# varivael global $_SERVER
/*
echo '<pre>Servidor: <br>';
var_dump($_SERVER);
echo '</pre>';
*/

# teste de conexao com o banco de dados
/*
$conn = new \PDO( 'mysql:host=localhost;charset=utf8;dbname=mysql', 'root', ''); 
$stmt = $conn->prepare('SHOW TABLES');
$stmt->execute();
$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
echo '<pre> Teste mysql <br>';
print_r($result);
echo '</pre>';
*/
