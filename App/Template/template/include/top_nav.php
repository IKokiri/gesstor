<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:void(0)" class="refreshPage" data-toggle="dropdown" aria-expanded="false">
                        <span class=" fa fa-refresh"></span>
                    </a>
                </li>
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                       aria-expanded="false">
                        <img src="App/src/foto.jpg" alt=""><?php echo $_SESSION['gesstor']['login']['identificador'] ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a class="item_menu" href="javascript:void(0)" data-page="perfil"> Perfil</a></li>

                        <li class="redirect_page" data-page="login"><a href="javascript:void(0)"><i
                                        class="fa fa-sign-out pull-right "></i> Sair</a></li>
                    </ul>
                </li>
                <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                       aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-green">0</span>
                    </a>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        <li>
                            <a>
                                <span class="image"><img src="App/src/img.jpg" alt="Profile Image"/></span>
                                <span>
                          <span>Sistema</span>
                          <span class="time">Agora</span>
                        </span>
                                <span class="message">
                          Nenhuma Mensagem
                        </span>
                            </a>
                        </li>
                        <li>
                            <div class="text-center">
                                <a>
                                    <strong>Ver Todas</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>