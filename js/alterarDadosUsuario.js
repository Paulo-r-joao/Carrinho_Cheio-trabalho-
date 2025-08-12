$(document).ready(function() {
    $("#formCadUsuario").on("submit", function(e) {
        e.preventDefault(); // Impede envio padrão
        const formData = new FormData(this);

        $.ajax({
            url: "insert-update-usuarios.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $("#message").removeClass("error").addClass("success")
                        .text(response.message).fadeIn().delay(3000).fadeOut();

                    $("#formCadUsuario")[0].reset();
                    $("#formCadUsuario .foto-preview-area").empty();

                    // Recarrega a tabela de usuários
                    if (typeof carregarUsuarios === 'function') {
                        carregarUsuarios(paginaAtual, termoFiltro); // << USA VARIÁVEIS GLOBAIS
                    }

                    // Atualiza a imagem, se necessário
                    if (response.foto_perfil && $('#formCadUsuario #id').val()) {
                        const userId = $('#formCadUsuario #id').val();
                        const novaFoto = `uploads/${response.foto_perfil}`;
                        const imgEl = $(`tr td:contains(${userId})`).siblings().find('img');

                        if (imgEl.length) {
                            imgEl.attr('src', novaFoto + '?v=' + new Date().getTime());
                        }
                    }

                } else {
                    $("#message").removeClass("success").addClass("error")
                        .text(response.message).fadeIn().delay(3000).fadeOut();
                }
            },
            error: function(xhr, status, error) {
                console.log("Erro AJAX:", xhr.responseText, status, error);
                $("#message").removeClass("success").addClass("error")
                    .text("Erro ao processar a requisição!").fadeIn().delay(3000).fadeOut();
            }
        });
    });
});
