urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['servico'] = '';
interact_fields['icone'] = '';
interact_fields['valor'] = '';
interact_fields['status'] = '';
interact_fields['descricao'] = '';

var id_cobranca = '';

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
function grid() {     $('#table_principal').DataTable().destroy();

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: {

            action: 'PagamentoServico',
            method: 'getAllCliente'

        }, success: function (data) {

            div = '';

            if (data.count) {

                div = '';

                $.each(data.result, function (key, value) {

                    boleto = "Boleto"
                    classe = " gerar_boleto "

                    if (value.link_pagamento_gerado) {
                        boleto = '<a href="' + value.link_pagamento_gerado + '" target="_blank">Imprimir Boleto</a>'
                        classe = '';
                    }

                    div += '<div class="col-md-3 col-sm-6 col-xs-12">' +
                        '<div class="pricing ui-ribbon-container">' +
                        '<div class="ui-ribbon-wrapper">' +
                        '<div class="ui-ribbon">' +
                        status_pagseguro(value.status_cobranca) +
                        '</div>' +
                        '</div>' +
                        '<div class="title">' +
                        '<h2>' + value.servico + '</h2>' +
                        '<h1>R$ ' + value.valor_servico + '</h1>' +
                        '<span>' + value.identificador + '</span>' +
                        '</div>' +
                        '<div class="x_content">' +
                        '<div class="">' +
                        '<div class="pricing_features">' +
                        '<ul class="list-unstyled text-center">' +
                        '<li><i class="text-success"></i> <h3>Vencimento em <br><br><br><strong> ' + value.dia_vencimento + '</strong></h3></strong></li>' +
                        '</ul>' +
                        '</div>' +
                        '</div>' +
                        '<div class="pricing_footer">' +
                        '<span class="' + classe + ' btn btn-success     btn-block" role="button" data-link="' + value.link_pagamento_gerado + '" data-idcobranca ="' + value.id_cobranca + '"><h4>' + boleto + '</h4></span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                });

                $('.content-principal').html(div);
            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        }
    }).done(function () {

    });

}


function create(formData) {

    formData.append('action', "PagamentoServico");

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

    formData.append('action', "PagamentoServico");

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

    formData.append('action', "PagamentoServico");

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


    formData.append('action', "PagamentoServico");

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

$("#form-principal").submit(function (e) {

    e.preventDefault();

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.get('id') ? update(formData) : create(formData);

});

function loading() {
    $(".modal_load").modal('show');
}

function endLoading() {
    $(".modal_load").modal('hide');
}

function gerar_boleto() {

    loading();

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "PagSeguro");

    formData.append('method', "getSessionId");

    hash = '';

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            PagSeguroDirectPayment.setSessionId(data.sessionId);
            hash = PagSeguroDirectPayment.getSenderHash();
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        if (hash != "") {

            var formData = new FormData();

            formData.append('action', "PagSeguro");

            formData.append('method', "gerarBoleto");

            formData.append('hash', hash);

            formData.append('id_cobranca', id_cobranca);

            $.ajax({
                url: urlApp,
                type: 'POST',
                dataType: 'JSON',
                data: formData,
                success: function (data) {

                    window.open(data.paymentLink);
                    grid();
                },
                processData: false,
                cache: false,
                contentType: false
            }).done(function () {
                endLoading();
            });

        }
    });


}

$(document).ready(function () {

    $(document).on("click", ".gerar_boleto", function () {
        id_cobranca = $(this).data("idcobranca");
        gerar_boleto();
    })

    function initToolbarBootstrapBindings() {
        var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
                'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                'Times New Roman', 'Verdana'
            ],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
        $.each(fonts, function (idx, fontName) {
            fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
        });
        $('a[title]').tooltip({
            container: 'body'
        });
        $('.dropdown-menu input').click(function () {
            return false;
        })
            .change(function () {
                $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
            })
            .keydown('esc', function () {
                this.value = '';
                $(this).change();
            });

        $('[data-role=magic-overlay]').each(function () {
            var overlay = $(this),
                target = $(overlay.data('target'));
            overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
        });

        if ("onwebkitspeechchange" in document.createElement("input")) {
            var editorOffset = $('#editor').offset();

            $('.voiceBtn').css('position', 'absolute').offset({
                top: editorOffset.top,
                left: editorOffset.left + $('#editor').innerWidth() - 35
            });
        } else {
            $('.voiceBtn').hide();
        }
    }

    function showErrorAlert(reason, detail) {
        var msg = '';
        if (reason === 'unsupported-file-type') {
            msg = "Unsupported format " + detail;
        } else {
            console.log("error uploading file", reason, detail);
        }
        $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
            '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
    }

    initToolbarBootstrapBindings();

    $('#editor').wysiwyg({
        fileUploadError: showErrorAlert
    });

    window.prettyPrint;
    prettyPrint();

    inicio();

    grid();

    $(document).on('click', '.add', function () {
        $(".modal_principal").modal('show');
        init_wizard();
    })

    $(document).on('click', '.save', function () {
        $("#form-principal").submit();

    })

    $(document).on('click', '.delete', function () {

        dataId = $(this).data('id');
        if(confirm("Remover o registro?")){
            $("#id").val(dataId);

        var formData = new FormData();

        formData = load_fields(formData, interact_fields);

                   remove(formData);        }

    });

    $(document).on('click', '.update', function () {

        dataId = $(this).data('id');

        $("#id").val(dataId);

        load();
    })

})
