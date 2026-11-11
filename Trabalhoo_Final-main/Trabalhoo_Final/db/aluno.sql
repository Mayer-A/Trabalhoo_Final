/* ===================================================
   1. CRIAÇÃO E SELEÇÃO DO BANCO DE DADOS
   =================================================== */
/* Cria um novo banco de dados (schema) chamado 'aluno' */
CREATE DATABASE aluno;
/* Seleciona o banco 'aluno' para garantir que as próximas instruções (como criar tabelas) sejam feitas dentro dele */
USE aluno;

/* ===================================================
   2. CRIAÇÃO DA TABELA DE ALUNOS
   =================================================== */
/* Cria a tabela chamada 'aluno' para armazenar os dados dos estudantes */
CREATE TABLE aluno (
    /* 
       PK_CODIGO_ALUNO:
       - INT: Tipo de dado numérico inteiro.
       - SERIAL: é o mesmo q AUTOINCREMENT, pois é o padrão no VSCODE, SERIAL seria numeração sequencial automaticamente (1, 2, 3...).
       - PRIMARY KEY: Chave Primária; garante que cada aluno tenha um código único e exclusivo (não pode repetir nem ser nulo).
    */
    pk_codigo_aluno SERIAL PRIMARY KEY,
    nome VARCHAR(20) NOT NULL,
    sobrenome VARCHAR(20) NOT NULL,
    idade INT NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(20) NOT NULL,
    adm BOOLEAN NOT NULL DEFAULT FALSE
);

INSERT INTO aluno (nome, sobrenome, idade, email, senha, adm) VALUES 
('Logan', 'Wolverine', 137, 'wolverine@xmen.com', 'adm123', true),
('Scott', 'Summers', 28, 'ciclope@xmen.com', 'ciclope123', false),
('Jean', 'Grey', 27, 'jean@xmen.com', 'jean123', false);