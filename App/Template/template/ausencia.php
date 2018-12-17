<div class="row">
    <div class="col-md-12 ">

        <div class="x_panel ">
            <div class="x_title">
                <h2>Ausência</h2>
                <ul class="nav navbar-right panel_toolbox">

                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content ">
                <form class="form-horizontal form-label-left input_mask" id="form-principal" method='POST'
                      enctype="multipart/form-data">
                    <div>
                        <div class="form-group col-md-4">
                            <label>Colaborador:</label>
                            <select class="select2_single form-control" id="id_colaborador">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Tipo:</label>
                            <select class="select2_single form-control" id="id_tipo">
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Telefone</label>
                            <input type="text" class="form-control" id="telefone"
                                   placeholder="Telefone">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Telefone</label>
                            <input type="text" class="form-control" id="telefone_2"
                                   placeholder="Telefone 2">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Representante:</label>
                            <select class="select2_single form-control" id="id_representante">
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Representante 2:</label>
                            <select class="select2_single form-control" id="id_representante_2">
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Empresa</label>
                            <input type="text" class="form-control" id="empresa"
                                   placeholder="Empresa">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Local</label>
                            <input type="text" class="form-control" id="ausencia_local"
                                   placeholder="Local">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="">Do Dia</label>
                            <input type="text" class="form-control mask_data" id="ausencia_de"
                                   placeholder="De">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="">Hora</label>
                            <input type="text" class="form-control mask_hora" id="ausencia_hora"
                                   placeholder="Hora">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Retorno</label>
                            <input type="text" class="form-control mask_data" id="retorno_de"
                                   placeholder="Retorno">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="">Hora</label>
                            <input type="text" class="form-control mask_hora" id="retorno_hora"
                                   placeholder="Hora">
                        </div>
                        <div class="checkbox col-md-1 form-group has-feedback">
                            <label>&nbsp</label>
                                <input type="checkbox" class="flat form-control" id="status" checked="checked"> Ativado

                        </div>
                        <div class="form-group col-md-1">
                            <label for="">&nbsp;</label>
                            <input type="submit" class='btn btn-success form-control' value="+">
                        </div>
                    </div>
                    <div class="row col-md-12 contatos_html">


                        <div class="clearfix"></div>


                    </div>
                    <input type="hidden" id="id">
                </form>
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

            <div class="x_content">
                <table id="table_principal"
                       class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Colaborador</th>
                        <th>Telefones</th>
                        <th>Representantes</th>
                        <th>Empresa</th>
                        <th>Do Dia</th>
                        <th>Até o Dia</th>
                        <th>status</th>
                    </tr>
                    </thead>
                    <tbody class='grid'>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Tipo</th>
                        <th>Colaborador</th>
                        <th>Telefones</th>
                        <th>Representantes</th>
                        <th>Empresa</th>
                        <th>Do Dia</th>
                        <th>Até o Dia</th>
                        <th>status</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>