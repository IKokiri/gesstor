<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Cliente</h2>
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
                        <th>Tipo</th>
                        <th>Cliente</th>
                        <th>CNPJ</th>
                        <th>Local</th>
                        <th>Serviços</th>
                        <th>Contatos</th>
                        <th>Status</th>
                        <th>Alterar</th>
                        <th>Deletar</th>
                    </tr>
                    </thead>
                    <tbody class='grid'>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Tipo</th>
                        <th>Cliente</th>
                        <th>CNPJ</th>
                        <th>Local</th>
                        <th>Serviços</th>
                        <th>Contatos</th>
                        <th>Status</th>
                        <th>Alterar</th>
                        <th>Deletar</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal_principal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Cliente</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal form-label-left" id="form-principal" method='POST' enctype="multipart/form-data">

                    <div id="wizard_verticle" class="form_wizard wizard_horizontal">
                        <ul class="wizard_steps">
                            <li>
                                <a href="#step-1">
                                    <span class="step_no">1</span>
                                    <span class="step_descr">
                                                             1<br/>
                                                            <small>Básico</small>
                                                        </span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-2">
                                    <span class="step_no">2</span>
                                    <span class="step_descr">
                                                            2<br/>
                                                            <small>Localização</small>
                                                        </span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-3">
                                    <span class="step_no">3</span>
                                    <span class="step_descr">
                                                            3<br/>
                                                            <small>Usuario</small>
                                                        </span>
                                </a>
                            </li>

                        </ul>
                        <div id="step-1">
                            <form class="form-horizontal form-label-left input_mask">

                                <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">

                                    <div id="gender" class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default" data-toggle-class="btn-primary"
                                               data-toggle-passive-class="btn-default">
                                            <input type="radio" class='pessoa_tipo' id='tipo_pessoa'
                                                   name="tipo_pessoa"
                                                   value="Física"
                                                   data-parsley-multiple="tipo_pessoa">Física
                                        </label>
                                        <label class="btn btn-primary" data-toggle-class="btn-primary"
                                               data-toggle-passive-class="btn-default">
                                            <input type="radio" class='pessoa_tipo' id='tipo_pessoa'
                                                   name="tipo_pessoa"
                                                   value="Jurídica"
                                                   data-parsley-multiple="tipo_pessoa"> Jurídica
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback fisica">
                                    <label>Nome:</label>
                                    <input type="text" class="form-control has-feedback-left" id="nome"
                                           placeholder="Nome">
                                    <span class="fa fa-user form-control-feedback left"
                                          aria-hidden="true"></span>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback fisica">
                                    <label>Sobrenome:</label>
                                    <input type="text" class="form-control has-feedback-left" id="sobrenome"
                                           placeholder="Sobrenome">
                                    <span class="fa fa-user form-control-feedback left"
                                          aria-hidden="true"></span>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback juridica">
                                    <label>Razão Social:</label>
                                    <input type="text" class="form-control has-feedback-left" id="razao_social"
                                           placeholder="Razão Social">
                                    <span class="fa fa-industry form-control-feedback left"
                                          aria-hidden="true"></span>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback juridica">
                                    <label>Fantasia:</label>
                                    <input type="text" class="form-control has-feedback-left" id="fantasia"
                                           placeholder="Fantasia">
                                    <span class="fa fa-industry form-control-feedback left"
                                          aria-hidden="true"></span>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback fisica">
                                    <label>RG:</label>
                                    <input type="text" class="form-control has-feedback-left" id="rg"
                                           placeholder="rg">
                                    <span class="fa fa-book form-control-feedback left"
                                          aria-hidden="true"></span>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback fisica">
                                    <label>CPF:</label>
                                    <input type="text" class="form-control has-feedback-left mask_cpf" id="cpf"
                                           placeholder="CPF">
                                    <span class="fa fa-credit-card form-control-feedback left"
                                          aria-hidden="true"></span>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback juridica">
                                    <label>IE:</label>
                                    <input type="text" class="form-control has-feedback-left" id="ie"
                                           placeholder="ie">
                                    <span class="fa fa-industry form-control-feedback left"
                                          aria-hidden="true"></span>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback juridica">
                                    <label>CNPJ:</label>
                                    <input type="text" class="form-control has-feedback-left mask_cnpj" id="cnpj"
                                           placeholder="CNPJ">
                                    <span class="fa fa-industry form-control-feedback left"
                                          aria-hidden="true"></span>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback juridica">
                                    <label>Nome Reduzido:</label>
                                    <input type="text" class="form-control has-feedback-left" id="nome_reduzido"
                                           placeholder="NOME REDUZIDO">
                                    <span class="fa fa-industry form-control-feedback left"
                                          aria-hidden="true"></span>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback juridica">
                                    <label>Numero Sapiens:</label>
                                    <input type="text" class="form-control has-feedback-left" id="numero_sapiens"
                                           placeholder="Numero Sapiens">
                                    <span class="fa fa-industry form-control-feedback left"
                                          aria-hidden="true"></span>
                                </div>
                                <div class="checkbox col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                    <label>
                                        <input type="checkbox" class="flat" id="status" checked="checked">
                                        Ativado
                                    </label>
                                </div>
                        </div>
                        <div id="step-2">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback row-fluid row">
                                <label>CEP:</label>
                                <input type="text" class="form-control has-feedback-left mask_cep" id="cep"
                                       placeholder="CEP">
                                <span class="fa fa-street-view form-control-feedback left"
                                      aria-hidden="true"></span>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid row">
                                <label>Rua:</label>
                                <input type="text" class="form-control has-feedback-left" id="rua"
                                       placeholder="Rua">
                                <span class="fa fa-street-view form-control-feedback left"
                                      aria-hidden="true"></span>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid row">
                                <label>Nº:</label>
                                <input type="text" class="form-control has-feedback-left" id="numero"
                                       placeholder="Nº">
                                <span class="fa fa-street-view form-control-feedback left"
                                      aria-hidden="true"></span>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid row">
                                <label>Bairro:</label>
                                <input type="text" class="form-control has-feedback-left" id="bairro"
                                       placeholder="Bairro">
                                <span class="fa fa-street-view form-control-feedback left"
                                      aria-hidden="true"></span>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid row">
                                <label>Cidade:</label>
                                <input type="text" class="form-control has-feedback-left" id="cidade"
                                       placeholder="Cidade">
                                <span class="fa fa-street-view form-control-feedback left"
                                      aria-hidden="true"></span>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid row">
                                <label>UF:</label>
                                <input type="text" class="form-control has-feedback-left" id="uf"
                                       placeholder="UF">
                                <span class="fa fa-street-view form-control-feedback left"
                                      aria-hidden="true"></span>
                            </div>
                        </div>
                        <div id="step-3">
                            <div class="col-md-6 col-sm-6 col-xs-6 form-group has-feedback row-fluid row">
                                <label>E-mail:</label>
                                <input type="text" class="form-control has-feedback-left" id="email"
                                       placeholder="E-Mail">
                                <span class="fa fa-street-view form-control-feedback left"
                                      aria-hidden="true"></span>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid row">
                                <label>Senha:</label>
                                <input type="password" class="form-control has-feedback-left" id="senha"
                                       placeholder="SENHA">
                                <span class="fa fa-street-view form-control-feedback left"
                                      aria-hidden="true"></span>
                            </div>
                        </div>

                    </div>

                    <input type="hidden" id="id">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal_servicos" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>

                <h4 class="modal-title" id="modalservicos">Adicionar Serviços</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left input_mask" id="form-servicos-cliente"
                      method='POST' enctype="multipart/form-data">

                    <div class="col-md-6">

                        <label>Serviço:</label>
                        <select class="select2_single form-control" id="id_servico">
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid row">
                        <label>Valor:</label>
                        <input type="text" class="form-control has-feedback-left mask_money" id="valor_servico"
                               placeholder="Valor">
                        <span class="fa fa-money form-control-feedback left"
                              aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid row">
                        <label>Dia Vencimento:</label>
                        <input type="text" class="form-control has-feedback-left mask_data" id="dia_vencimento"
                               placeholder="Dia Vencimento">
                        <span class="fa fa-calendar form-control-feedback left"
                              aria-hidden="true"></span>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid row">
                        <label>Identificador</label>:</label>
                        <input type="text" class="form-control has-feedback-left" id="identificador"
                               placeholder="Nome do dominio ou arte">
                        <span class="fa fa-archive form-control-feedback left"
                              aria-hidden="true"></span>
                    </div>

                    <div class="col-md-6">

                        <label>Tipo de Taxa:</label>
                        <select class="select2_single form-control" id="tipo_taxa">
                            <option value="mensal">Mensalidade</option>
                            <option value="unica">Unica</option>
                        </select>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid row">
                        <label>Qtde Meses</label>:</label>
                        <input type="text" class="form-control has-feedback-left" id="numero_meses"
                               placeholder="Qtde de meses contrato">
                        <span class="fa fa-archive form-control-feedback left"
                              aria-hidden="true"></span>
                    </div>
                    <input type="hidden" id="id_area">
                    <input type="hidden" id="id_servico_cliente">
                    <input type="hidden" id="area" value="C">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary save_servico_cliente">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal_servicos_area" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                </button>
                <span class="add_servico">
                            <a>
                                <i class="fa fa-plus">
                                </i>
                            </a>
                        </span>
                <h4 class="modal-title" id="modal_servicos_area">Serviços do Cliente</h4>
            </div>
            <div class="modal-body">
                <div class="servicos_do_cliente row">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal_contatos" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                </button>
                <span class="add_contato">
                            <a>
                                <i class="fa fa-plus">
                                </i>
                            </a>
                        </span>
                <h4 class="modal-title" id="modal_servicos_area">Contatos do Cliente</h4>
            </div>
            <div class="modal-body">
                <div class="contatos_html row">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal_add_contatos" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>

                <h4 class="modal-title">Adicionar Contato</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left input_mask" id="form-contatos"
                      method='POST' enctype="multipart/form-data">

                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid row">
                        <label>Nome:</label>
                        <input type="text" class="form-control has-feedback-left" id="nome_contato"
                               placeholder="Nome">
                        <span class="fa fa-user form-control-feedback left"
                              aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid row">
                        <label>Sobrenome:</label>
                        <input type="text" class="form-control has-feedback-left" id="sobrenome_contato"
                               placeholder="Sobrenome">
                        <span class="fa fa-user form-control-feedback left"
                              aria-hidden="true"></span>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid row">
                        <label>E-Mail</label>:
                        <input type="text" class="form-control has-feedback-left" id="email_contato"
                               placeholder="E-Mail">
                        <span class="fa fa-at form-control-feedback left"
                              aria-hidden="true"></span>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid row">
                        <label>Telefone</label>:
                        <input type="text" class="form-control has-feedback-left mask_celular" id="telefone_contato"
                               placeholder="Telefone">
                        <span class="fa fa-phone form-control-feedback left"
                              aria-hidden="true"></span>
                    </div>

                    <input type="hidden" id="id_area">
                    <input type="hidden" id="id_area_contato">
                    <input type="hidden" id="id_contato">
                    <input type="hidden" id="area" value="C">
                    <input type="hidden" id="search" value="">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary save_contato">Salvar</button>
            </div>
        </div>
    </div>
</div>
