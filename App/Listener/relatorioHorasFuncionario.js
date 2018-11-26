urlApp = 'App.php'

interact_fields = {};

interact_fields['mesAno'] = '';
interact_fields['id_funcionario'] = '';
interact_fields['id_tabela'] = '';
interact_fields['id_tabela_complemento'] = '';

ultimo_campo_update = '';

function inicio() {

    loadFuncionarios();
    grid();
    $("#mesAno").focus();
}


function loadFuncionarios() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "Funcionario");

    formData.append('method', "getAllTemp");

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

            action: 'LancarHora',
            method: 'getAllData',
            mesAno: $("#mesAno").val(),
            id_funcionario: $("#id_funcionario").val()

        }, success: function (data) {

            tr = '';

            if (data.count) {

                tr = '';
                id_linha = '';


                // alert(data.result.tempoCusto['teste']);
                tempoTotalCusto = data.result.tempoCusto;
                diaCustos = 1;
                diaAnterior = 0;
                linhaDias = '<tr><td>Contratos</td><td><CENTER>Total</CENTER></td>';
                totaisLinha = false;
                $.each(data.result, function (key, value) {
                    if (key == 'tempoCusto') {
                        return;
                    }
                    campoTempo = '';

                    if (value.ausencia) {
                        campoTempo = value.ausencia;
                    } else {
                        campoTempo = value.tempo;
                    }


                    if (id_linha != value.id_tabela + '_' + value.id_tabela_complemento + '_' + value.id_aplicacao) {


                        diaCustos = 1;
                        id_linha = value.id_tabela + '_' + value.id_tabela_complemento + '_' + value.id_aplicacao;

                        tr += "</tr>";
                        tr += '<tr><td class="text-left">' + value.nomeCusto + ' </td> <td><center><B>' + tempoTotalCusto[value.nomeCusto] + '</B></center></td>';

                        // tr += '<tr><td colspan="31"  class="text-center"><h4>' + value.nomeCusto + ' - <strong>' + tempoTotalCusto[value.nomeCusto] + ' HORAS </strong></h4></td></tr><tr>';
                    }
                    id_input = value.data + '_' + value.id_funcionario + '_' + value.id_tabela + '_' + value.id_tabela_complemento;

                    colorDia = '';

                    var data = new Date(value.data);
                    var dia = data.getDay() + 1;
                    if (dia == 7 || dia == 6) {
                        colorDia = "#ff8585";
                    }


                    tr += "<td class='text-center' style='background-color:" + colorDia + "'><span><center>" + campoTempo + "</center></span></td>";

                    if (diaAnterior < diaCustos) {

                        linhaDias += "<td><center>" + diaCustos + "</center></td>";

                        diaAnterior = diaCustos;

                        diaCustos++;


                    }
                });
                linhaDias += "</tr>"
                tr += "<tr><td></td><td></td>"
                $.each(data.totais.totalDias, function (key, value) {
                    tr += "<td><strong><center>" + value + "</center></strong></td>"

                });

                tr += "</tr>";

                tr += '<tr><td colspan="40"class="text-right"><h3><center>' + data.totais.totalGeral + ' HORAS<center></h3></td></tr>';

                dadosFunc = "<tr>" +
                    "<td colspan='5'><h3><CENTER> HORAS TRABALHADAS</CENTER></h3></td>" +
                    "<td colspan='5'><center>" + data.dadosFunc.data + "</center></td>" +
                    "<td colspan='10'><center>" + data.dadosFunc.nome + "</center></td>" +
                    "<td colspan='11'><center>" + data.dadosFunc.centroCusto + "</center></td>" +
                    "<tr>";

                $('.grid').html('<thead>' + dadosFunc + linhaDias + '</thead>' + tr);
            } else if (data.MSN) {

                mensagem('Erro', data.msnErro, '', '');
            } else {
                $('.grid').html("");
            }
        }
    }).done(function () {
        $('#table_principal').DataTable();


    });

}
$(document).on("change", ".loadGrid", function () {
    grid();
});


$(document).ready(function () {

    inicio();

    $(document).on("click", "#imprimir", function () {

        var conteudo = document.getElementById('relatorio_horas').innerHTML,
            tela_impressao = window.open('about:blank');

        tela_impressao.document.write(conteudo);
        tela_impressao.window.print();
    })

})

