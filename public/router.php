<?php
/**
 * Router para o servidor de desenvolvimento do PHP
 * Este arquivo é usado pelo servidor built-in do PHP para redirecionar
 * todas as requisições para index.php quando o arquivo não existe
 */

$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);

// Se o arquivo existe (CSS, JS, imagens), serve diretamente
if (file_exists(__DIR__ . $path)) {
    return false;
}

// Caso contrário, redireciona para index.php
require_once __DIR__ . '/index.php';
