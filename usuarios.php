<?php session_start(); ?>
<div class="container">
    <h2>Cadastro de Usuários</h2>
    <form id="formCadUsuario">
        <div class="row mb-3">

            <div class="col-md-6">
              <label for="nm_nome" class="form-label">Nome</label>
              <input type="text" id="nm_nome" name="nm_nome" placeholder="Nome">
            </div>

            <div class="col-md-6">
              <label for="nm_login" class="form-label">Login</label>
              <input type="text" id="nm_login" name="nm_login" placeholder="Login">
            </div>
         </div>
         
         <!-- Email -->
          <div class="mb-3">
            <label for="ds_email" class="form-label">Email</label>
            <input type="text" id="ds_email" name="ds_email" placeholder="Email">
          </div>

          <!-- Senha -->
          <div class="mb-3">
            <label for="ds_password" class="form-label">Senha</label>
            <input type="password" id="ds_password" name="senha" placeholder="Senha">
          </div>
            <!-- Foto de Perfil (imagem ao lado do input file) -->
         <div class="mb-3 d-flex align-items-center gap-3">
            <!-- Input de arquivo (lado esquerdo) -->
            <div>
              <label for="foto_perfil" class="form-label">Foto de Perfil</label>
              <input type="file" class="form-control" id="foto_cadastro" name="foto_cadastro" accept="image/*">
            </div>

            <!-- Imagem de pré-visualização (lado direito) -->
            <div id="preview-container">
              <?php if (!empty($_SESSION['foto_cadastro']) && isset($_SESSION['foto_perfil'])): ?>
                <img src="uploads/<?php echo $_SESSION['foto_perfil']; ?>" alt="Foto de Cadastro"
                    width="150" height="150"
                    style="object-fit: cover; border-radius: 8px;">
              <?php endif; ?>
            </div>
          </div>
          <!-- Checkbox Administrador -->
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="inadim" name="inadmin" <?php echo ($_SESSION['in_admin'] == 1) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="inadim">Administrador</label>
          </div>

        <button type="submit" class="button">Confirmar</button>
        <!-- Div para mensagens -->
        <div id="message" style="display:none;"></div>
    </form>
    <script src="js/enviardados.js"></script>
</div>

<script>
  document.getElementById('foto_cadastro').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (!file) return;

    const preview = document.createElement('img');
    preview.width = 140;
   // preview.classList.add('rounded-circle', 'mb-2');

    const reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;

      // Remove pré-visualização anterior se houver
      const container = document.getElementById('preview-container');
      container.innerHTML = '';
      container.appendChild(preview);
    };
    reader.readAsDataURL(file);
  });
</script>
