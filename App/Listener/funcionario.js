urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['tipo_pessoa'] = '';
interact_fields['razao_social'] = '';
interact_fields['nome'] = '';
interact_fields['fantasia'] = '';
interact_fields['sobrenome'] = '';
interact_fields['rg'] = '';
interact_fields['ie'] = '';
interact_fields['cpf'] = '';
interact_fields['cnpj'] = '';
interact_fields['cep'] = '';
interact_fields['rua'] = '';
interact_fields['numero'] = '';
interact_fields['bairro'] = '';
interact_fields['cidade'] = '';
interact_fields['sigla'] = '';
interact_fields['uf'] = '';
interact_fields['status'] = '';

interact_fields['validadeCNH'] = '';
interact_fields['cnh'] = '';
interact_fields['categoriaCNH'] = '';

interact_fields['email'] = '';
interact_fields['senha'] = '';

interact_fields_servico = {};

interact_fields_servico['id'] = '';
interact_fields_servico['id_servico'] = '';
interact_fields_servico['id_servico_cliente'] = '';
interact_fields_servico['id_area'] = '';
interact_fields_servico['valor_servico'] = '';
interact_fields_servico['identificador'] = '';
interact_fields_servico['dia_vencimento'] = '';
interact_fields_servico['tipo_taxa'] = '';
interact_fields_servico['area'] = '';
interact_fields_servico['numero_meses'] = '';
interact_fields_servico['dias_entre'] = '';

interact_fields_contato = {};

interact_fields_contato['id_contato'] = '';
interact_fields_contato['nome_contato'] = '';
interact_fields_contato['sobrenome_contato'] = '';
interact_fields_contato['telefone_contato'] = '';
interact_fields_contato['email_contato'] = '';
interact_fields_contato['id_area_contato'] = '';
interact_fields_contato['area'] = '';

function inicio() {

}

function init_wizard() {

    $('#wizard_verticle').smartWizard({
        transitionEffect: 'slide',
        enableAllSteps: true,
        selected: 0

    });

    $('.buttonNext').addClass('btn btn-success').text('Próximo');
    $('.buttonPrevious').addClass('btn btn-primary').text('Anterior');
    $('.buttonFinish').addClass('btn btn-default').text('Finalizar');

}

function grid() {
    $('#table_principal').DataTable().destroy();

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: {

            action: 'Funcionario',
            method: 'getAll'

        }, success: function (data) {

            tbody = '';

            if (data.count) {

                tbody = '';

                $.each(data.result, function (key, value) {
                    status = value.status == 'A' ? 'fa-unlock' : 'fa-lock';

                    tbody += '<tr>' +
                        '<td width="30%">' + value.nome + " " + value.sobrenome + '</td>' +
                        '<td width="30%">' + value.sigla +
                        '<td width="5%" class="servicos_area" data-id="' + value.id + '"><span class="fa fa-suitcase"></span></td>' +
                        '<td width="5%" class="contatos" data-id="' + value.id + '"><span class="fa fa-users"></span></td>' +
                        '<td width="5%"><span class="fa ' + status + '"></span></td>' +
                        '<td width="5%" class="update" data-id="' + value.id + '"></td>' +
                        '<td width="5%" class="delete" data-id="' + value.id + '"></td>' +
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

function loadServicos() {

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: {

            action: 'Servico',
            method: 'getAllActive'

        }, success: function (data) {

            option = '';

            if (data.count) {

                $.each(data.result, function (key, value) {
                    option += '<option value="' + value.id + '" data-valor="' + value.valor + '">' + value.servico + '</option>';
                });

                $("#id_servico").html(option);
                $("#id_servico").trigger('change');

            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        }
    }).done(function () {

        $(".select2_single").select2({
            placeholder: "Select a state",
            allowClear: true
        });

    });

}

function getContatosFuncionario(formData) {

    formData.append('action', "Contato");

    formData.append('method', "getAllArea");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {
            servicos = '';
            if (data.result) {
                div = '';
                $.each(data.result, function (key, value) {
                    div += '<div class="col-md-6 col-sm-6 col-xs-6 profile_details">' +
                        '<div class="well profile_view">' +
                        '<div class="col-sm-12">' +
                        '<h4 class="brief"><i>' + value.nome_contato + ' ' + value.sobrenome_contato + '</i></h4>' +
                        '<div class="left col-xs-9">' +
                        '<h2>Cargo</h2>' +
                        '<ul class="list-unstyled">' +
                        '<li><i class="fa fa-at"></i> E-Mail:' + value.email_contato + '</li>' +
                        '<li><i class="fa fa-phone"></i> Tel:. ' + value.telefone_contato + ' </li>' +
                        '</ul>' +
                        '</div>' +
                        '<div class="right col-xs-3 text-center">' +
                        '<img src="App/src/foto.jpg" alt="" class="img-circle img-responsive">' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-xs-12 bottom text-center">' +
                        '<span class="col-xs-9 col-sm-9 ">' + value.identificador + '</span>' +
                        '<button type="button" data-id="' + value.id + '" class="btn btn-primary btn-xs col-xs-1 col-sm-1 update_contato "><i class="fa fa-edit"> </i> </button>' +
                        '<button type="button" data-id="' + value.id + '" class="btn btn-danger btn-xs col-xs-1 col-sm-1 delete_contato"><i class="fa fa-close"> </i> </button>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                });
                $(".contatos_html").html(div);
            }
            else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
    });

}

function loadServicosFuncionario(formData) {

    formData.append('action', "ServicoArea");

    formData.append('method', "getServicoArea");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {
            servicos = '';
            if (data.result) {

                $.each(data.result, function (key, value) {
                    servicos += "<div data-idservicocliente='" + value.id + "' class='col-md-2 col-sm-2 col-xs-2 servicoDoFuncionario " + value.icone + " fa-4x' title='" + value.servico + " R$ " + value.valor_servico + " " + value.identificador + "'></div>";
                });

                $(".servicos_do_cliente").html(servicos);

            }
            else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
    });

}


function create(formData) {

    formData.append('action', "Funcionario");

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

function createServicoArea(formData) {

    formData.append('action', "ServicoArea");

    formData.append('method', "create");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {
            if (data.result) {
                mensagem('OK', 'Cadastrado', 'success', '');
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

function createContato(formData) {

    formData.append('action', "Contato");

    formData.append('method', "create");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {
            if (data.result) {
                mensagem('OK', 'Cadastrado', 'success', '');
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

    formData.append('action', "Funcionario");

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

function remove_contato(formData) {

    formData.append('action', "Contato");

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

        getContatosFuncionario(formData);
    });
}

function update(formData) {

    formData.append('action', "Funcionario");

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

function updateServicoArea(formData) {

    formData.append('action', "ServicoArea");

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

function updateContato(formData) {

    formData.append('action', "Contato");

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
            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }


        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        getContatosFuncionario(formData);
    });
}


function load() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "Funcionario");

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
        init_wizard();
    });

}
function load_contato() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields_contato);

    formData.append('action', "Contato");

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

    });
}

