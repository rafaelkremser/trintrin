<?=$this->fetch('../common/header.php', $data)?>

<section class="create_livros">
    <div class="admin-container">
        <div class="titulo_pagina">
            <i class='bx bx-book'></i> Bicicletas - Cadastrar
        </div>
        <hr>
        <div class="form">
            <form action="<?=URL_BASE?>admin/bicicletas_insert" method="post" enctype="multipart/form-data">
                <div class="row first-row">
                    <div class="w-80">
                        <label><span>Nome da bicicleta</span></label>
                        <input type="text" name="nome_bicicleta" required>
                    </div>
                    <div class="w-20">
                        <label><span>Data</span></label>
                        <input type="date" name="data_bicicleta" required>
                    </div>
                </div>
                <div class="row">
                    <label><span>Descrição</span></label>
                    <textarea name="descricao_bicicleta" id="descricao_bicicleta" required></textarea>
                </div>
                <div class="row">
                    <label><span>Imagem</span></label>
                    <input type="file" name="imagem_principal" accept="image/*" required>
                    <!--<div class="imagem">
                        <img src="<?=URL_BASE?>" value="<?=$data['informacoes']['bicicleta']['autor_bicicleta']?>">
                        <label>
                            <div class="delete-image">
                                <input type="checkbox" name="excluir_imagem_principal">
                                Excluir imagem
                            </div>
                        </label>
                    </div>-->
                </div>
                <div class="row">
                    <label><span>Galeria de Imagens</span></label>
                    <input type="file" name="galeria_imagens[]" accept="image/*" multiple>
                    <!--<div class="row galeria-de-imagem">
                        
                    </div>-->
                    
                    <div class="row row-select">
                        <label>
                            <span>Ativo</span>
                            <select name="ativo_bicicleta" required>
                                <option value="s">Sim</option>
                                <option value="n">Não</option>
                            </select>
                        </label>
                    </div>
                    <div class="row button">
                        <button type="submit">Salvar</button>
                    </div>
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