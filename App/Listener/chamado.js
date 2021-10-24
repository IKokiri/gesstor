urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['id_servico_cliente'] = '';
interact_fields['descricao'] = '';
interact_fields['assunto'] = '';
interact_fields['file'] = '';

interact_fields_status = {};
interact_fields_status['id'] = '';
interact_fields_status['status'] = '';


function inicio() {
}

function grid() {     $('#table_principal').DataTable().destroy();

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: {

            action: 'ChamadoCliente',
            method: 'getAll'

        }, success: function (data) {

            tbody = '';

            if (data.count) {

                tbody = '';

                $.each(data.result, function (key, value) {

                    tbody += '<tr style="background:' + value.cor + '">' +
                        '<td width="10%">' + value.identifica + '</td>' +
                        '<td width="15%">' + value.servico + '</td>' +
                        '<td width="15%">' + value.assunto + '</td>' +
                        '<td width="15%">' + value.data_criado + '</td>' +
                        '<td width="15%">' + value.hora_criado + '</td>' +
                        '<td width="15%" data-id=' + value.id + ' class="update_status_chamado">' + value.descricao_status + '</td>' +
                        '<td width="15%" data-id=' + value.id + ' class="ver_chamado"></td>'
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

function history(formData) {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "ChamadoCliente");

    formData.append('method', "getHistory");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {
            descricoes = '';
            if (data.result) {

                assunto = data.result[0]['assunto'];

                $.each(data.result, function (key, value) {

                    classe = '';
                    back = '#EEEEEE';
                    style = 'style=background:' + back + ';';
                    style2 = 'style=background:' + back + ';margin-left:0';


                    if (value.id_servico_cliente == 0) {
                        classe = 'blockquote-reverse';
                        style = '';
                        style2 = '';
                        back = '';
                    }

                    anexo = ''

                    if (value.new_name) {
                        anexo = "<a  href='App/imagens/chamados/" + value.new_name + "' class='fa fa-paperclip fa-2x pull-right' target='_blank'></a>";
                    }
                    descricoes += "<blockquote " + style + " class='" + classe + "'>" +
                        "<p>" + value.descricao + "</p>" +
                        "<footer " + style2 + "> " + value.identifica + "  <cite title='Source Title'>" + value.data_criado + " as " + value.hora_criado + " </cite>" +
                        anexo +
                        "</footer>" +
                        "</blockquote>";

                });

                $(".descricoes").html(descricoes);
                $(".assunto_chamado").html(assunto);

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

function responder(formData) {

    formData.append('action', "ChamadoCliente");

    formData.append('method', "create");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {
            descricoes = '';
            if (data.result) {
            }
            else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {

        history();
    });

}


function load_status() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "Status");

    formData.append('method', "getAll");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            if (data.result) {

                status = '';

                $.each(data.result, function (key, value) {

                    status += '<button data-id="' + value.id + '" type="button" class="btn btn-default button_status" style="background: ' + value.cor + '">' + value.status + '</button>';

                });

                $(".status_disponiveis").html(status)

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


function update_status(formData) {

    formData.append('action', "ChamadoCliente");

    formData.append('method', "update_status");

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
                $(".modal").modal('hide');
                grid();
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

$(document).ready(function () {

    $(document).on('click', '.ver_chamado', function () {

        dataId = $(this).data('id');

        $("#id").val(dataId);

        history();

        $(".modal_ver_chamado").modal('show');

    });

    $(document).on('click', ".update_status_chamado", function () {

        id = $(this).data('id');

        $("#id").val(id);

        $(".modal_status_chamado").modal('show');

        load_status();

    });

    $(document).on('click', '.answer', function () {

        var formData = new FormData();

        formData = load_fields(formData, interact_fields);

        responder(formData);

    });

    $(document).on('click', '.button_status', function () {

        id_status = $(this).data('id');

        $("#status").val(id_status);

        var formData = new FormData();

        formData = load_fields(formData, interact_fields_status);

        update_status(formData);

    });

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


})
