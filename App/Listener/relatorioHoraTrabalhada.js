urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['id_centro_custo'] = '';

function buscarValorCentroCusto() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "CustoHoraDepartamento");
    formData.append('id_centro_custo', $("#id_centro_custo").val());
    formData.append('data', '01/' + $("#data").val());

    formData.append('method', "getByValor");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {
            if (data.result) {
                valor = 0;

                if (data.result['valor']) {
                    valor = data.result['valorBR'];
                }

                $("#valorHora").html("<h3>R$ " + valor + "</h3>");

            }
            else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        $(".modal_principal").modal('show');
        $(".select2_single").select2({
            placeholder: "Select a state",
            allowClear: true
        });
    });

}

function loadCentroCusto() {
    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "CentroCusto");

    formData.append('method', "getAll");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            option = '';

            if (data.count) {

                $.each(data.result, function (key, value) {
                    option += '<option value="' + value.id + '" >' + value.centroCusto + ' (' + value.departamento + ')</option>';
                });

                $("#id_centro_custo").html(option);

            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },

        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        $(".select2_single").select2({
            placeholder: "Select a state",
            allowClear: true
        });
    });

}

function grid() {

    $('#table_principal').DataTable().destroy();

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: {

            action: 'RelatorioHorasDepartamento',
            method: 'getAllDepartamento',
            data: $("#data").val(),
            id_centro_custo: $("#id_centro_custo").val()

        }, success: function (data) {

            datas = '';

            if (data.datas['data_inicio']) {
                datas = "De " + data.datas['data_inicio'] + " à " + data.datas['data_fim']
            }

            tbody = '';

            if (data.count) {
                table = '<div id="relatorio_horas">' +
                    '<div>' +
                    '<div style="text-align: center">' +
                    'APURAÇÃO DE HORAS TRABALHADAS' +
                    '</div>' +
                    '<span style="float:right;position:relative">' + datas + '</span>' +
                    '</div>' +
                    '<table border="1" width="100%" >';
                thead = '<thead><tr><td></td>'
                tbody = '';
                totais = "<tr><td>Total</td>";

                $.each(data.centroCustos, function (key, value) {

                    thead += '<td style="text-align:center">' + value + '</td>';


                });
                thead += "</thead></tr>"
                $.each(data.result, function (key, value) {
                    tbody += "<tr><td>" + key + "</td>";
                    $.each(value, function (key1, value1) {

                        tbody += '<td style="text-align:right">' + value1 + '</td>';

                    });
                    tbody += "</tr>";
                });

                $.each(data.centroCustosTotais, function (key, value) {
                    totais += '<td style="text-align:center"><h2><strong>' + value + '</strong></h2></td>';
                });

                totais += "</tr>";

                table += thead + tbody + totais + "</table>Gerado em: " + data.datas['gerado'] + "<div>";

                $('.grid').html(table);

            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        }
    }).done(function () {
        $('#table_principal').DataTable();
    });

}

$(document).on("click", "#gerar", function () {
    grid();
})
$(document).on("click", "#imprimir", function () {

    var conteudo = document.getElementById('relatorio_horas').innerHTML,
        tela_impressao = window.open('about:blank');

    tela_impressao.document.write(conteudo);
    tela_impressao.window.print();
})
$("#form-principal").submit(function (e) {

    e.preventDefault();

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.get('id') ? update(formData) : create(formData);

});

$(document).on("change", "#id_centro_custo,#data", function () {
    buscarValorCentroCusto();
    grid();
})

$(document).ready(function () {
    $("#data").focus();
    grid();
    loadCentroCusto();

})
