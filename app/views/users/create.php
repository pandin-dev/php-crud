<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-user-plus"></i> Cadastrar Novo Usuário</h4>
            </div>
            <div class="card-body">
                <form action="/users/store" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome Completo *</label>
                                <input type="text" 
                                       class="form-control <?= isset($_SESSION['errors']['nome']) ? 'is-invalid' : '' ?>" 
                                       id="nome" 
                                       name="nome" 
                                       value="<?= htmlspecialchars($_SESSION['old_data']['nome'] ?? '') ?>"
                                       required>
                                <?php if (isset($_SESSION['errors']['nome'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $_SESSION['errors']['nome'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" 
                                       class="form-control <?= isset($_SESSION['errors']['email']) ? 'is-invalid' : '' ?>" 
                                       id="email" 
                                       name="email" 
                                       value="<?= htmlspecialchars($_SESSION['old_data']['email'] ?? '') ?>"
                                       required>
                                <?php if (isset($_SESSION['errors']['email'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $_SESSION['errors']['email'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefone" class="form-label">Telefone *</label>
                                <input type="text" 
                                       class="form-control <?= isset($_SESSION['errors']['telefone']) ? 'is-invalid' : '' ?>" 
                                       id="telefone" 
                                       name="telefone" 
                                       value="<?= htmlspecialchars($_SESSION['old_data']['telefone'] ?? '') ?>"
                                       placeholder="(11) 99999-9999"
                                       oninput="maskPhone(this)"
                                       required>
                                <?php if (isset($_SESSION['errors']['telefone'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $_SESSION['errors']['telefone'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="data_nascimento" class="form-label">Data de Nascimento *</label>
                                <input type="date" 
                                       class="form-control <?= isset($_SESSION['errors']['data_nascimento']) ? 'is-invalid' : '' ?>" 
                                       id="data_nascimento" 
                                       name="data_nascimento" 
                                       value="<?= htmlspecialchars($_SESSION['old_data']['data_nascimento'] ?? '') ?>"
                                       required>
                                <?php if (isset($_SESSION['errors']['data_nascimento'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $_SESSION['errors']['data_nascimento'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">* Campos obrigatórios</small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/users" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar Usuário
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
// Limpar dados da sessão
unset($_SESSION['errors']);
unset($_SESSION['old_data']);
?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
