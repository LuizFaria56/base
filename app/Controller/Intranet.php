<?php

namespace App\Controller;

use Exception;
use Core\Controller;
use Core\View;
use App\Util;

/**
 * Home controller
 */
class Intranet extends Controller
{

    # +----------------------------------------------------+
    # | funcao default: apresenta pagina inicial do modulo |
    # +----------------------------------------------------+
    public function indexAction()
    {
        # precisa estar logado
        if (isset($_SESSION['id'])) {
            $params = [
                'session' => $_SESSION,
                'root' => URL_PROJECT,
                'args' => $this->route_params,
                'header' => 'Intranet'];
            try {
                View::renderTemplate('Intranet/index.html', $params);
            } catch (Exception $err) {
                throw new Exception($err->getMessage());
            }    
        } else {
            header('Location: '.URL_PROJECT.'/home');
        }
    }

}
