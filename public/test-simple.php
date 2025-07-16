<?php
// Teste simples de log
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Iniciando teste...\n";

require_once __DIR__ . '/../app/core/Database.php';

try {
    echo "Criando instância do Database...\n";
    $db = Database::getInstance();
    echo "Database criado com sucesso!\n";
    
    echo "Executando INSERT...\n";
    $result = $db->execute("INSERT INTO users (nome, email, created_at) VALUES (?, ?, NOW())", 
                          ['Teste Simples', 'teste.simples@test.com']);
    
    echo "Resultado do INSERT: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";
    
    if ($result) {
        $lastId = $db->lastInsertId();
        echo "ID inserido: $lastId\n";
        
        echo "Verificando logs...\n";
        $logFile = __DIR__ . '/../logs/database_actions.json';
        $content = file_get_contents($logFile);
        echo "Conteúdo do log: $content\n";
        
        // Cleanup
        echo "Executando DELETE para limpeza...\n";
        $deleteResult = $db->execute("DELETE FROM users WHERE id = ?", [$lastId]);
        echo "DELETE resultado: " . ($deleteResult ? 'SUCCESS' : 'FAILED') . "\n";
        
        echo "Verificando logs após DELETE...\n";
        $content2 = file_get_contents($logFile);
        echo "Conteúdo do log após DELETE: $content2\n";
    }
    
} catch (Exception $e) {
    echo "ERRO: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "Teste finalizado.\n";
?>
