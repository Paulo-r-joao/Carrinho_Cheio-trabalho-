<?php

$success = true;
$message = 'Venda efetuada com sucesso!';

header("Content-Type: application/json");
require_once "conexao.php"; // $pdo definido

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $cliente = $_POST["cliente"] ?? '';
        $vendedor = $_POST["vendedor"] ?? '';
        $produto = $_POST["produto"] ?? '';
        $quantidade = $_POST["quantidade"] ?? '';
        $valor = $_POST["valor"] ?? '';

        // PEGANDO A QUANTIDADE DISPONÍVEL NO ESTOQUE
        $sqlQ = "SELECT quantidade FROM produtos WHERE id = :idProduto";
        $sqlQuantidade = $pdo->prepare($sqlQ);
        $sqlQuantidade->bindParam(':idProduto', $produto);
        $sqlQuantidade->execute();

        $Produto = $sqlQuantidade->fetch(PDO::FETCH_ASSOC);

        if (!$Produto) {
            throw new Exception("Produto não encontrado.");
        }

        $quantidadeEstoque = (int) $Produto['quantidade'];
        $quantidadeCliente = (int) $quantidade;

        if (($quantidadeEstoque - $quantidadeCliente) < 0) {
            throw new Exception("Quantidade insuficiente em estoque.");
        }

        // INSERINDO VENDA
        $sql = "INSERT INTO vendas (idCliente, idVendedor, idProduto, qtQuantidade, vlValor)
                VALUES (:idCliente, :idVendedor, :idProduto, :qtQuantidade, :vlValor)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idCliente', $cliente);
        $stmt->bindParam(':idVendedor', $vendedor);
        $stmt->bindParam(':idProduto', $produto);
        $stmt->bindParam(':qtQuantidade', $quantidade);  
        $stmt->bindParam(':vlValor', $valor);       
        $stmt->execute();

        // ATUALIZANDO ESTOQUE
        $sql = "UPDATE produtos SET quantidade = quantidade - :qtQuantidade WHERE id = :idProduto";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':qtQuantidade', $quantidade);
        $stmt->bindParam(':idProduto', $produto);
        $stmt->execute();

        echo json_encode([
            'success' => $success,
            'message' => $message
        ]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Erro no banco de dados: " . $e->getMessage()]);
    } catch (Exception $e) {
        echo json_encode(["message" => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Método não permitido."]);
}

exit;
