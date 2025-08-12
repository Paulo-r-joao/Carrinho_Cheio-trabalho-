<link rel="stylesheet" href="css/style.css">

<div class="container mt-4"  style='background-color:rgba(224, 224, 224, 0.507);'>
    <div class="card ">
        <div class="text-white p-3">
            <h4 class="mb-0">Histórico de Vendas</h4>
        </div>

        <div class="card-body">
            <input type="text" id="filtro" class="form-control mb-3" placeholder="Buscar na tabela...">

            <div class="table-responsive">
                
               <!-- <table class="table table-bordered text-center align-middle" style="table-layout: fixed; width: 100%;">-->
                      <table class="table table-bordered text-center align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>Cliente</th>
                            <th>Produto</th>
                            <th>Vendedor</th>
                            <th>Quantidade</th>
                            <th>Valor da Venda</th>
                        </tr>
                    </thead>
                    <tbody id="corpo-tabela">
                        <!-- Conteúdo carregado via AJAX -->
                    </tbody>
                </table>
            </div>

            <nav>
                <ul id="paginacao" class="pagination justify-content-center mt-4"></ul>
            </nav>
        </div>
    </div>
</div>

<script src="js/script-ordenacao-vendas.js"></script>

</html