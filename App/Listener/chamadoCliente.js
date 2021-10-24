urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['id_servico_cliente'] = '';
interact_fields['descricao'] = '';
interact_fields['assunto'] = '';
interact_fields['file'] = '';
interact_fields['area'] = '';

interact_fields_answer = {};

interact_fields_answer['id'] = '';
interact_fields_answer['id_servico_cliente'] = '';
interact_fields_answer['assunto'] = '';
interact_fields_answer['file2'] = '';

function zerar(){

    $("#id").val('');

    interact_fields = {};

    interact_fields['id'] = '';
    interact_fields['id_servico_cliente'] = '';
    interact_fields['descricao'] = '';
    interact_fields['assunto'] = '';
    interact_fields['file'] = '';
    interact_fields['area'] = '';

    interact_fields_answer = {};

    interact_fields_answer['id'] = '';
    interact_fields_answer['id_servico_cliente'] = '';
    interact_fields_answer['assunto'] = '';
    interact_fields_answer['file2'] = '';
}

function inicio() {

}


function loadServicos() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "ServicoArea");

    formData.append('method', "getServicoUsuario");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            option = '';

            if (data.count) {

                $.each(data.result, function (key, value) {
                    option += '<option value="' + value.id + '" data-valor="' + value.valor + '">' + value.servico + '</option>';
                });

                $("#id_servico_cliente").html(option);

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

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "ChamadoCliente");

    formData.append('method', "getAllArea");


    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            tbody = '';

            if (data.count) {

                tbody = '';

                $.each(data.result, function (key, value) {


                    tbody += '<tr style="background:' + value.cor + '">' +
                        '<td width="15%">' + value.servico + '</td>' +
                        '<td width="15%">' + value.assunto + '</td>' +
                        '<td width="15%">' + value.data_criado + '</td>' +
                        '<td width="15%">' + value.hora_criado + '</td>' +
                        '<td width="15%">' + value.descricao_status + '</td>' +
                        '<td width="15%" data-id=' + value.id + ' class="ver_chamado"></td>'
                    '</tr>';
                });

                $('.grid').html(tbody);
            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        $('#table_principal').DataTable();
    });

}


function create(formData) {

    formData.append('action', "ChamadoCliente");

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

    formData.append('action', "ChamadoCliente");

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


function load() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);


    formData.append('action', "ChamadoCliente");

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
    });

}

$("#form-principal").submit(function (e) {

    e.preventDefault();

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    create(formData);

});

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

    formData.append('descricao', $("#descricao_chamado").html());

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
$(document).ready(function () {

    $('.modal').on('hidden.bs.modal', function (e) {
      zerar();
    })

    $(document).on('click', '.answer', function () {

        var formData = new FormData();

        formData = load_fields(formData, interact_fields_answer);

        responder(formData);

    });


    $(document).on('click', '.ver_chamado', function () {

        dataId = $(this).data('id');

        $("#id").val(dataId);

        history();

        $(".modal_ver_chamado").modal('show');

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
    loadServicos();
    inicio();

    grid();

    $(document).on('click', '.add', function () {
        $(".modal_principal").modal('show');
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


})
