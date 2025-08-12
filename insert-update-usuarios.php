<?php
require_once "conexao.php";

header('Content-Type: application/json'); // Indica que retornará JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $nome = $_POST["nm_nome"] ?? '';
        $nmlogin = $_POST["nm_login"] ?? '';
        $dspassword = $_POST["senha"] ?? '';
        $dsemail = $_POST["ds_email"] ?? '';
        $inadmin = isset($_POST["inadmin"]) ? 1 : 0;
        if (!filter_var($dsemail, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("E-mail incorreto");
        }
   
        if (preg_match("/[*+=\/'\-]/", $dsemail)) {
            throw new Exception("E-mail possuí caracteres não permitidos");
        }
        
        
        if (empty($nome) ) {
            throw new Exception("Nome não pode ser vazio");
        }
        if(strlen($nmlogin) < 5|| strlen($nome) < 5 ){throw new Exception("Nome e Login devem ser mais de 5 letras");}

        if (preg_match("/[*+=\/'\\\\]/", $dspassword)) {
            throw new Exception("Senha inválida: contém caracteres proibidos.");
        }
    
        // Exemplo de regra extra (opcional)
        if (strlen($dspassword) < 5) {
            throw new Exception("Senha muito curta. Mínimo 5 caracteres.");
        }
    
        if (strlen($dspassword) > 15) {
            throw new Exception("Senha muito longa. Máximo 15 caracteres.");
        }

        $fotoPerfil = null;
        
       
        $sqlVerifica = "SELECT id FROM usuarios WHERE nm_login = :nmlogin";
        $stmtVerifica = $pdo->prepare($sqlVerifica);
        $stmtVerifica->bindParam(':nmlogin', $nmlogin);
        $stmtVerifica->execute();

        if ($stmtVerifica->rowCount() > 0) {

            if (!empty($_FILES['foto_perfil']['name'])) {
                $fotoNome = uniqid() . "_" . basename($_FILES['foto_perfil']['name']);
                $caminhoUpload = __DIR__ . "/uploads/" . $fotoNome;
    
                if (!move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $caminhoUpload)) {
                    throw new Exception("Erro ao fazer upload da imagem.");
                }
    
                $fotoPerfil = $fotoNome;
            }
            else{
                echo json_encode( "Nao tem foto" );
            } 

            // Atualizar
            $sql = "UPDATE usuarios 
                    SET nm_nome = :nome, ds_password = :dspassword, ds_email = :dsemail, in_admin = :inadmin";

            if ($fotoPerfil !== null) {
                $sql .= ", foto_perfil = :foto_perfil";
            }

            $sql .= " WHERE nm_login = :nmlogin";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':dspassword', $dspassword);
            $stmt->bindParam(':dsemail', $dsemail);
            $stmt->bindParam(':inadmin', $inadmin);
            $stmt->bindParam(':nmlogin', $nmlogin);

            if ($fotoPerfil !== null) {
                $stmt->bindParam(':foto_perfil', $fotoPerfil);
            }

            $stmt->execute();

            echo json_encode(["success" => true, "message" => "Usuário atualizado com sucesso!"]);
        } else {
            // Inserir

            if (!empty($_FILES['foto_cadastro']['name'])) {
                $fotoNome = uniqid() . "_" . basename($_FILES['foto_cadastro']['name']);
                $caminhoUpload = __DIR__ . "/uploads/" . $fotoNome;
    
                if (!move_uploaded_file($_FILES['foto_cadastro']['tmp_name'], $caminhoUpload)) {
                    throw new Exception("Erro ao fazer upload da imagem.");
                }
    
                $fotoPerfil = $fotoNome;
            }
            else{

               // echo json_encode( "Nao tem foto" );
                $fotoPerfil = 'sem-foto.jpg';
            } 

            $sql = "INSERT INTO usuarios (nm_nome, nm_login, ds_password, ds_email, in_admin, foto_perfil) 
                    VALUES (:nome, :nmlogin, :dspassword, :dsemail, :inadmin, :foto_perfil)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':nmlogin', $nmlogin);
            $stmt->bindParam(':dspassword', $dspassword);
            $stmt->bindParam(':dsemail', $dsemail);
            $stmt->bindParam(':inadmin', $inadmin);
            $stmt->bindParam(':foto_perfil', $fotoPerfil);
            $stmt->execute();                                                                                                      

            echo json_encode(["success" => true, "message" => "Usuário cadastrado com sucesso!"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erro no banco: " . $e->getMessage()]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Erro: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Requisição inválida."]);
}