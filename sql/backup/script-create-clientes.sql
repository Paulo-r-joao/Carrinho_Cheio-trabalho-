USE aulaphp;
CREATE TABLE clientes(
	id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    endereco VARCHAR(100),
    telefone INT(11),
    email VARCHAR(100),
    estado_civil VARCHAR(1),
    foto_clientes VARCHAR(255)
);

DROP TABLE clientes;