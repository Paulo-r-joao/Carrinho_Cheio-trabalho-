<?php
require_once "conexao.php";

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $nome = $_POST["nome"] ?? '';
        $endereco = $_POST["endereco"] ?? '';
        $telefone = $_POST["telefone"] ?? null;
        $email = $_POST["email"] ?? '';
        $estado_civil = $_POST["estado_civil"] ?? '';


        if(strlen($telefone)<9){throw new Exception("O telefone deve estar completo");}

        if (empty($nome)) {
            throw new Exception("O nome é obrigatório.");
        }

        $fotoCliente = null;

        if (isset($_FILES['foto_cliente']) && $_FILES['foto_cliente']['error'] === UPLOAD_ERR_OK) {
            $extensao = pathinfo($_FILES['foto_cliente']['name'], PATHINFO_EXTENSION);
            $fotoNome = uniqid('cliente_', true) . "." . $extensao;

            $caminhoUpload = __DIR__ . "/uploads/" . $fotoNome;

            if (!move_uploaded_file($_FILES['foto_cliente']['tmp_name'], $caminhoUpload)) {
                throw new Exception("Erro ao fazer upload da imagem.");
            }

            $fotoCliente = $fotoNome;
            $_SESSION['foto_cliente'] = $fotoCliente;  // opcional: se quiser manter na sessão.
        }

        // Verifica se já existe um cliente com esse nome e email
        $sqlVerifica = "SELECT id FROM clientes WHERE nome = :nome AND email = :email";
        $stmtVerifica = $pdo->prepare($sqlVerifica);
        $stmtVerifica->bindParam(':nome', $nome);
        $stmtVerifica->bindParam(':email', $email);
        $stmtVerifica->execute();

        if ($stmtVerifica->rowCount() > 0) {
            // Atualiza cliente existente
            $sql = "UPDATE clientes 
                    SET endereco = :endereco, telefone = :telefone, estado_civil = :estado_civil";

            if ($fotoCliente) {
                $sql .= ", foto_clientes = :foto_clientes";
            }

            $sql .= " WHERE nome = :nome AND email = :email";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':endereco', $endereco);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':estado_civil', $estado_civil);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);

            if ($fotoCliente) {
                $stmt->bindParam(':foto_clientes', $fotoCliente);
            }

            $stmt->execute();

            echo json_encode(["success" => true, "message" => "Cliente atualizado com sucesso!"]);
        } else {
            // Insere novo cliente
            $sql = "INSERT INTO clientes (nome, endereco, telefone, email, estado_civil, foto_clientes) 
                    VALUES (:nome, :endereco, :telefone, :email, :estado_civil, :foto_clientes)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':endereco', $endereco);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':estado_civil', $estado_civil);
            $stmt->bindValue(':foto_clientes', $fotoCliente);

            $stmt->execute();

            echo json_encode(["success" => true, "message" => "Cliente cadastrado com sucesso!"]);
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
