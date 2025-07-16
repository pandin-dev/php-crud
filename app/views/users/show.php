<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-user"></i> Detalhes do Usuário</h4>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">ID:</dt>
                    <dd class="col-sm-9"><?= htmlspecialchars($user['id']) ?></dd>

                    <dt class="col-sm-3">Nome:</dt>
                    <dd class="col-sm-9"><?= htmlspecialchars($user['nome']) ?></dd>

                    <dt class="col-sm-3">Email:</dt>
                    <dd class="col-sm-9">
                        <a href="mailto:<?= htmlspecialchars($user['email']) ?>">
                            <?= htmlspecialchars($user['email']) ?>
                        </a>
                    </dd>

                    <dt class="col-sm-3">Telefone:</dt>
                    <dd class="col-sm-9">
                        <a href="tel:<?= htmlspecialchars($user['telefone']) ?>">
                            <?= htmlspecialchars($user['telefone']) ?>
                        </a>
                    </dd>

                    <dt class="col-sm-3">Data de Nascimento:</dt>
                    <dd class="col-sm-9">
                        <?= date('d/m/Y', strtotime($user['data_nascimento'])) ?>
                        <small class="text-muted">
                            (<?= date('Y') - date('Y', strtotime($user['data_nascimento'])) ?> anos)
                        </small>
                    </dd>

                    <dt class="col-sm-3">Cadastrado em:</dt>
                    <dd class="col-sm-9"><?= date('d/m/Y H:i:s', strtotime($user['created_at'])) ?></dd>

                    <?php if (isset($user['updated_at']) && $user['updated_at']): ?>
                        <dt class="col-sm-3">Última atualização:</dt>
                        <dd class="col-sm-9"><?= date('d/m/Y H:i:s', strtotime($user['updated_at'])) ?></dd>
                    <?php endif; ?>
                </dl>

                <div class="d-flex justify-content-between mt-4">
                    <a href="/users" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar para Lista
                    </a>
                    
                    <div>
                        <a href="/users/edit?id=<?= $user['id'] ?>" class="btn btn-warning me-2">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button type="button" 
                                class="btn btn-danger" 
                                onclick="confirmDelete(<?= $user['id'] ?>, '<?= htmlspecialchars($user['nome']) ?>')">
                            <i class="fas fa-trash"></i> Excluir
                        </button>
                    </div>
                </div>

                <!-- Form oculto para exclusão -->
                <form id="delete-form-<?= $user['id'] ?>" 
                      action="/users/delete" 
                      method="POST" 
                      style="display: none;">
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
