urlApp = 'App/Core/App.php'

interact_fields = {};

interact_fields['email'] = '';
interact_fields['senha'] = '';

$(document).ready(function () {

    $(document).on('click', '#entrar', function () {

        var formData = new FormData();

        formData.append('action', 'Login');

        formData.append('method', 'login');

        // formData.append('email', $("#frm_login #email").val()+'@kuttner.com.br');
        formData.append('email', $("#frm_login #email").val());

        formData.append('senha', $("#frm_login #senha").val());

        login(formData);
    });
    //
    // $(document).on('click', '#entrarCliente', function () {
    //
    //     var formData = new FormData();
    //
    //     formData.append('action', 'Login');
    //
    //     formData.append('method', 'loginCliente');
    //
    //     formData.append('email', $("#frm_cliente #email_cliente").val());
    //
    //     formData.append('senha', $("#frm_cliente #senha_cliente").val());
    //
    //     login(formData);
    // });

})

function direcionaLogado(formData) {
    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'text',
        data: formData,
        success: function (data) {
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        window.location = "index.php";
    });
}

function login(formData) {

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {
            if (data.count == 1) {

                var formData = new FormData();

                formData.append('action', 'inicio');

                direcionaLogado(formData);

            } else {
                mensagem('Atenção', 'Dados incorretos', 'warning', '')
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {

    });
}

$(document).on("change", '#email', function (e) {

    // if (e.keyCode == 64) {

        // emailCompleto = $(this).val();

        // $(this).val("")

        $("#senha").focus();


    // }

})

$(document).on("keypress", '#senha', function (e) {

    if (e.keyCode == 13) {

        $("#entrar").trigger("click");
    }

})

$("#email").focus();
