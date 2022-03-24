<?php

namespace App\Controller;

use Exception;
use Core\Controller;
use Core\View;
use App\Util;

/**
 * Home controller
 */
class Home extends Controller
{

    # +----------------------------------------------------+
    # | funcao default: apresenta pagina inicial do modulo |
    # +----------------------------------------------------+
    public function indexAction()
    {
        $params = [
            'session' => $_SESSION,
            'root' => URL_PROJECT,
            'args' => $this->route_params,
            'header' => 'Home'];
            try {
                View::renderTemplate('Home/index.html', $params);
            } catch (Exception $err) {
                throw new Exception($err->getMessage());
            }
    }

}
