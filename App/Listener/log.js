urlApp = 'App.php'

function grid() {     $('#table_principal').DataTable().destroy();

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: {

            action: 'Log',
            method: 'getAll'

        }, success: function (data) {

            tbody = '';

            if (data.count) {

                tbody = '';

                $.each(data.result, function (key, value) {

                    tbody += '<tr>' +
                        '<td>' + value.nome + ' ' + value.sobrenome + '</td>' +
                        '<td>' + value.tabela + '</td>' +
                        '<td>' + value.campo + '</td>' +
                        '<td>' + value.de + '</td>' +
                        '<td>' + value.para + '</td>' +
                        '<td>' + value.id_registro + '</td>' +
                        '<td>' + value.data + '</td>' +
                        '<td>' + value.hora + '</td>' +
                        '<td>' + value.operacao + '</td>' +
                        '</tr>';
                });

                $('.grid').html(tbody);
            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        }
    }).done(function () {
        $('#table_principal').DataTable();
    });

}


$(document).ready(function () {

    grid();


})
