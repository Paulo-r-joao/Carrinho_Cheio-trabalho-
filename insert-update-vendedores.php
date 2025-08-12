<?php
require_once "conexao.php";

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $nome = $_POST["nome"] ?? '';
        $endereco = $_POST["endereco"] ?? '';
        $telefone = $_POST["telefone"] ?? '';
        $email = $_POST["email"] ?? '';

        // Validação de campos obrigatórios
        if (empty($nome) || empty($endereco) || empty($telefone) || empty($email)) {
            throw new Exception("Todos os campos são obrigatórios.");
        }

        $fotoVendedor = null;

        if (isset($_FILES['foto_vendedor']) && $_FILES['foto_vendedor']['error'] === UPLOAD_ERR_OK) {
            $extensao = pathinfo($_FILES['foto_vendedor']['name'], PATHINFO_EXTENSION);
            $fotoNome = uniqid('vendedor_', true) . "." . $extensao;

            $caminhoUpload = __DIR__ . "/uploads/" . $fotoNome;

            if (!move_uploaded_file($_FILES['foto_vendedor']['tmp_name'], $caminhoUpload)) {
                throw new Exception("Erro ao fazer upload da imagem.");
            }

            $fotoVendedor = $fotoNome;
        }

        // Verifica se já existe um vendedor com esse nome e email
        $sqlVerifica = "SELECT id FROM vendedores WHERE nome = :nome AND email = :email";
        $stmtVerifica = $pdo->prepare($sqlVerifica);
        $stmtVerifica->bindParam(':nome', $nome);
        $stmtVerifica->bindParam(':email', $email);
        $stmtVerifica->execute();

        if ($stmtVerifica->rowCount() > 0) {
            // Atualiza vendedor existente
            $sql = "UPDATE vendedores 
                    SET endereco = :endereco, telefone = :telefone";

            if ($fotoVendedor) {
                $sql .= ", foto_vendedores = :foto_vendedores";
            }

            $sql .= " WHERE nome = :nome AND email = :email";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':endereco', $endereco);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);

            if ($fotoVendedor) {
                $stmt->bindParam(':foto_vendedores', $fotoVendedor);
            }

            $stmt->execute();

            echo json_encode(["success" => true, "message" => "Vendedor atualizado com sucesso!"]);
        } else {
            // Insere novo vendedor
            $sql = "INSERT INTO vendedores (nome, endereco, telefone, email, foto_vendedores) 
                    VALUES (:nome, :endereco, :telefone, :email, :foto_vendedores)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':endereco', $endereco);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':email', $email);
            $stmt->bindValue(':foto_vendedores', $fotoVendedor);

            $stmt->execute();

            echo json_encode(["success" => true, "message" => "Vendedor cadastrado com sucesso!"]);
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