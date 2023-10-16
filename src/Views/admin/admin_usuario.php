<?=$this->fetch('common/header.php', $data)?>

<section class="create_livros">
    <div class="admin-container">
        <div class="titulo_pagina">
            <i class='bx bx-user-circle'></i> Usuário
        </div>
        <hr>
        <div class="form">
            <form action="<?=URL_BASE?>admin/usuario_update" class="form_ajax" method="post" enctype="multipart/form-data">
                <div class="row first-row">
                    <div class="w-50">
                        <label><span>Nome</span></label>
                        <input type="text" name="nome_usuario" value="<?=$data['informacoes']['usuario']['nome_usuario']?>" required>
                    </div>
                    <div class="w-50">
                        <label><span>E-mail</span></label>
                        <input type="mail" name="email_usuario" value="<?=$data['informacoes']['usuario']['email_usuario']?>" required>
                    </div>
                </div>
                <div class="row">
                    <label><span>Foto usuário</span></label>
                    <input type="file" name="foto_usuario">
                    <div class="imagem">
                        <img src="<?=URL_BASE.$data['informacoes']['usuario']['foto_usuario']?>">
                        <label>
                            <div class="delete-image">
                                <input type="checkbox" name="excluir_foto_usuario">
                                Excluir imagem
                            </div>
                        </label>
                    </div>
                </div>
                <div class="row aviso-senha">
                    <i class='bx bxs-error-circle'></i>
                    <p>Caso deseje alterar a sua senha, preencha os dois campos abaixo.</p>
                </div>
                <div class="row first-row">
                    <div class="w-50">
                        <label><span>Senha</span></label>
                        <input type="password" name="senha_usuario">
                    </div>
                    <div class="w-50">
                        <label><span>Confirmar senha</span></label>
                        <input type="password" name="confirmar_senha_usuario">
                    </div>
                </div>
                <div class="row button">
                    <button type="submit">Salvar</button>
                </div>
                <input type="hidden" name="id_usuario" value="1">
                <div class="alerta"></div>
            </form>
        </div>
    </div>
</section>



<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<?=$this->fetch('common/footer.php')?>