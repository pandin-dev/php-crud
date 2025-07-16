<?php

return [
    // Configurações da aplicação
    'app_name' => 'Sistema CRUD',
    'app_version' => '1.0.0',
    'app_url' => 'http://localhost/crud/public',
    
    // Configurações de debug
    'debug' => true,
    'log_errors' => true,
    'timezone' => 'America/Sao_Paulo',
    'log_level' => 'debug',
    
    // Configurações de sessão
    'session' => [
        'lifetime' => 7200, // 2 horas
        'path' => '/',
        'domain' => '',
        'secure' => false,
        'httponly' => true
    ],
    
    // Configurações de paginação
    'pagination' => [
        'per_page' => 10,
        'max_per_page' => 100
    ],
    
    // Configurações de upload
    'upload' => [
        'max_size' => 2048, // KB
        'allowed_types' => ['jpg', 'jpeg', 'png', 'gif'],
        'upload_path' => 'uploads/'
    ],
    
    // Configurações de validação
    'validation' => [
        'min_name_length' => 2,
        'max_name_length' => 255,
        'min_phone_digits' => 10,
        'max_phone_digits' => 15
    ]
];
