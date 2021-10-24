urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['numero'] = '';
interact_fields['revisao'] = '';
interact_fields['data'] = '';
interact_fields['id_cliente'] = '';
interact_fields['id_cliente_final'] = '';
interact_fields['id_objeto'] = '';
interact_fields['id_representante'] = '';
interact_fields['proposta_venda'] = '';
interact_fields['id_status_orcamento'] = '';
interact_fields['id_funcionario'] = '';
interact_fields['numero_pedido'] = '';
interact_fields['observacao'] = '';
interact_fields['tipo'] = '';
interact_fields['status'] = '';
interact_fields['addHoras'] = '';

function inicio() {
    loadFuncionarios();
    loadClientes();
    loadRepresentantes();
    loadObjetos();
    loadStatusOrcamento();
    // grid();

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


function proximoOrcamento(tipoOrcamento) {

    var formData = new FormData();

    formData.append('action', "NumeroOrcamento");

    formData.append('method', "getNext");

    formData.append('tipo', tipoOrcamento);

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            option = '<option value="">Selecione</option>';

            if (data.count) {

                $("#nomeNumero").html(data.result['numeroPad']);
                $("#nomeRevisao").html(data.result['revisao']);


            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');

            } else if (data.count == 0) {
                $("#nomeNumero").html(data.result['numeroPad']);
                $("#nomeRevisao").html(data.result['revisao']);
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
                '<option value="adicionar_objeto">ADICIONAR NOVO</option>';

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

function loadStatusOrcamento() {
    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "StatusOrcamento");

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
                    option += '<option value="' + value.id + '" >' + value.statusOrcamento + '</option>';
                });

                $("#id_status_orcamento").html(option);

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

function loadRepresentantes() {
    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "Representante");

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
                    option += '<option value="' + value.id + '" >' + value.representante + '</option>';
                });

                $("#id_representante").html(option);

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
                    option += '<option data-nomereduzido="' + value.nome_reduzido + '" value="' + value.id + '" >' + value.identificador + '</option>';
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

            action: 'NumeroOrcamento',
            method: 'getAllGrid',
            tipo_filtro: $("#tipo_filtro").val(),
            data_filtro: $("#data_filtro").val()

        }, success: function (data) {

            tbody = '';

            if (data.count) {

                tbody = '';

                $.each(data.result, function (key, value) {

                    sigla = (value.sigla == null ? "" : value.sigla)
                    razao_social = (value.razao_social == null ? "" : value.razao_social)
                    nome = (value.nome == null ? "" : value.nome)
                    razao_final = (value.razao_final == null ? "" : value.razao_final)
                    nome_final = (value.nome_final == null ? "" : value.nome_final)
                    representante = (value.representante == null ? "" : value.representante)
                    proposta_venda = (value.proposta_venda == null ? "" : value.proposta_venda)
                    observacao = (value.observacao == null ? "" : value.observacao)
                    statusOrcamento = (value.statusOrcamento == null ? "" : value.statusOrcamento)
                    numero_pedido = (value.numero_pedido == null ? "" : value.numero_pedido)


                    tbody += '<tr>' +
                        '<td>' + value.numeroPad + '</td>' +
                        '<td>' + value.revisao + '</td>' +
                        '<td>' + sigla + '</td>' +
                        '<td>' + value.data + '</td>' +
                        '<td>' + razao_social + '</td>' +
                        '<td>' + razao_final + '</td>' +
                        '<td>' + value.objeto + '</td>' +
                        '<td>' + representante + '</td>' +
                        '<td>' + observacao + '</td>' +
                        '<td class="orcamento text-center" style="cursor: pointer" data-id="' + value.id + '"><a href="javascript:void(0)"><i class="fa fa-file"></i></a></td>' +
                        '<td class="visualizar text-center" style="cursor: pointer" data-id="' + value.id + '"><a href="javascript:void(0)"><i class="fa fa-eye"></i></a></td>' +
                        '<td class="update text-center" style="cursor: pointer" data-id="' + value.id + '"><a href="javascript:void(0)"><i class="fa fa-pencil-square-o"></i></a></td>' +
                        '</tr>';
                });

                $('.grid').html(tbody);
            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            } else {
                tbody += '<tr>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '</tr>';

                $('.grid').html(tbody);
            }
        }
    }).done(function () {
        $('#table_principal').DataTable({
            "ordering": false
        });

        setaDataAtualCampo("#data");


        $("#myModalLabel span:not(#nomeNumero)").html("");

        $(".select2_single:not(#data_filtro)").val("");
        $(".select2_single").select2({
            placeholder: "Selecione",
            allowClear: true
        });

        $("#revisao").val("0");
        $("#revisao").trigger("change");

    });

}

