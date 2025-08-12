SELECT 
            v.idCliente,
            v.idVendedor,
            v.idProduto,
            v.dataCadastro,
            v.qtQuantidade,
            v.vlValor,
            v.data_venda,
            c.nome  nomeCliente,
            p.descricao  nomeProduto,
            ve.nome  nomeVendedor
        FROM vendas v
        INNER JOIN clientes c ON v.idCliente = c.id
        INNER JOIN produtos p ON v.idProduto = p.id
        INNER JOIN vendedores ve ON v.idVendedor = ve.id
        ORDER BY v.dataCadastro DESC;