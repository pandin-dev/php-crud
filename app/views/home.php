<?php $title = 'Sistema CRUD - Home'; ?>
<?php require_once __DIR__ . '/layouts/header.php'; ?>

<!-- Hero Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="hero-section text-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; color: white;">
            <div class="container">
                <div class="d-flex justify-content-center align-items-center mb-4">
                    <img src="https://pandin.dev/static/media/logo.f9d2a21d43934c936788.webp" 
                         alt="Pandin Logo" 
                         style="height: 60px; margin-right: 15px;">
                    <h1 class="display-4 fw-bold mb-0">Sistema CRUD</h1>
                </div>
                <p class="lead mb-4">Gerenciamento moderno de usuários com PHP</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4 mb-5">
    <div class="col-md-6 col-lg-3">
        <div class="card h-100 border-0 shadow-sm hover-card">
            <div class="card-body text-center p-4">
                <div class="feature-icon bg-success bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-plus fa-lg"></i>
                </div>
                <h5 class="card-title mb-2">Criar</h5>
                <p class="card-text text-muted small mb-3">Adicionar novos usuários</p>
                <a href="/users/create" class="btn btn-outline-success btn-sm rounded-pill">
                    Novo Usuário
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="card h-100 border-0 shadow-sm hover-card">
            <div class="card-body text-center p-4">
                <div class="feature-icon bg-primary bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-list fa-lg"></i>
                </div>
                <h5 class="card-title mb-2">Listar</h5>
                <p class="card-text text-muted small mb-3">Visualizar todos os usuários</p>
                <a href="/users" class="btn btn-outline-primary btn-sm rounded-pill">
                    Ver Lista
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="card h-100 border-0 shadow-sm hover-card">
            <div class="card-body text-center p-4">
                <div class="feature-icon bg-info bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-file-code fa-lg"></i>
                </div>
                <h5 class="card-title mb-2">XML</h5>
                <p class="card-text text-muted small mb-3">Importar/Exportar dados</p>
                <a href="/xml" class="btn btn-outline-info btn-sm rounded-pill">
                    Gerenciar XML
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="card h-100 border-0 shadow-sm hover-card">
            <div class="card-body text-center p-4">
                <div class="feature-icon bg-warning bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-chart-line fa-lg"></i>
                </div>
                <h5 class="card-title mb-2">Logs</h5>
                <p class="card-text text-muted small mb-3">Monitorar atividades</p>
                <a href="/logs" class="btn btn-outline-warning btn-sm rounded-pill">
                    Ver Logs
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Tech Stack -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <img src="https://pandin.dev/favicon.ico" 
                             alt="Pandin Favicon" 
                             style="height: 40px;">
                    </div>
                    <div class="col-md-10">
                        <h6 class="mb-2">Sistema desenvolvido com</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-primary rounded-pill">PHP 8+</span>
                            <span class="badge bg-info rounded-pill">PDO</span>
                            <span class="badge bg-success rounded-pill">MySQL</span>
                            <span class="badge bg-warning rounded-pill">Bootstrap 5</span>
                            <span class="badge bg-dark rounded-pill">MVC</span>
                            <span class="badge bg-secondary rounded-pill">Prepared Statements</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.hero-section {
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="25" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="25" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.1;
}

.hero-section > * {
    position: relative;
    z-index: 1;
}
</style>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
