<div class="col-md-12 w-35 mt-3 cabecalho">
    <label class="cabecalho-label">Área do Investidor</label>
</div>

<div class="col-md-12 mt-4 trader-logado"></div>

<div class="col-md-12 mt-4 trader-ordens">
    <span>Seu(s) Trades:</span>

    <div class="col-md-8 margin-auto mt-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Empresa</th>
                    <th>Código do Ativo</th>
                    <th>Data da Compra</th>
                    <!--<th>Ações</th>-->
                </tr>
            </thead>
            <tbody id="table-body">
                <tr class="txt-center">
                    <td colspan="7">Nenhum registro encontrado!</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="col-md-8 margin-auto display-flex">

        <div class="col-md-6">
            <b>Valor mínimo esperado:</b> R$<span style="margin: 0; margin-right: 15px;" id="value-expected">0</span>
            <button type="button" class="btn btn-primary" id="btn-add-value">Add Valor</button>
        </div>

        <div class="col-md-6">
            <b>Valor máximo esperado:</b> R$<span style="margin: 0; margin-right: 15px;" id="max-value-expected">0</span>
            <button type="button" class="btn btn-primary" id="btn-add-max-value">Add Valor</button>
        </div>
    </div>
</div>

<div class="col-md-3 mt-5 ml-auto">
    <button type="button" class="btn btn-light" id="btn-logout">Sair</button>
</div>
