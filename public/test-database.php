<?php
/**
 * Script de teste de conexão com o banco de dados
 * Execute este arquivo para verificar se a conexão está funcionando
 */

require_once __DIR__ . '/../app/core/Database.php';

echo "<h2>Teste de Conexão com o Banco de Dados</h2>";

try {
    // Tentar conectar ao banco
    $db = Database::getInstance();
    $connection = $db->getConnection();
    
    if ($connection) {
        echo "<p style='color: green;'>✅ Conexão com o banco de dados estabelecida com sucesso!</p>";
        
        // Testar se a tabela users existe
        $stmt = $connection->prepare("SHOW TABLES LIKE 'users'");
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result) {
            echo "<p style='color: green;'>✅ Tabela 'users' encontrada!</p>";
            
            // Contar registros na tabela
            $stmt = $connection->prepare("SELECT COUNT(*) as total FROM users");
            $stmt->execute();
            $count = $stmt->fetch();
            
            echo "<p style='color: blue;'>📊 Total de usuários cadastrados: " . $count['total'] . "</p>";
            
            // Mostrar estrutura da tabela
            echo "<h3>Estrutura da tabela 'users':</h3>";
            $stmt = $connection->prepare("DESCRIBE users");
            $stmt->execute();
            $columns = $stmt->fetchAll();
            
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Chave</th><th>Padrão</th><th>Extra</th></tr>";
            
            foreach ($columns as $column) {
                echo "<tr>";
                echo "<td>" . $column['Field'] . "</td>";
                echo "<td>" . $column['Type'] . "</td>";
                echo "<td>" . $column['Null'] . "</td>";
                echo "<td>" . $column['Key'] . "</td>";
                echo "<td>" . $column['Default'] . "</td>";
                echo "<td>" . $column['Extra'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            
        } else {
            echo "<p style='color: red;'>❌ Tabela 'users' não encontrada! Execute o script SQL em database/schema.sql</p>";
        }
        
    } else {
        echo "<p style='color: red;'>❌ Falha na conexão com o banco de dados!</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro: " . $e->getMessage() . "</p>";
    echo "<p>Verifique as configurações em config/database.php</p>";
}

echo "<hr>";
echo "<h3>Configurações atuais do banco:</h3>";
$config = require __DIR__ . '/../config/database.php';
echo "<ul>";
echo "<li><strong>Host:</strong> " . $config['host'] . "</li>";
echo "<li><strong>Database:</strong> " . $config['dbname'] . "</li>";
echo "<li><strong>Username:</strong> " . $config['username'] . "</li>";
echo "<li><strong>Charset:</strong> " . $config['charset'] . "</li>";
echo "</ul>";

echo "<hr>";
echo "<p><a href='index.php'>← Voltar para o sistema</a></p>";
?>
