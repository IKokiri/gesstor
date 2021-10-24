<style>
    tr:hover {
        background-color: #DDD;
    }
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2> Apuração de horas trabalhadas </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div>

                    <div class="col-md-4 col-sm-4 col-xs-4 form-group has-feedback">
                        <label>
                            Mes / Ano
                        </label>

                        <input type="text" class="form-control has-feedback-left mask_mes_ano" id="data">
                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>

                    </div>


                    <div class="col-md-4 col-sm-4 col-xs-4 form-group has-feedback">

                        <div class="form-group col-md-4">
                            <label>Centro Custo:</label>
                            <select class="select2_single form-control" id="id_centro_custo">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4 form-group has-feedback">

                        <div class="form-group col-md-4">
                            <label>Valor:</label>

                            <div id="valorHora"></div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
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

