<style>
    tr:hover {
        background-color: #DDD;
    }
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2> Relatório Acumulado </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div>

                    <div class="col-md-3 col-sm-3 col-xs-3 form-group has-feedback">
                        <label>
                            Mes / Ano
                        </label>

                        <input type="text" class="form-control has-feedback-left mask_data" id="data_inicio">
                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>

                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-3 form-group has-feedback">

                        <label>
                            Mes / Ano
                        </label>

                        <input type="text" class="form-control has-feedback-left mask_data" id="data_fim">
                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>

                    </div>


                    <div class="col-md-3 col-sm-3 col-xs-3 form-group has-feedback">

                        <div class="form-group">
                            <label>Contrato / Proposta:</label>
                            <select class="select2_single form-control" id="id_tipo">
                                <option value="">Todos</option>
                                <option value="1">Contrato</option>
                                <option value="2">Propostas</option>
                            </select>
                        </div>

                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <br>
                        <input type="button" class="btn btn-success" id='gerar' value="Gerar">
                        <input type="button" class="btn btn-success" id='imprimir' value="Imprimir">
                        <input type="button" class="btn btn-success" id='ocCampos' value="OC">
                    </div>
                </div>
            </div>
            
            <div class="grid" id="imp_relatorio">
            

            </div>
        </div>
    </div>
</div>