function create(formData) {

    formData.append('action', "NumeroOrcamento");

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

                $(".modal_principal").modal('hide');
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
        proximoOrcamento(tipoOrcamento);
        $(".save").show();
    });
}

function remove(formData) {

    formData.append('action', "NumeroOrcamento");

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

    formData.append('action', "NumeroOrcamento");

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
                $(".modal_principal").modal('hide');
                // load();
            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }


        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        $(".save").show();
    });
}


function load() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "NumeroOrcamento");

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

function visualizar() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "NumeroOrcamento");

    formData.append('method', "getJoinId");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            if (data.result) {

                conteudo_visu = '';

                $(".nomeVisual").html(data.result['proposta']);

                conteudo_visu += "<div class='row'>" +
                    "<h4 class='col-md-12 col-sm-12 col-xs-12 marcar'>Funcionário:<br/><br/>" + data.result['nome_funcionario'] + ' ' + data.result['sobrenome_funcionario'] + "</h4>";
                conteudo_visu += "<h4 class='col-md-6 col-sm-6 col-xs-6 marcar'>Cliente:<br/><br/>" + data.result['razao_social'] + "</h4>";
                conteudo_visu += "<h4 class='col-md-6 col-sm-6 col-xs-6 marcar'>Cliente Final:<br/><br/>" + data.result['razao_final'] + "</h4>";
                conteudo_visu += "<h4 class='col-md-6 col-sm-6 col-xs-6 marcar'>Objeto:<br/><br/>" + data.result['objeto'] + "</h4>";
                conteudo_visu += "<h4 class='col-md-6 col-sm-6 col-xs-6 marcar'>N° Pedido:<br/><br/>" + data.result['numero_pedido'] + "</h4>";
                conteudo_visu += "<h4 class='col-md-12 col-sm-12 col-xs-12 marcar'>Observação:<br/><br/>" + data.result['observacao'] + "</h4>";
                conteudo_visu += "<h5 class='col-md-12 col-sm-12 col-xs-12 marcar'>GERADO EM:<br/><br/>" + data.result['data_gerado_data'] + ' ' + data.result['data_gerado_hora'] + "</h5></div>";

                $(".conteudo_visu").html(conteudo_visu);
            }


            else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        $(".modal_visualizar").modal('show');

        $(".select2_single").select2({
            placeholder: "Selecione",
            allowClear: true
        });
    });

}

$("#form-principal").submit(function (e) {
    $(".save").hide();
    e.preventDefault();

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.get('id') ? update(formData) : create(formData);

});

function create_cliente(formData) {

    formData.append('action', "Cliente");

    formData.append('method', "create");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {
            if (data.result) {

                mensagem('OK', 'Cadastrado', 'success', '');

                loadClientes();

                $(".modal_cliente").modal('hide');

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

function limparTour() {

}

function carregarAnosFiltro() {

    optionF = '';

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: {

            action: 'NumeroOrcamento',
            method: 'anosPropostas'

        }, success: function (data) {


            if (data.count) {


                $.each(data.result, function (key, value) {

                    optionF += '<option value="' + value + '">' + value + '</option>';

                });
                optionF += '<option value="Todos">Todos</option>';

                $("#data_filtro").html(optionF);

            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            } else {

            }
        }
    }).done(function () {


    });

}


function usuarioLogado() {

    optionF = '';

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: {

            action: 'NumeroOrcamento',
            method: 'usuarioLogado'

        }, success: function (data) {

            $("#id_funcionario").val(data)
        }
    }).done(function () {

        $(".select2_single").select2({
            placeholder: "Selecione",
            allowClear: true


        });
        $("#id_funcionario").trigger("change")
    });

}


