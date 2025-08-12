<!-- historico-usuarios.php -->
<link rel="stylesheet" href="css/style.css">
<div class="escuro"></div>
  

<div class="container mt-4" style='background-color:rgba(224, 224, 224, 0.507);'>
  
  
  <div class="card ">
    <div class="text-white p-3">
      <h4 class="mb-0">Histórico de Usuários</h4>
    </div>
    <div class="card-body">
      <input type="text" id="filtro" class="form-control mb-3" placeholder="Buscar na tabela...">
      
      <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
          <thead class="table-dark">
            <tr>
              <th>Id</th>
              <th>Login</th>
              <th>Nome</th>
              <th>Email</th>
              <th>Acesso</th>
              <th>Foto Perfil</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody id="corpo-tabela">
            <!-- Conteúdo carregado via AJAX -->
          </tbody>
        </table>
      </div>
      <div id="mensagem-container" class="alert-mensagem " style="z-index:1100;"></div>
      <!-- Diálogo global de confirmação (centralizado) -->
       
      <div id="confirmation-dialog">
        <p>Excluir este usuário?</p>
        <div class="d-flex">
          <button id="btn-cancel" class="btn btn-sm btn-outline-secondary" style='border-radius:8px;'>Não</button>
          <button id="btn-confirm" class="btn btn-sm btn-danger" style='border-radius:8px;'>Sim</button>
        </div>
      </div>
      
      <nav>
        <ul id="paginacao" class="pagination justify-content-center mt-4"></ul>
      </nav>
    </div>
  </div>
</div>

<script>
  const escuro = document.querySelector('.escuro');
  const dialog = document.getElementById('confirmation-dialog');
  const btnCancel = document.getElementById('btn-cancel');
  const btnConfirm = document.getElementById('btn-confirm');

  // Função para abrir
  function abrirDialogo() {

      escuro.style.display = 'block';
      dialog.style.display = 'block';
  }

  // Função para fechar
  function fecharDialogo() {
      escuro.style.display = 'none';
      dialog.style.display = 'none';
  }

  // Eventos dos botões
  btnCancel.addEventListener('click', fecharDialogo);
  escuro.addEventListener('click', fecharDialogo);
</script>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Seu script -->
<script src="js/script-ordenacao-usuarios.js"></script>
