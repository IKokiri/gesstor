urlApp = 'App.php'

interact_fields = {};

interact_fields['mesAno'] = '';
interact_fields['id_funcionario'] = '';
interact_fields['id_tabela'] = '';
interact_fields['id_tabela_complemento'] = '';

ultimo_campo_update = '';

function inicio() {

    $("#mesAno").focus();
}


function grid() {
    $('#table_principal').DataTable().destroy();

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: {

            action: 'LancarHora',
            method: 'situacaoHoras',
            mesAno: $("#mesAno").val()

        }, success: function (data) {


            if (data.count) {

                table = '<thead><tr><td><h5>COLABORADOR</h5></td><td><h5>SITUAÇÃO</h5></td></tr></thead>';

                $.each(data.result, function (key, value) {
                    status = value.status;

                    cor = ''

                    if (!value.status) {
                        status = "ABERTO";
                    }

                    if (status == "ABERTO") {

                        cor = "#FFC1C1";

                    } else if (status == "FINALIZADO") {

                        cor = "#FFEC8B";

                    } else if (status == "APROVADO") {

                        cor = "#8FBC8F";

                    }

                    table += "<tr style='background-color:" + cor + "'><td>" + value.nome + " " + value.sobrenome + "</td><td>" + status + "</td></tr>"
                })

                $('.grid').html(table);

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

