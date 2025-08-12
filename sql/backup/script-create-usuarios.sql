USE aulaphp;
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nm_login VARCHAR(50) NOT NULL UNIQUE,
    ds_password VARCHAR(255) NOT NULL,
    ds_email VARCHAR(255),
    foto_perfil VARCHAR(200),
    nm_nome VARCHAR(100),
    in_admin INT(1)
);

INSERT INTO usuarios(nm_login, ds_password, ds_email, nm_nome, in_admin)
VALUES ("teste1","123456","bruno@gmil.com","Bruno",1);

DROP TABLE usuarios;