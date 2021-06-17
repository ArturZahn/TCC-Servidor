DROP DATABASE IF EXISTS tcc;
CREATE DATABASE tcc;
USE tcc;

CREATE TABLE endereco (
    endereco_cod INT PRIMARY KEY AUTO_INCREMENT,
    endereco_cidade VARCHAR(50) NOT NULL,
    endereco_bairro VARCHAR(50) NOT NULL,
    endereco_rua VARCHAR(50) NOT NULL,
    endereco_numero INT NOT NULL,
    endereco_complemento VARCHAR(100) NOT NULL,
    endereco_informacoesAdicinais VARCHAR(200) NOT NULL
);

CREATE TABLE cooperativa (
    cooperativa_cod INT PRIMARY KEY,
    cooperativa_nome VARCHAR(100) NOT NULL,
    cooperativa_cnpj VARCHAR(20) NOT NULL,
    cooperativa_email VARCHAR(256) NOT NULL,
    cooperativa_telefone VARCHAR(20) NOT NULL,
    cooperativa_senha VARCHAR(32) NOT NULL,
    
    endereco_cod INT NOT NULL,

    FOREIGN KEY (endereco_cod) REFERENCES endereco(endereco_cod)
);

CREATE TABLE cliente (
    cliente_cod INT PRIMARY KEY AUTO_INCREMENT,
    cliente_nome VARCHAR(100) NOT NULL,
    cliente_email VARCHAR(256) NOT NULL,
    cliente_telefone VARCHAR(20) NOT NULL,
    cliente_cpf VARCHAR(20) NOT NULL,
    cliente_senha VARCHAR(32) NOT NULL,
    cliente_fotoDePerfil MEDIUMBLOB,

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
    produtor_fotoDePerfil MEDIUMBLOB,

    endereco_cod INT NOT NULL,

    FOREIGN KEY (endereco_cod) REFERENCES endereco(endereco_cod)
);

CREATE TABLE tipoContagem (
    tipoContagem_cod INT PRIMARY KEY AUTO_INCREMENT,
    tipoContagem_nome VARCHAR(50) NOT NULL
);

CREATE TABLE produto (
    produto_cod INT PRIMARY KEY AUTO_INCREMENT,
    produto_nome VARCHAR(100) NOT NULL,
    produto_descricao VARCHAR(1000) NOT NULL,
    produto_quantidadeEmEstoque INT NOT NULL,
    produto_peso REAL NOT NULL,

    produtor_cod INT NOT NULL,
    tipoContagem_cod INT NOT NULL,

    FOREIGN KEY (produtor_cod) REFERENCES produtor(produtor_cod),
    FOREIGN KEY (tipoContagem_cod) REFERENCES tipoContagem(tipoContagem_cod)
);

CREATE TABLE carrinho (
    carrinho_cod INT PRIMARY KEY AUTO_INCREMENT,
    carrinho_quantidade INT NOT NULL,

    cliente_cod INT NOT NULL,
    produto_cod INT NOT NULL,
    FOREIGN KEY (cliente_cod) REFERENCES cliente(cliente_cod),
    FOREIGN KEY (produto_cod) REFERENCES produto(produto_cod)
);

CREATE TABLE estadoPedido (
    estadoPedido_cod INT PRIMARY KEY,
    estadoPedido_estado VARCHAR(50) NOT NULL
);

CREATE TABLE pedido (
    pedido_cod INT PRIMARY KEY AUTO_INCREMENT,

    cliente_cod INT NOT NULL,
    estadoPedido_cod INT NOT NULL,

    FOREIGN KEY (cliente_cod) REFERENCES cliente(cliente_cod),
    FOREIGN KEY (estadoPedido_cod) REFERENCES estadoPedido(estadoPedido_cod)
);

CREATE TABLE itemPedido (
    itemPedido_cod INT PRIMARY KEY AUTO_INCREMENT,
    itemPedido_quantidade INT NOT NULL,
    itemPedido_precoPago REAL NOT NULL,

    pedido_cod INT NOT NULL,
    produto_cod INT NOT NULL,
    FOREIGN KEY (pedido_cod) REFERENCES pedido(pedido_cod),
    FOREIGN KEY (produto_cod) REFERENCES produto(produto_cod)
);