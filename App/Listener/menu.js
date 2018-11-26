urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['menu'] = '';
interact_fields['icone'] = '';
interact_fields['status'] = '';

function grid() {
    $('#table_principal').DataTable().destroy();

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: {

            action: 'Menu',
            method: 'getAll'

        }, success: function (data) {

            tbody = '';

            if (data.count) {

                tbody = '';

                $.each(data.result, function (key, value) {

                    tbody += '<tr>' +
                        '<td width="60%">' + value.menu + '</td>' +
                        '<td width="10%">' + value.icone + '</td>' +
                        '<td width="10%">' + value.status + '</td>' +
                        '<td width="10%" class="update" data-id="' + value.id + '"></td>' +
                        '<td width="10%" class="delete" data-id="' + value.id + '"></td>' +
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

    formData.append('action', "Menu");

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

    formData.append('action', "Menu");

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

    formData.append('action', "Menu");

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

    formData.append('action', "Menu");

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

    formData.get('id') ? update(formData) : create(formData);

});

$(document).ready(function () {

    grid();

    $(document).on('click', '.add', function () {
        $(".modal_principal").modal('show');
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
