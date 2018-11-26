urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['id_centro_custo'] = '';


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

            option = "";

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


function loadFuncionarios() {
    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "Funcionario");

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
                    option += '<option value="' + value.id + '" >' + value.nome + ' ' + value.sobrenome + '</option>';
                });

                $("#id_funcionario").html(option);

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
            method: 'apuracaoHorasTrabalhadas',
            data_inicio: $("#data_inicio").val(),
            data_fim: $("#data_fim").val(),
            id_centro_custo: $("#id_centro_custo").val(),
            id_funcionario: $("#id_funcionario").val()

        }, success: function (data) {

            titulo = "<center><h2> Apuração de  Horas Trabalhadas </h2><center>"
            datas = "<div align='right'> <span> "+data.dadosAdicionais.data_inicio+" </span> à <span> "+data.dadosAdicionais.data_fim+" </span> "+data.dadosAdicionais.data_solicitacao+"</div>"
            thead = "<thead style='text-align:center'>" +
                "<tr>" +
                "<td><h4>TIPO</h4></td>" +
                "<td><h4>COLABORADORES</h4></td>" +
                "<td><h4>CENTRO CUSTO</h4></td>" +
                "<td><h4>AJUSTE VALOR<br> CENTRO CUSTO </h4></td>" +
                "<td><h4>AJUSTE HORA<br> CENTRO CUSTO </h4></td>" +
                "<td><h4>HORAS</h4></td>" +
                "<td><h4>VALOR</h4></td>" +
                "<td><h4>TOTAL</h4></td>" +
                "<tr>" +
                "</thead>";

            tbody = '';

            tfoot = "<tfoot>" +
                "<tr>" +
                "<td>TOTAIS</td>" +
                "<td>" + data.totais.funcionario + "</td>" +
                "<td></td>" +
                "<td></td>" +
                "<td></td>" +
                "<td>" + data.totais.tempo + "</td>" +
                "<td></td>" +
                "<td>"+data.totais.valor+"</td>" +
                "<tr>";            
                "</tfoot>";

            $.each(data.dados, function (key, value) {

                tbody += "<tbody>" +
                    "<tr>" +
                    "<td>" + value.alias + "</td>" +
                    "<td>" + value.nome + ' ' + value.sobrenome + "</td>" +
                    "<td>" + value.centroCusto + "</td>" +
                    "<td>" + (value.ajuste ? value.ajuste : 0)  +"</td>" +
                    "<td>" + (value.ajusteH ? value.ajusteH : 0)  +"</td>" +
                    "<td>" + value.tempo + "</td>" +
                    "<td>" + value.valor + "</td>" +
                    "<td>" + value.totalLinha + "</td>" +
                    "<tr>" +
                    "</tbody>";

            })



            table = "<table width='100%' style='border-collapse: collapse;' border='1'>" +
                thead +
                tbody +
                tfoot +
                "</table>";


            $(".grid").html(titulo+''+table+''+datas);

        }
    }).done(function () {
        $('#table_principal').DataTable();
    });

}


$(document).on("click", "#gerar", function () {
    grid();
})
$(document).on("click", "#imprimir", function () {

    var conteudo = document.getElementById('imp_relatorio').innerHTML,
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

$(document).ready(function () {
    $("#data").focus();
    grid();
    loadCentroCusto();
    loadFuncionarios();

})
