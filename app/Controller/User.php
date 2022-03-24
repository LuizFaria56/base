<?php

namespace App\Controller;

use Exception;
use Core\Controller;
use Core\View;
use App\Model\User as UserModel;
use App\Util;

/**
 * User controller
 */
class User extends Controller
{

    # +----------------------------------------------------+
    # | funcao default: apresenta pagina inicial do modulo |
    # +----------------------------------------------------+
    public function indexAction()
    {
        # precisa ter nivel admin
        if (isset($_SESSION['nivel']) and $_SESSION['nivel'] == ADMIN_LEVEL) {
            $user = new UserModel();
            $lista = $user->getList();
            $params = [
                'session' => $_SESSION,
                'root' => URL_PROJECT,
                'back' => '/intranet',
                'header' => 'Usuário',
                'args' => $this->route_params,
                'niveis' => Util::$niveis,
                'estados' => Util::$estados,
                'lista' => $lista
            ];
            try {
                View::renderTemplate('User/index.html', $params);
            } catch (Exception $err) {
                throw new Exception($err->getMessage());
            }    
        } else {
            # redireciona para a pagina da intranet
            header('Location: '.URL_PROJECT.'/intranet');
        }
    }

    # +----------------------------------------------------+
    # | registro de visitante                              |
    # +----------------------------------------------------+
    public function registerAction()
    {
        if (!empty($_POST)) {
            # requisicao POST para registrar no banco
            $user = new UserModel();
            $user->setNome($_POST['nome']);
            $user->setEmail($_POST['email']);
            $hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            $user->setSenha($hash);
            $user->setNivel(USER_LEVEL);
            $result = $user->register();
            # redireciona para a pagina de registro
            header('Location: '.URL_PROJECT.'/user/register');                
        } else {
            # requisicao GET apresenta formulario de registro
            $params = [
                'session' => $_SESSION,
                'root' => URL_PROJECT,
                'back' => '/home',
                'header' => 'Registrar-se na aplicação',
                'args' => $this->route_params
            ];
            try {
                View::renderTemplate('User/index.html', $params);
            } catch (Exception $err) {
                throw new Exception($err->getMessage());
            }    
        }
    }

    # +----------------------------------------------------+
    # | login para a area restrita                         |
    # +----------------------------------------------------+
    public function loginAction()
    {
        if (!empty($_POST)) {
            # requisicao POST verifica login
            $user = new UserModel();
            $objeto = $user->getByEmail($_POST['email']);
            if (!$objeto) {
                # volta para a pagina de login
                header('Location: '.URL_PROJECT.'/user/login');
            }
            if (password_verify($_POST['senha'], $objeto['senha'])) {
                # inicia variaveis de sessao e direciona para intranet
                $_SESSION['id'] = $objeto['id'];
                $_SESSION['nome'] = $objeto['nome'];
                $_SESSION['email'] = $objeto['email'];
                $_SESSION['nivel'] = $objeto['nivel'];
                header('Location: '.URL_PROJECT.'/intranet');
            } else {
                # volta para a pagina de login
                header('Location: '.URL_PROJECT.'/user/login');
            }
        } else {
            # requisicao GET apresenta tela de login
            $params = [
                'session' => $_SESSION,
                'root' => URL_PROJECT,
                'back' => '/home',
                'header' => 'Login',
                'args' => $this->route_params
            ];
            try {
                View::renderTemplate('User/index.html', $params);
            } catch (Exception $err) {
                throw new Exception($err->getMessage());
            }    
        }
    }

