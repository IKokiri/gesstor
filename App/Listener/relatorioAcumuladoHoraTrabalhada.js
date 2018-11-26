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
            method: 'acumuloHorasTrabalhadas',
            data_inicio: $("#data_inicio").val(),
            data_fim: $("#data_fim").val(),
            id_centro_custo: $("#id_centro_custo").val(),
            id_tipo: $("#id_tipo").val(),
            id_funcionario: $("#id_funcionario").val()

        }, success: function (data) {

            titulo = "<center><h2> Custo de Mão de Obra &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+data.dadosAdicionais.data_inicio+" </span> à <span> "+data.dadosAdicionais.data_fim+"</h2><center>"
            datas = "<div align='right'> <span> "+data.dadosAdicionais.data_inicio+" </span> à <span> "+data.dadosAdicionais.data_fim+" </span> "+data.dadosAdicionais.data_solicitacao+"</div>"
            thead = "<thead style='text-align:center'>" +
                "<tr>" +
                "<td class='escon' ><h4>CONTRATO / PROPOSTA</h4></td>" +
                "<td  class='escon'><h4>HORAS</h4></td>" +
                "<td><h4>TOTAL</h4></td>" +
                "<tr>" +
                "</thead>";

            tbody = '';

            tfoot = "<tr>" +
                "<td  class='escon' >TOTAIS</td>" +
                "<td   class='escon' style='text-align:right'>" + data.totais.tempo + "</td>" +
                "<td  style='text-align:right'>"+data.totais.valorBr+"</td>" +
                "<tr>";     

            $.each(data.dados, function (key, value) {
                color = '';
                if(value.ajustado == "true"){
                    color = '#f99090';
                }
                tbody += "<tbody>" +
                    "<tr style='background-color:"+color+"'>" +
                    "<td  class='escon'>" + value.alias + "</td>" +
                    "<td  class='escon' style='text-align:right'>" + value.tempo + "</td>" +
                    "<td style='text-align:right'>" + value.totalBr + "</td>" +
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
$(document).on("click", "#ocCampos", function () {
    
    $(".escon").hide()
})

$(document).on("click","#totReal",function(){
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

})
