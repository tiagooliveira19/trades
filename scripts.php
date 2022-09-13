<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js"
        integrity="sha512-sR3EKGp4SG8zs7B0MEUxDeq8rw9wsuGVYNfbbO/GLCJ59LBE4baEfQBVsP2Y/h2n8M19YV1mujFANO1yA3ko7Q==" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

    $(document).ready(function () {

        carregaAtivos();

        let usuario = 'usuario';
        let area_usuario = 'area-usuario';
        let acoes = 'acoes';
        let user = localStorage.getItem('USUARIO_LOGADO');
        let userLogged = localStorage.getItem('LOGADO');
        let userLoggedId = localStorage.getItem('ID_USUARIO');
        let valueExpected = localStorage.getItem('VALOR_ESPERADO');
        let maxValueExpected = localStorage.getItem('VALOR_MAX_ESPERADO');
        let activeCode = localStorage.getItem('CODIGO_ATIVO');

        $('#' + usuario).toggleClass('item-menu-ativo');

        if (userLogged) {

            $('.cliente-logado').html('<span>Seja bem-vind@ '+ user +'!</span>').fadeIn('slow');
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
            $('#' + area_usuario).toggleClass('item-menu-ativo').removeClass('oculto');
            $('.area-usuario, #div-ativos').removeClass('oculto');

        } else {

            $('#area-usuario, .area-usuario').addClass('oculto');

            $('#usuario').closest('.item-menu').toggleClass('item-menu-ativo').removeClass('oculto').fadeIn('slow', function () {
                $('.login').removeClass('oculto').fadeIn('slow');
            });
        }

        // Máscara telefone no form
        $('input[type="tel"]').inputmask({
            mask: ["(99) 9999-9999", "(99) 99999-9999"],
            keepStatic: true
        });

        /* -- Comportamento menu -- */
        $('#usuario').on('click', function () {
            $('#acoes, #area-usuario').closest('.item-menu').removeClass('item-menu-ativo');
            $(this).closest('.item-menu').toggleClass('item-menu-ativo');

            $('.area-usuario, .acoes').fadeOut('fast');
            $('.usuario').fadeIn('slow');
        });

        $('#area-usuario').on('click', function () {
            $('#usuario, #acoes').closest('.item-menu').removeClass('item-menu-ativo');
            $(this).closest('.item-menu').toggleClass('item-menu-ativo');

            $('.usuario, .acoes').fadeOut('fast');
            $('.area-usuario').fadeIn('slow');
        });

        $('#acoes').on('click', function () {
            $('#usuario, #area-usuario').closest('.item-menu').removeClass('item-menu-ativo')
            $(this).closest('.item-menu').toggleClass('item-menu-ativo')

            $('.usuario, .area-usuario').fadeOut('fast');
            $('.acoes, #conteudo-acoes').removeClass('oculto').fadeIn('slow');
        });

        $('#' + usuario).on('mouseover', function () {
            $('#area-usuario, #acoes').closest('.item-menu').removeClass('mouseOverMenu')
            $(this).closest('.item-menu').toggleClass('mouseOverMenu')
        });

        $('#' + area_usuario).on('mouseover', function () {
            $('#usuario, #acoes').closest('.item-menu').removeClass('mouseOverMenu')
            $(this).closest('.item-menu').toggleClass('mouseOverMenu')
        });

        $('#' + acoes).on('mouseover', function () {
            $('#cliente, #area-cliente').closest('.item-menu').removeClass('mouseOverMenu')
            $(this).closest('.item-menu').toggleClass('mouseOverMenu')
        });

        // Muda para o formulário de login
        $('#btn-cadastro').click(function () {
            $('.login').fadeOut('slow', function () {
                $('.cadastro').fadeIn('slow');
            });
        });

        // Muda para o formulário de cadastro
        $('#btn-login').click(function () {
            $('.cadastro').fadeOut('slow', function () {
                $('.login').fadeIn('slow');
            });
        });

        // Envia os dados do usuario para api (Cadastro)
        $('#form-cadastro').submit(function (e) {

            e.preventDefault();
            let dados = $(this).serialize();

            $.ajax({
                url: 'http://localhost:3000/usuarios',
                dataType: 'json',
                type: 'post',
                data: dados,

                success: function (response) {

                    swal('', 'Usuário cadastrado com sucesso!', 'success');

                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                }
            });
        });

        // Envia os dados do usuario para api (Login)
        $('#form-login').submit(function (e) {

            e.preventDefault();
            let dados = $(this).serialize();

            $.ajax({
                url: 'http://localhost:3000/login',
                dataType: 'json',
                type: 'post',
                data: dados,

                success: function (response) {

                    if (response.length > 0) {

                        let usuario = response[0]['nome'];
                        let id_usuario = response[0]['id'];

                        localStorage.setItem('LOGADO', 'TRUE');
                        localStorage.setItem('USUARIO_LOGADO', usuario);
                        localStorage.setItem('ID_USUARIO', id_usuario);

                        carregaAtivos();
                        buscaOrdensUsuario(id_usuario);

                        $('#usuario, .login, .cadastro').addClass('oculto');
                        $('.cliente-logado').html('<span>Seja bem-vind@ '+ usuario +'!</span>').fadeIn('slow');

                        $('#' + area_usuario).closest('.item-menu').toggleClass('item-menu-ativo').removeClass('oculto').fadeIn('slow', function () {
                            $('.area-usuario').removeClass('oculto').fadeIn('slow');
                        });

                        $('#div-ativos').removeClass('oculto');
                    } else {
                        swal('', 'Usuário não cadastrado no sistema!', 'warning');
                    }
                }
            });
        });

        // Envia os dados da ordem para api
        $('#form-ordem').submit(function (e) {

            e.preventDefault();

            let usuario = localStorage.getItem('ID_USUARIO');
            let ativo = $('input[name="ativo"]:checked').val();
            var data_ordem = formataData(new Date());

            $.ajax({
                url: 'http://localhost:3000/ordem',
                dataType: 'json',
                type: 'post',
                data: 'usuario=' + usuario + '&ativo=' + ativo + '&data=' + data_ordem,

                success: function (response) {

                    swal('', 'Ordem executada com sucesso!', 'success');

                    setTimeout(function () {
                        $('#conteudo-acoes').fadeOut('fast');
                        $('#div-ativos').addClass('oculto');
                        // $('#conteudo-acoes, #div-ativos').addClass('oculto');
                        $('#' + acoes).closest('.item-menu').toggleClass('item-menu-ativo');
                        $('#' + area_usuario).closest('.item-menu').toggleClass('item-menu-ativo').fadeIn('slow', function () {
                            buscaOrdensUsuario(usuario);
                            $('.area-usuario').removeClass('oculto').fadeIn('slow');
                        });
                    }, 1500);
                }
            });
        });

        // Data no formato para bd
        function formataData (data) {
            return data.getFullYear() + '-' + (data.getMonth() + 1) + '-' + data.getDate();
        }

        // Data no formato para exibição ao usuário
        function formataDataExibe (data) {
            let date = new Date(data);
            return date.toLocaleDateString('pt-BR');
        }

        // Carrega os ativos direto da base
        function carregaAtivos () {

            $.get('http://localhost:3000/ativos', function (response) {

                // Dados vindos da api
                if (response.length > 0) {

                    $('#div-aviso').addClass('oculto');
                    $('#ativos').removeClass('oculto');

                    $('#c1p1').html('<b>' + response[0]['empresa'] + '</b>');
                    $('#c1p2').html(response[0]['codigo_ativo']);

                    $('#c2p1').html('<b>' + response[1]['empresa'] + '</b>');
                    $('#c2p2').html(response[1]['codigo_ativo']);

                    $('#c3p1').html('<b>' + response[2]['empresa'] + '</b>');
                    $('#c3p2').html(response[2]['codigo_ativo']);

                    $('#c4p1').html('<b>' + response[3]['empresa'] + '</b>');
                    $('#c4p2').html(response[3]['codigo_ativo']);

                    $('#c5p1').html('<b> '+ response[4]['empresa'] + '</b>');
                    $('#c5p2').html(response[4]['codigo_ativo']);
                }
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
                                '</tr>'
                            );
                    });
                } else {
                    $('#table-body')
                        .html('<tr class="txt-center"><td colspan="7">Nenhum registro encontrado!</td></tr>');
                }
            });
        }

        // Monitora dados do ativo selecionado pelo usuario
        function monitoraAtivo (codigo_ativo) {

            $.get('https://api.hgbrasil.com/finance/stock_price?key=19d39c8f&symbol=' + codigo_ativo, function (response) {

                    let price = response['results'][codigo_ativo.toUpperCase()]['price'];
                    // console.log(price);

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

        // Add valor minimo esperado
        $('#btn-add-value').click(function () {

            swal("Digite aqui o valor esperado:", {
                content: "input",
            })
            .then((value) => {
                localStorage.setItem('VALOR_ESPERADO', value);
                $('#value-expected').html(value);
                $('#btn-add-value').addClass('oculto');
            });
        });

        // Add valor maximo esperado
        $('#btn-add-max-value').click(function () {

            swal("Digite aqui o valor esperado:", {
                content: "input",
            })
                .then((value) => {
                    localStorage.setItem('VALOR_MAX_ESPERADO', value);
                    $('#max-value-expected').html(value);
                    $('#btn-add-max-value').addClass('oculto');
                });
        });

        // Desloga o usuário e o retorna para a página inicial
        $('#btn-logout').click(function () {

            localStorage.removeItem('LOGADO');
            localStorage.removeItem('VALOR_ESPERADO');
            localStorage.removeItem('VALOR_MAX_ESPERADO');
            localStorage.removeItem('USUARIO_LOGADO');
            localStorage.removeItem('ID_USUARIO');
            localStorage.removeItem('CODIGO_ATIVO');

            $('#area-usuario, .area-usuario').addClass('oculto');

            $('#usuario').closest('.item-menu').toggleClass('item-menu-ativo').removeClass('oculto').fadeIn('slow', function () {
                $('.login').removeClass('oculto').fadeIn('slow');
            });

            setTimeout(function () {
                location.reload();
            }, 300);
        });
    });
</script>
