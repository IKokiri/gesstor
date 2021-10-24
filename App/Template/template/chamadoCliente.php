<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Chamado</h2>
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
                        <th>Servico</th>
                        <th>Assunto</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Status</th>
                        <th>Ver</th>
                    </tr>
                    </thead>
                    <tbody class='grid'>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Servico</th>
                        <th>Assunto</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Status</th>
                        <th>Ver</th>

                    </tr>
                </table>
            </div>
        </div>
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
                <h4 class="modal-title" id="myModalLabel">Chamado</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal form-label-left input_mask" id="form-principal" method='POST'
                      enctype="multipart/form-data">
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid">
                        <label>Serviço:</label>
                        <select class="select2_single form-control" id="id_servico_cliente">
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid">
                        <label>Assunto:</label>
                        <input type="text" class="form-control has-feedback-left" id="assunto"
                               placeholder="Assunto">
                        <span class="fa fa-send form-control-feedback left"
                              aria-hidden="true"></span>
                    </div>
                    <div class="x_content">
                        <div id="alerts"></div>
                        <div class="btn-toolbar editor" data-role="editor-toolbar"
                             data-target="#editor">
                            <div class="btn-group">
                                <a data-original-title="Font" class="btn dropdown-toggle"
                                   data-toggle="dropdown" title=""><i class="fa fa-font"></i><b
                                        class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a data-edit="fontName Serif"
                                           style="font-family:'Serif'">Serif</a></li>
                                    <li><a data-edit="fontName Sans" style="font-family:'Sans'">Sans</a>
                                    </li>
                                    <li><a data-edit="fontName Arial"
                                           style="font-family:'Arial'">Arial</a></li>
                                    <li><a data-edit="fontName Arial Black"
                                           style="font-family:'Arial Black'">Arial Black</a>
                                    </li>
                                    <li><a data-edit="fontName Courier"
                                           style="font-family:'Courier'">Courier</a></li>
                                    <li><a data-edit="fontName Courier New"
                                           style="font-family:'Courier New'">Courier New</a>
                                    </li>
                                    <li><a data-edit="fontName Comic Sans MS"
                                           style="font-family:'Comic Sans MS'">Comic Sans MS</a>
                                    </li>
                                    <li><a data-edit="fontName Helvetica"
                                           style="font-family:'Helvetica'">Helvetica</a></li>
                                    <li><a data-edit="fontName Impact"
                                           style="font-family:'Impact'">Impact</a></li>
                                    <li><a data-edit="fontName Lucida Grande"
                                           style="font-family:'Lucida Grande'">Lucida Grande</a>
                                    </li>
                                    <li><a data-edit="fontName Lucida Sans"
                                           style="font-family:'Lucida Sans'">Lucida Sans</a>
                                    </li>
                                    <li><a data-edit="fontName Tahoma"
                                           style="font-family:'Tahoma'">Tahoma</a></li>
                                    <li><a data-edit="fontName Times"
                                           style="font-family:'Times'">Times</a></li>
                                    <li><a data-edit="fontName Times New Roman"
                                           style="font-family:'Times New Roman'">Times New
                                            Roman</a></li>
                                    <li><a data-edit="fontName Verdana"
                                           style="font-family:'Verdana'">Verdana</a></li>
                                </ul>
                            </div>

                            <div class="btn-group">
                                <a data-original-title="Font Size" class="btn dropdown-toggle"
                                   data-toggle="dropdown" title=""><i
                                        class="fa fa-text-height"></i>&nbsp;<b
                                        class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a data-edit="fontSize 5">
                                            <p style="font-size:17px">Huge</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-edit="fontSize 3">
                                            <p style="font-size:14px">Normal</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-edit="fontSize 1">
                                            <p style="font-size:11px">Small</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="btn-group">
                                <a data-original-title="Bold (Ctrl/Cmd+B)" class="btn"
                                   data-edit="bold" title=""><i class="fa fa-bold"></i></a>
                                <a data-original-title="Italic (Ctrl/Cmd+I)" class="btn"
                                   data-edit="italic" title=""><i class="fa fa-italic"></i></a>
                                <a data-original-title="Strikethrough" class="btn"
                                   data-edit="strikethrough" title=""><i
                                        class="fa fa-strikethrough"></i></a>
                                <a data-original-title="Underline (Ctrl/Cmd+U)" class="btn"
                                   data-edit="underline" title=""><i
                                        class="fa fa-underline"></i></a>
                            </div>

                            <div class="btn-group">
                                <a data-original-title="Bullet list" class="btn"
                                   data-edit="insertunorderedlist" title=""><i
                                        class="fa fa-list-ul"></i></a>
                                <a data-original-title="Number list" class="btn"
                                   data-edit="insertorderedlist" title=""><i
                                        class="fa fa-list-ol"></i></a>
                                <a data-original-title="Reduce indent (Shift+Tab)" class="btn"
                                   data-edit="outdent" title=""><i class="fa fa-dedent"></i></a>
                                <a data-original-title="Indent (Tab)" class="btn"
                                   data-edit="indent" title=""><i class="fa fa-indent"></i></a>
                            </div>

                            <div class="btn-group">
                                <a data-original-title="Align Left (Ctrl/Cmd+L)"
                                   class="btn btn-info" data-edit="justifyleft" title=""><i
                                        class="fa fa-align-left"></i></a>
                                <a data-original-title="Center (Ctrl/Cmd+E)" class="btn"
                                   data-edit="justifycenter" title=""><i
                                        class="fa fa-align-center"></i></a>
                                <a data-original-title="Align Right (Ctrl/Cmd+R)" class="btn"
                                   data-edit="justifyright" title=""><i
                                        class="fa fa-align-right"></i></a>
                                <a data-original-title="Justify (Ctrl/Cmd+J)" class="btn"
                                   data-edit="justifyfull" title=""><i
                                        class="fa fa-align-justify"></i></a>
                            </div>

                            <div class="btn-group">
                                <a data-original-title="Hyperlink" class="btn dropdown-toggle"
                                   data-toggle="dropdown" title=""><i
                                        class="fa fa-link"></i></a>
                                <div class="dropdown-menu input-append">
                                    <input class="span2" placeholder="URL"
                                           data-edit="createLink" type="text">
                                    <button class="btn" type="button">Add</button>
                                </div>
                                <a data-original-title="Remove Hyperlink" class="btn"
                                   data-edit="unlink" title=""><i class="fa fa-cut"></i></a>
                            </div>

                            <div class="btn-group">
                                <a data-original-title="Insert picture (or just drag &amp; drop)"
                                   class="btn" title="" id="pictureBtn"><i
                                        class="fa fa-picture-o"></i></a>
                                <input
                                    style="opacity: 0; position: absolute; top: 0px; left: 0px; width: 41px; height: 34px;"
                                    data-role="magic-overlay" data-target="#pictureBtn"
                                    data-edit="insertImage" type="file">
                            </div>

                            <div class="btn-group">
                                <a data-original-title="Undo (Ctrl/Cmd+Z)" class="btn"
                                   data-edit="undo" title=""><i class="fa fa-undo"></i></a>
                                <a data-original-title="Redo (Ctrl/Cmd+Y)" class="btn"
                                   data-edit="redo" title=""><i class="fa fa-repeat"></i></a>
                            </div>
                        </div>

                        <div id="descricao" data-type='innerhtml' class="editor-wrapper placeholderText"
                             contenteditable="true"></div>

                        <textarea name="descricao" id="descricao" style="display:none;"></textarea>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid">
                        <label>Anexo:</label>
                        <input type="file" id="file">
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
<div class="modal fade modal_ver_chamado" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title assunto_chamado" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal form-label-left input_mask" id="form-ver-chamado" method='POST'
                      enctype="multipart/form-data">
                    <div class="descricoes">

                    </div>

                    <div>
                        <div class="x_content">
                            <div id="alerts"></div>
                            <div class="btn-toolbar editor" data-role="editor-toolbar"
                                 data-target="#editor">
                                <div class="btn-group">
                                    <a data-original-title="Font" class="btn dropdown-toggle"
                                       data-toggle="dropdown" title=""><i class="fa fa-font"></i><b
                                            class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a data-edit="fontName Serif"
                                               style="font-family:'Serif'">Serif</a></li>
                                        <li><a data-edit="fontName Sans" style="font-family:'Sans'">Sans</a>
                                        </li>
                                        <li><a data-edit="fontName Arial"
                                               style="font-family:'Arial'">Arial</a></li>
                                        <li><a data-edit="fontName Arial Black"
                                               style="font-family:'Arial Black'">Arial Black</a>
                                        </li>
                                        <li><a data-edit="fontName Courier"
                                               style="font-family:'Courier'">Courier</a></li>
                                        <li><a data-edit="fontName Courier New"
                                               style="font-family:'Courier New'">Courier New</a>
                                        </li>
                                        <li><a data-edit="fontName Comic Sans MS"
                                               style="font-family:'Comic Sans MS'">Comic Sans MS</a>
                                        </li>
                                        <li><a data-edit="fontName Helvetica"
                                               style="font-family:'Helvetica'">Helvetica</a></li>
                                        <li><a data-edit="fontName Impact"
                                               style="font-family:'Impact'">Impact</a></li>
                                        <li><a data-edit="fontName Lucida Grande"
                                               style="font-family:'Lucida Grande'">Lucida Grande</a>
                                        </li>
                                        <li><a data-edit="fontName Lucida Sans"
                                               style="font-family:'Lucida Sans'">Lucida Sans</a>
                                        </li>
                                        <li><a data-edit="fontName Tahoma"
                                               style="font-family:'Tahoma'">Tahoma</a></li>
                                        <li><a data-edit="fontName Times"
                                               style="font-family:'Times'">Times</a></li>
                                        <li><a data-edit="fontName Times New Roman"
                                               style="font-family:'Times New Roman'">Times New
                                                Roman</a></li>
                                        <li><a data-edit="fontName Verdana"
                                               style="font-family:'Verdana'">Verdana</a></li>
                                    </ul>
                                </div>

                                <div class="btn-group">
                                    <a data-original-title="Font Size" class="btn dropdown-toggle"
                                       data-toggle="dropdown" title=""><i
                                            class="fa fa-text-height"></i>&nbsp;<b
                                            class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a data-edit="fontSize 5">
                                                <p style="font-size:17px">Huge</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-edit="fontSize 3">
                                                <p style="font-size:14px">Normal</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-edit="fontSize 1">
                                                <p style="font-size:11px">Small</p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="btn-group">
                                    <a data-original-title="Bold (Ctrl/Cmd+B)" class="btn"
                                       data-edit="bold" title=""><i class="fa fa-bold"></i></a>
                                    <a data-original-title="Italic (Ctrl/Cmd+I)" class="btn"
                                       data-edit="italic" title=""><i class="fa fa-italic"></i></a>
                                    <a data-original-title="Strikethrough" class="btn"
                                       data-edit="strikethrough" title=""><i
                                            class="fa fa-strikethrough"></i></a>
                                    <a data-original-title="Underline (Ctrl/Cmd+U)" class="btn"
                                       data-edit="underline" title=""><i
                                            class="fa fa-underline"></i></a>
                                </div>

                                <div class="btn-group">
                                    <a data-original-title="Bullet list" class="btn"
                                       data-edit="insertunorderedlist" title=""><i
                                            class="fa fa-list-ul"></i></a>
                                    <a data-original-title="Number list" class="btn"
                                       data-edit="insertorderedlist" title=""><i
                                            class="fa fa-list-ol"></i></a>
                                    <a data-original-title="Reduce indent (Shift+Tab)" class="btn"
                                       data-edit="outdent" title=""><i class="fa fa-dedent"></i></a>
                                    <a data-original-title="Indent (Tab)" class="btn"
                                       data-edit="indent" title=""><i class="fa fa-indent"></i></a>
                                </div>

                                <div class="btn-group">
                                    <a data-original-title="Align Left (Ctrl/Cmd+L)"
                                       class="btn btn-info" data-edit="justifyleft" title=""><i
                                            class="fa fa-align-left"></i></a>
                                    <a data-original-title="Center (Ctrl/Cmd+E)" class="btn"
                                       data-edit="justifycenter" title=""><i
                                            class="fa fa-align-center"></i></a>
                                    <a data-original-title="Align Right (Ctrl/Cmd+R)" class="btn"
                                       data-edit="justifyright" title=""><i
                                            class="fa fa-align-right"></i></a>
                                    <a data-original-title="Justify (Ctrl/Cmd+J)" class="btn"
                                       data-edit="justifyfull" title=""><i
                                            class="fa fa-align-justify"></i></a>
                                </div>

                                <div class="btn-group">
                                    <a data-original-title="Hyperlink" class="btn dropdown-toggle"
                                       data-toggle="dropdown" title=""><i
                                            class="fa fa-link"></i></a>
                                    <div class="dropdown-menu input-append">
                                        <input class="span2" placeholder="URL"
                                               data-edit="createLink" type="text">
                                        <button class="btn" type="button">Add</button>
                                    </div>
                                    <a data-original-title="Remove Hyperlink" class="btn"
                                       data-edit="unlink" title=""><i class="fa fa-cut"></i></a>
                                </div>

                                <div class="btn-group">
                                    <a data-original-title="Insert picture (or just drag &amp; drop)"
                                       class="btn" title="" id="pictureBtn"><i
                                            class="fa fa-picture-o"></i></a>
                                    <input
                                        style="opacity: 0; position: absolute; top: 0px; left: 0px; width: 41px; height: 34px;"
                                        data-role="magic-overlay" data-target="#pictureBtn"
                                        data-edit="insertImage" type="file">
                                </div>

                                <div class="btn-group">
                                    <a data-original-title="Undo (Ctrl/Cmd+Z)" class="btn"
                                       data-edit="undo" title=""><i class="fa fa-undo"></i></a>
                                    <a data-original-title="Redo (Ctrl/Cmd+Y)" class="btn"
                                       data-edit="redo" title=""><i class="fa fa-repeat"></i></a>
                                </div>
                            </div>

                            <div id="descricao_chamado" data-type='innerhtml' class="editor-wrapper placeholderText"
                                 contenteditable="true"></div>

                            <textarea name="descricao_chamado" id="descricao_chamado" style="display:none;"></textarea>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback row-fluid">
                            <label>Anexo:</label>
                            <input type="file" id="file2">
                        </div>
                        <input type="hidden" id="id">
                        <input type="hidden" id="assunto">
                        <input type="hidden" id="area" value="F">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary answer">Responder</button>
            </div>
        </div>
    </div>
</div>
