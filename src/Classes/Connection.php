<?php

namespace Src\Classes;

/**
 * Classe para conexao com o banco de dados
 */
abstract class Connection
{
	# atributo único para conexão
	private static $conn;

	# +-----------------------------------------------------------------------+
	# | realiza a conexao com o banco de dados                                |
	# +-----------------------------------------------------------------------+
	public function dbConn()
	{
		# abre a conexao apenas se ainda nao foi aberta
		if(self::$conn == null) {
			try {
				# usa constantes do config para iniciar a conexao
				self::$conn =  new \PDO( DBSGBD.":host=".DBHOST.";charset=".DBCHARSET.";"."dbname=".DBNAME, DBUSER, DBPASS);
			} catch (PDOException $err) {
				return $err->getMessage();
			}
		}
		return self::$conn;
	}
}
