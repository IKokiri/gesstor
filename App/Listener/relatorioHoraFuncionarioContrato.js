urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['id_centro_custo'] = '';
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


                    option += '<option value="' + value.id + '" >' + value.contrato + '</option>';
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
            method: 'acumuloHorasFuncionarioContrato',
            id_contrato: $("#id_contrato").val(),
            data_inicio: $("#data_inicio").val(),
            data_fim: $("#data_fim").val(),
            id_funcionario: $("#id_funcionario").val()

        }, success: function (data) {
            let dias = 0
            let totalHoras = 0

            titulo = "<center><h2> Horas Trabalhadas do funcionário "+$("#id_funcionario option:selected").text()+" de " + $("#data_inicio").val() + " </span> à <span> " + $("#data_fim").val() + " para o contrato "+$("#id_contrato option:selected").text()+" </h2><center>"
            // datas = "<div align='right'> <span> " + data.dadosAdicionais.data_inicio + " </span> à <span> " + data.dadosAdicionais.data_fim + " </span> " + data.dadosAdicionais.data_solicitacao + "</div>"
            thead = "<thead style='text-align:center'>" +
                "<tr>" +
                "<td class='escon' ><h4>Data</h4></td>" +
                "<td  class='escon'><h4>Horas</h4></td>" +
                "<tr>" +
                "</thead>";

             tbody = '';


             $.each(data.result, function (key, value) {
                 tbody += "<tbody>" +
                     "<tr>" +
                     "<td  class='escon'>" + value.data + "</td>" +
                     "<td  class='escon'>" + value.tempo + "</td>" +
                     "<tr>" +
                     "</tbody>"

                     dias++
                     totalHoras += parseInt(value.tempo)
             })

             
            let tfoot = "<tr>" +
            "<td   class='escon' style='text-align:right'><h3>" + dias + "Listados </h3> </td>" +
            "<td  style='text-align:right'><h3>" + totalHoras + "Horas Trabalhadas</td></h3> " +
            "<tr>";



            table = "<table width='100%' style='border-collapse: collapse;' border='1'>" +
                thead +
                tbody +
                tfoot +
                "</table>";


            $(".grid").html(titulo + '' + table);
            

        }
    }).done(function () {
        $('#table_principal').DataTable();
    });

}


$(document).on("click", "#gerar", function () {
    grid();
})
$(document).on("click", "#ocCampos", function () {

    $(".escon").hide()
})

$(document).on("click", "#totReal", function () {
    $(".totReal").toggle();
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
    loadContratos();

    $(document).on("change", "#id_tipo", function () {
        id = $(this).val();

        if (id == "2") {
            $(".class_contrato").hide();
        } else {
            $(".class_contrato").show();
        }
    })

})
