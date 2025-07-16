<?php

require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    // Listar todos os usuários
    public function index()
    {
        $users = $this->userModel->getAll();
        $title = 'Lista de Usuários';
        require_once __DIR__ . '/../views/users/index.php';
    }

    // Mostrar formulário de criação
    public function create()
    {
        $title = 'Criar Usuário';
        require_once __DIR__ . '/../views/users/create.php';
    }

    // Salvar novo usuário
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /users');
            exit;
        }

        $data = [
            'nome' => $_POST['nome'] ?? '',
            'email' => $_POST['email'] ?? '',
            'telefone' => $_POST['telefone'] ?? '',
            'data_nascimento' => $_POST['data_nascimento'] ?? ''
        ];

        // Validar dados
        $errors = $this->userModel->validate($data);

        // Verificar se email já existe
        if (empty($errors['email']) && $this->userModel->emailExists($data['email'])) {
            $errors['email'] = 'Este email já está em uso';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $data;
            header('Location: /users/create');
            exit;
        }

        $result = $this->userModel->create($data);

        if ($result) {
            $_SESSION['success'] = 'Usuário criado com sucesso!';
        } else {
            $_SESSION['error'] = 'Erro ao criar usuário. Tente novamente.';
        }

        header('Location: /users');
        exit;
    }

    // Mostrar formulário de edição
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            $_SESSION['error'] = 'ID do usuário não informado';
            header('Location: /users');
            exit;
        }

        $user = $this->userModel->getById($id);
        
        if (!$user) {
            $_SESSION['error'] = 'Usuário não encontrado';
            header('Location: /users');
            exit;
        }

        $title = 'Editar Usuário';
        require_once __DIR__ . '/../views/users/edit.php';
    }

    // Atualizar usuário
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /users');
            exit;
        }

        $id = $_POST['id'] ?? null;
        
        if (!$id) {
            $_SESSION['error'] = 'ID do usuário não informado';
            header('Location: /users');
            exit;
        }

        $data = [
            'nome' => $_POST['nome'] ?? '',
            'email' => $_POST['email'] ?? '',
            'telefone' => $_POST['telefone'] ?? '',
            'data_nascimento' => $_POST['data_nascimento'] ?? ''
        ];

        // Validar dados
        $errors = $this->userModel->validate($data);

        // Verificar se email já existe (excluindo o usuário atual)
        if (empty($errors['email']) && $this->userModel->emailExists($data['email'], $id)) {
            $errors['email'] = 'Este email já está em uso';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $data;
            header("Location: /users/edit?id=$id");
            exit;
        }

        $result = $this->userModel->update($id, $data);

        if ($result) {
            $_SESSION['success'] = 'Usuário atualizado com sucesso!';
        } else {
            $_SESSION['error'] = 'Erro ao atualizar usuário. Tente novamente.';
        }

        header('Location: /users');
        exit;
    }

    // Deletar usuário
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /users');
            exit;
        }

        $id = $_POST['id'] ?? null;
        
        if (!$id) {
            $_SESSION['error'] = 'ID do usuário não informado';
            header('Location: /users');
            exit;
        }

        $result = $this->userModel->delete($id);

        if ($result) {
            $_SESSION['success'] = 'Usuário deletado com sucesso!';
        } else {
            $_SESSION['error'] = 'Erro ao deletar usuário. Tente novamente.';
        }

        header('Location: /users');
        exit;
    }

    // Visualizar usuário específico
    public function show()
    {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            $_SESSION['error'] = 'ID do usuário não informado';
            header('Location: /users');
            exit;
        }

        $user = $this->userModel->getById($id);
        
        if (!$user) {
            $_SESSION['error'] = 'Usuário não encontrado';
            header('Location: /users');
            exit;
        }

        $title = 'Visualizar Usuário';
        require_once __DIR__ . '/../views/users/show.php';
    }
}
