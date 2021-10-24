urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['data'] = '';
interact_fields['tempo'] = '';
interact_fields['data'] = '';
interact_fields['id_tabela'] = '';
interact_fields['id_tabela_complemento'] = '';
interact_fields['id_centro_custo'] = '';
interact_fields['l_id_centro_custo'] = '';
interact_fields['l_id_tabela'] = '';
interact_fields['l_id_tabela_complemento'] = '';
interact_fields['l_data'] = '';
interact_fields['status'] = '';


function loadCentroCustoSelect() {
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

            option = '';

            if (data.count) {

                $.each(data.result, function (key, value) {
                    option += '<option value="' + value.id + '" >' + value.centroCusto + ' (' + value.departamento + ')' + '</option>';
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

function loadUnidadesMedida() {
    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "UnidadeMedida");

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
                    option += '<option value="' + value.id + '" >' + value.unidade + '</option>';
                });

                $("#id_unidade").html(option);

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

            action: 'AjusteHoras',
            method: 'getAll'

        }, success: function (data) {

            tbody = '';

            if (data.count) {

                tbody = '';

                $.each(data.result, function (key, value) {

                    tbody += '<tr>' +
                        '<td width="60%">' + value.numero + '</td>' +
                        '<td width="60%">' + value.centroCusto + '</td>' +
                        '<td width="10%">' + value.data + '</td>' +
                        '<td width="10%">' + value.tempo + '</td>' +
                        '<td width="10%" class="update" data-id_centro_custo ="' + value.id_centro_custo + '" data-id_tabela="' + value.id_tabela + '" data-id_tabela_complemento="' + value.id_tabela_complemento + '" data-data="' + value.data + '"></td>' +
                        '<td width="10%" class="delete" data-id_centro_custo ="' + value.id_centro_custo + '" data-id_tabela="' + value.id_tabela + '" data-id_tabela_complemento="' + value.id_tabela_complemento + '" data-data="' + value.data + '"></td>' +
                        '</tr>';
                });

                $('.grid').html(tbody);
            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        }
    }).done(function () {
        $('#table_principal').DataTable();
    });

}


function create(formData) {

    formData.append('action', "AjusteHoras");

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

    });
}

function remove(formData) {

    formData.append('action', "AjusteHoras");

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

    formData.append('action', "AjusteHoras");

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
    idid_comp = 0;
    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "AjusteHoras");

    formData.append('method', "getById");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {


            if (data.result) {
                $("#id_tabela").val(data.result['id_tabela']);
                $("#id_tabela").trigger('change');
                idid_comp = data.result['id_tabela_complemento'];
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

        setTimeout(function () {

            $("#id_tabela_complemento").val(idid_comp);

            $(".select2_single").select2({
                placeholder: "Select a state",
                allowClear: true
            });
        }, 2000)

    });

}

$("#form-principal").submit(function (e) {

    e.preventDefault();

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.get('l_id_tabela') ? update(formData) : create(formData);

});

$(document).on('change', "#id_tabela", function () {

    tipo = $("#id_tabela").val();

    if (tipo == 1) {
        loadSubContratos();
    } else if (tipo == 2) {
        loadPropostas();
    } else if (tipo == 3) {
        loadCentroCusto();
    } else if (tipo == 4) {
        loadFolga();
    }
});


function loadSubContratos() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "SubContrato");

    formData.append('method', "getAllHoras");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            option = '<option value="">Selecione</option>';

            if (data.count) {

                $.each(data.result, function (key, value) {


                    option += '<option value="' + value.id + '" >' + value.sub_contrato + '</option>';
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


function loadPropostas() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "NumeroOrcamento");

    formData.append('method', "getAllNumero");

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


$(document).ready(function () {

    grid();
    loadCentroCustoSelect();
    loadUnidadesMedida();

    $(document).on('click', '.add', function () {
        $(".modal_principal").modal('show');
    })

    $(document).on('click', '.save', function () {

        $("#form-principal").submit();

    })

    $(document).on('click', '.delete', function () {

        data_id_centro_custo = $(this).data('id_centro_custo');
        data_id_tabela = $(this).data('id_tabela');
        data_id_tabela_complemento = $(this).data('id_tabela_complemento');
        data_data = $(this).data('data');

        if (confirm("Remover o registro?")) {

            $("#l_id_centro_custo").val(data_id_centro_custo);
            $("#l_id_tabela").val(data_id_tabela);
            $("#l_id_tabela_complemento").val(data_id_tabela_complemento);
            $("#l_data").val(data_data);

            var formData = new FormData();

            formData = load_fields(formData, interact_fields);

            remove(formData);
        }
    });

    $(document).on('click', '.update', function () {

        data_id_centro_custo = $(this).data('id_centro_custo');
        data_id_tabela = $(this).data('id_tabela');
        data_id_tabela_complemento = $(this).data('id_tabela_complemento');
        data_data = $(this).data('data');

        $("#l_id_centro_custo").val(data_id_centro_custo);
        $("#l_id_tabela").val(data_id_tabela);
        $("#l_id_tabela_complemento").val(data_id_tabela_complemento);
        $("#l_data").val(data_data);

        load();
    })

})
