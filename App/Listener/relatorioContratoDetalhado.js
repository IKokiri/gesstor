urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['id_centro_custo'] = '';


function loadPropostas() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "NumeroOrcamento");

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

                    data = value.data.split("/");
                    mes = data[1];
                    ano = data[2].slice(2, 4);
                    data = mes + '' + ano;

                    option += '<option value="' + value.id + '" >' +
                        value.numeroPad +
                        '.' +
                        value.revisaoPad +
                        '-' +
                        value.sigla +
                        '-' +
                        data +
                        '-' +
                        value.cliente +
                        '</option>';
                });

                $("#id_tabela_complemento").html(option);

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

                $("#id_tabela_complemento").html(option);

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

            option = '<option value="">Selecione</option>';

            if (data.count) {

                $.each(data.result, function (key, value) {


                    option += '<option value="' + value.id + '" >' + value.centroCusto + " - " + value.departamento + '</option>';
                });

                $("#id_tabela_complemento").html(option);

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

$(document).on('change', "#id_tabela", function () {

    tipo = $("#id_tabela").val();

    if (tipo == 1) {
        loadContratos();
    } else if (tipo == 2) {
        loadPropostas();
    } else if (tipo == 3) {
        loadCentroCusto();
    }
});

function grid() {
    $('#table_principal').DataTable().destroy();

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: {
            action: 'RelatorioHorasDepartamento',
            method: 'getContratosDetalhado',
            inicio: $("#inicio").val(),
            fim: $("#fim").val()


        }, success: function (data) {


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


$(document).ready(function () {

    grid();
    loadContratos()
    $("#inicio").focus();

})


$(document).on("keyup", '#inicio', function (e) {

    if (e.keyCode == 13) {

        $("#fim").focus();

    }

})