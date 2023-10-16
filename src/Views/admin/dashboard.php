<?=$this->fetch('common/header.php', $data)?>

<section class="dashboard">
    <div class="admin-container">
        <div class="titulo_pagina">
            <i class='bx bxs-dashboard'></i> Dashboard
        </div>
        <hr>
        <p>Bem-vindo, <?=$_SESSION['usuario_logado']['nome_usuario']?>!</p>
        <br>
        <p>Esse é o painel administrativo do seu site. Aqui você pode cadastrar novas bicicletas e gerenciar suas locações, além de poder também acessar e-mails cadastrados e mensagens de visitantes.</p>
    </div>
</section>

<?=$this->fetch('common/footer.php')?>