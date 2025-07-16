-- Script SQL para criar o banco de dados e tabela do sistema CRUD

-- Criar o banco de dados
CREATE DATABASE IF NOT EXISTS crud_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Usar o banco de dados
USE crud_db;

-- Criar a tabela de usuários
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    data_nascimento DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserir alguns dados de exemplo
INSERT INTO users (nome, email, telefone, data_nascimento) VALUES
('João Silva', 'joao.silva@email.com', '(11) 99999-1111', '1990-05-15'),
('Maria Santos', 'maria.santos@email.com', '(11) 99999-2222', '1985-08-22'),
('Pedro Oliveira', 'pedro.oliveira@email.com', '(11) 99999-3333', '1992-12-10'),
('Ana Costa', 'ana.costa@email.com', '(11) 99999-4444', '1988-03-07'),
('Carlos Ferreira', 'carlos.ferreira@email.com', '(11) 99999-5555', '1995-09-18');

-- Criar índices para melhorar a performance
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_nome ON users(nome);
CREATE INDEX idx_users_created_at ON users(created_at);

-- Mostrar a estrutura da tabela
DESCRIBE users;

-- Mostrar os dados inseridos
SELECT * FROM users ORDER BY id;
