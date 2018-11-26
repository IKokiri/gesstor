<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2> Sub Contratos </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li class="add">
                        <a>
                            <i class="fa fa-plus">

                            </i>
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="table_principal"
                       class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>Divisao</th>
                        <th>Contrato</th>
                        <th>Funcionario</th>
                        <th>Objeto</th>
                        <th>Gerente</th>
                        <th>Responsável</th>
                        <th>Status</th>
                        <th>Alterar</th>
                    </tr>
                    </thead>
                    <tbody class='grid'>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Divisao</th>
                        <th>Contrato</th>
                        <th>Funcionario</th>
                        <th>Objeto</th>
                        <th>Gerente</th>
                        <th>Responsável</th>
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
                <h4 class="modal-title" id="myModalLabel"> Sub Contrato: <span id="nomeNumero"></span>.<span
                            id="nomeDivisao"></span>-<span id="nomeSigla"></span>-<span id="nomeMesAno"></span>
            </div>
            <div class="modal-body">

                <form class="form-horizontal form-label-left input_mask form-group" id="form-principal" method='POST'
                      enctype="multipart/form-data">

                    <div class="col-md-12">
                        <label>Contrato:</label>
                        <select class="select2_single form-control" id="id_contrato">
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Divisão:</label>
                        <input type="text" class="form-control" id="divisao"
                               maxlength="2" placeholder="Divisão">
                    </div>

                    <div class="col-md-6">
                        <label>Funcionário Contrato:</label>
                        <select class="select2_single form-control" id="id_funcionario">
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label>Objeto:</label>
                        <select class="select2_single form-control" id="id_objeto">
                            <option value=""> SELECIONE</option>
                            <option value="adicionar_objeto"> ADICIONAR NOVO</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Gerente:</label>
                        <select class="select2_single form-control" id="id_gerente">
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Responsável:</label>
                        <select class="select2_single form-control" id="id_responsavel">
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label>Observação:</label>
                        <input type="text" class="form-control" id="observacao" placeholder="Observação">
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