urlApp = 'App.php'

interact_fields = {};

interact_fields['file'] = '';
interact_fields['senha'] = '';
interact_fields['confirmar'] = '';

function grid() {

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: {

            action: 'Usuario',
            method: 'getAllInfo'

        }, success: function (data) {


            if (data.count) {

                $("#email").html(data.result.email)
                $("#funcionario").html(data.result.funcionario)
                $("#imagem").attr('src', 'App/imagens/usuarios/' + data.result.imagem)

            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        }
    }).done(function () {

    });

}

function alterarFoto(formData) {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "Usuario");

    formData.append('method', "updateFoto");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {
            descricoes = '';
            if (data.result) {
            }
            else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        grid();
    });

}


function alterarSenha() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "Usuario");

    formData.append('method', "alterarSenha");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {
            descricoes = '';
            if (data.result) {

                mensagem('OK', 'Alterado', 'success', '');
                $(".modal_principal").modal('hide');
            }
            else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }else{
                mensagem('ERRO', 'Senhas diferentes', 'warning', '');
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        grid();
    });

}

$(document).ready(function () {

    grid();

    $(document).on("change", "#file", function () {
        alterarFoto();
    })

    $(document).on("click", "#imagem", function () {
        $("#file").trigger("click");

    })

    $(document).on("click", ".senha", function () {
        $(".modal_principal").modal("show");
    })

    $(document).on("click", ".save", function () {
        alterarSenha()
    })

})
