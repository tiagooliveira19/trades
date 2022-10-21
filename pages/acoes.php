<div id="conteudo-acoes">
    <div class="col-md-12 w-35 mt-3 cabecalho">
        <label class="cabecalho-label">Ações</label>
    </div>

    <div class="txt-center mt-5" id="div-aviso">
        <span>Logue-se para ter acesso às ações disponíveis!</span>
    </div>

    <div class="oculto" id="ativos">
        <div class="col-md-10 offset-2 div-ativos">
            <div class="col-md-3">
                <div class="txt-center">
                    <img src="images/ativo.png" class="w-25" alt="imagem-login" id="imagem-login" >
                </div>
                <div class="txt-center mt-2">
                    <span class="display-block itens-ativos" id="c1p1"></span>
                    <span class="display-block itens-ativos" id="c1p2"></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="txt-center">
                    <img src="images/ativo.png" class="w-25" alt="imagem-login" id="imagem-login" >
                </div>
                <div class="txt-center mt-2">
                    <span class="display-block itens-ativos" id="c2p1"></span>
                    <span class="display-block itens-ativos" id="c2p2"></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="txt-center">
                    <img src="images/ativo.png" class="w-25" alt="imagem-login" id="imagem-login" >
                </div>
                <div class="txt-center mt-2">
                    <span class="display-block itens-ativos" id="c3p1"></span>
                    <span class="display-block itens-ativos" id="c3p2"></span>
                </div>
            </div>
        </div>

        <div class="col-md-9 offset-3 div-ativos">
            <div class="col-md-3">
                <div class="txt-center">
                    <img src="images/ativo.png" class="w-25" alt="imagem-login" id="imagem-login" >
                </div>
                <div class="txt-center mt-2">
                    <span class="display-block itens-ativos" id="c4p1"></span>
                    <span class="display-block itens-ativos" id="c4p2"></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="txt-center">
                    <img src="images/ativo.png" class="w-25" alt="imagem-login" id="imagem-login" >
                </div>
                <div class="txt-center mt-2">
                    <span class="display-block itens-ativos" id="c5p1"></span>
                    <span class="display-block itens-ativos" id="c5p2"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 margin-auto oculto" id="div-ativos-ordem" style="margin-top: 100px;">

        <form class="display-flex" id="form-ordem">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="ativo" id="abev3" value="1" required>
                <label class="form-check-label" for="abev3">Ambev S.A.</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="ativo" id="petr4" value="2">
                <label class="form-check-label" for="petr4">Petróleo Brasileiro S.A.</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="ativo" id="sqia3" value="3">
                <label class="form-check-label" for="sqia3">Sinqia S.A.</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="ativo" id="smft3" value="4">
                <label class="form-check-label" for="smft3">Smart Fit</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="ativo" id=vale3" value="5">
                <label class="form-check-label" for=vale3">Vale S.A.</label>
            </div>

            <div>
                <button type="submit" class="btn btn-primary" id="btn-executar-ordem">Executar Ordem</button>
            </div>
        </form>
    </div>
</div>
