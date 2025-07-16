<?php
session_start();

// Configurar para exibir erros durante desenvolvimento
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Definir o diretório base
define('BASE_PATH', __DIR__);

// Incluir as classes necessárias
require_once BASE_PATH . '/../app/core/Router.php';
require_once BASE_PATH . '/../app/controllers/HomeController.php';
require_once BASE_PATH . '/../app/controllers/UserController.php';
require_once BASE_PATH . '/../app/controllers/LogController.php';
require_once BASE_PATH . '/../app/controllers/XmlController.php';

// Criar instância do router
$router = new Router();

// Definir as rotas
// Rota para a página inicial
$router->addRoute('GET', '/', 'HomeController', 'index');

// Rotas para usuários
$router->addRoute('GET', '/users', 'UserController', 'index');
$router->addRoute('GET', '/users/create', 'UserController', 'create');
$router->addRoute('POST', '/users/store', 'UserController', 'store');
$router->addRoute('GET', '/users/show', 'UserController', 'show');
$router->addRoute('GET', '/users/edit', 'UserController', 'edit');
$router->addRoute('POST', '/users/update', 'UserController', 'update');
$router->addRoute('POST', '/users/delete', 'UserController', 'delete');

// Rotas para logs
$router->addRoute('GET', '/logs', 'LogController', 'index');
$router->addRoute('GET', '/logs/clear', 'LogController', 'clear');
$router->addRoute('GET', '/logs/api', 'LogController', 'api');

// Rotas para XML (Import/Export)
$router->addRoute('GET', '/xml', 'XmlController', 'index');
$router->addRoute('POST', '/xml/import', 'XmlController', 'import');
$router->addRoute('GET', '/xml/export', 'XmlController', 'export');
$router->addRoute('GET', '/xml/exemplo', 'XmlController', 'exemplo');

// Obter o método e o caminho da requisição
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Se estivermos acessando diretamente index.php, redirecionar para a raiz
if ($requestPath === '/public/index.php' || $requestPath === '/index.php') {
    $requestPath = '/';
}

// Remover '/public' do início do caminho se existir
if (strpos($requestPath, '/public') === 0) {
    $requestPath = substr($requestPath, 7); // Remove '/public'
    if (empty($requestPath)) {
        $requestPath = '/';
    }
}

// Remover barras no final da URL (exceto para a raiz)
if ($requestPath !== '/' && substr($requestPath, -1) === '/') {
    $requestPath = rtrim($requestPath, '/');
}

// Debug: mostrar o caminho processado (remover em produção)
// echo "<!-- Debug: Request Path: $requestPath -->";

// Despachar a rota
$router->dispatch($requestMethod, $requestPath);
?>
