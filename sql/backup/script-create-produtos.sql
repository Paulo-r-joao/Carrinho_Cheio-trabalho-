USE aulaphp;
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

DROP TABLE produtos;