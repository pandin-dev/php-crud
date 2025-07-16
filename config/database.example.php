<?php
// Configuração do banco de dados
// 
// INSTRUÇÕES:
// 1. Copie este arquivo para database.php
// 2. Configure com suas credenciais do MySQL
// 3. Altere o 'dbname' para o nome do seu banco

return [
    'host' => 'localhost',
    'dbname' => 'meu_sistema_crud', // Altere para o nome do seu banco
    'username' => 'seu_usuario',     // Seu usuário MySQL
    'password' => 'sua_senha',       // Sua senha MySQL
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
];
