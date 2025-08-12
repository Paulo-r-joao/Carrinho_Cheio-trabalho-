USE aulaphp;
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

DROP TABLE vendas;