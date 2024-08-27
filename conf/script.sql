#CREATE DATABASE gerenciadorTarefas;
USE gerenciadorTarefas;

-- Criação da tabela de usuários
CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

-- Criação da tabela de quadros
CREATE TABLE quadro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    usuario_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE
);

-- Criação da tabela de listas com referência ao usuário
CREATE TABLE lista (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    quadro_id INT,
    usuario_id INT,
    FOREIGN KEY (quadro_id) REFERENCES quadro(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE
);

-- Criação da tabela de tarefas com referência ao usuário
CREATE TABLE tarefa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    arquivo VARCHAR(255), 
    lista_id INT,
    prazo DATE,
    usuario_id INT,
    FOREIGN KEY (lista_id) REFERENCES lista(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE
);

-- Inserção de dados
INSERT INTO usuario (nome, email, senha) VALUES 
    ("Felipe Caue Machado", "fmachad6@gmail.com", "12345678"),
    ("Yohanês da Silva Zanghelini", "yzanghelini@gmail.com", "87654321");

-- Inserção de quadros
INSERT INTO quadro (nome, usuario_id) VALUES 
    ("Faculdade", 2),
    ("Trabalho", 2);

-- Inserção de listas
INSERT INTO lista (nome, quadro_id, usuario_id) VALUES 
    ("Pendente", 1, 2);
