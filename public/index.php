<?php

/**
 * pagina inicial de toda requisicao
 */

# carrega autoload e config
require_once('../src/vendor/autoload.php');
require_once('../config/config.php');

# define classe/funcoes para tratamento de erros e excecoes
error_reporting(E_ALL);
set_error_handler('Src\Classes\Error::errorHandler');
set_exception_handler('Src\Classes\Error::exceptionHandler');

# inicia sessao
session_start();

# instancia o dispatch que vai identificar: controller, metodo e parametros
$dispatch = new App\Dispatch();

/*
# TESTE DAS CONSTANTES DEFINIDAS NO CONFIG.PHP
echo '<pre>SERVER_NAME..: '.SERVER_NAME.'<br>HTTP_HOST....: '.HTTP_HOST.'<br>DOCUMENT_ROOT: '.DOCUMENT_ROOT.'<br>URL_ROOT.....: '.URL_ROOT.'<br>URL_PAGE.....: '.URL_PAGE.'<br>DIR_PROJECT..: '.DIR_PROJECT.'<br>';
print_r($_SERVER);
echo '</pre>';
*/
/*
# TESTE DE ACESSO AO BANCO DE DADOS
$conn = new \PDO( 'mysql:host=localhost;charset=utf8;dbname=mysql', 'root', '');
$stmt = $conn->prepare('SHOW TABLES');
$stmt->execute();
$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
echo '<pre> Teste mysql <br>';
print_r($result);
echo '</pre>';
*/
