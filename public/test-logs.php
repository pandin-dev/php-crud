<?php
/**
 * Arquivo de teste para demonstrar o sistema de logs
 * Acesse este arquivo diretamente no navegador para gerar algumas ações no banco
 */

require_once __DIR__ . '/../app/core/Database.php';

echo "<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <meta nome='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Teste do Sistema de Logs</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body>
    <div class='container mt-5'>
        <h1>Teste do Sistema de Logs</h1>
        <div class='alert alert-info'>
            <p>Este arquivo executa algumas operações no banco de dados para testar o sistema de logs.</p>
            <p><strong>Nota:</strong> Apenas as operações <strong>CUD (Create, Update, Delete)</strong> são registradas nos logs. Operações SELECT não são logadas.</p>
            <p><strong>Nota:</strong> Apenas as duas últimas alterações CUD são mantidas nos logs.</p>
        </div>";

try {
    $db = Database::getInstance();
    
    // Teste 1: SELECT (não será logado)
    echo "<div class='alert alert-secondary'><strong>Teste 1:</strong> Executando SELECT (não será logado)...</div>";
    $users = $db->fetchAll("SELECT * FROM users LIMIT 5");
    echo "<p>✅ SELECT executado com sucesso. Registros encontrados: " . count($users) . " <em>(não aparecerá nos logs)</em></p>";
    
    // Teste 2: INSERT (será logado)
    echo "<div class='alert alert-secondary'><strong>Teste 2:</strong> Executando INSERT (será logado)...</div>";
    $result = $db->execute("INSERT INTO users (nome, email, created_at) VALUES (?, ?, NOW())", 
                          ['Usuário Teste Log', 'teste.log@exemplo.com']);
    if ($result) {
        echo "<p>✅ INSERT executado com sucesso. ID: " . $db->lastInsertId() . " <em>(LOG #1)</em></p>";
    }
    
    // Teste 3: UPDATE (será logado)
    echo "<div class='alert alert-secondary'><strong>Teste 3:</strong> Executando UPDATE (será logado)...</div>";
    $lastId = $db->lastInsertId();
    $result = $db->execute("UPDATE users SET nome = ? WHERE id = ?", 
                          ['Usuário Teste Log Atualizado', $lastId]);
    if ($result) {
        echo "<p>✅ UPDATE executado com sucesso. <em>(LOG #2)</em></p>";
    }
    
    // Teste 4: Outro SELECT (não será logado)
    echo "<div class='alert alert-secondary'><strong>Teste 4:</strong> Executando outro SELECT (não será logado)...</div>";
    $user = $db->fetch("SELECT * FROM users WHERE id = ?", [$lastId]);
    if ($user) {
        echo "<p>✅ SELECT específico executado com sucesso. Usuário: " . htmlspecialchars($user['nome']) . " <em>(não aparecerá nos logs)</em></p>";
    }
    
    // Teste 5: DELETE (será logado e substituirá o INSERT nos logs)
    echo "<div class='alert alert-secondary'><strong>Teste 5:</strong> Executando DELETE (será logado)...</div>";
    $result = $db->execute("DELETE FROM users WHERE id = ?", [$lastId]);
    if ($result) {
        echo "<p>✅ DELETE executado com sucesso. <em>(LOG #3 - agora apenas UPDATE e DELETE aparecem nos logs)</em></p>";
    }
    
    echo "
        <div class='alert alert-success mt-4'>
            <h4>Testes Concluídos!</h4>
            <p>Foram executadas 5 operações no banco de dados:</p>
            <ul>
                <li>✅ <strong>2 SELECT</strong> - <em>Não logados</em></li>
                <li>📝 <strong>1 INSERT</strong> - <em>Logado</em></li>
                <li>📝 <strong>1 UPDATE</strong> - <em>Logado</em></li>
                <li>📝 <strong>1 DELETE</strong> - <em>Logado</em></li>
            </ul>
            <p><strong>Resultado:</strong> Apenas as 2 últimas operações CUD (UPDATE e DELETE) devem aparecer nos logs.</p>
            <a href='/logs' class='btn btn-primary'>Ver Logs</a>
            <a href='/logs/api' class='btn btn-info' target='_blank'>Ver Logs (JSON)</a>
        </div>";
        
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>
            <h4>Erro:</h4>
            <p>" . htmlspecialchars($e->getMessage()) . "</p>
          </div>";
}

echo "
    </div>
</body>
</html>";
?>
