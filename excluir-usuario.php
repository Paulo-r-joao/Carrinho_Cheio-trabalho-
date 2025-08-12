<?php
require_once("conexao.php");

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['sucesso' => false, 'erro' => 'ID não informado']);
    exit;
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo json_encode(['sucesso' => true]);
} else {
    echo json_encode(['sucesso' => false, 'erro' => 'Erro ao deletar usuário']);
}
exit;
