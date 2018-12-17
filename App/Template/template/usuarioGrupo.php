<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2> Grupos </h2>
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
                        <th>Usuário</th>
                        <th>Grupo</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody class='grid'>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Usuário</th>
                        <th>Grupo</th>
                        <th>Status</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal_principal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> Usuário Grupo </h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal form-label-left input_mask" id="form-principal" method='POST'
                      enctype="multipart/form-data">

                    <div class="form-group col-md-4">
                        <label>Usuário:</label>
                        <select class="select2_single form-control" id="id_usuario">
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Grupo:</label>
                        <select class="select2_single form-control" id="id_grupo_senha">
                        </select>
                    </div>

                    <div class="checkbox col-md-6 col-sm-6 col-xs-12 form-group has-feedback">

                        <label>
                            <input type="checkbox" class="flat" id="status" checked="checked"> Ativado
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
