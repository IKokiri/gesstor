urlApp = 'App.php'

interact_fields = {};

interact_fields['mesAno'] = '';
interact_fields['id_funcionario'] = '';
interact_fields['id_tabela'] = '';
interact_fields['id_tabela_complemento'] = '';
interact_fields['id_aplicacao'] = '';

ultimo_campo_update = '';

feriados = new Array();
feriadosKey = {};

diasMarcadosTotal = new Array();
diasSexta = new Array();

function inicio() {

    loadFuncionarios();
    grid();
    loadMotivos();
    $("#mesAno").focus();
    loadFeriados();

}

function loadPropostas() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "NumeroOrcamento");

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

                    data = value.data.split("/");
                    mes = data[1];
                    ano = data[2].slice(2, 4);
                    data = mes + '' + ano;

                    option += '<option value="' + value.id + '" >' +
                        value.numeroPad +
                        '.' +
                        value.revisaoPad +
                        '-' +
                        value.sigla +
                        '-' +
                        data +
                        '-' +
                        value.cliente +
                        '</option>';
                });

                $("#id_tabela_complemento").html(option);

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
function loadAplicacaoFuncionario() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "FuncionarioAplicacao");

    formData.append('method', "getAllJoinFuncionario");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            option = '';

            if (data.count) {

                $.each(data.result, function (key, value) {
                    option += '<option value="' + value.id_aplicacao + '">' + value.aplicacao + '</option>';
                });

                $("#id_aplicacao").html(option);

            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            } else {
                option += '<option value=""></option>';
                $("#id_aplicacao").html(option);
            }
        }, processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        $(".select2_single").select2({});
    });

}

function loadMotivos() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "MotivoAusencia");

    formData.append('method', "getAll");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            legendaMotivo = "";

            if (data.count) {

                $.each(data.result, function (key, value) {


                    legendaMotivo += " <strong>" + value.ausencia + "</strong> : " + value.descricao;

                });

                $("#legendas").html(legendaMotivo);

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

function loadFeriados() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "Feriado");

    formData.append('method', "getAll");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            if (data.count) {
                k = 0;
                $.each(data.result, function (key, value) {


                    feriados.push(value.data);
                    feriadosKey[value.data] = value.descricao;
                    k++;
                });

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

function loadSubContratos() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "SubContrato");

    formData.append('method', "getAllHoras");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            option = '<option value="">Selecione</option>';

            if (data.count) {

                $.each(data.result, function (key, value) {


                    option += '<option value="' + value.id + '" >' + value.sub_contrato +'</option>';
                });

                $("#id_tabela_complemento").html(option);

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

function loadCentroCusto() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "CentroCusto");

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


                    option += '<option value="' + value.id + '" >' + value.centroCusto + " - " + value.departamento + '</option>';
                });

                $("#id_tabela_complemento").html(option);

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

function loadFolga() {


    option = '<option value="1"> Folga </option>';

    $("#id_tabela_complemento").html(option);


}

