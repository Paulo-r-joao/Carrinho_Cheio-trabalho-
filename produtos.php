<!-- produtos.html ou produtos.phtml (parte interna apenas) -->
 
<div class="container">
    <h2>Cadastro de produtos</h2>
    <form id="formProduto" method="POST">
        <div class="row mb-3">
            <div class="col-md-4">                          
                <label for="id">Código:</label>
                <input type="text" id="id" name="id" require placeholder="Código">
            </div>
            <div class="col-md-4">
                <label for="quantidade">Valor:</label>
                <input type="number" step="0.01" id="valor" name="valor" min=0 required placeholder="0.00">
            </div>       
            <div class="col-md-4">
                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" min=0 required placeholder="Quantidade">
            </div>
        </div>       
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="tipoEmbalagem">Embalagem:</label>
                 <select name="tipoEmbalagem" id="tipoEmbalagem" required>
                    <option value="" disabled selected>Selecione</option>
                    <option value="cx">Caixa</option>
                    <option value="pct">Pacote</option>
                    <option value="gr">Garrafa</option>                    
                </select>   
            </div>
            <div class="col-md-6">                          
                    <label for="descricao">Descrição:</label>
                    <input type="text" id="descricao" name="descricao" required placeholder="Descrição do Produto">
            </div>   
        </div>
        <div class="row mb-3">
            <div class="mb-3 d-flex align-items-center gap-3">
                <!-- Input de arquivo (lado esquerdo) -->
                <div>
                <label for="form-label" class="form-label">Foto do Produto</label>
                <input type="file" class="form-control" id="foto_produto" name="foto_produto" accept="image/*">
                </div>

                <!-- Imagem de pré-visualização (lado direito) -->
                <div id="preview-container">
                <?php if (!empty($_SESSION['foto_produto']) && isset($_SESSION['foto_produto'])): ?>
                    <img src="uploads/<?php echo $_SESSION['foto_produto']; ?>" alt="Foto do Produto"
                        style="object-fit: cover; border-radius: 8px;">
                <?php endif; ?>
                </div>
            </div>
        </div>
        <button type="submit">Confirmar</button>
        <!-- Div para mensagens -->
        <div id="message" style="display:none;"></div>
    </form>
    <script src="js/enviardados.js"></script>
    <!-- <script src="js/enviardadosProduto.js"></script> -->
    <script>
    document.getElementById('foto_produto').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (!file) return;

    const preview = document.createElement('img');
    preview.width = 77;
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
</div>

