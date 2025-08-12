/* create database */
CREATE SCHEMA carrinhocheio;
USE carrinhocheio;

/* create table clientes */
USE carrinhocheio;
CREATE TABLE clientes(
	id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    endereco VARCHAR(100),
    telefone INT(11),
    email VARCHAR(100),
    estado_civil VARCHAR(1),
    foto_clientes VARCHAR(255)
);

/* insert clientes */
USE carrinhocheio;
INSERT INTO clientes(nome, endereco, telefone, email, estado_civil, foto_clientes)
VALUES ('Dio',"Rua do Dio", '88888888888',"dio@gmail.com",'S',"Dio.jpg");
INSERT INTO clientes(nome, endereco, telefone, email, estado_civil, foto_clientes)
VALUES ('Light',"Rua do Light", '999999999',"light@gmail.com",'C',"Light.jpg");

/* create table produtos */
USE carrinhocheio;
CREATE TABLE produtos (
    id VARCHAR(16) NOT NULL,
    descricao VARCHAR(100) NOT NULL,
    quantidade SMALLINT NOT NULL,
    tipoEmbalagem ENUM("cx","pct","gr"),
    valor DECIMAL(10,2) NOT NULL,
    foto_produto VARCHAR(200),
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_produtos PRIMARY KEY(id)
);

/* insert produtos */
USE carrinhocheio;
INSERT INTO produtos(id, descricao, quantidade, tipoEmbalagem, valor, foto_produto)
VALUES (0001,"Caixa de Leite", 900,"cx",4.90,"caixa.png");
INSERT INTO produtos(id, descricao, quantidade, tipoEmbalagem, valor, foto_produto)
VALUES (0002,"Pacote de Gelo", 500,"pct",20.00,"pacote.png");

/* create table usuarios */
USE carrinhocheio;
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nm_login VARCHAR(50) NOT NULL UNIQUE,
    ds_password VARCHAR(255) NOT NULL,
    ds_email VARCHAR(255),
    foto_perfil VARCHAR(200),
    nm_nome VARCHAR(100),
    in_admin INT(1)
);

/* insert usuarios*/
USE carrinhocheio;
INSERT INTO usuarios(nm_login, ds_password, ds_email, foto_perfil, nm_nome, in_admin)
VALUES ("dante","11200","dante@gmail.com", 'Dante.png',"Dante",1);
INSERT INTO usuarios(nm_login, ds_password, ds_email, foto_perfil, nm_nome, in_admin)
VALUES ("alokk","12345","alokk@gmail.com", 'Alok.jpg',"Alokk",1);
INSERT INTO usuarios(nm_login, ds_password, ds_email, foto_perfil, nm_nome, in_admin)
VALUES ("jogoj","54321","jogoj@gmail.com", 'JOGO.jpg',"Jogoj",0);

/* create table vendedores */
USE carrinhocheio;
CREATE TABLE vendedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100),   
    foto_vendedores VARCHAR(255),
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/* insert vendedores */
USE carrinhocheio;
INSERT INTO vendedores(nome, endereco, telefone, email, foto_vendedores)
VALUES ('Jotaro',"Rua do Jotaro", '22222222222',"jotaro@gmail.com","Jotaro.jpg");
INSERT INTO vendedores(nome, endereco, telefone, email, foto_vendedores)
VALUES ('L',"Rua do L", '11111111111',"L@gmail.com","L.jpg");

/* create table vendas */
USE carrinhocheio;
CREATE TABLE vendas (
    id INT AUTO_INCREMENT,
    idCliente INT NOT NULL,
    idVendedor INT NOT NULL,
    idProduto VARCHAR(16),
    qtQuantidade SMALLINT,  
    vlValor DECIMAL(10,2),
    data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_vendas PRIMARY KEY(id),
    CONSTRAINT pk_vendas_clientes FOREIGN KEY(idCliente) REFERENCES clientes (id),
    CONSTRAINT pk_vendas_vendedores FOREIGN KEY(idVendedor) REFERENCES vendedores (id),    
    CONSTRAINT pk_vendas_produtos FOREIGN KEY(idProduto) REFERENCES produtos (id)
);

/* insert vendas */
USE carrinhocheio;
INSERT INTO vendas(idCliente, idVendedor, idProduto, qtQuantidade, vlValor)
VALUES (1,1,'1',100,490.00);
INSERT INTO vendas(idCliente, idVendedor, idProduto, qtQuantidade, vlValor)
VALUES (2,2,'2',500,10000.00);