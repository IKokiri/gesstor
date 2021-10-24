<?php
if (isset($_SESSION['gesstor']['login'])) {
    $_SESSION['gesstor'] = [];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!-- Meta, title, CSS, favicons, etc. -->

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GESCON</title>

    <!-- Bootstrap -->
    <link href="App/Template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="App/Template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="App/Template/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="App/Template/production/css/animate.min.css" rel="stylesheet">

    <link href="App/Template/vendors/pnotify/dist/pnotify.css" rel="stylesheet">

    <link href="App/Template/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">

    <link href="App/Template/vendors/pnotify/dist/pnotify.brighttheme.css" rel="stylesheet">

    <!-- Custom Theme Style -->

    <link href="App/Template/build/css/custom.min.css" rel="stylesheet">

</head>

<body class="login">
<div>

    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div id="register" class="animate form login_form">
            <section class="login_content">
                <form id='frm_login' action="#">
                    <h1>Entrar</h1>
                    <div class="col-md-12">
                        <div class="col-md-8">
                            <input type="text" id="email" class="form-control mask_completa_email" placeholder="E-Mail"
                                   required=""/>
                        </div>
                        <div class="col-md-4">
                            <!-- <h2>@kuttner.com.br</h2> -->
                        </div>
                    </div>
                    <div>
                        <input type="password" id="senha" class="form-control" placeholder="Senha" required=""/>
                    </div>

                    <div>
                        <span class="btn btn-default submit" id="entrar">Entrar</span>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <p class="change_link">
                            <!--                            <a href="#signin" class="to_register"> Como Cliente </a>-->
                        </p>

                        <div class="clearfix"></div>
                        <br/>

                        <div>
                            <h1>GESCON</h1>
                        </div>
                    </div>
                </form>

            </section>
        </div>
    </div>
</div>
</body>

<script src="App/Template/vendors/jquery/dist/jquery.min.js"></script>
<script src="App/Template/vendors/pnotify/dist/pnotify.js"></script>
<script src="App/Template/vendors/pnotify/dist/pnotify.confirm.js"></script>
<script src="App/Template/vendors/pnotify/dist/pnotify.buttons.js"></script>
<script src="App/Template/vendors/maskmoney/maskmoney.js"></script>
<script src="App/Template/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
<script src="App/Template/template/js/geral.js"></script>
<script src='App/Listener/login.js'></script>
</html>