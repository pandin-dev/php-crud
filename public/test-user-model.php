<?php
/**
 * Teste das operações do User Model com logs
 */

require_once __DIR__ . '/../app/models/User.php';

echo "<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Teste User Model + Logs</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body>
    <div class='container mt-5'>
        <h1>🧪 Teste User Model + Sistema de Logs</h1>";

echo "<div class='alert alert-info'>
        <p>Testando operações CUD através do User Model para verificar se os logs são registrados.</p>
      </div>";

try {
    $userModel = new User();
    
    // Limpar logs antes do teste
    $logFile = __DIR__ . '/../logs/database_actions.json';
    file_put_contents($logFile, '[]');
    echo "<div class='alert alert-secondary'>🗑️ Logs limpos para teste</div>";
    
    // Teste 1: CREATE
    echo "<div class='card mb-3'>";
    echo "<div class='card-header'><strong>Teste 1: CREATE (INSERT)</strong></div>";
    echo "<div class='card-body'>";
    
    $userData = [
        'nome' => 'Usuário Teste Model',
        'email' => 'model.test.' . uniqid() . '@test.com',
        'telefone' => '(11) 99999-9999',
        'data_nascimento' => '1990-01-01'
    ];
    
    echo "<p>Criando usuário: " . htmlspecialchars($userData['nome']) . "</p>";
    $userId = $userModel->create($userData);
    
    if ($userId) {
        echo "<p>✅ <strong>Usuário criado com sucesso! ID: $userId</strong></p>";
        
        // Verificar logs
        $logs = json_decode(file_get_contents($logFile), true);
        echo "<p><strong>Logs após CREATE:</strong> " . count($logs) . " registros</p>";
        if (!empty($logs)) {
            echo "<pre class='bg-light p-2'>" . htmlspecialchars(json_encode($logs, JSON_PRETTY_PRINT)) . "</pre>";
        }
        
        // Teste 2: UPDATE
        echo "<hr>";
        echo "<h5>Teste 2: UPDATE</h5>";
        
        $updateData = [
            'nome' => 'Usuário Teste Model ATUALIZADO',
            'email' => $userData['email'], // Mesmo email
            'telefone' => '(11) 88888-8888',
            'data_nascimento' => '1990-01-01'
        ];
        
        echo "<p>Atualizando usuário ID: $userId</p>";
        $updateResult = $userModel->update($userId, $updateData);
        
        if ($updateResult) {
            echo "<p>✅ <strong>Usuário atualizado com sucesso!</strong></p>";
            
            // Verificar logs após update
            $logs = json_decode(file_get_contents($logFile), true);
            echo "<p><strong>Logs após UPDATE:</strong> " . count($logs) . " registros</p>";
            if (!empty($logs)) {
                echo "<pre class='bg-light p-2'>" . htmlspecialchars(json_encode($logs, JSON_PRETTY_PRINT)) . "</pre>";
            }
        } else {
            echo "<p>❌ Falha ao atualizar usuário</p>";
        }
        
        // Teste 3: DELETE
        echo "<hr>";
        echo "<h5>Teste 3: DELETE</h5>";
        
        echo "<p>Deletando usuário ID: $userId</p>";
        $deleteResult = $userModel->delete($userId);
        
        if ($deleteResult) {
            echo "<p>✅ <strong>Usuário deletado com sucesso!</strong></p>";
            
            // Verificar logs após delete
            $logs = json_decode(file_get_contents($logFile), true);
            echo "<p><strong>Logs após DELETE:</strong> " . count($logs) . " registros</p>";
            if (!empty($logs)) {
                echo "<pre class='bg-light p-2'>" . htmlspecialchars(json_encode($logs, JSON_PRETTY_PRINT)) . "</pre>";
            }
        } else {
            echo "<p>❌ Falha ao deletar usuário</p>";
        }
        
    } else {
        echo "<p>❌ Falha ao criar usuário</p>";
    }
    
    echo "</div></div>";
    
    echo "<div class='alert alert-success'>
            <h4>✅ Teste Concluído!</h4>
            <p>Se você viu logs JSON sendo exibidos acima, o sistema está funcionando corretamente!</p>
            <a href='/logs' class='btn btn-primary'>Ver Interface de Logs</a>
            <a href='/users' class='btn btn-secondary'>Ver Usuários</a>
          </div>";
    
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>
            <h4>❌ Erro:</h4>
            <p>" . htmlspecialchars($e->getMessage()) . "</p>
            <pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>
          </div>";
}

echo "
    </div>
</body>
</html>";
?>
