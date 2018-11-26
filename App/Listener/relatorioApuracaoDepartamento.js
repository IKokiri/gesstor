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
            method: 'apuracaoDepartamento',
            data_inicio: $("#data_inicio").val(),
            data_fim: $("#data_fim").val(),
            id_centro_custo: $("#id_centro_custo").val(),
            id_funcionario: $("#id_funcionario").val()

        }, success: function (data) {

           
            datas = "<div align='right'>"+ data.dadosAdicionais.data_solicitacao+ "</div>";
            dataTopo = "<span>"+data.dadosAdicionais.data_inicio+" </span> à <span> "+data.dadosAdicionais.data_fim+"</span>"
            
            

            tbody = '';
            titulo = '';
            tfoot = "<tfoot>" +
                "<tr>" +
                "<td>TOTAIS</td>" +          
                "<td style='text-align:center'>" + data.totais.tempo + "</td>" +
                "<td  style='text-align:center'>"+data.totais.valor+"</td>" +
                "<tr>";            
                "</tfoot>";
            valorCusto = 0;
            centroCusto = '';
            $.each(data.dados, function (key, value) {

                valorCusto = value.valorBr;
                centroCusto = value.centroCusto
                departamento = value.departamento
                titulo = "<div class='col-md-12 col-sm-12 text-center' style='font-size: 20px'><div class='col-md-9'>Apuração por Departamento</div><div class='col-md-3'>"+departamento+" - "+centroCusto+"</div><div class='col-md-12 row text-left'>"+dataTopo+"</div></div>"
                tbody += "<tbody>" +
                    "<tr>" +
                    "<td>" + value.alias + "</td>" +                    
                    "<td style='text-align:center'>" + value.tempo + "</td>" +
                    "<td style='text-align:right'>" + value.totalLinhaBr + "</td>" +
                    "<tr>" +
                    "</tbody>";

            })

            thead = "<thead style='text-align:center'>" +
                "<tr>" +
                "<td><h4>CONTRATO</h4></td>" +           
                "<td><h4>HORAS</h4></td>" +
                "<td><h4>CUSTO HORA<br><label>"+valorCusto+"</label></h4></td>" +
                "<tr>" +
                "</thead>";


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

$(document).on("change","#id_centro_custo",function(){
    grid();
})

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
