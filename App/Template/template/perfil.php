<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    Perfil de Usuário
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                    <div class="profile_img">
                        <div id="crop-avatar">
                            <!-- Current avatar -->
                            <img id='imagem' class="img-responsive avatar-view"
                                 src="" alt="FOTO"
                                 title="Adicione um foto">
                        </div>
                    </div>
                    <h3 id="funcionario"></h3>

                    <ul class="list-unstyled user_data">

                        <li>
                            <i class="fa fa-at user-profile-icon"></i> <span id="email"></span>
                        </li>


                    </ul>

                    <a class="btn senha btn-success"><i class="fa fa-key m-right-xs"></i></a>
                    <br/>


                </div>

                <input id='file' class='hide' type="file">
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
                <h4 class="modal-title" id="myModalLabel"> Senha </h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal form-label-left input_mask" id="form-principal" method='POST'
                      enctype="multipart/form-data">


                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <label>
                            Senha *
                        </label>
                        <input type="password" class="form-control has-feedback-left" id="senha"
                               placeholder="Senha">
                        <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <label>
                            Confirmar *
                        </label>
                        <input type="password" class="form-control has-feedback-left" id="confirmar"
                               placeholder="Senha">
                        <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
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
