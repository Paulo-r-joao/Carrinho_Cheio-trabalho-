<?php
require_once("conexao.php");

$filtro = isset($_GET['filtro']) ? trim($_GET['filtro']) : '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$limite = 6;
$offset = ($pagina - 1) * $limite;

// Consulta base com filtro
$sqlBase = "FROM vendedores v
    WHERE v.id LIKE :filtro 
    OR v.nome LIKE :filtro 
    OR v.endereco LIKE :filtro 
    OR v.telefone LIKE :filtro 
    OR v.email LIKE :filtro";

// Conta total
$stmtTotal = $pdo->prepare("SELECT COUNT(*) $sqlBase");
$stmtTotal->execute([':filtro' => "%$filtro%"]);
$totalRegistros = $stmtTotal->fetchColumn();
$totalPaginas = ceil($totalRegistros / $limite);

// Busca paginada
$stmt = $pdo->prepare("SELECT 
    v.id AS id,
    v.nome AS nome,
    v.endereco,
    v.telefone,
    v.email,
    v.foto_vendedores AS foto_vendedores
    $sqlBase
    ORDER BY v.id ASC
    LIMIT :limite OFFSET :offset");

$stmt->bindValue(':filtro', "%$filtro%", PDO::PARAM_STR);
$stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$vendedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gera HTML das linhas
$html = '';
foreach ($vendedores as $v) {
    $html .= "<tr>
        <td>" . htmlspecialchars($v['id']) . "</td>
        <td>" . htmlspecialchars($v['nome']) . "</td>
        <td>" . htmlspecialchars($v['endereco']) . "</td>
        <td>" . htmlspecialchars($v['telefone']) . "</td>
        <td>" . htmlspecialchars($v['email']) . "</td>
        <td><img src='uploads/" . htmlspecialchars($v['foto_vendedores']) . "' alt='Foto' style='width: 41px; height: auto;'></td>
    </tr>";
}

header('Content-Type: application/json');
echo json_encode([
    'tabela' => $html,
    'totalPaginas' => $totalPaginas
]);
?>
