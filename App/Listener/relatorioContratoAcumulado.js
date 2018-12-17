urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['id_centro_custo'] = '';
interact_fields['tipo'] = '';


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
            method: 'getContratosApuracao',
            inicio: $("#inicio").val(),
            tipo: $("#tipo").val(),
            fim: $("#fim").val()

        }, success: function (data) {
   
            tipo = defineLabelTipo();


            datas = '';

            // if (data.datas['data_inicio']) {
            //     datas = "De " + data.datas['data_inicio'] + " à " + data.datas['data_fim']
            // }

            tbody = '';

            // if (data.count) {
            table = '<div id="relatorio_horas">' +
                '<div>' +
                '<div class="titulo_relatorio" style="text-align: center">' +
                'DEMONSTRATIVO HORA / CUSTO POR '+tipo +
                '</div>' +
                '<span style="float:right;position:relative">' + datas + '</span>' +
                '</div>' +
                '<table style="border-collapse: collapse" border="1" width="100%" >';
            thead = '<thead><tr><td></td>'
            thead2 = '<tr><td></td>'
            tbody = '<tr>';
            totais = "<tr><td>Total</td>";

            $.each(data.cabecalho, function (key, value) {

                thead += '<td colspan="2" class="cols_visualizar" style="text-align:center">' + value + '</td>';
                thead2 += '<td class="visu_hora" style="text-align: center">H</td><td class="visu_valor" style="text-align: center">R$</td>';


            });
            thead2 += "</tr></thead>"
            thead += "</tr>";

            $.each(data.grid, function (key, value) {
                tbody += "<tr><td>" + key + "</td>";
                color = '#DDD';
                $.each(value.meses, function (key1, value1) {
                    vTemp = value1.split('_');
                    tbody += '<td  class="visu_hora"  style="text-align: right;background-color: ' + color + '">' + vTemp[0] + '</td><td class="visu_valor" style="text-align: right;background-color: ' + color + '">' + vTemp[1] + '</td>';
                    if (color == '#DDD') {
                        color = '';
                    } else {
                        color = '#DDD';
                    }
                });

                tbody += "</tr>";
            });
            tfoot = "<tfoot><tr><td><center>TOTAL</center></td>";

            $i = 0;
            $.each(data.totalRodape, function (keyRodape, valueRodape) {

                class_visu_col = "";

                if ($i % 2 == 0) {
                    class_visu_col = "visu_hora";
                } else if ($i % 2 == 1) {
                    class_visu_col = "visu_valor";
                }

                tfoot += '<td class="' + class_visu_col + '"><center>' + valueRodape + '</center></td>';

                $i++;
            });
            tfoot += '</tr></tfoot>';
            //
            // $.each(data.centroCustosTotais, function (key, value) {
            //     totais += '<td style="text-align:center"><h2><strong>' + value + '</strong></h2></td>';
            // });


            table += thead + thead2 + tbody + tfoot + "</table><div>";

            $('.grid').html(table);

            // } else if (data.MSN) {
            //     mensagem('Erro', data.msnErro, '', '');
            // }
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

function defineLabelTipo() {
    str = "";
    if ($("#tipo").val() == 1) {
        str = 'CONTRATO';
    } else {
        str = 'PROPOSTA';
    }
    return str;
}
function mostrarHora() {

    tipo = defineLabelTipo();

    $(".cols_visualizar").attr("colspan", 1);

    $(".visu_hora").show();
    $(".visu_valor").hide();
    $(".titulo_relatorio").html("DEMONSTRATIVO DE HORA POR " + tipo);

}

function mostrarValor() {
    tipo = defineLabelTipo();
    $(".cols_visualizar").attr("colspan", 1);
    $(".visu_valor").show();
    $(".visu_hora").hide();
    $(".titulo_relatorio").html("DEMONSTRATIVO DE CUSTO POR " + tipo);

}
function mostrarTudo() {
    tipo = defineLabelTipo();
    $(".cols_visualizar").attr("colspan", 2);
    $(".visu_valor").show();
    $(".visu_hora").show();

    $(".titulo_relatorio").html("DEMONSTRATIVO HORA / CUSTO POR " + tipo);


}

$(document).ready(function () {

    $(document).on("change", ".radioVisualizar", function () {
        valorRadio = $(this).val();

        if (valorRadio == "Completo") {
            mostrarTudo();
        } else if (valorRadio == "Hora") {
            mostrarHora()
        } else if (valorRadio == "Valor") {
            mostrarValor()
        }
    });

    grid();
    loadContratos()
    $("#inicio").focus();

})


$(document).on("keyup", '#inicio', function (e) {

    if (e.keyCode == 13) {

        $("#fim").focus();

    }

})