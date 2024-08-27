#CREATE DATABASE gerenciadorTarefas;
USE gerenciadorTarefas;

CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE quadro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    usuario_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE lista (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    quadro_id INT,
    FOREIGN KEY (quadro_id) REFERENCES quadro(id) ON DELETE CASCADE 
);

CREATE TABLE tarefa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    arquivo VARCHAR(255), 
    lista_id INT,
    prazo DATE,
    FOREIGN KEY (lista_id) REFERENCES lista(id) ON DELETE CASCADE
);
