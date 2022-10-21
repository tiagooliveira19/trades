$(document).ready(function () {

    let usuario = 'usuario';
    let area_usuario = 'area-usuario';
    let acoes = 'acoes';

    // Comportamento menu
    $('#usuario').on('click', function () {
        $('#area-usuario, #acoes').removeClass('item-menu-ativo');
        $(this).addClass('item-menu-ativo');

        $('.area-usuario, .acoes').fadeOut('fast');
        $('.usuario').removeClass('oculto').fadeIn('slow');
    });

    $('#area-usuario').on('click', function () {
        $('#usuario, #acoes').removeClass('item-menu-ativo');
        $(this).addClass('item-menu-ativo');

        $('.usuario, .acoes').fadeOut('fast');
        $('.area-usuario').removeClass('oculto').fadeIn('slow');
    });

    $('#acoes').on('click', function () {
        $('#usuario, #area-usuario').removeClass('item-menu-ativo');
        $(this).addClass('item-menu-ativo');

        $('.usuario, .area-usuario').fadeOut('fast');
        $('.acoes, #conteudo-acoes').removeClass('oculto').fadeIn('slow');
    });

    $('#' + usuario).on('mouseover', function () {
        $('#area-usuario, #acoes').removeClass('mouseOverMenu');
        $(this).addClass('mouseOverMenu');
    });

    $('#' + area_usuario).on('mouseover', function () {
        $('#usuario, #acoes').removeClass('mouseOverMenu');
        $(this).addClass('mouseOverMenu');
    });

    $('#' + acoes).on('mouseover', function () {
        $('#usuario, #area-usuario').removeClass('mouseOverMenu');
        $(this).addClass('mouseOverMenu');
    });
});
