$(document).ready(function() {

    /** ================================
     *  [1] Cadastro de Clientes
     *  ================================= */
    $("#formCadastro").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "insert-update-clientes.php",
            type: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    showMessage("success", response.message);
                    $("#formCadastro")[0].reset();
                } else {
                    showMessage("error", response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log("Erro AJAX:", xhr.responseText, status, error);
                showMessage("error", "Erro ao processar a requisição!");
            }
        });
    });
    


    /** ================================
     *  [2] Cadastro de Produtos
     *  ================================= */
    $("#formProduto").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "insert-update-produtos.php",
            type: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    showMessage("success", response.message);
                    $("#formProduto")[0].reset();
                } else {
                    showMessage("error", response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log("Erro AJAX:", xhr.responseText, status, error);
                showMessage("error", "Erro ao processar a requisição!");
            }
        });
    });


    /** ================================
     *  [3] Cadastro de Vendedores
     *  ================================= */
    $("#formVendedor").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "insert-update-vendedores.php",
            type: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    showMessage("success", response.message);
                    $("#formVendedor")[0].reset();
                } else {
                    showMessage("error", response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log("Erro AJAX:", xhr.responseText, status, error);
                showMessage("error", "Erro ao processar a requisição!");
            }
        });
    });


    /** ================================
     *  [4] Cadastro de Usuários
     *  ================================= */
    $("#formCadUsuario").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "insert-update-usuarios.php",
            type: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    showMessage("success", response.message);
                    $("#formCadUsuario")[0].reset();
                } else {
                    showMessage("error", response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log("Erro AJAX:", xhr.responseText, status, error);
                showMessage("error", "Erro ao processar a requisição!");
            }
        });
    });


    /** ================================
     *  [5] Função Única de Mensagem
     *  ================================= */
    function showMessage(type, message) {
        $("#message").removeClass("success error").addClass(type)
            .text(message).fadeIn().delay(3000).fadeOut();
    }

});
