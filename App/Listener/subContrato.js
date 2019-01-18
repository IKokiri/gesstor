urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['divisao'] = '';
interact_fields['id_contrato'] = '';
interact_fields['id_funcionario'] = '';
interact_fields['id_objeto'] = '';
interact_fields['id_gerente'] = '';
interact_fields['id_responsavel'] = '';
interact_fields['observacao'] = '';
interact_fields['status'] = '';
interact_fields['addHoras'] = '';
interact_fields['bloquear_em_horas'] = '';



function inicio() {

    loadFuncionarios();
    loadObjetos();
    loadContratos();
    grid();

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

            option = '<option value="">Selecione</option>';

            if (data.count) {

                $.each(data.result, function (key, value) {
                    option += '<option data-sigla="' + value.sigla + '" value="' + value.id + '" >' + value.nome + ' ' + value.sobrenome + '</option>';
                });

                $("#id_funcionario").html(option);
                $("#id_responsavel").html(option);
                $("#id_gerente").html(option);

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
                    option += '<option data-numero= "' + value.numero + '" data-mesano= "' + value.mesAno + '" value="' + value.id + '" >' + value.contrato + '</option>';
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
            placeholder: "Select a state",
            allowClear: true
        });
    });

}


function loadObjetos() {
    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "Objeto");

    formData.append('method', "getAll");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            option = '<option value="">Selecione</option>' +
                ' <option value="adicionar_objeto"> ADICIONAR NOVO</option>';

            if (data.count) {

                $.each(data.result, function (key, value) {
                    option += '<option value="' + value.id + '" >' + value.objeto + '</option>';
                });

                $("#id_objeto").html(option);

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

            action: 'SubContrato',
            method: 'getAll'

        }, success: function (data) {

            tbody = '';

            if (data.count) {

                tbody = '';

                $.each(data.result, function (key, value) {

                    tbody += '<tr>' +
                        '<td>' + value.sub_contrato + '</td>' +
                        '<td>' + value.contrato + '</td>' +
                        '<td>' + value.funcionario + '</td>' +
                        '<td>' + value.objeto + '</td>' +
                        '<td>' + value.gerente + '</td>' +
                        '<td>' + value.responsavel + '</td>' +
                        '<td>' + value.status + '</td>' +
                        '<td>' + value.bloquear_em_horas + '</td>' +
                        '<td class="update" data-id="' + value.id + '"></td>' +
                        '</tr>';
                });

                $('.grid').html(tbody);
            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        }
    }).done(function () {
        $('#table_principal').DataTable();

        now = new Date();

        dia = (now.getDate() < 10) ? '0' + "" + now.getDate() : now.getDate();
        mes = (now.getMonth() < 10) ? '0' + "" + now.getMonth() : now.getMonth();
        ano = now.getFullYear();
        dataAtual = dia + '/' + mes + '/' + ano;
        $("#data").val(dataAtual);
        $("#data").trigger("change");


    });

}


function create(formData) {

    formData.append('action', "SubContrato");

    formData.append('method', "create");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {
            if (data.result) {
                mensagem('OK', 'Cadastrado', 'success', '');
                clear_field('#form-principal');
                grid();
            } else if (data.validar) {
                $.each(data.validar, function (key, value) {
                    mensagem('Atenção', value, 'warning', '');

                })

            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        tipoOrcamento = $("[name='tipo']:checked").val();

    });
}

function remove(formData) {

    formData.append('action', "SubContrato");

    formData.append('method', "delete");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {
            if (data.validar) {
                $.each(data.validar, function (key, value) {
                    mensagem('Atenção', value, 'warning', '');

                })

            } else if (data.result) {

                mensagem('OK', 'Removido', 'success', '');

            } else if (data.MSN) {

                mensagem('Erro', data.msnErro, '', '');

            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        clear_field('#form-principal');
        grid();
    });
}

function update(formData) {

    formData.append('action', "SubContrato");

    formData.append('method', "update");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {
            if (data.validar) {
                $.each(data.validar, function (key, value) {
                    mensagem('Atenção', value, 'warning', '');

                })
            } else if (data.result) {
                mensagem('OK', 'Alterado', 'success', '');
                clear_field('#form-principal');
                grid();
                load();
            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {

    });
}


function load() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "SubContrato");

    formData.append('method', "getById");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            if (data.result) {

                fill_fields(data);

            }
            else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        $(".modal_principal").modal('show');

        $(".select2_single").select2({
            placeholder: "Select a state",
            allowClear: true
        });
    });

}

$("#form-principal").submit(function (e) {

    e.preventDefault();

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.get('id') ? update(formData) : create(formData);

});

//QUANDO ALGUMA TROCA FOR FEITA NOS CAMPOS OS CAMPOS DE IDENTIFICAÇÃO O CONTRATO SERA ALTERADO
$(document).on("change", "#id_contrato", function () {
    numero = $('option:selected', this).data('numero');
    mesAno = $('option:selected', this).data('mesano');
    $("#nomeNumero").html(numero)
    $("#nomeMesAno").html(mesAno)
})
$(document).ready(function () {

    inicio();


    $("#divisao").change(function () {
        $("#nomeDivisao").html($(this).val());
    });

    $(document).on("change", "#id_funcionario", function () {
        sigla = $('option:selected', this).data('sigla');
        $("#nomeSigla").html(sigla)
    })


    $(document).on('click', '.add', function () {
        $(".modal_principal").modal('show');
        $("#id_funcionario").trigger("change")
    })

    $(document).on('click', '.save', function () {

        $("#form-principal").submit();

    })

    $(document).on('click', '.delete', function () {

        dataId = $(this).data('id');
        if (confirm("Remover o registro?")) {
            $("#id").val(dataId);

            var formData = new FormData();

            formData = load_fields(formData, interact_fields);

            remove(formData);
        }
    });

    $(document).on('click', '.update', function () {

        dataId = $(this).data('id');

        $("#id").val(dataId);

        load();
    })

})
