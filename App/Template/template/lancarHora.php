<style>
    td:hover {
        background-color: darkgray;
    }
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

            <h2 class=" col-md-12 col-xs-12 col-sm-12"> Horas </h2>
            <div class="x_title">
                <div class="form-group col-md-4 col-xs-4 col-sm-4">
                    <label for="">Mês / Ano</label>
                    <input type="text" class="form-control mask_mes_ano loadGrid" id="mesAno"
                           placeholder="Data">
                </div>

                <div class="form-group col-md-4 col-xs-4 col-sm-4">
                    <label>Colaborador:</label>
                    <select class="select2_single form-control loadGrid" id="id_funcionario">
                    </select>
                </div>

                <div class="form-group col-md-4 col-xs-4 col-sm-4">
                    <label>Aplicação:</label>
                    <select class="select2_single form-control" id="id_aplicacao">
                    </select>
                </div>

                <div class="form-group  col-md-4 col-xs-4 col-sm-4">
                    <label>Tipo:</label>
                    <select class="select2_single form-control loadGrid" id="id_tabela">
                        <option value="0">Selecione</option>
                        <option value="1">Contrato</option>
                        <option value="2">Proposta</option>
                        <option value="3">Centro de Custos</option>
                        <option value="4">Folga</option>
                    </select>
                </div>

                <div class="form-group  col-md-4 col-xs-4 col-sm-4">
                    <label>Complemento:</label>
                    <select class="select2_single form-control loadGrid" id="id_tabela_complemento">
                    </select>
                </div>
                <div class="form-group  col-md-1 col-xs-1 col-sm-1">
                    <label>.</label>
                    <input  class="btn btn-success add  form-control" type="button" value="+">
                </div>
                <div class="form-group  col-md-3 col-xs-3 col-sm-3">
                    <label>.</label>
                    <input id='importar' class="btn btn-warning  form-control" type="button" value="Importar Mês Anterior">
                </div>



                <div class="clearfix"></div>
            </div>
<!--            <table class="table table-bordered">-->
            <table class="table-bordered">
                <h3 id="status"></h3>
                <thead>

                </thead>
                <tbody class="grid">

                </tbody>
            </table>
            <span id="legendas"></span>
        </div>
    </div>
</div>

<input class='btn btn-warning' id='finalizar' value='FINALIZAR MES' type="button">
<input class='btn btn-success' id='aprovar' value='APROVAR' type="button">
<input class='btn btn-danger' id='cancelar' value='CANCELAR' type="button">
<input class='btn btn-danger' id='desaprovar' value='DESAPROVAR' type="button">