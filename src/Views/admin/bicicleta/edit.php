<?=$this->fetch('../common/header.php', $data)?>

<section class="create_livros">
    <div class="admin-container">
        <div class="titulo_pagina">
            <i class='bx bx-book'></i> Bicicletas - Editar
        </div>
        <hr>
        <div class="form">
            <form action="<?=URL_BASE?>admin/bicicletas_update" method="post" enctype="multipart/form-data">
                <div class="row first-row">
                    <div class="w-80">
                        <label><span>Nome</span></label>
                        <input type="text" name="nome_bicicleta" value="<?=$data['informacoes']['bicicleta']['nome_bicicleta']?>" required>
                    </div>
                    <div class="w-20">
                        <label><span>Data</span></label>
                        <input type="date" name="data_bicicleta" value="<?=date('Y-m-d', strtotime($data['informacoes']['bicicleta']['data_cadastro']))?>" required>
                    </div>
                </div>
                <div class="row">
                    <label><span>Descrição</span></label>
                    <textarea name="descricao_bicicleta" id="descricao_bicicleta" required><?=$data['informacoes']['bicicleta']['descricao_bicicleta']?></textarea>
                </div>
                <div class="row">
                    <label><span>Imagem</span></label>
                    <input type="file" name="imagem_principal">
                    <div class="imagem">
                        <img src="<?=URL_BASE.$data['informacoes']['bicicleta']['imagem_principal_bicicleta']?>">
                        <label>
                            <div class="delete-image">
                                <input type="checkbox" name="excluir_imagem_principal">
                                Excluir imagem
                            </div>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <label><span>Galeria de Imagens</span></label>
                    <input type="file" name="galeria_imagens[]" multiple>
                    <div class="row galeria-de-imagem">
                        <?php foreach ($data['informacoes']['bicicleta']['galeria'] as $imagem) { ?>
                            <div class="imagem">
                                <img src="<?=URL_BASE.$imagem['caminho_imagem']?>">
                                <label>
                                    <div class="delete-image">
                                        <input type="checkbox" name="excluir_imagem_galeria[]" value="<?=$imagem['caminho_imagem']?>">
                                        Excluir imagem
                                    </div>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                    
                    <div class="row row-select">
                        <label>
                            <span>Ativo</span>
                            <select name="ativo_bicicleta" value="<?=$data['informacoes']['bicicleta']['ativo_bicicleta']?>" required>
                                <option value="s" <?php if($data['informacoes']['bicicleta']['status_bicicleta'] === 's') echo 'selected' ?>>Sim</option>
                                <option value="n" <?php if($data['informacoes']['bicicleta']['status_bicicleta'] === 'n') echo 'selected' ?>>Não</option>
                            </select>
                        </label>
                    </div>
                    <div class="row button">
                        <button type="submit">Salvar</button>
                    </div>
                        <input type="hidden" name="id_bicicleta" value="<?=$data['informacoes']['bicicleta']['id_bicicleta']?>">
                        <input type="hidden" name="nome_imagem_atual" value="<?=$data['informacoes']['bicicleta']['imagem_principal_bicicleta']?>">
                </div>
            </form>
        </div>
    </div>
</section>



<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'descricao_bicicleta' );
</script>
<?=$this->fetch('../common/footer.php')?>