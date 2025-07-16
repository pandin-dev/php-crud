<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-users"></i> Lista de Usuários</h2>
            <a href="/users/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Novo Usuário
            </a>
        </div>

        <?php if (empty($users)): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Nenhum usuário cadastrado.
                <a href="/users/create" class="alert-link">Clique aqui para cadastrar o primeiro usuário</a>.
            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    <th>Data de Nascimento</th>
                                    <th>Cadastrado em</th>
                                    <th class="text-center" width="200">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['id']) ?></td>
                                        <td><?= htmlspecialchars($user['nome']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= htmlspecialchars($user['telefone']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($user['data_nascimento'])) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="/users/show?id=<?= $user['id'] ?>" 
                                                   class="btn btn-sm btn-info" title="Visualizar">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="/users/edit?id=<?= $user['id'] ?>" 
                                                   class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger" 
                                                        title="Excluir"
                                                        onclick="confirmDelete(<?= $user['id'] ?>, '<?= htmlspecialchars($user['nome']) ?>')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            
                                            <!-- Form oculto para exclusão -->
                                            <form id="delete-form-<?= $user['id'] ?>" 
                                                  action="/users/delete" 
                                                  method="POST" 
                                                  style="display: none;">
                                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