function loadFuncionarios() {

    var formData = new FormData();
    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "Funcionario");

    formData.append('method', "getAllTemp");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            option = '';
            var arrId = []
                   

            if (data.count) {

                

                $.each(data.result, function (key, value) {

                    // console.log(arrId.indexOf(value.id))
                    if(arrId.indexOf(value.id) < 0){
                        arrId.push(value.id)  

                        // console.log("aaaa")                      
                        option += '<option value="' + value.id + '" >' + value.nome + ' ' + value.sobrenome + '</option>';

                    }else{
                        // console.log("bbbb")

                    }

                });
                // console.log(arrId)
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
            placeholder: "Select a state",
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

            action: 'LancarHora',
            method: 'getAllData',
            mesAno: $("#mesAno").val(),
            id_funcionario: $("#id_funcionario").val()

        }, success: function (data) {
            tr = '';

            if (data.count) {

                tr = '';
                id_linha = '';
                status = '';


                tempoTotalCusto = data.result.tempoCusto;
                diaCustos = 1;
                $.each(data.result, function (key, value) {


                    if (!status) {
                        status = value.status;
                    }
                    if (key == 'tempoCusto') {
                        return;
                    }
                    campoTempo = '';

                    if (value.ausencia) {
                        campoTempo = value.ausencia;
                    } else {
                        campoTempo = value.tempo;
                    }

                    id_input_cab = value.data + '-' + value.id_funcionario + '-' + value.id_tabela + '-' + value.id_tabela_complemento + '-' + value.id_aplicacao;

                    if (id_linha != value.id_tabela + '_' + value.id_tabela_complemento + '_' + value.id_aplicacao) {
                        diaCustos = 1;
                        id_linha = value.id_tabela + '_' + value.id_tabela_complemento + '_' + value.id_aplicacao;
                        // titulo = "FOLGA - "

                        tr += "</tr>";
                        tr += '<tr><td colspan="31"  class="text-center"><h4>' + value.nomeCusto + ' - <strong> ' + tempoTotalCusto[value.nomeCusto] + ' HORAS </strong><span class="pull-right"><a class="removerHoras" data-idcompleto="' + id_input_cab + '" href="javascript:void(0)"><i class="fa fa-trash-o"></i></a></h4></span> </td></tr><tr>';

                        gr = '';
                        if (value.nomeCusto == "FOLGA") {
                            gr = 'grs';
                        }
                    }

                    id_input = value.data + '_' + value.id_funcionario + '_' + value.id_tabela + '_' + value.id_tabela_complemento + '_' + value.id_aplicacao;

                    dataEN = dataPTEN(value.data, '/');

                    colorDia = '';

                    descricaoDia = "";

                    var data = new Date(value.data);

                    var dia = data.getDay() + 1;

                    if (dia == 7 || dia == 6) {
                        colorDia = "#fd6363";
                    } else if (feriados.includes(dataEN)) {
                        descricaoDia = feriadosKey[dataEN];
                        colorDia = "#60aefd";
                    }

                    diasMarcadosTotal.push(colorDia);
                    dia_semana = '';

                    switch (dia) {
                        case 7:
                            dia_semana = 'DOM'
                            break;
                        case 1:
                            dia_semana = 'SEG'

                            break;
                        case 2:
                            dia_semana = 'TER'

                            break;
                        case 3:
                            dia_semana = 'QUA'

                            break;
                        case 4:
                            dia_semana = 'QUI'

                            break;
                        case 5:
                            dia_semana = 'SEX'

                            diasSexta.push(diaCustos)
                            break;
                        case 6:
                            dia_semana = 'SAB';
                            break;
                    }

                    tr += "<td  title='" + descricaoDia + "' class='text-center diaLancamento' style='background-color:" + colorDia + "'><strong>" + diaCustos++ + '</strong><br>' + dia_semana + "" + "<input class='" + gr + " update'  max-length='4' data-id='" + id_input + "'style='width:100%;text-align: center' value='" + campoTempo + "' type='text' placeholder='0'></td>";

                });


                if (!status || status == "undefined" || status == "null") {
                    status = "ABERTO";
                } else if (status == "FINALIZADO") {
                    status = "FINALIZADO";
                } else if (status == "APROVADO") {
                    status = "APROVADO";
                }

                $("#status").html(status);

                tr += "<tr class='text-center'>";

                tempContagemDias = 0;

                $.each(data.totais.totalDias, function (key, value) {

                    colorDiaTotal = '';

                    if (parseFloat(value) != parseInt(9)) {
                        colorDiaTotal = "#DDDDDD";
                    }

                    if (diasMarcadosTotal[tempContagemDias]) {
                        colorDiaTotal = diasMarcadosTotal[tempContagemDias];
                    }

                    if (diasSexta.indexOf(tempContagemDias + 1) >= 0 && parseFloat(value) == parseInt(8)) {
                        colorDiaTotal = "#FFFFFF"
                    }

                    if (diasSexta.indexOf(tempContagemDias + 1) >= 0 && parseFloat(value) == parseInt(9)) {
                        colorDiaTotal = "#DDDDDD"
                    }

                    tempContagemDias++;

                    tr += "<td style='background-color:" + colorDiaTotal + "'><h3>" + value + "</h3></td>"

                });
                tempContagemDias = 0;
                tr += "</tr>";

                tr += '<tr><td colspan="40"class="text-right"><h1>' + data.totais.totalGeral + ' HORAS</h1></td></tr>';

                $('.grid').html(tr);
            } else if (data.MSN) {

                mensagem('Erro', data.msnErro, '', '');
            } else {
                $('.grid').html("");
            }
        }
    }).done(function () {
        $('#table_principal').DataTable();
        $(".mask_float_hora").inputmask("([9][9].5|0)|(aaa)");
        // console.log(diasSexta);
        var countries = {
            GR1: "GR1",
            GR2: "GR2",
            GR3: "GR3",
            GR4: "GR4",
            GR5: "GR5"
        };

        var countriesArray = $.map(countries, function (value, key) {
            return {
                value: value,
                data: key
            };
        });

        $('.grs').autocomplete({
            lookup: countriesArray
        });

        proximoCampo = proximaData(ultimo_campo_update);


        $("[data-id='" + proximoCampo + "']").focus();
        diasMarcadosTotal = new Array();
        diasSexta = new Array();
    });

}
//
// function grid() {     $('#table_principal').DataTable().destroy();
//
//     $.ajax({
//         url: urlApp,
//         type: 'POST',
//         dataType: 'JSON',
//         data: {
//
//             action: 'LancarHora',
//             method: 'getAllData',
//             mesAno: $("#mesAno").val(),
//             id_funcionario: $("#id_funcionario").val()
//
//         }, success: function (data) {
//
//             tr = '';
//
//             if (data.count) {
//
//                 tr = '';
//                 id_linha = '';
//
//
//                 $.each(data.result, function (key, value) {
//
//                     campoTempo = '';
//
//                     if (value.ausencia) {
//                         campoTempo = value.ausencia;
//                     } else {
//                         campoTempo = value.tempo;
//                     }
//
//                     if (id_linha != value.id_tabela + '_' + value.id_tabela_complemento) {
//
//                         id_linha = value.id_tabela + '_' + value.id_tabela_complemento;
//
//                         tr += "</tr>";
//
//                         tr += '<tr><td>' + value.nomeCusto + '</td>';
//                     }
//
//                     id_input = value.data + '_' + value.id_funcionario + '_' + value.id_tabela + '_' + value.id_tabela_complemento;
//
//                     tr += "<td><input class='grs update' max-length='4' data-id='" + id_input + "'style='width:100%;text-align: center' value='" + campoTempo + "' type='text' placeholder='0'></td>";
//
//                 });
//
//                 tr += "<tr><td>TOTAIS</td>"
//                 $.each(data.totais.totalDias, function (key, value) {
//                     tr += "<td><h3>" + value + "</h3></td>"
//
//                 });
//                 tr += "</tr>";
//
//                 tr += '<tr><td colspan="40"class="text-right"><h1>' + data.totais.totalGeral + ' HORAS</h1></td></tr>';
//
//                 $('.grid').html(tr);
//             } else if (data.MSN) {
//
//                 mensagem('Erro', data.msnErro, '', '');
//             } else {
//                 $('.grid').html("");
//             }
//         }
//     }).done(function () {
//         $('#table_principal').DataTable();
//         $(".mask_float_hora").inputmask("([9][9].5|0)|(aaa)");
//
//         var countries = {
//             GR1: "GR1",
//             GR2: "GR2",
//             GR3: "GR3",
//             GR4: "GR4",
//             GR5: "GR5"
//         };
//         var countriesArray = $.map(countries, function (value, key) {
//             return {
//                 value: value,
//                 data: key
//             };
//         });
//
//         $('.grs').autocomplete({
//             lookup: countriesArray
//         });
//
//     });
//
// }


