<?php
require_once("conexao.php");

$filtro = isset($_GET['filtro']) ? trim($_GET['filtro']) : '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$limite = 6;
$offset = ($pagina - 1) * $limite;

$sqlBase = "FROM clientes c
    WHERE c.id LIKE :filtro 
    OR c.nome LIKE :filtro 
    OR c.endereco LIKE :filtro 
    OR c.telefone LIKE :filtro 
    OR c.email LIKE :filtro
    OR c.estado_civil LIKE :filtro";

// Conta total
$stmtTotal = $pdo->prepare("SELECT COUNT(*) $sqlBase");
$stmtTotal->execute([':filtro' => "%$filtro%"]);
$totalRegistros = $stmtTotal->fetchColumn();
$totalPaginas = ceil($totalRegistros / $limite);

// Busca paginada
$stmt = $pdo->prepare("SELECT 
    c.id AS id,
    c.nome AS nome,
    c.endereco AS endereco,
    c.telefone AS telefone,
    c.email AS email,
    c.estado_civil AS estadoCivil,
    c.foto_clientes AS fotoClientes
    $sqlBase
    ORDER BY c.id ASC
    LIMIT :limite OFFSET :offset");

$stmt->bindValue(':filtro', "%$filtro%", PDO::PARAM_STR);
$stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$html = '';
foreach ($clientes as $c) {
    $foto = !empty($c['fotoClientes']) ? "uploads/" . htmlspecialchars($c['fotoClientes']) : 'sem-foto.png';
    $html .= "<tr>
        <td>" . htmlspecialchars($c['id']) . "</td>
        <td>" . htmlspecialchars($c['nome']) . "</td>
        <td>" . htmlspecialchars($c['endereco']) . "</td>
        <td>" . htmlspecialchars($c['email']) . "</td>
        <td>" . htmlspecialchars($c['telefone']) . "</td>
        <td>" . htmlspecialchars($c['estadoCivil']) . "</td>
        <td><img src='{$foto}' alt='Foto' style='width: 41px; height: auto;'></td>
        
        
        
    </tr>";
}

header('Content-Type: application/json');
echo json_encode([
    'tabela' => $html,
    'totalPaginas' => $totalPaginas
]);
?>
