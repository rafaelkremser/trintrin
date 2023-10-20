<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Bicicleta;
use App\Model\Usuario;

final class HomeController
{
    public function home(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES);
        return $renderer->render($response, "home.php");
    }

    public function bikes(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $bicicletas = new Bicicleta();
        $lista = $bicicletas->selectAllBicicleta();

        $data['informacoes'] = array (
            'lista' => $lista,
        );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES."/bikes");
        return $renderer->render($response, "bikes.php", $data);
    }
    
    public function bikes_view(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $args['id'];

        $bicicletas = new Bicicleta();
        $usuario = new Usuario();
        $resultado = $bicicletas->selectBicicleta('*', array('id_bicicleta' => $id))[0];
        $id_vendedor = $resultado['vendedor_bicicleta'];
        $nome_vendedor = $usuario->selectUsuario('nome_usuario', array('id_usuario' => $id_vendedor))[0];
        

        $data['informacoes'] = array (
            'id_bicicleta' => $id,
            'bicicleta' => $resultado,
            'vendedor' => $nome_vendedor,
        );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES."/bikes");
        return $renderer->render($response, "bikes_view.php", $data);
    }

    public function bikes_payment(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $args['id'];

        $bicicletas = new Bicicleta();
        $usuario = new Usuario();
        $resultado = $bicicletas->selectBicicleta('*', array('id_bicicleta' => $id))[0];

        $data['informacoes'] = array (
            'id_bicicleta' => $id,
            'bicicleta' => $resultado
        );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES."/bikes/bikes_payment");
        return $renderer->render($response, "bikes_payment.php", $data);
    }
}