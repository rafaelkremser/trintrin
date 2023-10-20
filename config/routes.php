<?php
use Slim\App;
return function (App $app) {
    $app->get('/', '\App\Controller\HomeController:home');
    $app->get('/bikes', '\App\Controller\HomeController:bikes');
    $app->get('/bikes/{id}', '\App\Controller\HomeController:bikes_view');
    $app->get('/bikes/payment/{id}', '\App\Controller\HomeController:bikes_payment');

    // Controlador Admin
    $app->get('/admin-login', '\App\Controller\AdminController:login');
    $app->get('/admin/usuario', '\App\Controller\AdminController:usuario');
    $app->get('/admin/dashboard', '\App\Controller\AdminController:dashboard');
    $app->get('/admin/site', '\App\Controller\AdminController:site');
    $app->get('/admin/logout', '\App\Controller\AdminController:logout');
    $app->post('/admin/usuario_update', '\App\Controller\AdminController:usuario_update');
    $app->post('/admin/login', '\App\Controller\AdminController:verificar_login');
    $app->post('/admin/site_update', '\App\Controller\AdminController:site_update');

    // Controlador Bicicletas
    $app->get('/admin/bicicletas', '\App\Controller\BicicletasController:bicicletas');
    $app->get('/admin/bicicletas-cadastrar', '\App\Controller\BicicletasController:bicicletas_create');
    $app->get('/admin/bicicletas-editar/{id}', '\App\Controller\BicicletasController:bicicletas_edit');
    $app->post('/admin/bicicletas_insert', '\App\Controller\BicicletasController:bicicletas_insert');
    $app->post('/admin/bicicletas_update', '\App\Controller\BicicletasController:bicicletas_update');
    $app->post('/admin/bicicletas_delete', '\App\Controller\BicicletasController:bicicletas_delete');

    // Cadastro
    $app->get('/cadastrar', '\App\Controller\AdminController:cadastro');
    $app->post('/cadastrar_insert', '\App\Controller\AdminController:cadastrar_insert');
};
