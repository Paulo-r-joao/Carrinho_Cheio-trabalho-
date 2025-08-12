<!-- vendedores.html ou vendedores.phtml (parte interna apenas) -->
<?php
// Conexão com o banco de dados
session_start();
    require_once "conexao.php"; // Inclui a conexão com o banco de dados
    // Buscar vendedores
    $sqlVendedores = "SELECT id, nome FROM vendedores";
    $resultVendedores = $pdo->query($sqlVendedores);

    // Buscar clientes
    $sqlClientes = "SELECT id, nome FROM clientes";
    $resultClientes = $pdo->query($sqlClientes);

    // Buscar produtos
    $sqlProdutos = "SELECT id, descricao, valor, quantidade FROM produtos";
    $resultProdutos = $pdo->query($sqlProdutos);
?>

<div class="container">
    <form id="formVendas" method="POST">
        <h2>Cadastro de Vendas</h2>
             
        <label for="vendedor">Vendedor</label>
        <select name="vendedor" required>
            <option value="">Selecione o vendedor</option>
        <!--  while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {-->
            <?php while($row = $resultVendedores->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nome']) ?></option>
            <?php endwhile; ?>
        </select>

        <label for="cliente">Cliente</label>
        <select name="cliente" required>
            <option value="">Selecione o cliente</option>
            <?php while($row = $resultClientes->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nome']) ?></option>
            <?php endwhile; ?>
        </select>
       

        <label for="produto">Produto</label>
        <select name="produto" id="produto" onchange="calcularTotal()" required>
            <option value="">Selecione o produto</option>
            <?php while($row = $resultProdutos->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?= $row['id'] ?>" data-preco="<?= $row['valor']?>" maxima="<?= $row['quantidade']?>"><?= htmlspecialchars($row['descricao']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <div class="row mb-2">

          <div class="col-md-6">
            <label for="quantidade lbl-field">Quantidade Vendida</label>
            <input type="number" name="quantidade" id="quantidade" min="1" value="1" onchange="calcularTotal()" required><br><br>
          </div>

           <div class="col-md-6">
            <label for="valor">Valor da Venda</label>
            <input type="text" name="valor" id="valor" readonly>
          </div>
        </div>    

        <button type="submit">Registrar Venda</button>
         <!-- Div para mensagens -->
        <div id="message" style="display:none;"></div>
    </form>
        <script>
            function calcularTotal() {
            const select = document.getElementById("produto");
            const quantidade = document.getElementById("quantidade").value;
            const preco = parseFloat(select.options[select.selectedIndex].getAttribute("data-preco"));
            let quantidade_maxima = parseInt(select.options[select.selectedIndex].getAttribute("maxima"));
            if(quantidade_maxima === 0){
                quantidade_maxima = quantidade_maxima + 1;
            }
            const total = preco * quantidade;
            document.getElementById("valor").value = total.toFixed(2);
            document.getElementById("quantidade").max = quantidade_maxima;
            }
        </script>
        <script src="js/enviarVenda.js"></script>
</div>


