<div class="modal fade" id="modalCadastroUsuario" tabindex="-1" aria-labelledby="modalCadastroUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content width-modal">
      <form id="formCadUsuario" enctype="multipart/form-data">
        <input type="hidden" id="id" name="id" value="">

        <div class="modal-header">
          <h5 class="modal-title">Editar Usuário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <div class="modal-body">

          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Nome</label>
              <input type="text" class="form-control" id="nm_nome" name="nm_nome" value="" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Login</label>
              <input type="text" class="form-control" id="nm_login" name="nm_login" value="" readonly>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" id="ds_email" name="ds_email" value="" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label">Senha Atual</label>
            <input type="text" class="form-control" id="old_ds_password" name="old_senha" value="" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label">Nova Senha</label>
            <input type="password" class="form-control" id="ds_password" name="senha" value="">
          </div>

          <div class="mb-3">
            <label class="form-label">Foto de Perfil</label>
            <input type="file" class="form-control" id="foto_perfil" name="foto_perfil" accept="image/*">
          </div>

          <div class="foto-preview-area text-center mb-3"></div>

          <div class="form-check mb-3">
            <!-- Alinhar o name do checkbox com o PHP: in_admin -->
            <input class="form-check-input" type="checkbox" id="inadim" name="inadmin">
            <label class="form-check-label" for="inadim">Administrador</label>
          </div>

          <div id="message" class="mb-2 text-center"></div>

        </div>

        <div class="modal-footer">
          <button type="submit"  class="btn btn-primary">Salvar Alterações</button>
        </div>
        <!-- 🙏 -->
      </form>
    </div>
  </div>
</div>

<script>
// Preview da foto nova no modal (executar quando o input muda)
document.getElementById('foto_perfil').addEventListener('change', function(event) {
  const file = event.target.files[0];
  if (!file) return;

  const previewArea = document.querySelector('.foto-preview-area');
  previewArea.innerHTML = ''; // Limpa preview antigo

  const img = document.createElement('img');
  img.style.width = '150px';
  img.style.height = '150px';
  img.style.objectFit = 'cover';
  img.style.borderRadius = '8px';

  const reader = new FileReader();
  reader.onload = function(e) {
    img.src = e.target.result;
    previewArea.appendChild(img);
  };
  reader.readAsDataURL(file);
});
</script>