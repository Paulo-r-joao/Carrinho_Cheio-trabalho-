<!-- painel.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Carrinho Cheio</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style-painel.css">
  <link rel="stylesheet" href="css/style.css">
  <!-- icone -->
  <link rel="icon" href="img/x.ico" type="image/x-icon"><!-- colocar imagem em -> .ico < -->
</head>

<body>
<?php session_start(); ?>

<!-- Barra superior -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container">
    <button class="btn btn-outline-secondary d-lg-none" id="menu-toggle">
      <i class="bi bi-list"></i>
    </button>
    <div class="ms-auto dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-bs-toggle="dropdown">
        <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['nm_login']); ?>
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="configuracoes" data-bs-toggle="" data-bs-target="#configuracoes">
            <i class="bi bi-gear"></i> Configurações
          </a>
        <!-- Perfi -->
          <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalUsuario">
            <i class="bi bi-person me-2"></i> Perfil
          </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <a class="dropdown-item text-danger" href="logout.php">
            <i class="bi bi-box-arrow-right me-2"></i> Sair
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- https://icons.getbootstrap.com/ -->
<!-- Menu Lateral -->
<div id="sidebar">
  <div class="text-center fw-bold py-3">
    <!-- bi bi-shop-window -->
    <a>Carrinho Cheio</a> 
  </div>
  <nav class="nav flex-column">
    <a class="nav-link" data-bs-toggle="collapse" href="#cadastros">
      <span><i class="bi bi-folder-plus"></i> Cadastros</span>
      <i class="bi bi-chevron-down"></i>
    </a>
    <div class="collapse" id="cadastros">
      <a href="#" class="nav-link submenu" data-page="clientes">Clientes</a>
      <a href="#" class="nav-link submenu" data-page="vendedores">Vendedores</a>
      <a href="#" class="nav-link submenu" data-page="produtos">Produtos</a>
    </div>

    <a class="nav-link" data-bs-toggle="collapse" href="#movimentacoes">
      <span><i class="bi-cart"></i> Vendas</span>
      <i class="bi bi-chevron-down"></i>
    </a>
    <div class="collapse" id="movimentacoes">
      <a href="#" class="nav-link submenu" data-page="vendas">Vendas</a>
      <a href="#" class="nav-link submenu" data-page="historico-vendas">Histórico de Vendas</a>
    </div>

    <a class="nav-link" data-bs-toggle="collapse" href="#relatorios">
      <span><i class="bi bi-journals"></i> Relatórios</span>
      <i class="bi bi-chevron-down"></i>
    </a>
    <div class="collapse" id="relatorios">
      <a href="#" class="nav-link submenu" data-page="historico-clientes">Clientes</a>
      <a href="#" class="nav-link submenu" data-page="historico-vendedores">Vendedores</a>
      <a href="#" class="nav-link submenu" data-page="historico-produtos">Produtos</a>
    </div>

    <a class="nav-link" data-bs-toggle="collapse" href="#administracao">
      <span><i class="bi bi-person-gear"></i> Administração</span>
      <i class="bi bi-chevron-down"></i>
    </a>
    <div class="collapse" id="administracao">
      <a href="#" class="nav-link submenu" data-page="historico-usuarios">Lista Usuários</a>
      <a href="#" class="nav-link submenu" data-page="usuarios">Cadastro Usuários</a>
      <a href="#" class="nav-link submenu" data-page="permissoes">Permissões</a>
    </div>
  </nav>
</div>

<!-- Conteúdo Principal -->
<div id="main">
  <h2>Bem-vindo!</h2>
  <p>Selecione um item do menu à esquerda.</p>
</div>

<!-- Modal de Perfil do Usuário -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content width-modal">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUsuarioLabel">Meu Perfil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Nome</label>
            <input type="text" class="form-control" value="<?php echo $_SESSION['nm_nome'] ?? ''; ?>" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Login</label>
            <input type="text" class="form-control" value="<?php echo $_SESSION['nm_login'] ?? ''; ?>" readonly>
          </div>
        </div>

        <div class="row mb-3 align-items-center">
          <div class="col-md-8">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" value="<?php echo $_SESSION['ds_email'] ?? ''; ?>" readonly>
          </div>
          <div class="col-md-4 text-center">
            <label class="form-label d-block">Foto de Perfil</label>
            <div id="preview-container">
              <?php if (!empty($_SESSION['foto_perfil'])): ?>
                <img src="uploads/<?php echo $_SESSION['foto_perfil']; ?>" alt="Foto de Perfil"
                     width="100" height="100"
                     style="object-fit: cover; border-radius: 8px;">
              <?php else: ?>
                <p class="text-muted" style="font-size: 0.9em;">Nenhuma foto enviada.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once 'editar-user.php'; ?>

<!-- No final do body, antes de fechar </body> -->
<!-- jQuery primeiro -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Depois Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Depois seus scripts -->
<script src="js/script.js"></script>
<script src="js/enviardados.js"></script>

<script>
    // Toggle do menu lateral
    document.getElementById('menu-toggle').addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('show');
    });

    // Pré-visualização de imagem de perfil
    document.getElementById('foto_perfil').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (!file) return;

        const preview = document.createElement('img');
        preview.width = 150;
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            
            const container = document.getElementById('preview-container');
            container.innerHTML = '';
            container.appendChild(preview);
        };
        reader.readAsDataURL(file);
    });
</script>

</body>
</html>