DROP DATABASE IF EXISTS nutrihealth;
CREATE DATABASE IF NOT EXISTS nutrihealth;
USE nutrihealth;


CREATE TABLE `user` (
  id int not null AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  typeUser char(1) not null,
  primary key (id)
);


-- ===========================
-- 1️⃣ Criar tabela perfil
-- ===========================
CREATE TABLE IF NOT EXISTS perfil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);

-- Inserir perfis
INSERT INTO perfil (nome) VALUES
('Administrador'),
('Nutricionista'),
('Usuário Geral');

-- ===========================
-- 2️⃣ Criar tabela acao
-- ===========================
CREATE TABLE IF NOT EXISTS acao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modulo VARCHAR(100) NOT NULL,
    acao VARCHAR(50) NOT NULL
);

-- Inserir ações (CRUD de cada módulo)
INSERT INTO acao (modulo, acao) VALUES
-- Cadastro de Pacientes
('Cadastro de Pacientes','Create'),('Cadastro de Pacientes','Read'),('Cadastro de Pacientes','Update'),('Cadastro de Pacientes','Delete'),
-- Anamnese Paciente
('Anamnese Paciente','Create'),('Anamnese Paciente','Read'),('Anamnese Paciente','Update'),('Anamnese Paciente','Delete'),
-- Prontuário Eletrônico
('Prontuário Eletrônico','Create'),('Prontuário Eletrônico','Read'),('Prontuário Eletrônico','Update'),('Prontuário Eletrônico','Delete'),
-- Agenda de Consultas
('Agenda de Consultas','Create'),('Agenda de Consultas','Read'),('Agenda de Consultas','Update'),('Agenda de Consultas','Delete'),
-- Planos Alimentares Personalizados
('Planos Alimentares Personalizados','Create'),('Planos Alimentares Personalizados','Read'),('Planos Alimentares Personalizados','Update'),('Planos Alimentares Personalizados','Delete'),
-- Relatórios
('Relatórios','Create'),('Relatórios','Read'),('Relatórios','Update'),('Relatórios','Delete');

-- ===========================
-- 3️⃣ Criar tabela perfil_acao
-- ===========================
CREATE TABLE IF NOT EXISTS perfil_acao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    perfil_id INT NOT NULL,
    acao_id INT NOT NULL,
    FOREIGN KEY (perfil_id) REFERENCES perfil(id),
    FOREIGN KEY (acao_id) REFERENCES acao(id)
);

-- ===========================
-- 4️⃣ Inserir permissões na tabela perfil_acao
-- ===========================

-- Administrador (tudo)
INSERT INTO perfil_acao (perfil_id, acao_id) VALUES
(1,1),(1,2),(1,3),(1,4),
(1,5),(1,6),(1,7),(1,8),
(1,9),(1,10),(1,11),(1,12),
(1,13),(1,14),(1,15),(1,16),
(1,17),(1,18),(1,19),(1,20),
(1,21),(1,22),(1,23),(1,24);

-- Nutricionista
INSERT INTO perfil_acao (perfil_id, acao_id) VALUES
(2,2),(2,14), -- apenas Read para Cadastro e Agenda
(2,5),(2,6),(2,7),(2,8), -- Anamnese completo
(2,9),(2,10),(2,11),(2,12), -- Prontuário completo
(2,17),(2,18),(2,19),(2,20), -- Planos Alimentares completo
(2,21),(2,22),(2,23),(2,24); -- Relatórios completo

-- Usuário Geral
INSERT INTO perfil_acao (perfil_id, acao_id) VALUES
(3,1),(3,2),(3,3),(3,4), -- Cadastro de Pacientes completo
-- Anamnese → nenhuma
(3,9),(3,10),(3,11),(3,12), -- Prontuário completo
(3,13),(3,14),(3,15),(3,16), -- Agenda completo
-- Planos Alimentares → nenhuma
(3,23); -- Relatórios → Update somente
