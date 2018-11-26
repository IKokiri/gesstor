urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['id_grupo'] = '';
interact_fields['tela'] = '';
interact_fields['status'] = '';

function inicio() {
    loadPermissoesTelas();
    loadGrupoPermissao();
}


function loadPermissoesTelas() {
    $.ajax({
        url: urlApp,
        async: false,
        type: 'POST',
        dataType: 'JSON',
        data: {

            action: 'SubMenu',
            method: 'getAllJoin'

        }, success: function (data) {

            if (data.count) {

                menu = data.result[0].menu;

                nav = '<div class="col-md-4"><h3>' + data.result[0].menu + '</h3>';

                $.each(data.result, function (key, value) {

                    if (menu != value.menu) {

                        menu = value.menu;
                        nav += "</div>";
                        nav += '<div class="col-md-4"><h3>' + value.menu + '</h3>';
                    }
                    if (menu == value.menu) {
                        nav += '<h5><input name="subMenus[]" value="' + value.id + '" type="checkbox">' + value.subMenu + '</h5>';
                    }

                });


                $("#telas").html(nav);

            } else if (data.MSN) {

                mensagem('Erro', data.msnErro, '', '');
            }
        }
    }).done(function () {

    });
}

function grid() {     $('#table_principal').DataTable().destroy();

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: {

            action: 'PermissaoTela',
            method: 'getAllJoin'

        }, success: function (data) {

            tbody = '';

            if (data.count) {

                tbody = '';

                $.each(data.result, function (key, value) {

                    tbody += '<tr>' +
                        '<td>' + value.grupo + '</td>' +
                        '<td class="update" data-idgrupo="' + value.id_grupo + '"></td>' +
                        '<td class="delete" data-idgrupo="' + value.id_grupo + '"></td>' +
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

    formData.append('action', "PermissaoTela");

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

    formData.append('action', "PermissaoTela");

    formData.append('method', "deleteGrupo");

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

    formData.append('action', "PermissaoTela");

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

    formData.append('action', "PermissaoTela");

    formData.append('method', "getByIdGrupos");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            if (data.result) {

                $("input[type='checkbox']").prop("checked", false);
                $.each(data.result, function (key, value) {

                    $("input[value='" + value.id_sub_menu + "']").prop("checked", true);
                })
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

    var subMenus = [];

    $("input[name='subMenus[]']:checked").each(function () {

        subMenus.push($(this).val());

    });

    var formData = new FormData();

    formData.append('subMenus', subMenus);

    formData.append('id_grupo', $("#id_grupo").val());

    formData.append('id_grupo', $("#id_grupo").val());

    formData.get('id_grupo') ? update(formData) : create(formData);

});

function loadGrupoPermissao() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "GrupoPermissao");

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
                    option += '<option value="' + value.id + '" >' + value.grupo + '</option>';
                });

                $("#id_grupo").html(option);

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
$(document).ready(function () {

    grid();
    inicio();

    $(document).on('click', '.add', function () {
        $(".modal_principal").modal('show');
    })

    $(document).on('click', '.save', function () {

        $("#form-principal").submit();

    })

    $(document).on('click', '.delete', function () {

        dataId = $(this).data('idgrupo');
        if(confirm("Remover o registro?")){
            $("#id_grupo").val(dataId);

        var formData = new FormData();

        formData = load_fields(formData, interact_fields);

             remove(formData);        }
    });

    $(document).on('click', '.update', function () {

        dataId = $(this).data('idgrupo');

        $("#id_grupo").val(dataId);

        load();
    })

})
