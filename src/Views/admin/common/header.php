<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    <title>TrinTrin | Admin</title>
    <link href="<?=URL_BASE?>resources/css/css.css" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="admin">
	<header>
        <div class="container">
            <div class="left">
                <i class='bx bx-menu'></i>
            </div>
            <div class="right">
                <label class="switch">
                    <input type="checkbox" onclick="lightmode()">
                    <span class="slider"></span>
                </label>
                <div class="menu">
                    <ul>
                        <li>
                            <?=$_SESSION['usuario_logado']['nome_usuario']?>
                            <i class='bx bx-caret-down'></i>
                            <img src="<?=URL_BASE.$_SESSION['usuario_logado']['foto_usuario']?>">

                            <ul class="dropdown">
                                <li><a href="<?=URL_BASE?>admin/usuario">Perfil</a></li>
                                <li><a href="<?=URL_BASE?>admin/site">Configurações</a></li>
                                <li><a href="<?=URL_BASE?>admin/logout">Sair</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <aside class="">
            <div class="aside-content">
                <div class="admin-logo">
                    <i class='bx bx-x'></i>
                    <img src="<?=URL_BASE?>resources/imagens/header/trimtrim_header.png" alt="TrimTrim">
                </div>
                <hr class="frs-lnh">
                <ul>
                    <li><a href="<?=URL_BASE?>admin/dashboard" class="<?=($data['informacoes']['menu_active'] === 'dashboard') ? 'active' : '' ?>">
                        <i class='bx bxs-dashboard'></i>
                        Dashboard
                    </a></li>
                    <li class="nome_categoria">Conteúdo</li>
                    <hr>
                    <li><a href="<?=URL_BASE?>admin/bicicletas" class="<?=($data['informacoes']['menu_active'] === 'bicicletas') ? 'active' : '' ?>">
                        <i class='bx bx-bike'></i>
                        Bicicletas
                    </a></li>
                    <li class="nome_categoria">Configurações</li>
                    <hr>
                    <li><a href="<?=URL_BASE?>admin/usuario" class="<?=($data['informacoes']['menu_active'] === 'usuario') ? 'active' : '' ?>">
                        <i class='bx bx-user-circle'></i>
                        Usuário
                    </a></li>
                    <li><a href="<?=URL_BASE?>admin/logout">
                        <i class='bx bx-log-out'></i>
                        Sair
                    </a></li>
                </ul>
            </div>
            <div class="copyright">
                <p>Todos os direitos reservados &#169 <?=date('Y')?></p>
                <p>Desenvolvido por <a href="https://www.linkedin.com/in/rafaelkremser/">Grupo 5</a>.</p>
            </div>
            <div class="admin-shadow"></div>
        </aside>
	</header>
    <div class="conteudo">