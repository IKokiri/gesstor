urlApp = '../../../App/Core/App.php'

function loadTipos() {

    var formData = new FormData();

    formData.append('action', "Ausencia");

    formData.append('method', "getAllOrder");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            html = '';

            if (data.count) {
                arr = [];
                $.each(data.result, function (key1, value1) {

                    if (key1 == "Visitantes") {
                        html += "<tr class='azulKuttner'>" +
                            "<td><b><b></td>" +
                            "<td>Nome</td>" +
                            "<td>Do Dia</td>" +
                            "<td>&Agrave;s</td>" +
                            "<td>At&eacute; o Dia</td>" +
                            "<td>&Agrave;s</td>" +
                            "<td>Empresa</td>" +
                            "<td>Setor</td>" +
                            "<td>Pessoa de Contato</td>" +
                            "<td>Contato</td>" +
                            "</tr>";
                    }

                    html += "<tr class='bordaTipo'><td colspan='10'></td></tr><tr>" +
                        "<td class='azulKuttner text-left' rowspan='" + value1.length + "' >" + key1 + "</td>";

                    rowspanColaborador = 1;
                    ultimoColaborador = 0;
                    ultimoTipo = 0;

                    $.each(value1, function (key, value) {


                        futuro = "";

                        if (value.futuro) {
                            futuro = "futuro";
                        }

                        if (value.id_colaborador == ultimoColaborador && value.id_tipo == ultimoTipo) {

                            rowspanColaborador++;

                        } else {
                            rowspanColaborador = 1;
                            html += "<td class='text-left " + futuro + " rspan" + value.id_colaborador + '' + value.id_tipo + "'>" + ucfirst(value.nome_colaborador) + " " + ucfirst(value.sobrenome_colaborador) + "</td>";

                        }

                        rep2 = " / " + ucfirst(value.nome_representante_2) + " " + ucfirst(value.sobrenome_representante_2);

                        if (value.nome_representante_2 == "NENHUM") {

                            rep2 = ''
                        }

                        rep1 = ucfirst(value.nome_representante) + " " + ucfirst(value.sobrenome_representante);

                        if (value.nome_representante == "NENHUM") {

                            rep1 = ''
                        }

                        html += "<td class='" + futuro + "'>" + value.ausencia_de + "</td>" +
                            "<td class='" + futuro + "'>" + value.ausencia_hora + "</td>" +
                            "<td class='" + futuro + "'>" + value.retorno_de + "</td>" +
                            "<td class='" + futuro + "'>" + value.retorno_hora + "</td>" +
                            "<td class='text-left " + futuro + "'>" + value.empresa + "</td>" +
                            "<td class='text-left " + futuro + "'>" + value.ausencia_local + "</td>" +
                            "<td class='text-left " + futuro + "'>" + rep1 + rep2 + "</td>" +
                            "<td class='" + futuro + "'>" + value.telefone + '  ' + (value.telefone_2? ' / '+value.telefone_2: '') + "</td>" +
                            "</tr>";

                        ultimoColaborador = value.id_colaborador;
                        ultimoTipo = value.id_tipo;
                        ultimoColaboradorTipo = ultimoColaborador + '' + ultimoTipo;
                        arr[ultimoColaboradorTipo] = rowspanColaborador;
                    });


                });

                $(".grid").html(html);

            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },

        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        arr.forEach(function (valor, chave) {

            $(".rspan" + chave).prop("rowspan", valor);
        });


    });

}
function ucfirst(word){
    if(word){
        word = word.toLowerCase();
        word = word[0].toUpperCase()+""+word.slice(1);
        return word;
    }

}

$(document).ready(function () {

    loadTipos();

})




