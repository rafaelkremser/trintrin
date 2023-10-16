<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="<?=URL_BASE?>resources/css/css.css">
</head>
<body>
    <div class="bg-admin-login">
        <div class="admin-login-container">
            <form action="<?=URL_BASE?>cadastrar_insert" method="post" class="form_ajax">
                <h1>Cadastro</h1>
                <div class="input-group">
                    <label for="">Nome completo</label>
                    <input type="text" name="nome_usuario" placeholder="Nome completo" required>
                </div>
                <div class="input-group">
                    <label for="">E-mail</label>
                    <input type="text" name="email_usuario" placeholder="E-mail" required>
                </div>
                <div class="input-group">
                    <label for="">Senha</label>
                    <input type="password" name="senha_usuario" placeholder="Senha" required>
                </div>
                <div class="input-group">
                    <label for="">Confirmar senha</label>
                    <input type="password" name="confirmar_senha_usuario" placeholder="Confirmar senha" required>
                </div>
                <input type="submit" value="Cadastrar">
                <div class="alerta-cadastro"></div>
            </form>
        </div>
    </div>

    <script src="<?=URL_BASE?>resources/js/jquery/jquery.min.js"></script>
	<script src="<?=URL_BASE?>resources/js/slick/slick.min.js"></script>
	<script src="<?=URL_BASE?>resources/js/form/jquery.form.min.js"></script>
	<script src="<?=URL_BASE?>resources/js/js.min.js"></script>
</body>
</html>