function info_servico_cliente() {

    var formData = new FormData();

    formData.append('id', $("#id_servico_cliente").val()
    );
    formData.append('action', "ServicoArea");

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


$("#form-servicos-cliente").submit(function (e) {

    e.preventDefault();

    var formData = new FormData();

    formData = load_fields(formData, interact_fields_servico);

    formData.get('id_servico_cliente') ? updateServicoArea(formData) : createServicoArea(formData);

});

$("#form-contatos").submit(function (e) {

    e.preventDefault();

    var formData = new FormData();

    formData = load_fields(formData, interact_fields_contato);

    formData.get('id_contato') ? updateContato(formData) : createContato(formData);

});

$(document).ready(function () {

    loadServicos();
    inicio();

    $(document).on('click', ".contatos", function () {

        dataId = $(this).data('id');

        $("#id_area_contato").val(dataId);

        $(".modal_contatos").modal('show');

        var formData = new FormData();

        formData = load_fields(formData, interact_fields_contato);

        getContatosFuncionario(formData);

    })


    $(document).on('click', ".add_contato", function () {
        $(".modal").modal('hide');
        $(".modal_add_contatos").modal('show');
    })

    $(document).on('click', ".update_contato", function () {

        dataId = $(this).data('id');

        $("#id_contato").val(dataId);
        // $(".modal").modal('hide');

        $(".modal_add_contatos").modal('show');

        load_contato();

    })

    $(document).on("click", ".servicoDoFuncionario", function () {


        dataId = $(this).data('idservicocliente');

        $("#id_servico_cliente").val(dataId);

        $(".modal").modal('hide');
        $(".modal_servicos").modal('show');
        info_servico_cliente();
    })

    $(document).on('click', '.add_servico', function () {
        $(".modal").modal('hide');
        $(".modal_servicos").modal('show');
        loadServicos();
    })

    $(document).on('change', '#id_servico', function () {
        v = $("#id_servico option:selected").data('valor');
        $("#valor_servico").val(v);
    });

    $(document).on('change', '.pessoa_tipo', function () {
        tp = $(this).val();

        if (tp == 'Física') {
            $(".juridica").hide();
            $(".juridica input:not('[type=radio]')").val('');
            $(".fisica").show();
        } else if (tp == 'Jurídica') {
            $(".fisica").hide();
            $(".fisica input:not('[type=radio]')").val('');
            $(".juridica").show();
        }
    });


    grid();

    $(document).on('click', '.add', function () {
        $(".modal_principal").modal('show');
        init_wizard();
    })

    $(document).on('click', '.servicos_area', function () {
        id_area = $(this).data('id');
        $("#id_area").val(id_area);
        // $(".modal_servicos").modal('show');
        // loadServicos();
        $(".modal_servicos_area").modal("show");
        var formData = new FormData();

        formData = load_fields(formData, interact_fields_servico);

        loadServicosFuncionario(formData);
    })

    $(document).on('click', '.save', function () {

        $("#form-principal").submit();

    })

    $(document).on('click', '.save_servico_cliente', function () {

        $("#form-servicos-cliente").submit();

    })

    $(document).on('click', '.save_contato', function () {

        $("#form-contatos").submit();

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

    $(document).on('click', '.delete_contato', function () {

        dataId = $(this).data('id');

        $("#id_contato").val(dataId);

        var formData = new FormData();

        formData = load_fields(formData, interact_fields_contato);

        remove_contato(formData);

    });

    $(document).on('click', '.update', function () {

        dataId = $(this).data('id');

        $("#id").val(dataId);

        load();
    })


})
