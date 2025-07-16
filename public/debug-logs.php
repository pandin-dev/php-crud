<?php
/**
 * Debug do sistema de logs
 *    $randomEmail = 'debug.' . uniqid() . '@test.com';
    echo "<p>Executando: INSERT INTO users (nome, email, created_at) VALUES ('Debug User', '$randomEmail', NOW())</p>";
    
    $result = $db->execute("INSERT INTO users (nome, email, created_at) VALUES (?, ?, NOW())", 
                          ['Debug User', $randomEmail]);require_once __DIR__ . '/../app/core/Database.php';

echo "<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Debug do Sistema de Logs</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body>
    <div class='container mt-5'>
        <h1>🔍 Debug do Sistema de Logs</h1>";

echo "<div class='alert alert-info'>
        <h5>Verificações do Sistema:</h5>
      </div>";

try {
    $db = Database::getInstance();
    
    // Verificar se o arquivo de log existe e tem permissões
    $logFile = __DIR__ . '/../logs/database_actions.json';
    echo "<div class='card mb-3'>";
    echo "<div class='card-header'><strong>1. Verificação do Arquivo de Log</strong></div>";
    echo "<div class='card-body'>";
    echo "<p><strong>Caminho:</strong> $logFile</p>";
    echo "<p><strong>Existe:</strong> " . (file_exists($logFile) ? '✅ Sim' : '❌ Não') . "</p>";
    echo "<p><strong>Legível:</strong> " . (is_readable($logFile) ? '✅ Sim' : '❌ Não') . "</p>";
    echo "<p><strong>Gravável:</strong> " . (is_writable($logFile) ? '✅ Sim' : '❌ Não') . "</p>";
    echo "<p><strong>Conteúdo atual:</strong> " . htmlspecialchars(file_get_contents($logFile)) . "</p>";
    echo "</div></div>";
    
    // Testar INSERT com debug
    echo "<div class='card mb-3'>";
    echo "<div class='card-header'><strong>2. Teste INSERT com Debug</strong></div>";
    echo "<div class='card-body'>";
    
    $randomEmail = 'debug.' . uniqid() . '@test.com';
    echo "<p>Executando: INSERT INTO users (name, email, created_at) VALUES ('Debug User', '$randomEmail', NOW())</p>";
    
    $result = $db->execute("INSERT INTO users (name, email, created_at) VALUES (?, ?, NOW())", 
                          ['Debug User', $randomEmail]);
    
    echo "<p><strong>Resultado do INSERT:</strong> " . ($result ? '✅ Sucesso' : '❌ Falha') . "</p>";
    
    if ($result) {
        $lastId = $db->lastInsertId();
        echo "<p><strong>ID inserido:</strong> $lastId</p>";
        
        // Verificar logs após INSERT
        $logsAfterInsert = file_get_contents($logFile);
        echo "<p><strong>Logs após INSERT:</strong></p>";
        echo "<pre class='bg-light p-2'>" . htmlspecialchars($logsAfterInsert) . "</pre>";
        
        // Testar UPDATE
        echo "<hr>";
        echo "<p>Executando: UPDATE users SET nome = 'Debug User Updated' WHERE id = $lastId</p>";
        
        $updateResult = $db->execute("UPDATE users SET nome = ? WHERE id = ?", 
                                   ['Debug User Updated', $lastId]);
        
        echo "<p><strong>Resultado do UPDATE:</strong> " . ($updateResult ? '✅ Sucesso' : '❌ Falha') . "</p>";
        
        // Verificar logs após UPDATE
        $logsAfterUpdate = file_get_contents($logFile);
        echo "<p><strong>Logs após UPDATE:</strong></p>";
        echo "<pre class='bg-light p-2'>" . htmlspecialchars($logsAfterUpdate) . "</pre>";
        
        // Testar DELETE
        echo "<hr>";
        echo "<p>Executando: DELETE FROM users WHERE id = $lastId</p>";
        
        $deleteResult = $db->execute("DELETE FROM users WHERE id = ?", [$lastId]);
        
        echo "<p><strong>Resultado do DELETE:</strong> " . ($deleteResult ? '✅ Sucesso' : '❌ Falha') . "</p>";
        
        // Verificar logs após DELETE
        $logsAfterDelete = file_get_contents($logFile);
        echo "<p><strong>Logs após DELETE:</strong></p>";
        echo "<pre class='bg-light p-2'>" . htmlspecialchars($logsAfterDelete) . "</pre>";
    }
    
    echo "</div></div>";
    
    // Verificar se a instância do logger existe
    echo "<div class='card mb-3'>";
    echo "<div class='card-header'><strong>3. Verificação de Classes</strong></div>";
    echo "<div class='card-body'>";
    echo "<p><strong>Classe Database:</strong> " . (class_exists('Database') ? '✅ Existe' : '❌ Não existe') . "</p>";
    echo "<p><strong>Classe Logger:</strong> " . (class_exists('Logger') ? '✅ Existe' : '❌ Não existe') . "</p>";
    
    // Testar logger diretamente
    if (class_exists('Logger')) {
        $logger = new Logger();
        echo "<p><strong>Logger instanciado:</strong> ✅ Sim</p>";
        
        // Testar diretamente
        echo "<p>Testando logger diretamente...</p>";
        $logger->logDatabaseAction('INSERT', 'INSERT INTO test VALUES (1)', [], true);
        
        $logsAfterDirect = file_get_contents($logFile);
        echo "<p><strong>Logs após teste direto:</strong></p>";
        echo "<pre class='bg-light p-2'>" . htmlspecialchars($logsAfterDirect) . "</pre>";
    }
    
    echo "</div></div>";
    
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>
            <h4>Erro:</h4>
            <p>" . htmlspecialchars($e->getMessage()) . "</p>
            <p><strong>Trace:</strong></p>
            <pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>
          </div>";
}

echo "
        <div class='mt-4'>
            <a href='/logs' class='btn btn-primary'>Ver Interface de Logs</a>
            <a href='/test-logs.php' class='btn btn-secondary'>Teste Original</a>
        </div>
    </div>
</body>
</html>";
?>
