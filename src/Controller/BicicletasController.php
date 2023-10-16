<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use App\Model\Bicicleta;
use App\Model\Usuario;

final class BicicletasController
{
    function __construct() {
        Usuario::verificarLogin();
    }
    public function bicicletas(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $bicicletas = new Bicicleta();
        $usuario = new Usuario();
        $emailUsuarioLogado = $_SESSION['usuario_logado']['email_usuario'];
        $idUsuarioLogado = $usuario->selectUsuario('id_usuario', array('email_usuario' => $emailUsuarioLogado));
        

        if (isset($_GET['pesquisa']) && $_GET['pesquisa'] !== '') {
            $lista = $bicicletas->selectBicicletasPesquisa($_GET['pesquisa'], $idUsuarioLogado[1]['id_usuario']);
            $paginaAtual = 1;
            $paginaAnterior = false;
            $proximaPagina = false;
        } else {
            $limit = 10;
            $paginaAtual = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($paginaAtual*$limit) - $limit;
            $qntTotal = count($bicicletas->selectBicicleta('*', array('1'=>'1')));
            $proximaPagina = ($qntTotal > ($paginaAtual*$limit)) ? URL_BASE."admin/bicicletas?page=".($paginaAtual+1) : false;
            $paginaAnterior = ($paginaAtual > 1) ? URL_BASE."admin/bicicletas?page=".($paginaAtual-1) : false;
            $lista = $bicicletas->selectByVendedor($idUsuarioLogado[0]['id_usuario']);
        }

        $data['informacoes'] = array (
            'menu_active' => 'bicicletas',
            'lista' => $lista,
            'paginaAtual' => $paginaAtual,
            'proximaPagina' => $proximaPagina,
            'paginaAnterior' => $paginaAnterior
        );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/bicicleta");
        return $renderer->render($response, "admin.php", $data);
    }

    public function bicicletas_create(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $data['informacoes'] = array (
            'menu_active' => 'bicicletas'
        );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/bicicleta");
        return $renderer->render($response, "create.php", $data);
    }

    public function bicicletas_edit(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $args['id'];

        $bicicletas = new Bicicleta();
        $resultado = $bicicletas->selectBicicleta('*', array('id_bicicleta' => $id))[0];
        $resultado['galeria'] = $bicicletas->selectGaleria($id);

        $data['informacoes'] = array (
            'menu_active' => 'bicicletas',
            'id_bicicleta' => $id,
            'bicicleta' => $resultado
        );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/bicicleta");
        return $renderer->render($response, "edit.php", $data);
    }
    
