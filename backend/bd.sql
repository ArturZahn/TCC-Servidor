DROP DATABASE IF EXISTS tcc;
CREATE DATABASE tcc;
USE tcc;

CREATE TABLE endereco (
    endereco_cod INT PRIMARY KEY AUTO_INCREMENT,
    endereco_cidade VARCHAR(50) NOT NULL,
    endereco_bairro VARCHAR(50) NOT NULL,
    endereco_rua VARCHAR(50) NOT NULL,
    endereco_estado VARCHAR(2),
    endereco_numero INT,
    endereco_cep VARCHAR(9) NOT NULL,
    endereco_complemento VARCHAR(100) NOT NULL,
    endereco_informacoesadicinais VARCHAR(200) NOT NULL
);

CREATE TABLE cooperativa (
    cooperativa_cod INT PRIMARY KEY,
    cooperativa_nome VARCHAR(100) NOT NULL,
    cooperativa_cnpj VARCHAR(20) NOT NULL,
    cooperativa_email VARCHAR(256) NOT NULL,
    cooperativa_telefone VARCHAR(20) NOT NULL,
    cooperativa_taxa_vendas FLOAT NOT NULL,
    
    endereco_cod INT,

    FOREIGN KEY (endereco_cod) REFERENCES endereco(endereco_cod)
);

CREATE TABLE cliente (
    cliente_cod INT PRIMARY KEY AUTO_INCREMENT,
    cliente_nome VARCHAR(100) NOT NULL,
    cliente_email VARCHAR(256) NOT NULL,
    cliente_telefone VARCHAR(20) NOT NULL,
    cliente_cpf VARCHAR(20) NOT NULL,
    cliente_senha VARCHAR(32) NOT NULL,
    cliente_fotodeperfil MEDIUMBLOB,

    endereco_cod INT,

    FOREIGN KEY (endereco_cod) REFERENCES endereco(endereco_cod)
);

CREATE TABLE produtor (
    produtor_cod INT PRIMARY KEY AUTO_INCREMENT,
    produtor_nome VARCHAR(100) NOT NULL,
    produtor_email VARCHAR(256) NOT NULL,
    produtor_telefone VARCHAR(20) NOT NULL,
    produtor_cpfcnpj VARCHAR(20) NOT NULL,
    produtor_senha VARCHAR(32) NOT NULL,
    produtor_fotodeperfil MEDIUMBLOB,

    endereco_cod INT,

    FOREIGN KEY (endereco_cod) REFERENCES endereco(endereco_cod)
);

/*CREATE TABLE tipocontagem (
    tipocontagem_cod INT PRIMARY KEY AUTO_INCREMENT,
    tipocontagem_nome VARCHAR(50) NOT NULL
);*/

CREATE TABLE produto (
    produto_cod INT PRIMARY KEY AUTO_INCREMENT,
    produto_nome VARCHAR(100) NOT NULL,
    produto_descricao VARCHAR(1000) NOT NULL,
    produto_quantidadeemestoque INT NOT NULL,
    produto_precoantigo REAL NOT NULL,
    produto_preco REAL NOT NULL,
    produto_foto MEDIUMBLOB,

    /*tipocontagem_cod INT,*/
    produto_tipocontagem VARCHAR(30) NOT NULL,
    produtor_cod INT NOT NULL,

    /*FOREIGN KEY (tipocontagem_cod) REFERENCES tipocontagem(tipocontagem_cod),*/
    FOREIGN KEY (produtor_cod) REFERENCES produtor(produtor_cod)
);

CREATE TABLE itemcarrinho (
    itemcarrinho_cod INT PRIMARY KEY AUTO_INCREMENT,
    itemcarrinho_quantidade INT NOT NULL,

    cliente_cod INT NOT NULL,
    produto_cod INT NOT NULL,
    FOREIGN KEY (cliente_cod) REFERENCES cliente(cliente_cod),
    FOREIGN KEY (produto_cod) REFERENCES produto(produto_cod)
);

CREATE TABLE estadopedido (
    estadopedido_cod INT PRIMARY KEY,
    estadopedido_estado VARCHAR(50) NOT NULL
);

CREATE TABLE pedido (
    pedido_cod INT PRIMARY KEY AUTO_INCREMENT,
    pedido_datacompra DATETIME,
    pedido_pagamento VARCHAR(100),
    pedido_taxa VARCHAR(100),

    cliente_cod INT NOT NULL,
    estadopedido_cod INT NOT NULL,
    endereco_cod INT NOT NULL,

    FOREIGN KEY (cliente_cod) REFERENCES cliente(cliente_cod),
    FOREIGN KEY (estadopedido_cod) REFERENCES estadopedido(estadopedido_cod),
    FOREIGN KEY (endereco_cod) REFERENCES endereco(endereco_cod)
);

CREATE TABLE itempedido (
    itempedido_cod INT PRIMARY KEY AUTO_INCREMENT,
    itempedido_quantidade INT NOT NULL,
    itempedido_precounitariopago REAL NOT NULL,
    pedido_cod INT NOT NULL,
    produto_cod INT NOT NULL,
    FOREIGN KEY (pedido_cod) REFERENCES pedido(pedido_cod),
    FOREIGN KEY (produto_cod) REFERENCES produto(produto_cod)
);

CREATE TABLE pagamento (
    pagamento_cod INT PRIMARY KEY AUTO_INCREMENT,
    pagamento_data DATETIME
);

CREATE TABLE itempagamento (
    itempagamento_cod INT PRIMARY KEY AUTO_INCREMENT,

    itempedido_cod INT NOT NULL,
    pagamento_cod INT NOT NULL,
    FOREIGN KEY (itempedido_cod) REFERENCES itempedido(itempedido_cod),
    FOREIGN KEY (pagamento_cod) REFERENCES pagamento(pagamento_cod)
);

CREATE TABLE console (
	cod INT PRIMARY KEY AUTO_INCREMENT,
	log VARCHAR(1000)
);

CREATE TABLE admin (
    admin_cod INT PRIMARY KEY AUTO_INCREMENT,
    admin_login VARCHAR(50),
    admin_senha VARCHAR(32)
);

CREATE TABLE paginasparapesquisar (
    paginasparapesquisar_cod INT PRIMARY KEY AUTO_INCREMENT,
    paginasparapesquisar_titulo VARCHAR(250),
    paginasparapesquisar_endereco VARCHAR(250)
);

CREATE TABLE produtorimagem (
    produtorimagem_cod INT PRIMARY KEY AUTO_INCREMENT,
    produtorimagem_foto MEDIUMBLOB,
    
    produtor_cod INT,
    
    FOREIGN KEY (produtor_cod) REFERENCES produtor(produtor_cod)
);