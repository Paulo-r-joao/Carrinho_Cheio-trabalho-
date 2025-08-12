<?php
require_once("conexao.php");

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID não informado']);
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("
    SELECT id, nm_login, nm_nome, ds_email, ds_password, in_admin, foto_perfil
    FROM usuarios
    WHERE id = :id
    LIMIT 1
");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo json_encode(['success' => true, 'data' => $user]);
} else {
    echo json_encode(['success' => false, 'message' => 'Usuário não encontrado']);
}