function create(formData) {
    // alert($("#id_aplicacao").val());
    formData.append('action', "LancarHora");

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


function importarDados(formData) {
    // alert($("#id_aplicacao").val());

    formData.append('action', "LancarHora");

    formData.append('method', "importarDados");

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
                grid();
            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
                grid();
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

function removeHoras(formData) {

    formData.append('action', "LancarHora");

    formData.append('method', "deleteHoras");

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

    formData.append('action', "LancarHora");

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
                grid();


            } else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
                grid();
            }


        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {


    });
}


function finalizar() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "LancarHora");

    formData.append('method', "finalizar");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            if (data.result) {

                mensagem('OK', 'Finalizado', 'success', '');

            }
            else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        grid();
    });

}


function aprovar() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "LancarHora");

    formData.append('method', "aprovar");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            if (data.result) {

                mensagem('OK', 'Aprovado', 'success', '');

            }
            else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        grid();
    });

}

function cancelar() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "LancarHora");

    formData.append('method', "cancelar");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            if (data.result) {

                mensagem('OK', 'Cancelado', 'success', '');

            }
            else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        grid();
    });

}

function desaprovar() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "LancarHora");

    formData.append('method', "desaprovar");

    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        success: function (data) {

            if (data.result) {

                mensagem('OK', 'Desaprovado', 'success', '');

            }
            else if (data.MSN) {
                mensagem('Erro', data.msnErro, '', '');
            }
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {
        grid();
    });

}


