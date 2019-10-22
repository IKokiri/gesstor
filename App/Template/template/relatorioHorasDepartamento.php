<style>
    tr:hover{
        background-color: #AAAAAA;
    }
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2> Relátorio de Horas Por Departamento </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div>

                    <div class="col-md-4 col-sm-4 col-xs-4 form-group has-feedback">
                        <label>
                            Início
                        </label>

                        <input type="text" class="form-control has-feedback-left mask_data" id="data_inicio">
                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>

                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-4 form-group has-feedback">
                        <label>
                            Fim
                        </label>

                        <input type="text" class="form-control has-feedback-left mask_data" id="data_fim">
                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-3 form-group has-feedback">
                        <div class="form-group">
                            <label>Contrato / Proposta:</label>
                            <select class="select2_single form-control" id="id_tipo">
                                <option value="0">Todos</option>
                                <option value="1">Contrato</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-3 form-group has-feedback class_contrato">
                        <div class="form-group">
                            <label>Contrato:</label>
                            <select class="select2_single form-control" id="id_contrato">
                            </select>
                        </div>
                    </div>   

                    <div class="col-md-4 col-sm-4 col-xs-4 form-group has-feedback">
                        <br>
                        <input type="button" class="btn btn-success" id='gerar' value="Gerar">
                        <input type="button" class="btn btn-success" id='imprimir' value="Imprimir">
                    </div>
                </div>
            </div>
            <div class="grid">

            </div>
        </div>
    </div>
</div>

