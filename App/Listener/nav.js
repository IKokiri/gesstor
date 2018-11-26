urlApp = 'App/Core/App.php';

var page = 'inicio'

function letMeGo() {

    var formData = new FormData();

    formData.append('action', page);
    $.ajax({
        url: urlApp,
        type: 'POST',
        dataType: 'text',
        data: formData,
        success: function (data) {

            location.reload();
        },
        processData: false,
        cache: false,
        contentType: false
    }).done(function () {

    });

}
// function loadNav() {
//     $.ajax({
//         url: urlApp,
//         type: 'POST',
//         dataType: 'JSON',
//         data: {
//
//             action: 'SubMenu',
//             method: 'getAllJoin'
//
//         }, success: function (data) {
//
//             if (data.count) {
//
//                 nav = '';
//
//                 $.each(data.result, function (key, value) {
//
//                     nav += '<li><a href="javascript:void(0)" class="item_menu" data-page="' + value.nomeArquivo + '">' +
//                         value.menu + "-" + value.subMenu
//                     '</a>' +
//                     '</li>';
//
//                 });
//                 $('.side-menu').html(nav);
//
//             } else if (data.MSN) {
//
//                 mensagem('Erro', data.msnErro, '', '');
//             }
//         }
//     }).done(function () {
//     });
// }

function loadNav() {
    $.ajax({
        url: urlApp,
        async: false,
        type: 'POST',
        dataType: 'JSON',
        data: {

            action: 'GrupoPermissao',
            method: 'getAllid'

        }, success: function (data) {

            if (data.count) {


                menu = data.result[0].menu;

                nav = '<li>' +
                    '<a>' +
                    '<i class="' + data.result[0].icone + '">' +
                    '</i>' +
                    data.result[0].menu +
                    '<span class="fa fa-chevron-down">' +
                    '</span>' +
                    '</a>' +
                    '<ul class="nav child_menu">';

                $.each(data.result, function (key, value) {

                    if (menu != value.menu) {
                        nav += '</ul>' +
                            '</li>';

                        menu = value.menu;

                        nav += '<li>' +
                            '<a>' +
                            '<i class="' + value.icone + '">' +
                            '</i>' +
                            value.menu +
                            '<span class="fa fa-chevron-down">' +
                            '</span>' +
                            '</a>' +
                            '<ul class="nav child_menu">';
                    }
                    if (menu == value.menu) {
                        nav += '<li>' +
                            '<a href="javascript:void(0)" class="item_menu" data-page="' + value.nomeArquivo + '">' +
                            value.subMenu +
                            '</a>' +
                            '</li>';
                    }


                });


                $(".side-menu").html(nav);

            } else if (data.MSN) {

                mensagem('Erro', data.msnErro, '', '');
            }
        }
    }).done(function () {
        var lnk2 = $('<script src="App/Template/build/js/custom.min.js"></script>');
        $("#customJs").append(lnk2);
    });
}

$(document).ready(function () {
    loadNav();
    $(document).on('click', '.item_menu', function () {

        page = $(this).data('page');

        letMeGo();

    });

    $(document).on('click', '.redirect_page', function () {

        page = $(this).data('page');
        window.location = "index.php?action=logout";

    });


})