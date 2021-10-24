urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['id_tipo'] = '';
interact_fields['id_colaborador'] = '';
interact_fields['ausencia_de'] = '';
interact_fields['ausencia_hora'] = '';
interact_fields['retorno_de'] = '';
interact_fields['retorno_hora'] = '';
interact_fields['empresa'] = '';
interact_fields['ausencia_local'] = '';
interact_fields['id_representante'] = '';
interact_fields['id_representante_2'] = '';
interact_fields['telefone'] = '';
interact_fields['telefone_2'] = '';
interact_fields['status'] = '';


function loadTipos() {
    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "Tipo");

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
                    option += '<option value="' + value.id + '" >' + value.tipo + '</option>';
                });

                $("#id_tipo").html(option);

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

                $("#id_colaborador").html(option);

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

function loadRepresentantes() {
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

                $("#id_representante").html(option);
                $("#id_representante_2").html(option);

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

function grid() {     $('#table_principal').DataTable().destroy();

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: {

            action: 'Ausencia',
            method: 'getAllJoin'

        }, success: function (data) {

            tbody = '';

            if (data.count) {

                tbody = '';

                $.each(data.result, function (key, value) {

                    tbody += '<tr>' +
                        '<td>' + value.tipo + '</td>' +
                        '<td>' + value.nome_colaborador + ' ' + value.sobrenome_colaborador + '</td>' +
                        '<td>' + value.telefone + '<br>' + value.telefone_2 + '</td>' +
                        '<td>' + value.nome_representante + ' ' + value.sobrenome_representante + '<br>' + value.nome_representante_2 + ' ' + value.sobrenome_representante_2 + '</td>' +
                        '<td>' + value.empresa + '<br>' + value.ausencia_local + '</td>' +
                        '<td>' + value.ausencia_de + '<br>' + value.ausencia_hora + '</td>' +
                        '<td>' + value.retorno_de + '<br>' + value.retorno_hora + '</td>' +
                        '<td class="troca_status" data-id="' + value.id + '">' + value.status + '</td>' +
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

    formData.append('action', "Ausencia");

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

    formData.append('action', "Ausencia");

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

    formData.append('action', "Ausencia");

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

function troca_status(formData) {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "Ausencia");

    formData.append('method', "troca_status");

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

    formData.append('action', "Ausencia");

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
        $(".select2_single").select2();
    });

}

function ultimoColaborador() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "Ausencia");

    formData.append('method', "getLast");

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
        $("#id").val("");
        $(".modal_principal").modal('show');
        $(".select2_single").select2();
    });

}

$("#form-principal").submit(function (e) {

    e.preventDefault();

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.get('id') ? update(formData) : create(formData);

});

function createFuncionario(formData) {

    formData.append('action', "Funcionario");

    formData.append('method', "create");
    lastInsert = 0;
    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            lastInsert = data.lastId;

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

        loadFuncionarios();

        setTimeout(function () {

            $("#id_colaborador").val(lastInsert);

            $(".select2_single").select2();

        }, 1000)


    });
}

$(document).ready(function () {


    grid();

    $(document).on('keyup', '.select2-search__field', function (e) {

        if (e.keyCode == 13) {

            var formData = new FormData();

            formData.append('tipo_pessoa', 'Física');
            formData.append('razao_social', '');
            formData.append('nome', $(this).val());
            formData.append('fantasia', '');
            formData.append('sobrenome', '');
            formData.append('rg', '');
            formData.append('ie', '');
            formData.append('cpf', '');
            formData.append('cnpj', '');
            formData.append('cep', '32010050');
            formData.append('rua', 'Santiago Ballesteros');
            formData.append('numero', '610');
            formData.append('bairro', 'Cinco');
            formData.append('cidade', 'Contagem');
            formData.append('uf', 'MG');
            formData.append('status', 'A');
            formData.append('email', $(this).val().replace(" ", "") + "@" + $(this).val().replace(" ", "") + ".com.br");
            formData.append('senha', "visitante");

            createFuncionario(formData)
        }
    })

    $(document).on('click', '.save', function () {

        $("#form-principal").submit();

    })


    $(document).on('change', '#id_colaborador', function () {
        ultimoColaborador();

    })

    $(document).on('click', '.delete', function () {
        return false;
        dataId = $(this).data('id');
        if(confirm("Remover o registro?")){
            $("#id").val(dataId);

        var formData = new FormData();

        formData = load_fields(formData, interact_fields);

                      remove(formData);        }
    });

    $(document).on('click', '.update', function () {
        return false;
        dataId = $(this).data('id');

        $("#id").val(dataId);

        load();
    })

    $(document).on('click', '.troca_status', function () {

        dataId = $(this).data('id');

        $("#id").val(dataId);

        troca_status();
    })

    loadTipos();

    loadFuncionarios();

    loadRepresentantes();

})
