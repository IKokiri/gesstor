<style>
    .marcar:hover {
        background-color: #CCC;
    }
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2> Orçamentos </h2>
                <input type="button" id='teste' class="btn btn-success add pull-right" value="+">
                <input type="button" class="btn btn-info help pull-right" value="?">
                <div class="clearfix"></div>
                <select id="tipo_filtro">
                <option value="3">3</option>
                <option value="4">4</option>
                </select>
                <!-- <div id="gender" class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default" data-toggle-class="btn-primary"
                           data-toggle-passive-class="btn-default">
                        <input type="radio" class='pessoa_tipo filtro' id='tipo_filtro'
                               name="tipo_filtro"
                               value="3"
                               data-parsley-multiple="tipo_pessoa">3 Digitos
                    </label>
                    <label class="btn btn-primary" data-toggle-class="btn-primary"
                           data-toggle-passive-class="btn-default">
                        <input type="radio" class='pessoa_tipo filtro' id='tipo_filtro'
                               name="tipo_filtro"
                               value="4"
                               data-parsley-multiple="tipo_pessoa"> 4 Digitos
                    </label>
                </div> -->

                <div class="col-md-2">
                    <select class="select2_single form-control" id="data_filtro">
                    </select>
                </div>

            </div>
            <div class="x_content">
                <table id="table_principal"
                       class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Revisão</th>
                        <th>Funcionário</th>
                        <th>Mês Ano</th>
                        <th width="30%">Cliente</th>
                        <th>Final</th>
                        <th width="30%">Objeto</th>
                        <th>Representante</th>
                        <th>Observação</th>
                        <th>Orçamento</th>
                        <th>Visualizar</th>
                        <th>Alterar</th>
                    </tr>
                    </thead>
                    <tbody class='grid'>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Numero</th>
                        <th>Revisão</th>
                        <th>Funcionário</th>
                        <th>Mês Ano</th>
                        <th width="30%">Cliente</th>
                        <th>Final</th>
                        <th width="30%">Objeto</th>
                        <th>Representante</th>
                        <th>Observação</th>
                        <th>Orçamento</th>
                        <th>Visualizar</th>
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
                <h4 class="modal-title modal-principal-title" id="myModalLabel"> Orçamentos: <span id="nomeNumero"></span>.<span
                            id="nomeRevisao"></span>-<span id="nomeSigla"></span>-<span id="nomeMesAno"></span>-<span
                            id="nomeCliente"></span></h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal form-label-left input_mask form-group" id="form-principal" method='POST'
                      enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Tipo:</label><br>
                            <div id="gender" class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default" data-toggle-class="btn-primary"
                                       data-toggle-passive-class="btn-default">
                                    <input type="radio" class='pessoa_tipo' id='tipo'
                                           name="tipo"
                                           value="3"
                                           data-parsley-multiple="tipo_pessoa">3 Digitos
                                </label>
                                <label class="btn btn-primary" data-toggle-class="btn-primary"
                                       data-toggle-passive-class="btn-default">
                                    <input type="radio" class='pessoa_tipo' id='tipo'
                                           name="tipo"
                                           value="4"
                                           data-parsley-multiple="tipo_pessoa"> 4 Digitos
                                </label>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label>Revisão:</label>
                            <input type="text" class="form-control" value='0' id="revisao" maxlength="1" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-12 row">
                        <div class="col-md-6">
                            <label>Funcionário:</label>
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
                            <label for="">Data</label>
                            <input type="text" class="form-control mask_data" disabled id="data" placeholder="data">
                        </div>


                        <div class="col-md-6">
                            <label>Cliente Final:</label>
                            <select class="select2_single form-control" id="id_cliente_final">
                                <option value=""> SELECIONE</option>
                                <option value="adicionar_cliente"> ADICIONAR NOVO</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Objeto:</label>
                            <select class="select2_single form-control" id="id_objeto">
                                <option value=""> SELECIONE</option>
                                <option value="adicionar_objeto"> ADICIONAR NOVO</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Representante:</label>
                            <select class="select2_single form-control" id="id_representante">
                            </select>
                        </div>

                        <!--                        <div class="col-md-6">-->
                        <!--                            <label>Proposta de Venda:</label>-->
                        <!--                            <input type="text" class="form-control" id="proposta_venda"-->
                        <!--                                   placeholder="Proposta">-->
                        <!--                        </div>-->

                        <div class="col-md-6">
                            <label>Status Orçamento:</label>
                            <select class="select2_single form-control" id="id_status_orcamento">
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Observação:</label>
                            <input type="text" class="form-control" id="observacao"
                                   placeholder="Observação">
                        </div>

                        <div class="col-md-6">
                            <label>Nº Pedido do CLiente:</label>
                            <input type="text" class="form-control" id="numero_pedido"
                                   placeholder="Pedido">
                        </div>

                        <div class="checkbox col-md-6 col-sm-6 col-xs-12 form-group has-feedback">

                            <label>
                                <input type="checkbox" class="flat" id="status" checked="checked"> Ativado
                            </label>
                        </div>
                        <div class="checkbox col-md-6 col-sm-6 col-xs-12 form-group has-feedback">

                            <label>
                                <input type="checkbox" class="flat" id="addHoras" checked="checked"> Adicionar em horas
                            </label>
                        </div>
                    </div>
                    <input type="hidden" id="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary save">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal_visualizar" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title nomeVisual text-center " id="myModalLabel"></h4>
            </div>
            <div class="modal-body conteudo_visu">


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
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

<div class="modal fade modal_orcamento" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-orcamento-title modal-title" id="myModalLabel">Orçamento</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal form-label-left input_mask form-group" id="form-orcamento" method='POST'
                      enctype="multipart/form-data">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary save_orcamento">Salvar</button>
            </div>
        </div>
    </div>
</div>