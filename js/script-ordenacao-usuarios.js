jQuery(document).ready(function($) {
    let paginaAtual  = 1;
    let termoFiltro  = "";

    function carregarUsuarios(pagina = 1, filtro = '') {
        paginaAtual = pagina;
        termoFiltro = filtro;
        $.ajax({
            url: 'buscar-usuarios.php',
            method: 'GET',
            dataType: 'json',
            data: { pagina: pagina, filtro: filtro },
            success: function(res) {
                $('#corpo-tabela').html(res.tabela);
                renderizarPaginacao(res.totalPaginas, pagina);
                configurarEventosExclusao();
                configurarEventosEdicao();
            },
            error: function() {
                alert('Erro ao carregar os dados.');
            }
        });
    }

    function configurarEventosExclusao() {
        const $dialog = $('#confirmation-dialog');
        const $escuro = $('.escuro');
        let usuarioIdParaExcluir;

        $('.btn-excluir').off('click').on('click', function(e) {
            e.preventDefault();
            usuarioIdParaExcluir = $(this).data('id');
            $dialog.show();
            $escuro.show();
        });

        $('#btn-cancel').off('click').on('click', function() {
            $dialog.hide();
            $escuro.hide();
        });

        $('#btn-confirm').off('click').on('click', function() {
            $.ajax({
                url: 'excluir-usuario.php',
                method: 'GET',
                data: { id: usuarioIdParaExcluir },
                dataType: 'json'
            })
            .done(function(response) {
                if (response.sucesso) {
                    mostrarMensagem('Usuário excluído com sucesso!', 'success');
                    carregarUsuarios(paginaAtual, termoFiltro);
                } else {
                    mostrarMensagem('Erro ao excluir usuário: ' + response.erro, 'danger');
                }
            })
            .fail(function() {
                mostrarMensagem('Erro na requisição', 'danger');
            })
            .always(function() {
                $dialog.hide();
                $escuro.hide()
            });
        });
// 
        $(document).off('click.fecharDialog').on('click.fecharDialog', function(e) {
            if (!$(e.target).closest('#confirmation-dialog, .btn-excluir').length) {
                $dialog.hide();
                $escuro.hide();
            }
        });
    }

    function configurarEventosEdicao() {
        $('.editar-usuario').off('click').on('click', function(e) {
            e.preventDefault();
            const userId = $(this).data('id');

            // Limpa o formulário antes de popular
            const $form = $('#formCadUsuario');
            $form.trigger('reset');
            $form.find('#id').val('');
            // Limpa preview antigo
            $('#modalCadastroUsuario .preview-edit').remove();

            $.ajax({
                url: 'buscar-usuario.php',
                method: 'GET',
                dataType: 'json',
                data: { id: userId },
                success: function(res) {
                    if (!res.success) {
                        alert('Erro: ' + res.message);
                        return;
                    }
                    const u = res.data;

                    // Preenche o formulário
                    $('#formCadUsuario #id').val(u.id);
                    $('#nm_nome').val(u.nm_nome);
                    $('#nm_login').val(u.nm_login);
                    $('#ds_email').val(u.ds_email);
                    $('#old_ds_password').val(u.ds_password);
                    $('#ds_password').val('');
                    $('#inadim').prop('checked', u.in_admin == 1);

                    // Carrega preview de foto (container específico)
                    const $container = $('<div class="preview-edit mb-3 text-center"></div>');
                    if (u.foto_perfil) {
                        $container.append(
                          `<img src="uploads/${u.foto_perfil}" ` +
                          `width="150" height="150" ` +
                          `style="object-fit: cover; border-radius: 8px;">`
                        );
                    }
                    $('#formCadUsuario').find('.foto-preview-area').html($container);

                    // Abre o modal
                    const modalEl = document.getElementById('modalCadastroUsuario');
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();
                },
                error: function() {
                    alert('Erro ao buscar dados do usuário.');
                }
            });
        });
    }


    function mostrarMensagem(texto, tipo) {
        $('.alert-mensagem').remove();
        const mensagem = $(
            `<div class="alert alert-${tipo} alert
            -dismissible show alert-mensagem 
                        position-fixed t start-50 translate-middle-x mt-3" style="margin-bottom:700px;margin-left:80px; ">
              ${texto}
              
            </div>`
        );
        $('body').append(mensagem);
        setTimeout(() => mensagem.alert('close'), 3000);
    }

    function renderizarPaginacao(total, atual) {
        const paginacao = $('#paginacao');
        paginacao.empty();

        const anterior = $(
            `<li class="page-item ${atual === 1 ? 'disabled' : ''}">
              <a class="page-link" href="#">Anterior</a>
            </li>`
        );
        anterior.click(e => { e.preventDefault(); if (atual > 1) carregarUsuarios(atual - 1, termoFiltro); });
        paginacao.append(anterior);

        for (let i = 1; i <= total; i++) {
            const li = $(
                `<li class="page-item ${i === atual ? 'active' : ''}">
                  <a class="page-link" href="#">${i}</a>
                </li>`
            );
            li.click(e => { e.preventDefault(); carregarUsuarios(i, termoFiltro); });
            paginacao.append(li);
        }

        const proxima = $(
            `<li class="page-item ${atual === total ? 'disabled' : ''}">
              <a class="page-link" href="#">Próxima</a>
            </li>`
        );
        proxima.click(e => { e.preventDefault(); if (atual < total) carregarUsuarios(atual + 1, termoFiltro); });
        paginacao.append(proxima);
    }

    // Filtro em tempo real
    $('#filtro').on('input', function() {
        carregarUsuarios(1, $(this).val());
    });

    // Inicializa listagem
    carregarUsuarios();
    
});
