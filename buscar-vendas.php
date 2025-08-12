<?php
require_once("conexao.php");

$filtro = isset($_GET['filtro']) ? trim($_GET['filtro']) : '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$limite = 3;
$offset = ($pagina - 1) * $limite;

// Consulta base com filtro
$sqlBase = "FROM vendas v
    INNER JOIN clientes c ON v.idCliente = c.id
    INNER JOIN produtos p ON v.idProduto = p.id
    INNER JOIN vendedores ve ON v.idVendedor = ve.id
    WHERE c.nome LIKE :filtro OR p.descricao LIKE :filtro OR ve.nome LIKE :filtro";

// Conta total
$stmtTotal = $pdo->prepare("SELECT COUNT(*) $sqlBase");
$stmtTotal->execute([':filtro' => "%$filtro%"]);
$totalRegistros = $stmtTotal->fetchColumn();
$totalPaginas = ceil($totalRegistros / $limite);

// Busca paginada
$stmt = $pdo->prepare("SELECT 
    v.qtQuantidade,
    v.vlValor,
    c.nome AS nomeCliente,
    p.descricao AS nomeProduto,
    ve.nome AS nomeVendedor
    $sqlBase
    ORDER BY v.data_venda DESC
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
        <td>" . htmlspecialchars($v['nomeCliente']) . "</td>
        <td>" . htmlspecialchars($v['nomeProduto']) . "</td>
        <td>" . htmlspecialchars($v['nomeVendedor']) . "</td>
        <td>" . $v['qtQuantidade'] . "</td>
        <td>R$ " . number_format($v['vlValor'], 2, ',', '.') . "</td>
    </tr>";
}

echo json_encode([
    'tabela' => $html,
    'totalPaginas' => $totalPaginas
]);
