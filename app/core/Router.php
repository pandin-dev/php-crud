<?php

class Router
{
    private $routes = [];

    public function addRoute($method, $path, $controller, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch($requestMethod, $requestPath)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestPath) {
                $controller = new $route['controller']();
                $action = $route['action'];
                return $controller->$action();
            }
        }
        
        // Rota não encontrada
        http_response_code(404);
        echo "<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Página não encontrada</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body>
    <div class='container mt-5'>
        <div class='row'>
            <div class='col-md-6 offset-md-3 text-center'>
                <h1 class='display-1'>404</h1>
                <h2>Página não encontrada</h2>
                <p class='lead'>A página que você está procurando não existe.</p>
                <a href='/' class='btn btn-primary'>Voltar ao início</a>
            </div>
        </div>
    </div>
</body>
</html>";
    }
}
