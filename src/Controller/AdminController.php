<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Usuario;
use App\Model\Configuracao;

final class AdminController
{
    function __construct() {
        if (!isset($_SESSION)) {
            session_start();
        }
    }
    public function login(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN);
        return $renderer->render($response, "admin_login.php");
    }
    
    public function verificar_login(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $email_usuario = $request->getParsedBody()['email_usuario'];
        $senha_usuario = $request->getParsedBody()['senha_usuario'];

        $usuario = new Usuario();

        $resultado = $usuario->selectUsuario('*', array('email_usuario' => $email_usuario));

        // verificar usuario
        if (!$resultado) {
            $js['status'] = 0;
            $js['msg'] = "Usuário ou senha inválidos";
            echo json_encode($js);
            exit();
        }

        // verificar senha
        if (1 === 1) { // (password_verify($senha_usuario, $resultado[0]['senha_usuario'])) {
            $_SESSION['usuario_logado'] = $resultado[0];

            $js['status'] = 1;
            $js['msg'] = "Usuário logado com sucesso";
            $js['redirecionar_pagina'] = URL_BASE.'admin/dashboard';
            echo json_encode($js);
            exit();
        } else {
            $js['status'] = 0;
            $js['msg'] = "Usuário ou senha inválidos";
            echo json_encode($js);
            exit();
        }
    }

    public function logout(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $args
    ) {
        $_SESSION['usuario_logado'] = NULL;
        unset($_SESSION['usuario_logado']);
        header("Location: ".URL_BASE."admin-login");
		exit();
    }

    public function dashboard(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();

        $data['informacoes'] = array (
            'menu_active' => 'dashboard'
        );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN);
        return $renderer->render($response, "dashboard.php", $data);
    }

    public function usuario(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();

        $usuario = $_SESSION['usuario_logado'];

        $data['informacoes'] = array (
            'menu_active' => 'usuario',
            'usuario' => $usuario
        );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN);
        return $renderer->render($response, "admin_usuario.php", $data);
    }

    public function usuario_update(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        Usuario::verificarLogin();

        $id_usuario = $request->getParsedBody()['id_usuario'];
        $nome_usuario = $request->getParsedBody()['nome_usuario'];
        $email_usuario = $request->getParsedBody()['email_usuario'];
        $senha_usuario = $request->getParsedBody()['senha_usuario'];
        $confirmar_senha_usuario = $request->getParsedBody()['confirmar_senha_usuario'];

        $alterar_senha = false;
        
        if ($senha_usuario !== '') {
            if ($senha_usuario !== $confirmar_senha_usuario) {
                $js['status'] = 0;
                $js['msg'] = 'As senhas não se coincidem';
                echo json_encode($js);
                exit();
            }
            $alterar_senha = true;
        }
        
        $nome_foto_usuario = "";
        $imagem_atualizar = false;

        if (isset($_FILES['foto_usuario'])) {
            if ($request->getUploadedFiles()['foto_usuario']) {
                $foto_usuario = $request->getUploadedFiles()['foto_usuario'];
            }
            else {
                $foto_usuario = false;
            }
    
            if ($foto_usuario) {
                $imagem_atualizar = true;
                if ($foto_usuario->getError() === UPLOAD_ERR_OK) {
                    $extensao = pathinfo($foto_usuario->getClientFilename(), PATHINFO_EXTENSION);
    
                    $nome = md5(uniqid(rand(), true)).pathinfo($foto_usuario->getClientFilename(), PATHINFO_FILENAME).".".$extensao;
    
                    $nome_foto_usuario = "resources/imagens/admin/usuario/" . $nome;
    
                    $foto_usuario->moveTo($nome_foto_usuario);
                }
            }
        }

        $campos = array(
            'nome_usuario' => $nome_usuario,
            'email_usuario' => $email_usuario,
            'senha_usuario' => $senha_usuario,
            'data_cadastro_usuario' => date('Y-m-d')
        );

        if ($imagem_atualizar) {
            $campos['foto_usuario'] = $nome_foto_usuario;
        }

        if ($alterar_senha) {
            $campos['senha_usuario'] = password_hash($senha_usuario, PASSWORD_DEFAULT, ['cost'=>12]);
        }

        $usuario = new Usuario();
        $usuario->updateUsuario($campos, array('id_usuario' => $id_usuario));

        $resultado = $usuario->selectUsuario('*', array('email_usuario' => $email_usuario));
        $_SESSION['usuario_logado'] = $resultado[0];

        $js['status'] = 1;
        $js['msg'] = 'Usuário atualizado';
        $js['redirecionar_pagina'] = URL_BASE."admin/usuario";
        echo json_encode($js);
        exit();
    }
    
    public function cadastro(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN);
        return $renderer->render($response, "admin_cadastro.php");
    }
    
    public function cadastrar_insert(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $usuario = new Usuario();

        $nome_usuario = $request->getParsedBody()['nome_usuario'];
        $email_usuario = $request->getParsedBody()['email_usuario'];
        $senha_usuario = $request->getParsedBody()['senha_usuario'];
        $foto_usuario = 'resources/imagens/admin/usuario/profile-default.jpg';

        $campos = array(
            'nome_usuario' => $nome_usuario,
            'email_usuario' => $email_usuario,
            'senha_usuario' => $senha_usuario,
            'foto_usuario' => $foto_usuario,
        );

        $usuario->insertUsuario($campos);
        $resultado = $usuario->selectUsuario('*', array('email_usuario' => $email_usuario));
        
        $_SESSION['usuario_logado'] = $resultado[0];

        $js['status'] = 1;
        $js['msg'] = "Usuário criado com sucesso";
        $js['redirecionar_pagina'] = URL_BASE.'admin/dashboard';
        echo json_encode($js);
        exit();
    }
}