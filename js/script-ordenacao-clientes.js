$(document).ready(function () {
    let paginaAtual = 1;
    let termoFiltro = "";
   
    function carregarClientes(pagina = 1, filtro = '') {
        
        $.ajax({
            url: 'buscar-clientes.php',
            method: 'GET',
            dataType: 'json',
            data: {
                pagina: pagina,
                filtro: filtro
            },
            success: function (res) {
                $('#corpo-tabela').html(res.tabela);
                renderizarPaginacao(res.totalPaginas, pagina);
            },
            error: function () {
                alert('Erro ao carregar os dados.');
            }
        });
    }

    function renderizarPaginacao(total, atual) {
        const paginacao = $('#paginacao');
        paginacao.empty();

        const anterior = $(`<li class="page-item ${atual === 1 ? 'disabled' : ''}"><a class="page-link" href="#">Anterior</a></li>`);
        anterior.click(e => {
            e.preventDefault();
            if (atual > 1) carregarClientes(atual - 1, termoFiltro);
        });
        paginacao.append(anterior);

        for (let i = 1; i <= total; i++) {
            const li = $(`<li class="page-item ${i === atual ? 'active' : ''}"><a class="page-link" href="#">${i}</a></li>`);
            li.click(e => {
                e.preventDefault();
                carregarClientes(i, termoFiltro);
            });
            paginacao.append(li);
        }

        const proxima = $(`<li class="page-item ${atual === total ? 'disabled' : ''}"><a class="page-link" href="#">Próxima</a></li>`);
        proxima.click(e => {
            e.preventDefault();
            if (atual < total) carregarClientes(atual + 1, termoFiltro);
        });
        paginacao.append(proxima);
    }

    $('#filtro').on('input', function () {
        termoFiltro = $(this).val();
        carregarClientes(1, termoFiltro);
    });

    carregarClientes();
});