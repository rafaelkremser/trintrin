<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Bicicleta;
use App\Model\Usuario;
use App\Controller\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

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
    
    public function aboutus(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES);
        return $renderer->render($response, "aboutus.php");
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

        // INSTANCIA PRINCIPAL DO PAYLOAD PIX
        $obPayload = (new Payload)
            ->setPixKey('16694782624')
            ->setDescription($resultado['nome_bicicleta'])
            ->setMerchantName('Rafael')
            ->setMerchantCity('BELO HORIZONTE')
            ->setTxid('Trintrin')
            ->setAmount(strval($resultado['preco_bicicleta']));

        // CODIGO DE PAGAMENTO PIX
        $payloadQrCode = $obPayload->getPayload();
        
        // QR CODE
        $obQrCode = new QrCode($payloadQrCode);

        // IMAGEM DO QRCODE
        $image = (new Output\Png)->output($obQrCode,400);

        $data['informacoes'] = array (
            'id_bicicleta' => $id,
            'bicicleta' => $resultado,
            'payload' => $payloadQrCode,
            'image' => $image
        );
        
        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES."/bikes/bikes_payment");
        return $renderer->render($response, "bikes_payment.php", $data);
    }
}