<?php
// delete-usuario.php

// Conexão com o banco de dados (ajuste conforme necessário)
require_once 'conexao.php'; // Certifique-se de que este arquivo define $pdo

// Define o header para JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o ID foi enviado
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = intval($_POST['id']);

        try {
            // Verifica se o usuário existe
            $stmt = $pdo->prepare("SELECT foto_perfil FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);
            $usuario = $stmt->fetch();

            if (!$usuario) {
                echo json_encode(['success' => false, 'message' => 'Usuário não encontrado.']);
                exit;
            }

            // Excluir imagem, se existir
            if (!empty($usuario['foto_perfil'])) {
                $caminhoFoto = 'uploads/' . $usuario['foto_perfil'];
                if (file_exists($caminhoFoto)) {
                    unlink($caminhoFoto);
                }
            }

            // Deletar usuário do banco
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);

            echo json_encode(['success' => true, 'message' => 'Usuário excluído com sucesso.']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao excluir: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'ID inválido.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida.']);
}
