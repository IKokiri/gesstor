<style>
    tr:hover {
        background-color: #DDD;
    }
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2> Apuração por Departamento </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div>

                    <div class="col-md-3 col-sm-3 col-xs-3 form-group has-feedback">
                        <label>
                            Mes / Ano
                        </label>

                        <input type="text" class="form-control has-feedback-left mask_data" id="data_inicio" value="01/01/2018">
                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>

                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-3 form-group has-feedback">

                        <label>
                            Mes / Ano
                        </label>

                        <input type="text" class="form-control has-feedback-left mask_data" id="data_fim" value="01/01/2019">
                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>

                    </div>


                    <div class="col-md-3 col-sm-3 col-xs-3 form-group has-feedback">

                        <div class="form-group">
                            <label>Centro Custo:</label>
                            <select class="select2_single form-control" id="id_centro_custo">
                            </select>
                        </div>

                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <br>
                        <input type="button" class="btn btn-success" id='gerar' value="Gerar">
                        <input type="button" class="btn btn-success" id='imprimir' value="Imprimir">
                    </div>
                </div>
            </div>
            
            <ol>
                <li>Horas de  Contratos e PROPOSTAS lançadas no 4053(SEMEC) são replicadas para o 4003(MANUT). </li>
            
            </ol>
            
            <div class="grid" id="imp_relatorio">
            

            </div>
        </div>
    </div>
</div>

