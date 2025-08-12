<div class="container">
    <h2>Cadastro de Vendedores</h2>
    <form id="formVendedor" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required placeholder="Nome">

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" required placeholder="Endereço">

        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" required placeholder="Telefone">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required placeholder="Email">
        
        <div class="row mb-3">
            <div class="col-md-12 mt-3 d-flex align-items-center gap-3">
                <div>
                    <label for="foto_vendedor" class="form-label">Foto do Vendedor</label>
                    <input type="file" class="form-control" id="foto_vendedor" name="foto_vendedor" accept="image/*">
                </div>
                <div id="preview-container">
                    <?php if (!empty($_SESSION['foto_vendedor'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($_SESSION['foto_vendedor']); ?>" alt="Foto de Cadastro"
                            style="object-fit: cover; border-radius: 8px;">
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <button type="submit">Confirmar</button>
        <div id="message" style="display:none;"></div>
    </form>
    <script src="js/enviardados.js"></script>
</div>

<script>
  document.getElementById('foto_vendedor').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (!file) return;

    const preview = document.createElement('img');
    preview.width = 77;

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
