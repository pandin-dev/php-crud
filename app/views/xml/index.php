<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1><i class="fas fa-file-code"></i> Gerenciamento XML</h1>
                <p class="text-muted">Importe e exporte dados de usuários em formato XML</p>
            </div>
            <a href="/users" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar para Usuários
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Importar XML -->
    <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-upload"></i> Importar Usuários
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Importe múltiplos usuários a partir de um arquivo XML.</p>
                
                <form action="/xml/import" method="POST" enctype="multipart/form-data" id="importForm">
                    <div class="mb-3">
                        <label for="xml_file" class="form-label">Arquivo XML</label>
                        <input type="file" class="form-control" id="xml_file" name="xml_file" accept=".xml" required>
                        <div class="form-text">Selecione um arquivo XML com a estrutura correta.</div>
                    </div>
                    
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Formato Esperado:</h6>
                        <ul class="mb-0 small">
                            <li><strong>Elemento raiz:</strong> &lt;usuarios&gt;</li>
                            <li><strong>Cada usuário:</strong> &lt;usuario&gt;</li>
                            <li><strong>Campos obrigatórios:</strong> nome, email, telefone, data_nascimento</li>
                            <li><strong>Validações:</strong> Email único, formato de data YYYY-MM-DD</li>
                        </ul>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-upload"></i> Importar Usuários
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Exportar XML -->
    <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-download"></i> Exportar Usuários
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Exporte todos os usuários cadastrados para um arquivo XML.</p>
                
                <div class="mb-3">
                    <h6>O arquivo XML conterá:</h6>
                    <ul class="text-muted small">
                        <li>Todos os usuários cadastrados</li>
                        <li>Dados completos (ID, nome, email, telefone, datas)</li>
                        <li>Formato compatível para reimportação</li>
                        <li>Codificação UTF-8</li>
                    </ul>
                </div>
                
                <div class="alert alert-warning">
                    <small>
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Atenção:</strong> O arquivo incluirá todos os usuários do sistema, incluindo dados sensíveis.
                    </small>
                </div>
                
                <a href="/xml/export" class="btn btn-success w-100">
                    <i class="fas fa-download"></i> Exportar Todos os Usuários
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Exemplo e Ajuda -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-question-circle"></i> Ajuda e Exemplo
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Como usar:</h6>
                        <ol class="small">
                            <li><strong>Para importar:</strong> Prepare um arquivo XML com a estrutura mostrada ao lado</li>
                            <li><strong>Validação:</strong> Emails devem ser únicos no sistema</li>
                            <li><strong>Datas:</strong> Use formato YYYY-MM-DD (ex: 1990-01-15)</li>
                            <li><strong>Telefone:</strong> Aceita vários formatos, recomendado (11) 99999-0000</li>
                        </ol>
                        
                        <div class="mt-3">
                            <a href="/xml/exemplo" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-download"></i> Baixar XML de Exemplo
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Estrutura XML:</h6>
                        <pre class="bg-light p-3 rounded small"><code>&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;usuarios&gt;
    &lt;usuario&gt;
        &lt;nome&gt;João da Silva&lt;/nome&gt;
        &lt;email&gt;joao@email.com&lt;/email&gt;
        &lt;telefone&gt;(11) 99999-0000&lt;/telefone&gt;
        &lt;data_nascimento&gt;1990-01-15&lt;/data_nascimento&gt;
    &lt;/usuario&gt;
    &lt;usuario&gt;
        &lt;nome&gt;Maria Santos&lt;/nome&gt;
        &lt;email&gt;maria@email.com&lt;/email&gt;
        &lt;telefone&gt;(11) 88888-0000&lt;/telefone&gt;
        &lt;data_nascimento&gt;1985-05-22&lt;/data_nascimento&gt;
    &lt;/usuario&gt;
&lt;/usuarios&gt;</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validação do formulário
document.getElementById('importForm').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('xml_file');
    const file = fileInput.files[0];
    
    if (!file) {
        e.preventDefault();
        alert('Por favor, selecione um arquivo XML.');
        return;
    }
    
    if (!file.name.toLowerCase().endsWith('.xml')) {
        e.preventDefault();
        alert('Por favor, selecione apenas arquivos XML (.xml).');
        return;
    }
    
    if (file.size > 5 * 1024 * 1024) { // 5MB
        e.preventDefault();
        alert('Arquivo muito grande. Máximo permitido: 5MB.');
        return;
    }
    
    // Confirmar importação
    if (!confirm('Tem certeza que deseja importar os usuários deste arquivo XML?')) {
        e.preventDefault();
        return;
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
