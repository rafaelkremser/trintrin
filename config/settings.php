<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Timezone
date_default_timezone_set('America/Sao_Paulo');

//Definindo diretorio principal
define('DIRETORIO_PRINCIPAL', '/');
define('DIRETORIO_TEMPLATES', 'src/Views/publica');
define('DIRETORIO_TEMPLATES_ADMIN', 'src/Views/admin');
define('URL_BASE', 'http://localhost/');

define('SQL_DB_SERVER', 'localhost');
define('SQL_DB_USER', 'root');
define('SQL_DB_PASS', '');
define('SQL_DB_DATABASE', 'trimtrim');

// Settings
$settings = [];

// Path settings
$settings['root'] = dirname(__DIR__);

// Error Handling Middleware settings
$settings['error'] = [
    'display_error_details' => true,
    'log_errors' => true,
    'log_error_details' => true,
];

return $settings;