$(document).ready(function() {
    $("#formCadVendedor").on("submit", function(e) {
        e.preventDefault(); // Impede o envio tradicional do form

        $.ajax({
            url: "insert-update-vendedores.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $("#message").removeClass("error").addClass("success")
                        .text(response.message).fadeIn().delay(3000).fadeOut();
                    $("#formCadUsuario")[0].reset();
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