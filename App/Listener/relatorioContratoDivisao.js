urlApp = 'App.php'

interact_fields = {};

interact_fields['id_contrato'] = '';


function loadContratos() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "Contrato");

    formData.append('method', "getAll");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            option = '<option value="">Selecione</option>';

            if (data.count) {

                $.each(data.result, function (key, value) {


                    option += '<option value="' + value.id + '" >' + value.numero + '</option>';
                });

                $("#id_contrato").html(option);

            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },

        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        $(".select2_single").select2({
            placeholder: "Selecione",
            allowClear: true
        });
    });

}

function grid() {

    $('#table_principal').DataTable().destroy();

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: {
            action: 'RelatorioHorasDepartamento',
            method: 'getSubContratoContrato',
            id_contrato: $("#id_contrato").val()

        }, success: function (data) {

            if (data.count != 0) {

                table = '<table style="border-collapse: collapse" border="1" width="100%" >';

                thead = '<thead>' +
                    '<tr>' +
                    '<td>Aditivos</td>' +
                    '<td>HORAS</td>' +
                    '<td>VALOR</td>' +
                    '<td>TOTAL</td>' +
                    '</tr>' +
                    '</thead>';


                tbody = '<tbody>';


                $.each(data.grid, function (key, value) {

                    tbody += '<tr>' +
                        '<td>' +
                        key +
                        '</td>' + '<td>' +
                        value.tempo +
                        '</td>' + '<td>' +
                        value.valor +
                        '</td>' + '<td>' +
                        value.total +
                        '</td>' +
                        '</tr>';
                })

                tfoot = '<tfoot>';

                $.each(data.footer, function (key, value) {

                    tfoot += '<tr>' +
                        '<td>TOTAL </td>' +
                        '<td>' +
                        value.tempo +
                        '</td>' + '<td>' +
                        value.valor +
                        '</td>' + '<td>' +
                        value.total +
                        '</td>' +
                        '</tr>';
                })


                tfoot += '</tfoot>';

                tbody += "</tbody>"

                table += thead + tbody + tfoot + "</table>";


                $(".grid").html(table);

            }else{

                $(".grid").html("");
            }

        }
    }).done(function () {
        $('#table_principal').DataTable();
    });

}

$(document).on("click", "#gerar", function () {
    grid();
    $("#nome_contrato").html($("#id_contrato option:selected").text())
})

$(document).on("click", "#imprimir", function () {

    var conteudo = document.getElementById('relatorio_horas').innerHTML,
        tela_impressao = window.open('about:blank');

    tela_impressao.document.write(conteudo);
    tela_impressao.window.print();
})

$(document).ready(function () {
    loadContratos();
    grid();
    $("#inicio").focus();

})

