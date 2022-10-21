<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js"
        integrity="sha512-sR3EKGp4SG8zs7B0MEUxDeq8rw9wsuGVYNfbbO/GLCJ59LBE4baEfQBVsP2Y/h2n8M19YV1mujFANO1yA3ko7Q==" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="/js/menu.js"></script>
<script type="text/javascript" src="/js/ordens.js"></script>
<script>

    $(document).ready(function () {

        $('#usuario').addClass('item-menu-ativo');
        carregaAtivos();

        // Máscara telefone no form
        $('input[type="tel"]').inputmask({
            mask: ["(99) 9999-9999", "(99) 99999-9999"],
            keepStatic: true
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
                        $('.trader-logado').html('<span>Seja bem-vind@ '+ usuario +'!</span>').fadeIn('slow');

                        $('#area-usuario').addClass('item-menu-ativo').removeClass('oculto').fadeIn('slow', function () {
                            $('.area-usuario').removeClass('oculto').fadeIn('slow');
                        });

                        $('#div-ativos-ordem').removeClass('oculto').fadeIn('slow');
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
                        $('#div-ativos-ordem').addClass('oculto').fadeOut('fast');
                        $('#acoes').removeClass('item-menu-ativo').fadeOut('fast');
                        $('#area-usuario').addClass('item-menu-ativo').fadeIn('slow', function () {
                            buscaOrdensUsuario(usuario);
                            $('.area-usuario, #acoes').removeClass('oculto').fadeIn('slow');
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

    });
</script>
