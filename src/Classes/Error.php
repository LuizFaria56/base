<?php

namespace Src\Classes;

use Src\Classes\Util;

/**
 * Classe para tratamento de erros e excecoes
 */
class Error
{

    # +-----------------------------------------------------------------------+
    # | Tratamento de erro: converte erros em excecoes com o comando throw    |
    # +-----------------------------------------------------------------------+
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    # +-----------------------------------------------------------------------+
    # | Tratamento de excecao                                                 |
    # +-----------------------------------------------------------------------+
    public static function exceptionHandler($exception)
    {
        # O codigo pode ser 404 (nao encontrado) ou 500 (erro geral)
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }
        http_response_code($code);
        $log = DIR_PROJECT . '/public/tmp/' . date('Y-m-d') . '.txt';
        ini_set('error_log', $log);
        $parametros = array();
        $parametros['urlPage'] = URL_PAGE;
        $parametros['titulo'] = 'Erro';
        $parametros['descricao'] = 'Ocorreu um Erro';

        # durante desenvolvimento a constante SHOW_ERRORS deve ser true
        if (SHOW_ERRORS) {
            $message = "Exceção não capturada: '" . get_class($exception) . "'";
            $message .= " com a mensagem: '" . $exception->getMessage() . "'";
            $message .= "\nRastreamento de pilha:" . $exception->getTraceAsString();
            $message .= "\nLançada em '" . $exception->getFile() . "' na linha " . $exception->getLine();
            # em desenvolvimento todo o conteudo do erro importa
            $parametros['mensagem'] = $message;
        } else {
            $message = "Exceção não capturada: '" . get_class($exception) . "'";
            $message .= " com a mensagem '" . $exception->getMessage() . "'";
            $message .= "\nRastreamento de pilha: " . $exception->getTraceAsString();
            $message .= "\nLançada em '" . $exception->getFile() . "' na linha " . $exception->getLine();
            # em producao apenas a mensagem importa
            $parametros['mensagem'] = $exception->getMessage();
        }
        # o LOG deve ter o conteudo completo do erro
        error_log($message);
        View::render("$code.html",$parametros);
    }

}
