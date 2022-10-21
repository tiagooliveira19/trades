$(document).ready(function () {

    let user = localStorage.getItem('USUARIO_LOGADO');
    let userLogged = localStorage.getItem('LOGADO');
    let userLoggedId = localStorage.getItem('ID_USUARIO');
    let valueExpected = localStorage.getItem('VALOR_ESPERADO');
    let maxValueExpected = localStorage.getItem('VALOR_MAX_ESPERADO');
    let activeCode = localStorage.getItem('CODIGO_ATIVO');
    let apiKey = '19d39c8f';

    if (userLogged) {

        $('.trader-logado').html('<span>Seja bem-vind@ '+ user +'!</span>').fadeIn('slow');
        buscaOrdensUsuario (userLoggedId);

        if (valueExpected && maxValueExpected) {
            $('#value-expected').html(valueExpected);
            $('#max-value-expected').html(maxValueExpected);
            $('#btn-add-value, #btn-add-max-value').addClass('oculto');

            setInterval(function () {
                monitoraAtivo(activeCode.toString().toLowerCase());
            }, 300000); // 5 minutos = 300000 milissegundos

        } else {
            $('#value-expected, #max-value-expected').html('0');
            $('#btn-add-value, #btn-add-max-value').removeClass('oculto');
        }

        $('#usuario, .login, .cadastro').addClass('oculto');
        $('#area-usuario').addClass('item-menu-ativo').removeClass('oculto').fadeIn('slow');
        $('.area-usuario, #div-ativos-ordem').removeClass('oculto');

    } else {

        $('#area-usuario, .area-usuario').addClass('oculto');

        $('#usuario').addClass('item-menu-ativo').removeClass('oculto').fadeIn('slow', function () {
            $('.login').removeClass('oculto').fadeIn('slow');
        });
    }

    // Busca ordens realizados pelo usuario
    function buscaOrdensUsuario (id_usuario) {

        $.get('http://localhost:3000/ordem/' + id_usuario, function (response) {

            var table_body = 'table-body';

            if (response.length > 0) {

                $('#div-ativos').addClass('oculto');

                $('#' + table_body).empty();

                $.each(response, function (key, value) {

                    localStorage.setItem('CODIGO_ATIVO', value['codigo_ativo']);

                    $('#' + table_body)
                        .append(
                            '<tr>' +
                                '<td>'+ value['id'] +'</td>' +
                                '<td>'+ value['empresa'] +'</td>' +
                                '<td>'+ value['codigo_ativo'] +'</td>' +
                                '<td>'+ formataDataExibe(value['data']) +'</td>' +
                                /*'<td><i class="fa-solid fa-check pointer select-ativo" title="Selecionar Ativo"></i></td>' +*/
                            '</tr>'
                        );
                });
            } else {
                $('#table-body')
                    .html('<tr class="txt-center"><td colspan="7">Nenhum registro encontrado!</td></tr>');
            }
        });
    }

    // Add valor minimo esperado
    $('#btn-add-value').click(function () {

        swal("Digite aqui o valor esperado:", {
            content: "input",
            buttons: ["Cancelar", "Confirmar"],
        })
            .then((value) => {

                if (value) {
                    localStorage.setItem('VALOR_ESPERADO', value);
                    $('#value-expected').html(value);
                    $('#btn-add-value').addClass('oculto');
                } else {
                    localStorage.removeItem('VALOR_ESPERADO');
                }
            });
    });

    // Add valor maximo esperado
    $('#btn-add-max-value').click(function () {

        swal("Digite aqui o valor esperado:", {
            content: "input",
            buttons: ["Cancelar", "Confirmar"],
        })
            .then((value) => {

                if (value) {
                    localStorage.setItem('VALOR_MAX_ESPERADO', value);
                    $('#max-value-expected').html(value);
                    $('#btn-add-max-value').addClass('oculto');
                } else {
                    localStorage.removeItem('VALOR_MAX_ESPERADO');
                }
            });
    });

    // Monitora dados do ativo selecionado pelo usuario
    function monitoraAtivo (codigo_ativo) {

        $.get('https://api.hgbrasil.com/finance/stock_price?key=' + apiKey + '&symbol=' + codigo_ativo, function (response) {

            let price = response['results'][codigo_ativo.toUpperCase()]['price'];
            comparaValores(price);
        });
    }

    // Compara valores fornecidos pela api com os inputados pelo usuário para notificá-lo
    function comparaValores (price) {

        let valueExpected = $('#value-expected').html().toString().replace(",", ".");
        let maxValueExpected = $('#max-value-expected').html().toString().replace(",", ".");
        let formatedPrice = price.toString().replace(".", ",");

        valueExpected = parseFloat(valueExpected);
        maxValueExpected = parseFloat(maxValueExpected);

        if (price < valueExpected) {
            swal('', 'Valor da ação abaixo do mínimo esperado!\nPreço: R$'+formatedPrice, 'error');
        } else if (price <= valueExpected) {
            swal('', 'Valor da ação abaixo ou igual ao mínimo esperado!\nPreço: R$'+formatedPrice, 'warning');
        } else if (price === valueExpected) {
            swal('', 'Valor da ação igual ao mínimo esperado!\nPreço: R$'+formatedPrice, 'info');
        } else if (price >= valueExpected) {
            swal('', 'Valor da ação acima ou igual ao mínimo esperado!\nPreço: R$'+formatedPrice, 'info');
        } else if (price > valueExpected) {
            swal('', 'Valor da ação acima do mínimo esperado!\nPreço: R$'+formatedPrice, 'success');
        } else if (price === maxValueExpected) {
            swal('', 'Valor da ação igual ao máximo esperado!\nPreço: R$'+formatedPrice, 'success');
        } else if (price > maxValueExpected) {
            swal('', 'Valor da ação acima do máximo esperado!\nPreço: R$'+formatedPrice, 'success');
        }
    }

    // Data no formato para exibição ao usuário
    function formataDataExibe (data) {
        let date = new Date(data);
        return date.toLocaleDateString('pt-BR');
    }

    // Desloga o usuário e o retorna para a página inicial
    $('#btn-logout').click(function () {

        localStorage.removeItem('LOGADO');
        localStorage.removeItem('VALOR_ESPERADO');
        localStorage.removeItem('VALOR_MAX_ESPERADO');
        localStorage.removeItem('USUARIO_LOGADO');
        localStorage.removeItem('ID_USUARIO');
        localStorage.removeItem('CODIGO_ATIVO');

        $('#area-usuario, .area-usuario').addClass('oculto').fadeOut('slow');

        $('#usuario').addClass('item-menu-ativo').removeClass('oculto').fadeIn('slow', function () {
            $('.login').removeClass('oculto').fadeIn('slow');
        });

        setTimeout(function () {
            location.reload();
        }, 300);
    });
});
