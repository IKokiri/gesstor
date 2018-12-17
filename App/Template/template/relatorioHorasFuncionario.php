<style>
    td:hover {
        background-color: darkgray;
    }
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2 class="col-md-12"> Horas </h2>
                <div class="form-group col-md-1">
                    <label for="">Data</label>
                    <input type="text" class="form-control mask_mes_ano loadGrid" id="mesAno"
                           placeholder="Data">
                </div>

                <div class="form-group col-md-3">
                    <label>Colaborador:</label>
                    <select class="select2_single form-control loadGrid" id="id_funcionario">
                    </select>
                </div>

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
            <div class="form-group col-md-3">
                <label></label><br>
                <input type="button" class="btn btn-success" id='imprimir' value="Imprimir">
            </div>
            <div id="relatorio_horas">
                <div id="dadosFunc"></div>
                <table border="1" cellspacing='0' cellpadding='2' width="100%" class="grid">

                </table>
                <span id="legendas"></span>
            </div>


        </div>
    </div>
</div>