$("#form-principal").submit(function (e) {

    e.preventDefault();

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.get('id') ? update(formData) : create(formData);

});

$(document).on('change', "#id_tabela", function () {

    tipo = $("#id_tabela").val();

    if (tipo == 1) {
        loadSubContratos();
    } else if (tipo == 2) {
        loadPropostas();
    } else if (tipo == 3) {
        loadCentroCusto();
    } else if (tipo == 4) {
        loadFolga();
    }
});

$(document).on("change", ".loadGrid", function () {
    loadAplicacaoFuncionario();
    grid();
});


$(document).on("click", "#finalizar", function () {
    finalizar();
});

$(document).on("click", "#aprovar", function () {
    aprovar();
});

$(document).on("click", "#desaprovar", function () {
    desaprovar();
});

$(document).on("click", "#cancelar", function () {
    cancelar();
});

$(document).on("focus", "table input", function () {
    $(this).select();
})

$(document).on("click", "#importar", function () {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    importarDados(formData);
})

$(document).ready(function () {


    inicio();

    $(document).on("keyup", '.update', function (e) {

        ultimo_campo_update = $(this).data('id');

        if (e.keyCode == 13) {


            proximoCampo = proximaData(ultimo_campo_update);


            $("[data-id='" + proximoCampo + "']").focus();

        } else if (e.keyCode == 37) {

            anteriorCampo = anteriorData(ultimo_campo_update);


            $("[data-id='" + anteriorCampo + "']").focus();

        } else if (e.keyCode == 39) {


            proximoCampo = proximaData(ultimo_campo_update);


            $("[data-id='" + proximoCampo + "']").focus();

        }

    })

    $(document).on('click', '.add', function () {
        var formData = new FormData();

        formData = load_fields(formData, interact_fields);

        create(formData);
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

    $(document).on('click', '.removerHoras', function () {

        dataIdComp = $(this).data('idcompleto');

        if (confirm("Deseja remover?")) {


            var formData = new FormData();

            formData.append('idComp', dataIdComp);

            removeHoras(formData);
        }
    });

    $(document).on('change', '.update', function () {

        dataId = $(this).data('id');
        tempo = $(this).val();
        ultimo_campo_update = dataId;
        var formData = new FormData();

        formData = load_fields(formData, interact_fields);

        formData.append('identificador', dataId);

        formData.append('tempo', tempo);

        update(formData);
    })

})
