<style>
    tr:hover {
        background-color: #DDD;
    }
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2> Relatorio Aditivos </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div>
                    <div class="form-group col-md-3">

                        <label>Contrato:</label>

                        <select class="select2_single form-control loadGrid" id="id_contrato">
                        </select>

                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <br>
                        <input type="button" class="btn btn-success" id='gerar' value="Gerar">
                        <input type="button" class="btn btn-success" id='imprimir' value="Imprimir">
                    </div>
                </div>
            </div>
            <div id="relatorio_horas">
                <div>
                    <div class="titulo_relatorio" style="text-align: center">DEMONSTRATIVO <span
                                id="nome_contrato"></span> ADITIVOS
                    </div>
                </div>
                <div class="grid">

                </div>
            </div>
        </div>
    </div>
</div>

