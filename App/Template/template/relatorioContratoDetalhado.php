<style>
    tr:hover {
        background-color: #DDD;
    }
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2> Apuração de Contratos </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div>

                    <div class="col-md-3 col-sm-3 col-xs-3 form-group has-feedback">
                        <label>
                            Inicio
                        </label>

                        <input type="text" class="form-control has-feedback-left mask_data" id="inicio" value="">
                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>

                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 form-group has-feedback">
                        <label>
                            Fim
                        </label>

                        <input type="text" class="form-control has-feedback-left mask_data" id="fim" value="">
                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>

                    </div>

<!--                    <div class="form-group col-md-2">-->
<!--                        <label>Tipo:</label>-->
<!--                        <select class="select2_single form-control loadGrid" id="id_tabela">-->
<!--                            <option value="1">Contrato</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!---->
<!--                    <div class="form-group col-md-2">-->
<!--                        <label>Complemento:</label>-->
<!--                        <select class="select2_single form-control loadGrid" id="id_tabela_complemento">-->
<!--                        </select>-->
<!--                    </div>-->

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