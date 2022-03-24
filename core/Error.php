<?php

namespace Core;

/**
 * Error and exception handler
 *
 * PHP version 7.0
 */
class Error
{

    /**
     * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
     *
     * @param int $level  Error level
     * @param string $message  Error message
     * @param string $file  Filename the error was raised in
     * @param int $line  Line number in the file
     *
     * @return void
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) {  // to keep the @ operator working
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Exception handler.
     *
     * @param Exception $exception  The exception
     *
     * @return void
     */
    public static function exceptionHandler($exception)
    {
        $header = 'Error';
        // Code is 404 (not found) or 500 (general error)
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
            $header = 'Ocorreu um erro';
        } else {
            $header = 'Página não encontrada';
        }
        http_response_code($code);

        if (SHOW_ERRORS) {
            $message = '';
            $message .= "Uncaught exception: '" . get_class($exception) . "'\n";
            $message .= "Message: '" . $exception->getMessage() . "'\n";
            $message .= "\nStack trace:" . $exception->getTraceAsString() . "\n";
            $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "\n";
        } else {
            $log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
            ini_set('error_log', $log);
            $message = "Uncaught exception: '" . get_class($exception) . "'\n";
            $message .= " with message '" . $exception->getMessage() . "'\n";
            $message .= "\nStack trace: " . $exception->getTraceAsString() . "\n";
            $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "\n";
            error_log($message);
            $message = null;
        }

        $params = [
            'root' => URL_PROJECT,
            'header' => $header,
            'message' => $message
        ];

        View::renderTemplate("$code.html", $params);
    }
}
