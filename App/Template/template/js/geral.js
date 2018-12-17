var id_objeto_criado = '';

function mensagem(title, text, type, style) {

    title = title ? title : '?';
    text = text ? text : '?';
    type = type ? type : 'warning';
    style = style ? style : 'bootstrap3';

    new PNotify({
        title: title,
        text: text,
        type: type,
        styling: style,
        delay: 3000
    });

}

function confirma(title, text, type, style) {

    (new PNotify({
        title: title,
        text: text,
        icon: 'glyphicon glyphicon-question-sign',
        hide: false,
        confirm: {
            confirm: true
        },
        buttons: {
            closer: false,
            sticker: false
        },
        history: {
            history: false
        }
    })).get().on('pnotify.confirm', function () {
        return true;
    }).on('pnotify.cancel', function () {
        return false;
    });

}

function checkTypeLoad(element) {

    type = element.attr('type');

    if (type == 'checkbox') {
        return element.is(':checked') ? 'A' : 'D';
    } else if (type == 'file') {
        return element.prop('files')[0];
    } else if (element.data('type') == 'innerhtml') {
        return element.html();
    } else if (type == 'radio') {

        return $("[type='radio']:checked").val();
    }
    else {
        return element.val();
    }


}

function checkTypeFill(element, value) {

    type = element.attr('type');

    if (type == 'checkbox') {
        val = value == 'A' ? 'check' : 'uncheck';
        element.iCheck(val);
    } else if (type == 'radio') {

        $('[value = ' + value + ']').trigger('click');
    } else if (element.data('type') == 'innerhtml') {
        element.html(value);
    } else {
        element.val(value);
    }

}


function clear_field(form) {

    $(form + " input:not([type=radio],[type=checkbox])").val('');

}
function load_fields(form_data, interact_fields) {
    form_data = new FormData();
    $.each(interact_fields, function (key, value) {

        form_data.append(key, checkTypeLoad($('#' + key)));

    })

    return form_data;
}

function fill_fields(data_json) {

    $.each(data_json.result, function (key, value) {

        element = $('#' + key);

        v = value;

        v = checkTypeFill(element, v);

    })
}

$(".modal_principal").on('hide.bs.modal', function () {
    clear_field("#form-principal");
});
$(document).on("click", ".refreshPage", function () {
    location.reload(true);
})


// MASCARA
$(".mask_money").maskMoney({
    thousands: ''
});

// MASCARA
$(".mask_money_2").maskMoney({
    thousands: '',
    precision: 2,
    allowNegative: true
});
// MASCARA
$(".mask_time_2").maskMoney({
    thousands: '',
    precision: 1,
    allowNegative: true
});

// MASCARA
$(".mask_money_4").maskMoney({
    thousands: '',
    precision: 5
});

$(".mask_data").inputmask("99/99/9999");

$(".mask_mes_ano").inputmask("99/9999");

$(".mask_hora").inputmask("99:99");

$(".mask_cpf").inputmask("999.999.999-99");

$(".mask_cnpj").inputmask("99.999.999/9999-99");

$(".mask_cep").inputmask("99999-999");

$(".mask_celular").inputmask("(99) 9999[9]-9999");

$(".mask_celular_combo").inputmask("(99)9999[9]-9999 (99)9999[9]-9999");

// $(".mask_completa_email").inputmask("[a][a][a][a][a][a][a][a][a][a][.][a][a][a][a][a][a][a][a][a][a][a][a][a][a][a][a]");


function status_pagseguro(status) {

    retorno = "";

    switch (status) {
        case '1':
            // retorno = "Aguardando pagamento";
            retorno = "Aguarde Confirmação";
            break;
        case '2':
            retorno = "Em análise";
            break;
        case '3':
            retorno = "Paga";
            break;
        case '4':
            retorno = "Disponível";
            break;
        case '5':
            retorno = "Em disputa";
            break;
        case '6':
            retorno = "Devolvida";
            break;
        case '7':
            retorno = "Cancelada";
            break;
        case '8':
            retorno = "Debitado";
            break;
        case '9':
            retorno = "Retenção temporária";
            break;
        default:
            retorno = "Não Feita";

    }
    return retorno;
}

function ucfirst(word) {
    word = word.toLowerCase();
    word = word[0].toUpperCase() + "" + word.slice(1);
    return word;
}

// ATALHO ADIÇÃ ODE CLIENTE RAPIDO
// ATALHO ADIÇÃ ODE CLIENTE RAPIDO
// ATALHO ADIÇÃ ODE CLIENTE RAPIDO
// ATALHO ADIÇÃ ODE CLIENTE RAPIDO
// ATALHO ADIÇÃ ODE CLIENTE RAPIDO
// ATALHO ADIÇÃ ODE CLIENTE RAPIDO
// ATALHO ADIÇÃ ODE CLIENTE RAPIDO
// ATALHO ADIÇÃ ODE CLIENTE RAPIDO
// ATALHO ADIÇÃ ODE CLIENTE RAPIDO