    public function bicicletas_insert(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $usuario = new Usuario();

        $emailUsuarioLogado = $_SESSION['usuario_logado']['email_usuario'];
        $idUsuarioLogado = $usuario->selectUsuario('id_usuario', array('email_usuario' => $emailUsuarioLogado));
        $nome_bicicleta = $request->getParsedBody()['nome_bicicleta'];
        $data_bicicleta = $request->getParsedBody()['data_bicicleta'];
        $vendedor_bicicleta = $idUsuarioLogado[0]['id_usuario'];
        $descricao_bicicleta = $request->getParsedBody()['descricao_bicicleta'];
        $status_bicicleta = $request->getParsedBody()['ativo_bicicleta'];

        if ($request->getUploadedFiles()['imagem_principal']) {
            $imagem_principal = $request->getUploadedFiles()['imagem_principal'];
        }
        else {
            $imagem_principal = false;
        }
        
        $nome_imagem_principal = "";

        if ($imagem_principal) {
            if ($imagem_principal->getError() === UPLOAD_ERR_OK) {
                $extensao = pathinfo($imagem_principal->getClientFilename(), PATHINFO_EXTENSION);

                $nome = md5(uniqid(rand(), true)).pathinfo($imagem_principal->getClientFilename(), PATHINFO_FILENAME).".".$extensao;

                $nome_imagem_principal = "resources/imagens/bicicletas/" . $nome;

                $imagem_principal->moveTo($nome_imagem_principal);
            }
        }

        $campos = array(
            'nome_bicicleta' => $nome_bicicleta,
            'url_amigavel_bicicleta' => $this->gerarUrlAmigavel($nome_bicicleta),
            'vendedor_bicicleta' => $vendedor_bicicleta,
            'data_cadastro' => $data_bicicleta,
            'descricao_bicicleta' => $descricao_bicicleta,
            'imagem_principal_bicicleta' => $nome_imagem_principal,
            'status_bicicleta' => $status_bicicleta
        );

        $bicicletas = new Bicicleta();
        $bicicletas->insertBicicleta($campos);

        $id_bicicleta = $bicicletas->getUltimoBicicleta()['id_bicicleta'];

        if ($request->getUploadedFiles()['galeria_imagens']) {
            $galeria = $request->getUploadedFiles()['galeria_imagens'];
        }
        else {
            $galeria = false;
        }

        if ($galeria) {
            foreach ($galeria as $imagem) {
                $foto = array();
                if ($imagem->getError() === UPLOAD_ERR_OK) {
                    $extensao = pathinfo($imagem->getClientFilename(), PATHINFO_EXTENSION);
                
                    $nome = md5(uniqid(rand(), true)).pathinfo($imagem->getClientFilename(), PATHINFO_FILENAME).".".$extensao;
                
                    $foto["caminho_imagem"] = "resources/imagens/bicicletas/" . $nome;
                
                    $imagem->moveTo($foto["caminho_imagem"]);

                    $foto['id_bicicleta'] = $id_bicicleta;
                    
                    $bicicletas->insertFotoGaleria($foto);
                }
            } 
        }
        
        header('Location: '.URL_BASE.'admin/bicicletas');
        exit();
        

        $data['informacoes'] = array (
            'menu_active' => 'bicicletas'
        );

        $renderer = new PhpRenderer(DIRETORIO_TEMPLATES_ADMIN."/bicicleta");
        return $renderer->render($response, "admin.php", $data);
    }

