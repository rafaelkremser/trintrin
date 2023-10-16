<?=$this->fetch('../common/header.php', $data)?>

<section class="livros">
    <div class="admin-container">
        <div class="titulo_pagina">
            <i class="icon ion-md-bicycle"></i> Bicicletas
        </div>
        <hr>
        
        <div class="top">
            <div class="btn">
                <a href="<?=URL_BASE?>admin/bicicletas-cadastrar">
                    <i class='bx bx-plus'></i>
                    <span>Nova bicicleta</span>
                </a>
            </div>
            <div class="form_pesquisa">
                <form action="<?=URL_BASE?>admin/bicicletas" method="GET">
                    <input type="text" name="pesquisa" placeholder="Nome da bicicleta">
                    <button type="submit">Pesquisar</button>
                </form>
            </div>
        </div>
        <div class="list">
            <table>
                <thead>
                    <tr>
                        <td class="id">ID</td>
                        <td class="acao">AÇÕES</td>
                        <td class="titulo">NOME</td>
                        <td class="data">DATA DE CADASTRO</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($data['informacoes']['lista'] as $bicicleta) {?>
                            <tr>
                                <td class="table-id"><?=$bicicleta['id_bicicleta']?></td>
                                <td class="acoes-icon">
                                    <div class="alinhamento">
                                        <a href="<?=URL_BASE?>admin/bicicletas-editar/<?=$bicicleta['id_bicicleta']?>"><i class='bx bxs-edit'></i></a>
                                        <form action="<?=URL_BASE?>admin/bicicletas_delete" method="post">
                                            <input type="hidden" name="id_bicicleta" value="<?=$bicicleta['id_bicicleta']?>">
                                            <button type="submit"><i class='bx bxs-trash'></i></button>
                                        </form>
                                    </div>
                                </td>
                                <td class="table-titulo"><?=$bicicleta['nome_bicicleta']?></td>
                                <td class="table-date"><?=date('d/m/y', strtotime($bicicleta['data_cadastro']))?></td>
                            </tr>
                    <?php }?>
                </tbody>
            </table>
            <div class="paginacao">
                <?php if (isset($data['informacoes']['paginaAnterior']) && $data['informacoes']['paginaAnterior'] !== false) { ?>
                    <a href="<?=$data['informacoes']['paginaAnterior']?>"><i class="bx bxs-left-arrow-circle"></i></a>
                <?php } ?>
                <span><?=$data['informacoes']['paginaAtual']?></span>
                <?php if (isset($data['informacoes']['proximaPagina']) && $data['informacoes']['proximaPagina'] !== false) { ?>
                    <a href="<?=$data['informacoes']['proximaPagina']?>"><i class="bx bxs-right-arrow-circle"></i></a>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<?=$this->fetch('../common/footer.php')?>