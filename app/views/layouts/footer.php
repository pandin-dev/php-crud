    </div>

    <footer class="bg-dark text-light text-center py-3 mt-5">
        <div class="container">
            <p class="mb-1">&copy; <?= date('Y') ?> Sistema CRUD - Desenvolvido por <a href="https://pandin.dev" target="_blank" class="text-decoration-none fw-bold" style="color: #07f9fa;">Pandin Dev</a></p>
            <small class="text-muted">Visite <a href="https://pandin.dev" target="_blank" class="text-decoration-none" style="color: #07f9fa;">pandin.dev</a> para mais projetos</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Confirmação para exclusão
        function confirmDelete(id, nome) {
            if (confirm(`Tem certeza que deseja excluir o usuário "${nome}"?`)) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        // Máscara para telefone
        function maskPhone(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
                value = value.replace(/(\d)(\d{4})$/, '$1-$2');
            }
            input.value = value;
        }
    </script>
</body>
</html>
