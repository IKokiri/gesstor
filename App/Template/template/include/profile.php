<div class="profile">
    <div class="profile_pic">
        <a class="item_menu" href="javascript:void(0)" data-page="perfil"><img src="App/imagens/usuarios/<?php echo $_SESSION['gesstor']['login']['imagem']?>" alt="..."
                                                             class="img-circle profile_img"></a>
    </div>
    <div class="profile_info">
        <span> Bem Vindo,</span>
        <h2> <?php echo isset($_SESSION['gesstor']['login']['funcionario']) ? $_SESSION['gesstor']['login']['funcionario'] : 'Admin' ?> </h2>
    </div>
</div>