    # +----------------------------------------------------+
    # | apresenta formulario preenchido para alteracao     |
    # +----------------------------------------------------+
    public function editAction()
    {
        # precisa estar logado
        if (isset($_SESSION['id'])) {
            if (!empty($_POST)) {
                # requisicao POST grava alteracoes
                $user = new UserModel();
                $user->setNome($_POST['nome']);
                $user->setEmail($_POST['email']);
                $user->setEndereco($_POST['endereco']);
                $user->setCidade($_POST['cidade']);
                $user->setEstado($_POST['estado']);
                $user->setCep($_POST['cep']);
                $user->setTelefone($_POST['telefone']);
                $user->setNivel($_POST['nivel']);
                $user->setId($_POST['id']);
                $result = $user->update();
                if ($_SESSION['nivel'] == ADMIN_LEVEL) {
                    # redireciona para a pagina default
                    header('Location: '.URL_PROJECT.'/user');
                } else {
                    # redireciona para a pagina da intranet
                    header('Location: '.URL_PROJECT.'/intranet');
                }    
            } else {
                # requisicao GET apresenta formulario para alteracao
                # obtem ID dos parametros da rota
                $id = $this->route_params['arg'];
                $user = new UserModel();
                $objeto = $user->getObject($id);
                $lista = $user->getList();
                $params = [
                    'session' => $_SESSION,
                    'root' => URL_PROJECT,
                    'back' => '/intranet',
                    'header' => 'Alterar Usuário',
                    'args' => $this->route_params,
                    'niveis' => Util::$niveis,
                    'estados' => Util::$estados,
                    'lista' => $lista,
                    'objeto' => $objeto
                ];
                try {
                    View::renderTemplate('User/index.html', $params);
                } catch (Exception $err) {
                    throw new Exception($err->getMessage());
                }
            }    
        } else {
            header('Location: '.URL_PROJECT.'/home');
        }
    }
    
    # +----------------------------------------------------+
    # | abre janela para alterar senha                     |
    # +----------------------------------------------------+
    public function senhaAction()
    {
        # precisa estar logado
        if (isset($_SESSION['id'])) {
            if (!empty($_POST)) {
                if ($_POST['senha'] == $_POST['confirmacao']) {
                    $hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
                    $user = new UserModel();
                    $user->setSenha($hash);
                    $user->setId($_POST['id']);
                    $user->updateSenha();
                    # redireciona para a pagina da intranet
                    header('Location: '.URL_PROJECT.'/intranet');
                } else {
                    # redireciona para a pagina de senha
                    header('Location: '.URL_PROJECT.'/user/senha/'.$_POST['id']);
                }    
            } else {
                $params = [
                    'session' => $_SESSION,
                    'root' => URL_PROJECT,
                    'back' => '/intranet',
                    'header' => 'Senha',
                    'args' => $this->route_params
                ];
                try {
                    View::renderTemplate('User/index.html', $params);
                } catch (Exception $err) {
                    throw new Exception($err->getMessage());
                }    
            }    
        } else {
            header('Location: '.URL_PROJECT.'/home');
        }
    }

    # +----------------------------------------------------+
    # | recebe POST para adicionar no banco (insert)       |
    # +----------------------------------------------------+
    public function insertAction()
    {
        # precisa estar logado
        if (isset($_SESSION['id'])) {
            $hash = $this->senhaPadrao($_POST['nome']);
            $user = new UserModel();
            $user->setNome($_POST['nome']);
            $user->setEmail($_POST['email']);
            $user->setSenha($hash);
            $user->setEndereco($_POST['endereco']);
            $user->setCidade($_POST['cidade']);
            $user->setEstado($_POST['estado']);
            $user->setCep($_POST['cep']);
            $user->setTelefone($_POST['telefone']);
            $user->setNivel($_POST['nivel']);
            $result = $user->insert();
            # redireciona para a pagina default
            header('Location: '.URL_PROJECT.'/user');    
        } else {
            header('Location: '.URL_PROJECT.'/home');
        }
    }
    
    # +----------------------------------------------------+
    # | recebe PK para excluir do banco (delete)           |
    # +----------------------------------------------------+
    public function deleteAction()
    {
        # precisa estar logado
        if (isset($_SESSION['id'])) {
            $id = $this->route_params['arg'];
            $user = new UserModel();
            $result = $user->delete($id);
            # redireciona para a pagina default
            header('Location: '.URL_PROJECT.'/user');    
        } else {
            header('Location: '.URL_PROJECT.'/home');
        }
    }

    # +----------------------------------------------------+
    # | limpa a sessao e direciona para home               |
    # +----------------------------------------------------+
    public function logoutAction()
    {
        session_unset();
        header('Location: '.URL_PROJECT.'/home');
    }

    # +----------------------------------------------------+
    # | senha padrao: 1o.nome minusculo sem acentos        |
    # +----------------------------------------------------+
    protected function senhaPadrao($nome)
    {
        $aux = explode(' ', $nome);
		$aux = Util::clearString($aux[0]);
        $result = password_hash($aux, PASSWORD_DEFAULT);
		return $result;
    }

}
