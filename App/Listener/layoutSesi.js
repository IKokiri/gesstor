urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['menu'] = '';
interact_fields['icone'] = '';
interact_fields['status'] = '';
/*
HA

tipo_registro
cnpj_empresa
uf
numero_convenio
exercicio
mes_inicial_apuracao
mes_final_apuracao
nome_representante_empresa_1
cargo_representante_empresa_1
ddd_representante_empresa_1
telefone_representante_empresa_1
fax_representante_empresa_1
email_representante_empresa_1
nome_representante_empresa_2
cargo_representante_empresa_2
ddd_representante_empresa_2
telefone_representante_empresa_2
*/

ha = 
'<div class="row">
'<div class="col col-md-2">
'<label>
'Tipo de registro
'</label>
'<select class="select2_single form-control" name="" id="tipo_registro">
'<option value="HA">HA</option>
'<option value="DA">DA</option>
'<option value="DB">DB</option>
'<option value="DC">DC</option>
'<option value="TA">TA</option>
'</select>
'</div>
'</div>
'<div class="col col-md-2">
'<label for="">
'CNPJ da empresa
'</label>
'<input type="text" class="form-control" id="cnpj_empresa"
'placeholder="8" maxlength="8'>
'</div>
'<div class="col col-md-2">
'<label for="">
'UF
'</label>
'<input type="text" class="form-control" id="uf"
'placeholder="2" maxlength="2'>
'</div>
'<div class="col col-md-2">
'<label for="">
'Número do convênio
'</label>
'<input type="text" class="form-control" id="numero_convenio"
'placeholder="5" maxlength="5'>
'</div>
'<div class="col col-md-2">
'<label for="">
'Exercício
'</label>
'<input type="text" class="form-control" id="exercicio"
'placeholder="4" maxlength="4'>
'</div>
'<div class="col col-md-2">
'<label for="">
'Mês inicial de apuração
'</label>
'<input type="text" class="form-control" id="mes_inicial_apuracao"
'placeholder="2" maxlength="2'>
'</div>
'<div class="col col-md-2">
'<label for="">
'Mês final de apuração
'</label>
'<input type="text" class="form-control" id="mes_final_apuracao"
'placeholder="2" maxlength="2'>
'</div>
'<div class="col col-md-2">
'<label for="">
'Nome do 1º representante da empresa
'</label>
'<input type="text" class="form-control" id="nome_representante_empresa_1"
'placeholder="120" maxlength="120'>
'</div>
'<div class="col col-md-2">
'<label for="">
'Cargo do 1º representante da empresa
'</label>
'<input type="text" class="form-control" id="cargo_representante_empresa_1"
'placeholder="40" maxlength="40'>
'</div>
'<div class="col col-md-2">
'<label for="">
'DDD do 1º representante da empresa
'</label>
'<input type="text" class="form-control" id="ddd_representante_empresa_1"
'placeholder="2" maxlength="2'>
'</div>
'<div class="col col-md-2">
'<label for="">
'Telefone do 1º representante da empresa
'</label>
'<input type="text" class="form-control" id="telefone_representante_empresa_1"
'placeholder="9" maxlength="9'>
'</div>
'<div class="col col-md-2">
'<label for="">
'Fax do 1º representante da empresa
'</label>
'<input type="text" class="form-control" id="fax_representante_empresa_1"
'placeholder="9" maxlength="9'>
'</div>
'<div class="col col-md-2">
'<label for="">
'e-mail do 1º representante da empresa
'</label>
'<input type="text" class="form-control" id="email_representante_empresa_1"
'placeholder="100" maxlength="100'>
'</div>
'<div class="col col-md-2">
'<label for="">
'Nome do 2º representante da empresa
'</label>
'<input type="text" class="form-control" id="nome_representante_empresa_2"
'placeholder="120" maxlength="120'>
'</div>
'<div class="col col-md-2">
'<label for="">
'Cargo do 2º representante da empresa
'</label>
'<input type="text" class="form-control" id="cargo_representante_empresa_2"
'placeholder="40" maxlength="40'>
'</div>
'<div class="col col-md-2">
'<label for="">
'DDD do 2º representante da empresa
'</label>
'<input type="text" class="form-control" id="ddd_representante_empresa_2"
'placeholder="2" maxlength="2'>
'</div>
'<div class="col col-md-2">
'<label for="">
'Telefone do 2º representante da empresa
'</label>
'<input type="text" class="form-control" id="telefone_representante_empresa_2"
'placeholder="9" maxlength="9'>
'</div>'
'</div>'
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