interact_fields_cliente = {};

interact_fields_cliente['razao_social'] = '';
interact_fields_cliente['nome_reduzido'] = '';
interact_fields_cliente['cnpj'] = '';

$(document).on("change", "#id_cliente,#id_cliente_final", function () {
    valor = $(this).val();
    if (valor == "adicionar_cliente") {

        $(".modal_cliente").modal('show');
    }
})

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

$("#form-cliente").submit(function (e) {

    e.preventDefault();

    var formData = new FormData();

    formData = load_fields(formData, interact_fields_cliente);

    formData.append('status', 'A');
    formData.append('email', $("#nome_reduzido").val().replace(" ", "") + "@" + $("#nome_reduzido").val().replace(" ", "") + ".com.br");
    formData.append('senha', "cliente");
    formData.append('tipo_pessoa', "Jurídica");

    create_cliente(formData);

});

$(document).on('click', '.save_cliente', function () {

    $("#form-cliente").submit();


})

// ATALHO ADIÇÃ ODE CLIENTE RAPIDO
// ATALHO ADIÇÃ ODE CLIENTE RAPIDO
// ATALHO ADIÇÃ ODE CLIENTE RAPIDO
// ATALHO ADIÇÃ ODE CLIENTE RAPIDO
// ATALHO ADIÇÃ ODE CLIENTE RAPIDO
// ATALHO ADIÇÃ ODE CLIENTE RAPIDO
// ATALHO ADIÇÃ ODE CLIENTE RAPIDO
// ATALHO ADIÇÃ ODE CLIENTE RAPIDO
// ATALHO ADIÇÃ ODE CLIENTE RAPIDO


// ATALHO ADIÇÃ ODE OBJETO RAPIDO
// ATALHO ADIÇÃ ODE OBJETO RAPIDO
// ATALHO ADIÇÃ ODE OBJETO RAPIDO
// ATALHO ADIÇÃ ODE OBJETO RAPIDO
// ATALHO ADIÇÃ ODE OBJETO RAPIDO

interact_fields_objeto = {};

interact_fields_objeto['objeto'] = '';
interact_fields_objeto['complemento'] = '';

$(document).on("change", "#id_objeto", function () {
    valor = $(this).val();
    if (valor == "adicionar_objeto") {

        $(".modal_objeto").modal('show');
    }
})

function create_objeto(formData) {

    formData.append('action', "Objeto");

    formData.append('method', "create");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {
            if (data.result) {

                mensagem('OK', 'Cadastrado', 'success', '');

                loadObjetos();

                id_objeto_criado = data.lastId;

                $(".modal_objeto").modal('hide');

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

$("#form-objeto").submit(function (e) {

    e.preventDefault();

    var formData = new FormData();

    formData = load_fields(formData, interact_fields_objeto);

    formData.append('status', 'A');

    create_objeto(formData);

});

$(document).on('click', '.save_objeto', function () {

    $("#form-objeto").submit();


})

// ATALHO ADIÇÃ ODE OBJETO RAPIDO
// ATALHO ADIÇÃ ODE OBJETO RAPIDO
// ATALHO ADIÇÃ ODE OBJETO RAPIDO
// ATALHO ADIÇÃ ODE OBJETO RAPIDO
// ATALHO ADIÇÃ ODE OBJETO RAPIDO

function proximaData(data) {


    numero = data[8];
    numero += data[9];
    numeroReal = "-" + numero + "_";
    numero = parseInt(numero) + 1;

    if (numero < 10) {
        numero = "0" + numero
    }

    numero = "-" + numero + "_";

    data = data.replace(numeroReal, numero)

    return data;
}

function anteriorData(data) {


    numero = data[8];
    numero += data[9];
    numeroReal = "-" + numero + "_";
    numero = parseInt(numero) - 1;

    if (numero < 10) {
        numero = "0" + numero
    }

    numero = "-" + numero + "_";

    data = data.replace(numeroReal, numero)

    return data;
}

function dataPTEN(data, separador) {

    return data.substr(8, 2) + separador + data.substr(5, 2) + separador + data.substr(0, 4);

}


function setaDataAtualCampo(campo) {
    now = new Date();
    dia = (now.getDate() < 10) ? '0' + "" + now.getDate() : now.getDate();
    mes = ((now.getMonth() + 1) < 10) ? '0' + "" + (now.getMonth() + 1) : now.getMonth() + 1;
    ano = now.getFullYear();
    dataAtual = dia + '/' + mes + '/' + ano;
    $(campo).val(dataAtual);
    $(campo).trigger("change");
}