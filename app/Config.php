<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

   # nome da pasta do projeto
   const ROOT_PROJECT = 'base';

   # constantes do servidor
   const REQUEST_SCHEME = $_SERVER['REQUEST_SCHEME'];
   const SERVER_NAME = "{$_SERVER['SERVER_NAME']}";
   const HTTP_HOST = "{$_SERVER['HTTP_HOST']}";
   const DOCUMENT_ROOT = "{$_SERVER['DOCUMENT_ROOT']}";

   # outras constantes
   const URL_ROOT = REQUEST_SCHEME.'://'.SERVER_NAME;
   const URL_PROJECT = REQUEST_SCHEME.'://'.SERVER_NAME.'/'.ROOT_PROJECT;
   const SHOW_ERRORS = true;

   # nivel de acesso
   const USER_LEVEL = 0;
   const ADMIN_LEVEL = 9;

   # constantes de acesso ao banco de dados
   const DBSGBD = 'mysql';
   const DBCHARSET = 'utf8';
   const DBNAME = 'base';
   const DBHOST = SERVER_NAME;
   const DBUSER = 'root';
   const DBPASS = '';

}
