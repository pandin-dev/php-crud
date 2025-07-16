<?php

require_once __DIR__ . '/../core/Database.php';

class User
{
    private $db;
    private $table = 'users';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // CREATE - Criar novo usuário
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (nome, email, telefone, data_nascimento, created_at) 
                VALUES (?, ?, ?, ?, NOW())";
        
        try {
            $result = $this->db->execute($sql, [
                $data['nome'],
                $data['email'],
                $data['telefone'],
                $data['data_nascimento']
            ]);
            
            if ($result) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erro ao criar usuário: " . $e->getMessage());
            return false;
        }
    }

    // READ - Buscar todos os usuários
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        try {
            return $this->db->fetchAll($sql);
        } catch (PDOException $e) {
            error_log("Erro ao buscar usuários: " . $e->getMessage());
            return [];
        }
    }

    // READ - Buscar usuário por ID
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        try {
            return $this->db->fetch($sql, [$id]);
        } catch (PDOException $e) {
            error_log("Erro ao buscar usuário: " . $e->getMessage());
            return false;
        }
    }

    // UPDATE - Atualizar usuário
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} 
                SET nome = ?, email = ?, telefone = ?, 
                    data_nascimento = ?, updated_at = NOW() 
                WHERE id = ?";
        
        try {
            return $this->db->execute($sql, [
                $data['nome'],
                $data['email'],
                $data['telefone'],
                $data['data_nascimento'],
                $id
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar usuário: " . $e->getMessage());
            return false;
        }
    }

    // DELETE - Deletar usuário
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        try {
            return $this->db->execute($sql, [$id]);
        } catch (PDOException $e) {
            error_log("Erro ao deletar usuário: " . $e->getMessage());
            return false;
        }
    }

    // Validar dados do usuário
    public function validate($data)
    {
        $errors = [];

        // Validar nome
        if (empty($data['nome']) || strlen(trim($data['nome'])) < 2) {
            $errors['nome'] = 'Nome é obrigatório e deve ter pelo menos 2 caracteres';
        }

        // Validar email
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email válido é obrigatório';
        }

        // Validar telefone
        if (empty($data['telefone']) || strlen(preg_replace('/[^0-9]/', '', $data['telefone'])) < 10) {
            $errors['telefone'] = 'Telefone é obrigatório e deve ter pelo menos 10 dígitos';
        }

        // Validar data de nascimento
        if (empty($data['data_nascimento'])) {
            $errors['data_nascimento'] = 'Data de nascimento é obrigatória';
        } else {
            $date = DateTime::createFromFormat('Y-m-d', $data['data_nascimento']);
            if (!$date || $date->format('Y-m-d') !== $data['data_nascimento']) {
                $errors['data_nascimento'] = 'Data de nascimento deve estar no formato válido';
            }
        }

        return $errors;
    }

    // Verificar se email já existe (para CREATE)
    public function emailExists($email, $excludeId = null)
    {
        if ($excludeId) {
            $sql = "SELECT id FROM {$this->table} WHERE email = ? AND id != ?";
            $params = [$email, $excludeId];
        } else {
            $sql = "SELECT id FROM {$this->table} WHERE email = ?";
            $params = [$email];
        }

        try {
            $result = $this->db->fetch($sql, $params);
            return $result !== false;
        } catch (PDOException $e) {
            error_log("Erro ao verificar email: " . $e->getMessage());
            return false;
        }
    }
}
