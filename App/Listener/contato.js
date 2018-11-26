urlApp = 'App.php'

interact_fields = {};

interact_fields['busca'] = '';




function inicio() {

    grid();

}

function grid() {     $('#table_principal').DataTable().destroy();

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "Contato");

    formData.append('method', "getAllBy");
    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {
            if (data.count != 0) {
                div = '';
                $.each(data.result, function (key, value) {
                    div += '<div class="col-md-3 col-sm-6 col-xs-12 profile_details">' +
                        '<div class="well profile_view">' +
                        '<div class="col-sm-12">' +
                        '<h4 class="brief"><i>' + value.identificador + '</i></h4>' +
                        '<div class="left col-xs-9">' +
                        '<h2>Cargo</h2>' +
                        '<ul class="list-unstyled">' +
                        '<li><i class="fa fa-at"></i> E-Mail:' + value.email_contato + '</li>' +
                        '<li><i class="fa fa-phone"></i> Tel:. ' + value.telefone_contato + ' </li>' +
                        '</ul>' +
                        '</div>' +
                        '<div class="right col-xs-3">' +
                        '<img src="App/src/foto.jpg" alt="" class="img-circle img-responsive">' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-xs-12 bottom text-center">' +
                        '<span><h4>' + value.nome_contato + ' ' + value.sobrenome_contato + '</h4></span>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                });

                $(".contatos_html").html(div);
            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }else{
                $(".contatos_html").html('');
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        $('#table_principal').DataTable();
    });

}

$(document).ready(function () {

    inicio();
    $(document).on('keyup','#busca',function(){
        grid();
    })

})
