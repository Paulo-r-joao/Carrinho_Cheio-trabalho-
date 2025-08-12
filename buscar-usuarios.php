<?php
require_once("conexao.php");

$filtro  = isset($_GET['filtro'])  ? trim($_GET['filtro'])  : '';
$pagina  = isset($_GET['pagina'])  ? (int)$_GET['pagina']  : 1;
$limite  = 5;
$offset  = ($pagina - 1) * $limite;

// Consulta base com filtro
$sqlBase = "
    FROM usuarios u
    WHERE u.id           LIKE :filtro
       OR u.nm_login     LIKE :filtro
       OR u.nm_nome      LIKE :filtro
       OR u.ds_password  LIKE :filtro
       OR u.ds_email     LIKE :filtro
       OR u.in_admin     LIKE :filtro
";

// Conta total
$stmtTotal = $pdo->prepare("SELECT COUNT(*) $sqlBase");
$stmtTotal->execute([':filtro' => "%$filtro%"]);
$totalRegistros = $stmtTotal->fetchColumn();
$totalPaginas    = ceil($totalRegistros / $limite);

// Busca paginada
$stmt = $pdo->prepare("
    SELECT 
      u.id           AS id,
      u.nm_login     AS login,
      u.nm_nome      AS nome,
      u.ds_email     AS email,
      u.in_admin,
      u.foto_perfil  AS foto_perfil
    $sqlBase
    ORDER BY u.id ASC
    LIMIT :limite OFFSET :offset
");
$stmt->bindValue(':filtro',  "%$filtro%", PDO::PARAM_STR);
$stmt->bindValue(':limite',  $limite,    PDO::PARAM_INT);
$stmt->bindValue(':offset',  $offset,    PDO::PARAM_INT);
$stmt->execute();

$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gera HTML das linhas
$html = '';
foreach ($usuarios as $u) {
    if($u["in_admin"]==1){$u["in_admin"] = "ADM";}else{$u["in_admin"] = "VEND";}
    $html .= "<tr>
        <td>" . htmlspecialchars($u['id'])   . "</td>
        <td>" . htmlspecialchars($u['login']). "</td>
        <td>" . htmlspecialchars($u['nome']) . "</td>
        <td>" . htmlspecialchars($u['email']). "</td>
        <td>" . htmlspecialchars($u['in_admin']). "</td>
        <td><img src='uploads/" . htmlspecialchars($u['foto_perfil']) . "' alt='Foto' style='width:41px; height:auto;'></td>
        <td>
            <div class='btn-group'>
                <a href='#'
                   class='btn btn-primary editar-usuario'
                   data-bs-toggle='modal'
                   data-bs-target='#modalCadastroUsuario'
                   data-id='" . htmlspecialchars($u['id']) . "'>
                  Editar
                </a>
                <a href='#'
                   class='btn btn-danger btn-excluir' onclick='abrirDialogo()'
                   data-id='" . htmlspecialchars($u['id']) . "'>
                  Excluir
                </a>
            </div>
        </td>
    </tr>";
}

header('Content-Type: application/json');
echo json_encode([
    'tabela'       => $html,
    'totalPaginas' => $totalPaginas
]);
