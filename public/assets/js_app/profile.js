$(function () {
    // --- 1. PREVIEW DA IMAGEM ---
    // Chamado pelo onchange="previewImage(this)" que já está no seu HTML
    window.previewImage = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#avatar-preview').css('background-image', 'url(' + e.target.result + ')');
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    // --- 2. ATUALIZAR PERFIL (FOTO E NOME) ---
    $('#btn-save-profile').on('click', function (e) {
        e.preventDefault();

        // Como tem arquivo (foto), usamos FormData
        var formData = new FormData();
        var foto = $('#upload-photo')[0].files[0];
        var nome = $('#user_name').val();

        formData.append('user_name', nome);
        if (foto) {
            formData.append('user_photo', foto);
        }

        var $btn = $(this);
        $btn.prop('disabled', true).addClass('btn-loading');

        $.ajax({
            type: 'POST',
            url: '/profile/updateprofile', // Ajuste sua rota aqui
            data: formData,
            processData: false, // Obrigatório para FormData
            contentType: false, // Obrigatório para FormData
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success(response.message || "Perfil atualizado com sucesso!", "Sucesso");
                } else {
                    toastr.error(response.message || "Erro ao atualizar perfil.", "Erro");
                }
            },
            error: function () {
                toastr.error("Erro interno no servidor.", "Erro");
            },
            complete: function () {
                $btn.prop('disabled', false).removeClass('btn-loading');
            }
        });
    });

    // --- 3. ATUALIZAR SENHA ---
    $('#btn-update-password').on('click', function (e) {
        e.preventDefault();

        var currentPassword = $('#current_password').val();
        var newPassword = $('#new_password').val();
        var confirmPassword = $('#confirm_password').val();

        // Validação básica de client-side
        if (newPassword !== confirmPassword) {
            toastr.warning("As novas senhas não coincidem.", "Atenção");
            return;
        }

        if (newPassword.length < 6) {
            toastr.warning("A nova senha deve ter no mínimo 6 caracteres.", "Atenção");
            return;
        }

        var $btn = $(this);
        $btn.prop('disabled', true).addClass('btn-loading');

        $.ajax({
            type: 'POST',
            url: '/profile/updatepassword', // Ajuste sua rota aqui
            dataType: 'json',
            data: {
                current_password: currentPassword,
                new_password: newPassword
            },
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success(response.message || "Senha alterada com sucesso!", "Sucesso");
                    // Limpa os campos de senha
                    $('input[type="password"]').val('');
                } else {
                    toastr.error(response.message || "Erro ao alterar senha.", "Erro");
                }
            },
            error: function () {
                toastr.error("Erro ao processar solicitação.", "Erro");
            },
            complete: function () {
                $btn.prop('disabled', false).removeClass('btn-loading');
            }
        });
    });
});