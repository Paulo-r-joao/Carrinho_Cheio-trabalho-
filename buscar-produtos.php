<?php
require_once("conexao.php");

$filtro = isset($_GET['filtro']) ? trim($_GET['filtro']) : '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$limite = 6;
$offset = ($pagina - 1) * $limite;

// Consulta base com filtro
$sqlBase = "FROM produtos p
    WHERE p.id LIKE :filtro 
    OR p.descricao LIKE :filtro 
    OR p.quantidade LIKE :filtro 
    OR p.tipoEmbalagem LIKE :filtro 
    OR p.valor LIKE :filtro";

// Conta total
$stmtTotal = $pdo->prepare("SELECT COUNT(*) $sqlBase");
$stmtTotal->execute([':filtro' => "%$filtro%"]);
$totalRegistros = $stmtTotal->fetchColumn();
$totalPaginas = ceil($totalRegistros / $limite);

// Busca paginada
$stmt = $pdo->prepare("SELECT 
    p.id AS id,
    p.descricao AS nome,
    p.quantidade,
    p.tipoEmbalagem AS tipo,
    p.valor,
    p.foto_produto
    $sqlBase
    ORDER BY p.id ASC
    LIMIT :limite OFFSET :offset");

$stmt->bindValue(':filtro', "%$filtro%", PDO::PARAM_STR);
$stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gera HTML das linhas
$html = '';
foreach ($vendas as $v) {
    $html .= "<tr>
        <td>" . htmlspecialchars($v['id']) . "</td>
        <td>" . htmlspecialchars($v['nome']) . "</td>
        <td>" . htmlspecialchars($v['tipo']) . "</td>
        <td>" . $v['quantidade'] . "</td>
        <td>R$ " . number_format($v['valor'], 2, ',', '.') . "</td>
        <td><img src='uploads/" . htmlspecialchars($v['foto_produto']) . "' alt='Foto do Produto' style='width: 41px; height: auto;'></td>
    </tr>";
}

header('Content-Type: application/json');
echo json_encode([
    'tabela' => $html,
    'totalPaginas' => $totalPaginas
]);
?>