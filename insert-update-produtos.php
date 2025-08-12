<?php
require_once "conexao.php";

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $id = $_POST["id"] ?? '';
        $descricao = $_POST["descricao"] ?? '';
        $quantidade = $_POST["quantidade"] ?? '';
        $tipoEmbalagem = $_POST["tipoEmbalagem"] ?? '';
        $valor = $_POST["valor"] ?? '';

        // Validação de campos obrigatórios
        if (empty($descricao) || empty($quantidade) || empty($tipoEmbalagem) || empty($valor)) {
            throw new Exception("Todos os campos são obrigatórios.");
        }

        $fotoProduto = null;

        // Se tiver uma imagem para upload
        if (isset($_FILES['foto_produto']) && $_FILES['foto_produto']['error'] === UPLOAD_ERR_OK) {
            $extensao = pathinfo($_FILES['foto_produto']['name'], PATHINFO_EXTENSION);
            $fotoNome = uniqid('img_', true) . "." . $extensao;

            $caminhoUpload = __DIR__ . "/uploads/" . $fotoNome;

            if (!move_uploaded_file($_FILES['foto_produto']['tmp_name'], $caminhoUpload)) {
                throw new Exception("Erro ao fazer upload da imagem.");
            }

            $fotoProduto = $fotoNome;
        }

        // Verifica se já existe um produto com essa descrição
        $sqlVerifica = "SELECT id FROM produtos WHERE descricao = :descricao";
        $stmtVerifica = $pdo->prepare($sqlVerifica);
        $stmtVerifica->bindParam(':descricao', $descricao);
        $stmtVerifica->execute();

        if ($stmtVerifica->rowCount() > 0) {
            // Atualiza produto existente
            $sql = "UPDATE produtos 
                    SET quantidade = :quantidade, tipoEmbalagem = :tipoEmbalagem, valor = :valor";

            if ($fotoProduto) {
                $sql .= ", foto_produto = :foto_produto";
            }

            $sql .= " WHERE descricao = :descricao";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':quantidade', $quantidade);
            $stmt->bindParam(':tipoEmbalagem', $tipoEmbalagem);
            $stmt->bindParam(':valor', $valor);
            $stmt->bindParam(':descricao', $descricao);

            if ($fotoProduto) {
                $stmt->bindParam(':foto_produto', $fotoProduto);
            }

            $stmt->execute();

            echo json_encode(["success" => true, "message" => "Produto atualizado com sucesso!"]);
        } else {
            // Insere novo produto
            $sql = "INSERT INTO produtos (id, descricao, quantidade, tipoEmbalagem, valor, foto_produto) 
                    VALUES (:id, :descricao, :quantidade, :tipoEmbalagem, :valor, :foto_produto)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':quantidade', $quantidade);
            $stmt->bindParam(':tipoEmbalagem', $tipoEmbalagem);
            $stmt->bindParam(':valor', $valor);

            // Se não enviou imagem, salva NULL
            $stmt->bindValue(':foto_produto', $fotoProduto);

            $stmt->execute();

            echo json_encode(["success" => true, "message" => "Produto cadastrado com sucesso!"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erro no banco: " . $e->getMessage()]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Erro: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Requisição inválida."]);
}
?>
