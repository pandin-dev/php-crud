<?php 
include __DIR__ . '/../layouts/header.php'; 

// Função para determinar a classe do badge baseada na ação
function getActionBadgeClass($action) {
    switch ($action) {
        case 'INSERT': return 'success';
        case 'UPDATE': return 'warning';
        case 'DELETE': return 'danger';
        case 'CREATE': return 'primary';
        case 'DROP': return 'danger';
        case 'ALTER': return 'warning';
        default: return 'secondary';
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1>Logs de Ações do Banco de Dados</h1>
                    <p class="text-muted">Registrando apenas operações <strong>CUD</strong> (Create, Update, Delete) - Máximo de 2 registros</p>
                </div>
                <div>
                    <a href="/logs/api" class="btn btn-info" target="_blank">Ver JSON</a>
                    <a href="/logs/clear" class="btn btn-warning" onclick="return confirm('Tem certeza que deseja limpar todos os logs?')">Limpar Logs</a>
                </div>
            </div>

            <?php if (empty($logs)): ?>
                <div class="alert alert-info">
                    <h5>📋 Nenhuma ação CUD registrada ainda</h5>
                    <p>O sistema registra apenas operações de <strong>modificação</strong> do banco de dados:</p>
                    <ul class="mb-0">
                        <li><strong>CREATE</strong> - Criação de tabelas/estruturas</li>
                        <li><strong>INSERT</strong> - Inserção de dados</li>
                        <li><strong>UPDATE</strong> - Atualização de dados</li>
                        <li><strong>DELETE</strong> - Exclusão de dados</li>
                        <li><strong>ALTER/DROP</strong> - Modificação/Exclusão de estruturas</li>
                    </ul>
                    <hr>
                    <p class="mb-0"><em>Operações SELECT (leitura) não são registradas nos logs.</em></p>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($logs as $index => $log): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <span class="badge badge-<?php echo getActionBadgeClass($log['action']); ?>">
                                            <?php echo htmlspecialchars($log['action']); ?>
                                        </span>
                                        Ação #<?php echo $index + 1; ?>
                                    </h5>
                                    <small class="text-muted"><?php echo htmlspecialchars($log['timestamp']); ?></small>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h6>SQL Executado:</h6>
                                        <pre class="bg-light p-2 rounded"><code><?php echo htmlspecialchars($log['sql']); ?></code></pre>
                                    </div>
                                    
                                    <?php if (!empty($log['parameters'])): ?>
                                        <div class="mb-3">
                                            <h6>Parâmetros:</h6>
                                            <pre class="bg-light p-2 rounded"><code><?php echo htmlspecialchars(json_encode($log['parameters'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></code></pre>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="mb-3">
                                        <h6>Resultado:</h6>
                                        <span class="badge badge-<?php echo is_string($log['result']) && $log['result'] === 'success' ? 'success' : 'secondary'; ?>">
                                            <?php echo htmlspecialchars($log['result']); ?>
                                        </span>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small><strong>IP:</strong> <?php echo htmlspecialchars($log['ip_address']); ?></small>
                                        </div>
                                        <div class="col-md-6">
                                            <small><strong>ID:</strong> <?php echo htmlspecialchars($log['id']); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.badge-INSERT { background-color: #28a745; }
.badge-UPDATE { background-color: #ffc107; color: #212529; }
.badge-DELETE { background-color: #dc3545; }
.badge-CREATE { background-color: #6f42c1; }
.badge-DROP { background-color: #dc3545; }
.badge-ALTER { background-color: #fd7e14; }
.badge-OTHER { background-color: #6c757d; }

pre code {
    font-size: 0.85rem;
    max-height: 150px;
    overflow-y: auto;
}

.card {
    border-left: 4px solid;
}

.card:nth-child(odd) {
    border-left-color: #007bff;
}

.card:nth-child(even) {
    border-left-color: #6c757d;
}
</style>

<script>
// Auto-refresh a cada 30 segundos
setTimeout(function() {
    location.reload();
}, 30000);
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
