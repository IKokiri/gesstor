urlApp = 'App.php'
var table = '';
interact_fields = {};

interact_fields['id'] = '';
interact_fields['divisao'] = '';
interact_fields['id_funcionario'] = '';
interact_fields['id_cliente'] = '';
interact_fields['id_objeto'] = '';
interact_fields['data_fim'] = '';
interact_fields['id_gerente'] = '';
interact_fields['id_responsavel'] = '';
interact_fields['data_inicio'] = '';
interact_fields['data_contrato'] = '';
interact_fields['id_proposta'] = '';
interact_fields['observacao'] = '';
interact_fields['tipo'] = '';
interact_fields['status'] = '';
interact_fields['addHoras'] = '';


function inicio() {
    loadFuncionarios();
    loadClientes();
    loadObjetos();
    loadPropostas();
    grid();
    $("#tipo").prop("checked", true);

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
                    option += '<option data-sigla="' + value.sigla + '" value="' + value.id + '" >' + value.nome + ' ' + value.sobrenome + ' - ' + value.sigla + '</option>';
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
            placeholder: "Selecione",
            allowClear: true
        });
    });

}


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

                $("#id_proposta").html(option);

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


function getNext() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "Contrato");

    formData.append('method', "getNext");

    formData.append('tipo', $("[name='tipo']:checked").val());

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            option = '<option value="">Selecione</option>';

            if (data.count) {

                $("#nomeNumero").html(data.result.numero);

            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            } else {
                $("#nomeNumero").html(data.result.numero);
            }

        },

        processData: false,
        cache: false,
        contentType: false
    }).done(function () {

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
                '<option value="adicionar_objeto"> ADICIONAR NOVO</option>';

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
        $("#id_objeto").val(id_objeto_criado);
        $(".select2_single").select2({
            placeholder: "Selecione",
            allowClear: true
        });
    });

}

function loadClientes() {
    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "Cliente");

    formData.append('method', "getAllAtivos");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            option = '<option value="">Selecione</option>' +
                '<option value="adicionar_cliente"> ADICIONAR NOVO </option>';

            if (data.count) {

                $.each(data.result, function (key, value) {
                    option += '<option value="' + value.id + '" >' + value.identificador + '</option>';
                });

                $("#id_cliente").html(option);
                $("#id_cliente_final").html(option);

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


    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: {

            tipo: ($("[name='serie_busca']:checked").val()) ? $("[name='serie_busca']:checked").val() : 60,
            action: 'Contrato',
            method: 'getAll'

        }, success: function (data) {

            tbody = '';

            if (data.count) {

                tbody = '';

                $.each(data.result, function (key, value) {

                    tbody += '<tr>' +
                        '<td>' + value.contrato + '</td>' +
                        // '<td>' + value.divisao + '</td>' +
                        // '<td>' + value.nome + ' ' + value.sobrenome + '</td>' +
                        '<td>' + value.identificador + '</td>' +
                        '<td>' + value.objeto + '</td>' +
                        '<td>' + value.data_fim + '</td>' +
                        // '<td>' + value.sigla_gerente + '</td>' +
                        // '<td>' + value.sigla_responsavel + '</td>' +
                        '<td>' + value.data_inicio + '</td>' +
                        '<td>' + value.numero_proposta_tela + "." + value.revisao_proposta_tela + '</td>' +
                        '<td>' + value.tipoTela + '</td>' +
                        '<td>' + value.status + '</td>' +
                        '<td class="update" data-id=' + value.id + '></td>' +
                        '</tr>';
                });

                $('.grid').html(tbody);
            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        }
    }).done(function () {

        table = $('#table_principal').DataTable();

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

    formData.append('action', "Contrato");

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
        getNext();

    });
}


function remove(formData) {

    formData.append('action', "Contrato");

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

    formData.append('action', "Contrato");

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

    formData.append('action', "Contrato");

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
            placeholder: "Selecione",
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
$(document).on("change", ".serie_busca", function () {
    grid();
})

$(document).ready(function () {

    inicio();

    $(document).on("change", "#tipo", function () {
        getNext();
    })

    //QUANDO ALGUMA TROCA FOR FEITA NOS CAMPOS OS CAMPOS DE IDENTIFICAÇÃO O CONTRATO SERA ALTERADO
    $("#numero").change(function () {
        $("#nomeNumero").html($(this).val());
    });

    $(document).on("change", "#id_funcionario", function () {
        sigla = $('option:selected', this).data('sigla');
        $("#nomeSigla").html(sigla)
    })

    $("#divisao").change(function () {
        $("#nomeDivisao").html($(this).val());
    });

    $(document).on("change", "#tipo", function () {
        tipoOrcamento = $(this).val();
    });
    ''
    $(document).on("change", "#id_funcionario", function () {
        sigla = $('option:selected', this).data('sigla');
        $("#nomeSigla").html(sigla)
    })

    $(document).on("change", "#data_contrato", function () {

        data = $(this).val().split("/");

        mes = data[1];

        ano = data[2].slice(2, 4);

        $("#nomeMesAno").html(mes + '' + ano);

    })

    $(document).on('click', '.add', function () {
        $(".modal_principal").modal('show');
        $("#id_funcionario").trigger("change")
        $("#id_cliente").trigger("change")

        $("#divisao").trigger("change");
        getNext();
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
