<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2> Contratos </h2>
                <div class="form-group  pull-right col-md-1 col-xs-1 col-sm-1">
                    <!--                        <label>.</label>-->
                    <input class="btn btn-success add  form-control" type="button" value="+">
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!--                <div>-->
                <!--                    <div class="checkbox col-md-3 col-sm-3 col-xs-3 form-group has-feedback">-->
                <!--                        <label>-->
                <!--                            <input type="radio" value='1' class="serie_busca" name="serie_busca"> 1.000-->
                <!--                        </label>-->
                <!--                        <label>-->
                <!--                            <input type="radio" value='60' class="serie_busca" name="serie_busca"> 60.000-->
                <!--                        </label>-->
                <!--                    </div>-->
                <!---->
                <!--                </div>-->

                <table id="table_principal"
                       class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>Contrato</th>
                        <th>Cliente</th>
                        <th>Objeto</th>
                        <th>Data Fim</th>
                        <!--                        <th>Gerente</th>-->
                        <!--                        <th>Responsável</th>-->
                        <th>Data Inicio</th>
                        <th>Proposta</th>
                        <th>Série</th>
                        <th>Status</th>
                        <th>Alterar</th>
                    </tr>
                    </thead>
                    <tbody class='grid'>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Contrato</th>
                        <th>Cliente</th>
                        <th>Objeto</th>
                        <th>Data Fim</th>
                        <!--                        <th>Gerente</th>-->
                        <!--                        <th>Responsável</th>-->
                        <th>Data Inicio</th>
                        <th>Proposta</th>
                        <th>Série</th>
                        <th>Status</th>
                        <th>Alterar</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal_principal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> Contrato: <span id="nomeNumero"></span>.<span
                            id="nomeDivisao"></span>-<span id="nomeSigla"></span>-<span id="nomeMesAno"></span>
            </div>
            <div class="modal-body">

                <form class="form-horizontal form-label-left input_mask form-group" id="form-principal" method='POST'
                      enctype="multipart/form-data">

                    <div class="col-md-12">
                        <div id="gender" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default" data-toggle-class="btn-primary"
                                   data-toggle-passive-class="btn-default">
                                <input type="radio" class='pessoa_tipo' id='tipo'
                                       name="tipo"
                                       value="1"
                                       data-parsley-multiple="tipo_pessoa">Série 1.000
                            </label>
                            <label class="btn btn-primary" data-toggle-class="btn-primary"
                                   data-toggle-passive-class="btn-default">
                                <input type="radio" class='pessoa_tipo' id='tipo'
                                       name="tipo"
                                       value="60"
                                       data-parsley-multiple="tipo_pessoa"> Série 60.000
                            </label>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <label>Divisão:</label>
                        <input type="text" class="form-control" id="divisao"
                               maxlength="2" value='00' placeholder="Divisão">
                    </div>

                    <div class="col-md-6">
                        <label>Funcionário Contrato:</label>
                        <select class="select2_single form-control" id="id_funcionario">
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Cliente:</label>
                        <select class="select2_single form-control" id="id_cliente">
                            <option value=""> SELECIONE</option>
                            <option value="adicionar_cliente"> ADICIONAR NOVO</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Objeto:</label>
                        <select class="select2_single form-control" id="id_objeto">
                        </select>
                    </div>


                    <div class="col-md-4">
                        <label for="">Data Inicio</label>
                        <input type="text" class="form-control mask_data" id="data_inicio">
                    </div>
                    <div class="col-md-4">
                        <label for="">Data Contrato</label>
                        <input type="text" class="form-control mask_data" id="data_contrato">
                    </div>
                    <div class="col-md-4">
                        <label for="">Data Fim</label>
                        <input type="text" class="form-control mask_data" id="data_fim">
                    </div>
                    <div class="col-md-12">
                        <label>Proposta:</label>
                        <select class="select2_single form-control" id="id_proposta">
                        </select>
                    </div>
                    <!--                    <div class="col-md-6">-->
                    <!--                        <label>Gerente:</label>-->
                    <!--                        <select class="select2_single form-control" id="id_gerente">-->
                    <!--                        </select>-->
                    <!--                    </div>-->
                    <!---->
                    <!--                    <div class="col-md-6">-->
                    <!--                        <label>Responsável:</label>-->
                    <!--                        <select class="select2_single form-control" id="id_responsavel">-->
                    <!--                        </select>-->
                    <!--                    </div>-->
                    <div class="col-md-12">
                        <label for="">Observação</label>
                        <input type="text" class="form-control" id="observacao">
                    </div>
                    <input type="hidden" id="id">
                    <div class="checkbox col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <label>
                            <input type="checkbox" class="flat" id="status" checked="checked"> Ativado
                        </label>
                    </div>
                    <div class="checkbox col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <label>
                            <input type="checkbox" class="flat" id="addHoras" checked="checked"> Adicionar Em Horas
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary save">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal_cliente" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> Cliente </h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal form-label-left input_mask" id="form-cliente" method='POST'
                      enctype="multipart/form-data">

                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <label>
                            Razão Social
                        </label>

                        <input type="text" class="form-control has-feedback-left" id="razao_social"
                               placeholder="Razão Social">
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 form-group has-feedback">
                        <label>
                            Nome Reduzido
                        </label>

                        <input type="text" class="form-control has-feedback-left" id="nome_reduzido"
                               placeholder="Nome Reduzido">
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 form-group has-feedback">
                        <label>
                            CNPJ
                        </label>

                        <input type="text" class="form-control has-feedback-left mask_cnpj" id="cnpj">
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <input type="hidden" id="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary save_cliente">Salvar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal_objeto" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> Objeto </h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal form-label-left input_mask" id="form-objeto" method='POST'
                      enctype="multipart/form-data">

                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <label>
                            Objeto
                        </label>

                        <input type="text" class="form-control has-feedback-left" id="objeto"
                               placeholder="Objeto">
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 form-group has-feedback">
                        <label>
                            Complemento
                        </label>

                        <input type="text" class="form-control has-feedback-left" id="complemento"
                               placeholder="Complemento">
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary save_objeto">Salvar</button>
            </div>
        </div>
    </div>
</div>