function loadOrcamento() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "NumeroOrcamento");

    formData.append('method', "getJoinId");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            if (data.result) {

                conteudo_visu = '';

                $(".modal-orcamento-title").html(data.result['proposta'] + ' <br>' + data.result['objeto']);

            }

            else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        $(".modal_orcamento").modal('show');
    });

}


$(document).ready(function () {

    carregarAnosFiltro();

    $(document).on("change", "#data_filtro", function () {
        grid()
    })

    $(document).on("change", "#tipo_filtro", function () {
        grid()
    })

    $(document).on("click", ".orcamento", function () {


        dataId = $(this).data('id');

        $("#id").val(dataId);

        loadOrcamento();

    })

    $(document).on("click", ".help", function () {
        // Instance the tour
        var tour = new Tour({
            steps: [
                {
                    element: ".add",
                    title: "1 Adicionar",
                    content: "Exibe o formulário para cadastro de novas propostas.",
                    smartPlacement: true,
                    onShow: function (tour) {

                        $("*").removeClass("marcarTour");
                        $(".add").addClass("marcarTour");
                    },
                },
                {
                    element: ".grid",
                    title: "2 Registros",
                    content: "Neste campo pode ser visualizado todos os registros referentes a propostas",
                    placement: "top",
                    onShow: function (tour) {

                        $("*").removeClass("marcarTour");
                        $(".grid").addClass("marcarTour");
                    },

                }
                ,
                {
                    element: "#table_principal_info",
                    title: "3 Quantidade",
                    content: "Neste campo pode ser visualizado a quantidade de registros exibidos e a quantidade de registros cadastrados",
                    placement: "top",
                    onShow: function (tour) {

                        $("*").removeClass("marcarTour");
                        $("#table_principal_info").addClass("marcarTour");
                    },

                }
                , {
                    element: ".pagination",
                    title: "4 Paginas",
                    content: "Neste local podemos navegar entre as paginas com os registros de propostas.",
                    placement: "top",
                    onShow: function (tour) {

                        $("*").removeClass("marcarTour");
                        $(".pagination").addClass("marcarTour");
                    },
                }


            ]
        });

        // Initialize the tour
        tour.init();

        if (tour.ended()) {
            tour.restart();
        } else {
            tour.end();
            tour.start();
        }


    })
    inicio();

    $(document).on("change", "#tipo", function () {
        tipoOrcamento = $(this).val();
        proximoOrcamento(tipoOrcamento);
    });

    $(document).on("change", "#revisao", function () {

        $("#nomeRevisao").html($(this).val());
    });

    $(document).on("change", "#id_funcionario", function () {
        sigla = $('option:selected', this).data('sigla');
        $("#nomeSigla").html(sigla)
    })

    $(document).on("change", "#id_cliente", function () {
        cliente = $('option:selected', this).text();
        nome_reduzido = $('option:selected', this).data("nomereduzido");

        if (nome_reduzido) {
            cliente = nome_reduzido;
        }

        $("#nomeCliente").html(cliente)
    })

    $(document).on("change", "#data", function () {
        data = $(this).val().split("/");
        mes = data[1];
        ano = data[2].slice(2, 4);

        $("#nomeMesAno").html(mes + '' + ano);
    })

    $(document).on('click', '.add', function () {
        $(".modal-principal-title").show();
        setaDataAtualCampo("#data");
        $(".modal_principal").modal('show');
        $("#id_funcionario").trigger("change")
        $("#id_cliente").trigger("change")

        usuarioLogado();
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

        $(".modal-principal-title").hide();

        dataId = $(this).data('id');

        $("#id").val(dataId);

        load();
    })


    $(document).on('click', '.visualizar', function () {

        dataId = $(this).data('id');

        $("#id").val(dataId);

        visualizar();
    })


})





