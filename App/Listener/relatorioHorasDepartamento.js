urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['menu'] = '';
interact_fields['status'] = '';

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

function grid() {
    
    $('#table_principal').DataTable().destroy();
    /**
     * caso o usuário selecione um contrato
     */
    id_contrato = ''
    method= 'getAll';
    
    if($("#id_tipo").val() == 1){

        id_contrato= $("#id_contrato").val()
        method = 'getAllContratos'
    }
    
    


    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: {

            action: 'RelatorioHorasDepartamento',
            method: method,
            data_inicio: $("#data_inicio").val(),
            data_fim: $("#data_fim").val(),
            id_contrato: id_contrato
            

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
                    'DEMONSTRATIVO DE HORAS TRABALHADAS' +
                    '</div>' +
                    '<span style="float:right;position:relative">' + datas + '</span>' +
                    '</div>' +
                    '<table border="1" width="100%" >';
                thead = '<tr><td><CENTER>CONTRATOS</CENTER></td>'
                tbody = '';
                totais = "<tr><td>Total</td>";

                $.each(data.centroCustos, function (key, value) {

                    thead += '<td style="text-align:center">' + value + '</td>';


                });
                thead += "</tr>"
                $.each(data.result, function (key, value) {
                    tbody += "<tr><td>" + key + "</td>";
                    $.each(value, function (key1, value1) {

                        tbody += '<td style="text-align:center">' + value1.toString().replace('.',',') + '</td>';

                    });
                    tbody += "</tr>";
                });

                $.each(data.centroCustosTotais, function (key, value) {
                    totais += '<td style="text-align:center"><h2><strong>' + value.toString().replace('.',',') + '</strong></h2></td>';
                });

                totais += "</tr>";

                table += '<thead>' + thead + '</thead><tbody>' + tbody + '</tbody>' + totais + "</table>Gerado em: " + data.datas['gerado'] + "<div>";

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

$(document).ready(function () {

    $("#data_inicio").focus();

    grid();

})

$(document).on("change","#id_tipo",function(){
        
    tipo = $(this).val()

    if(tipo == 1){
        loadContratos();
    }
    
})

$(document).on("keyup", '#data_inicio', function (e) {

    if (e.keyCode == 13) {

        $("#data_fim").focus();

    }

})