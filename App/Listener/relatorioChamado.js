urlApp = 'App.php'

interact_fields = {};

interact_fields['id'] = '';
interact_fields['id_servico_cliente'] = '';
interact_fields['descricao'] = '';
interact_fields['assunto'] = '';
interact_fields['data_inicio'] = '';
interact_fields['data_fim'] = '';
interact_fields['file'] = '';

interact_fields_status = {};
interact_fields_status['id'] = '';
interact_fields_status['status'] = '';


function inicio() {
    load_status();
}


function load_status() {

    var formData = new FormData();

    formData = load_fields(formData, interact_fields);

    formData.append('action', "ChamadoCliente");

    formData.append('method', "getAllFilter");

    $.ajax({
            url: urlApp,
            type: 'POST',
            dataType: 'JSON',
            data: formData,
            success: function (data) {

                if (data.result) {

                    status = '';

                    total = 0;

                    aberto = 0;
                    corabe = "#FFFFFF";
                    emanalise = 0;
                    corema = "#FFFFFF";
                    reaberto = 0;
                    correa = "#FFFFFF";
                    finalizado = 0;
                    corfin = "#FFFFFF";
                    respondido = 0;
                    corres = "#FFFFFF";

                    if (data.count == 0) {

                    } else {

                        $.each(data.result, function (key, value) {
                            // status += '<button data-id="' + value.id + '" type="button" class="btn btn-default button_status" style="background: ' + value.cor + '">' + value.status + '</button>';
                            status += value.assunto + "<br>";

                            total++;

                            if (value.descricao_status == "ABERTO") {
                                aberto++;
                                corabe = value.cor;
                            } else if (value.descricao_status == "EM ANÁLISE") {
                                emanalise++;
                                corema = value.cor;
                            } else if (value.descricao_status == "REABERTO") {
                                reaberto++;
                                correa = value.cor;
                            } else if (value.descricao_status == "FINALIZADO") {
                                finalizado++;
                                corfin = value.cor;
                            } else if (value.descricao_status == "RESPONDIDO") {
                                respondido++;
                                corres = value.cor;
                            }

                        });
                    }

                    $(".status_disponiveis").html(
                        '<h3 >NUMERO DE CHAMADOS:</h3><h1>' + total + '</h1><br>' +
                        '<hr>' +
                        '<h3 >' +
                        '<div class="col-md-1"></div>' +
                        '<div class="col-md-2" style=background-color:black;color:'+corabe+'>ABERTOS: ' + aberto + '</div>' +
                        '<div class="col-md-2" style=background-color:black;color:'+corema+'>EM ANALISE: ' + emanalise + '</div>' +
                        '<div class="col-md-2" style=background-color:black;color:'+correa+'>REABERTOS: ' + reaberto + '</div>' +
                        '<div class="col-md-2" style=background-color:black;color:'+corfin+'>FINALIZADOS: ' + finalizado + '</div>' +
                        '<div class="col-md-2" style=background-color:black;color:'+corres+'>RESPONDIDOS: ' + respondido + '</div></h3>');

                    var theme = {
                        color: [
                            corabe, corema, correa, corfin,
                            corres, '#8abb6f', '#759c6a', '#bfd3b7'
                        ],

                        title: {
                            itemGap: 8,
                            textStyle: {
                                fontWeight: 'normal',
                                color: '#408829'
                            }
                        },

                        dataRange: {
                            color: ['#1f610a', '#97b58d']
                        },

                        toolbox: {
                            color: ['#408829', '#408829', '#408829', '#408829']
                        },

                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.5)',
                            axisPointer: {
                                type: 'line',
                                lineStyle: {
                                    color: '#408829',
                                    type: 'dashed'
                                },
                                crossStyle: {
                                    color: '#408829'
                                },
                                shadowStyle: {
                                    color: 'rgba(200,200,200,0.3)'
                                }
                            }
                        },

                        dataZoom: {
                            dataBackgroundColor: '#eee',
                            fillerColor: 'rgba(64,136,41,0.2)',
                            handleColor: '#408829'
                        },
                        grid: {
                            borderWidth: 0
                        },

                        categoryAxis: {
                            axisLine: {
                                lineStyle: {
                                    color: '#408829'
                                }
                            },
                            splitLine: {
                                lineStyle: {
                                    color: ['#eee']
                                }
                            }
                        },

                        valueAxis: {
                            axisLine: {
                                lineStyle: {
                                    color: '#408829'
                                }
                            },
                            splitArea: {
                                show: true,
                                areaStyle: {
                                    color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
                                }
                            },
                            splitLine: {
                                lineStyle: {
                                    color: ['#eee']
                                }
                            }
                        },
                        timeline: {
                            lineStyle: {
                                color: '#408829'
                            },
                            controlStyle: {
                                normal: {color: '#408829'},
                                emphasis: {color: '#408829'}
                            }
                        },

                        k: {
                            itemStyle: {
                                normal: {
                                    color: '#68a54a',
                                    color0: '#a9cba2',
                                    lineStyle: {
                                        width: 1,
                                        color: '#408829',
                                        color0: '#86b379'
                                    }
                                }
                            }
                        },
                        map: {
                            itemStyle: {
                                normal: {
                                    areaStyle: {
                                        color: '#ddd'
                                    },
                                    label: {
                                        textStyle: {
                                            color: '#c12e34'
                                        }
                                    }
                                },
                                emphasis: {
                                    areaStyle: {
                                        color: '#99d2dd'
                                    },
                                    label: {
                                        textStyle: {
                                            color: '#c12e34'
                                        }
                                    }
                                }
                            }
                        },
                        force: {
                            itemStyle: {
                                normal: {
                                    linkStyle: {
                                        strokeColor: '#408829'
                                    }
                                }
                            }
                        },
                        chord: {
                            padding: 4,
                            itemStyle: {
                                normal: {
                                    lineStyle: {
                                        width: 1,
                                        color: 'rgba(128, 128, 128, 0.5)'
                                    },
                                    chordStyle: {
                                        lineStyle: {
                                            width: 1,
                                            color: 'rgba(128, 128, 128, 0.5)'
                                        }
                                    }
                                },
                                emphasis: {
                                    lineStyle: {
                                        width: 1,
                                        color: 'rgba(128, 128, 128, 0.5)'
                                    },
                                    chordStyle: {
                                        lineStyle: {
                                            width: 1,
                                            color: 'rgba(128, 128, 128, 0.5)'
                                        }
                                    }
                                }
                            }
                        },
                        textStyle: {
                            fontFamily: 'Arial, Verdana, sans-serif'
                        }
                    };

                    var echartDonut = echarts.init(document.getElementById('echart_donut'), theme);

                    echartDonut.setOption({
                        tooltip: {
                            trigger: 'item',
                            formatter: "{a} <br/>{b} : {c} ({d}%)"
                        },
                        calculable: true,
                        legend: {
                            x: 'center',
                            y: 'bottom',
                            data: ['Abertos1', 'Em Analise1', 'Reabertos1', 'Finalizados1', 'Respondidos1']
                        },
                        toolbox: {
                            show: true,
                            feature: {
                                magicType: {
                                    show: true,
                                    type: ['pie', 'funnel'],
                                    option: {
                                        funnel: {
                                            x: '25%',
                                            width: '50%',
                                            funnelAlign: 'center',
                                            max: 1548
                                        }
                                    }
                                },
                                restore: {
                                    show: false,
                                    title: "Restore"
                                },
                                saveAsImage: {
                                    show: false,
                                    title: "Save Image"
                                }
                            }
                        },
                        series: [{
                            name: 'Dados',
                            type: 'pie',
                            radius: ['35%', '90%'],
                            itemStyle: {
                                normal: {
                                    label: {
                                        show: true
                                    },
                                    labelLine: {
                                        show: true
                                    }
                                },
                                emphasis: {
                                    label: {
                                        show: true,
                                        position: 'center',
                                        textStyle: {
                                            fontSize: '30',
                                            fontWeight: 'bold'
                                        }
                                    }
                                }
                            },
                            data: [{
                                value: aberto,
                                name: 'Abertos'
                            }, {
                                value: emanalise,
                                name: 'Em Analise'
                            }, {
                                value: reaberto,
                                name: 'Reabertos'
                            }, {
                                value: finalizado,
                                name: 'Finalizados'
                            }, {
                                value: respondido,
                                name: 'Respondidos'
                            }]
                        }]
                    });

                } else if (data.MSN) {
                    mensagem('Erro', data.msnErro, '', '');
                }
            },
            processData: false,
            cache: false,
            contentType: false
        }
    ).done(function () {
        $("canvas").css("background-color","rgba(10,10,10,0.9)");
    });

}

$(document).ready(function () {




    $(document).on('click', '#buscar', function () {

        load_status();

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


})