    public function bicicletas_update(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {

        $id = $request->getParsedBody()['id_bicicleta'];
        $nome_bicicleta = $request->getParsedBody()['nome_bicicleta'];
        $data_bicicleta = $request->getParsedBody()['data_bicicleta'];
        $descricao_bicicleta = $request->getParsedBody()['descricao_bicicleta'];
        $status_bicicleta = $request->getParsedBody()['ativo_bicicleta'];
        $nome_imagem_atual = $request->getParsedBody()['nome_imagem_atual'];

        $imagem_atualizar = false;

        if ($request->getUploadedFiles()['imagem_principal']->getClientFilename() !== ''){
            // Usuário quer atualizar a imagem principal
            $imagem_atualizar = true;
            $nome_imagem_principal = "";
            if ($request->getUploadedFiles()['imagem_principal']) {
                $imagem_principal = $request->getUploadedFiles()['imagem_principal'];
            }
            else {
                $imagem_principal = false;
            }
            if ($imagem_principal) {
                if ($imagem_principal->getError() === UPLOAD_ERR_OK) {
                    $extensao = pathinfo($imagem_principal->getClientFilename(), PATHINFO_EXTENSION);
    
                    $nome = md5(uniqid(rand(), true)).pathinfo($imagem_principal->getClientFilename(), PATHINFO_FILENAME).".".$extensao;
    
                    $nome_imagem_principal = "resources/imagens/bicicletas/" . $nome;
    
                    $imagem_principal->moveTo($nome_imagem_principal);

                    unlink($nome_imagem_atual);
                }
            }
        }

        $campos = array(
            'id_bicicleta' => $id,
            'nome_bicicleta' => $nome_bicicleta,
            'url_amigavel_bicicleta' => $this->gerarUrlAmigavel($nome_bicicleta),
            'data_cadastro' => $data_bicicleta,
            'descricao_bicicleta' => $descricao_bicicleta,
            'status_bicicleta' => $status_bicicleta
        );
        
        if ($imagem_atualizar) {
            $campos['imagem_principal_bicicleta'] = $nome_imagem_principal;
        }

        $bicicletas = new Bicicleta();
        $bicicletas->updateBicicleta($campos, array('id_bicicleta' => $id));

        $excluir_galeria = $request->getParsedBody()['excluir_imagem_galeria'];
        foreach ($excluir_galeria as $imagem) {
            $bicicletas->deleteImagemGaleria($imagem, $id);
            unlink($imagem);
        }

        $id_bicicleta = $id;

        if ($request->getUploadedFiles()['galeria_imagens']) {
            $galeria = $request->getUploadedFiles()['galeria_imagens'];
        }
        else {
            $galeria = false;
        }

        if ($galeria) {
            foreach ($galeria as $imagem) {
                $foto = array();
                if ($imagem->getError() === UPLOAD_ERR_OK) {
                    $extensao = pathinfo($imagem->getClientFilename(), PATHINFO_EXTENSION);
                
                    $nome = md5(uniqid(rand(), true)).pathinfo($imagem->getClientFilename(), PATHINFO_FILENAME).".".$extensao;
                
                    $foto["caminho_imagem"] = "resources/imagens/bicicletas/" . $nome;
                
                    $imagem->moveTo($foto["caminho_imagem"]);

                    $foto['id_bicicleta'] = $id_bicicleta;
                    
                    $bicicletas->insertFotoGaleria($foto);
                }
            } 
        }
        
        header('Location: '.URL_BASE.'admin/bicicletas');
        exit();
    }

    public function bicicletas_delete(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        $args
    ) {
        $id = $request->getParsedBody()['id_bicicleta'];

        $bicicletas = new Bicicleta();
        $resultado = $bicicletas->selectBicicleta('*', array('id_bicicleta' => $id))[0];
        $resultado['galeria'] = $bicicletas->selectGaleria($id);

        unlink($resultado['imagem_principal_bicicleta']);
        
        foreach ($resultado['galeria'] as $imagem) {
            unlink($imagem['caminho_imagem']);
        }

        $bicicletas->deleteBicicleta('id_bicicleta', $id);

        header('Location: '.URL_BASE.'admin/bicicletas');
        exit();
    }

    private function gerarUrlAmigavel($url) {

        $search = ['@<script[^>]*?>.*?</script>@si', '@<style[^>]*?>.*?</style>@siU', '@<[\/\!]*?[^<>]*?>@si', '@<![\s\S]*?--[ \t\n\r]*>@'];

        $string = preg_replace($search, '', $url);

        $table = ['Š'=>'S','š'=>'s','Đ'=>'Dj','đ'=>'dj','Ž'=>'Z','ž'=>'z','Č'=>'C','č'=>'c','Ć'=>'C','ć'=>'c','À'=>'A','Á'=>'A','Â'=>'A','Ã'=>'A','Ä'=>'A','Å'=>'A','Æ'=>'A','Ç'=>'C','È'=>'E','É'=>'E','Ê'=>'E','Ë'=>'E','Ì'=>'I','Í'=>'I','Î'=>'I','Ï'=>'I','Ñ'=>'N','Ò'=>'O','Ó'=>'O','Ô'=>'O','Õ'=>'O','Ö'=>'O','Ø'=>'O','Ù'=>'U','Ú'=>'U','Û'=>'U','Ü'=>'U','Ý'=>'Y','Þ'=>'B','ß'=>'Ss','à'=>'a','á'=>'a','â'=>'a','ã'=>'a','ä'=>'a','å'=>'a','æ'=>'a','ç'=>'c','è'=>'e','é'=>'e','ê'=>'e','ë'=>'e','ì'=>'i','í'=>'i','î'=>'i','ï'=>'i','ð'=>'o','ñ'=>'n','ò'=>'o','ó'=>'o','ô'=>'o','õ'=>'o','ö'=>'o','ø'=>'o','ù'=>'u','ú'=>'u','û'=>'u','ý'=>'y','ý'=>'y','þ'=>'b','ÿ'=>'y','Ŕ'=>'R','ŕ'=>'r'
        ];

        $string = strtr($string, $table);
        $string = mb_strtolower($string);
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        $string = str_replace(" ", "_", $string);
        return $string;
    }
}