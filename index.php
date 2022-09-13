<!DOCTYPE html>
<html lang="pt">

<head>
    <?php include 'metas.php'; ?>
    <title>Mercado de Ações</title>
</head>

<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 main">
            <div class="col-md-2 menu">
                <div class="col-md-12 item-menu item-menu-ativo" id="usuario">
                    <div class="col-md-1 tarja"></div>
                    <div class="col-md-11 descricao">
                        Usuário
                    </div>
                </div>

                <div class="col-md-12 item-menu oculto" id="area-usuario">
                    <div class="col-md-1 tarja"></div>
                    <div class="col-md-11 descricao">
                        Área do Investidor
                    </div>
                </div>

                <div class="col-md-12 item-menu" id="acoes">
                    <div class="col-md-1 tarja"></div>
                    <div class="col-md-11 descricao">
                        Ações
                    </div>
                </div>
                <div class="col-md-12 menu-footer"></div>
            </div>

            <div class="col-md-10 conteudo">

                <div class="row usuario">
                    <?php include 'pages/login.php'; ?>
                </div>

                <div class="row oculto area-usuario">
                    <?php include 'pages/area_usuario.php'; ?>
                </div>
                
                <div class="row oculto acoes">
                    <?php include 'pages/acoes.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'scripts.php'; ?>
</body>
</html>
