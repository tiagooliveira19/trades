const Ordem = require('../models/ordem');

// Cria e Salva uma nova ordem
exports.create = (req, res) => {
    // Valida a requisição
    if (!req.body) {
        res.status(400).send({
            message: "Os dados não podem ser vazios!"
        });
    }

    // Cria uma nova ordem
    const ordem = new Ordem({
        usuario: req.body.usuario,
        ativo: req.body.ativo,
        data: req.body.data
    });

    // Salva ordem criada no banco
    Ordem.create(ordem, (err, data) => {
        if (err)
            res.status(500).send({
                message:
                    err.message || "Ocorreu algum erro durante a criação da ordem!"
            });
        else res.send(data);
    });
};

// Busca ordem(s) pelo id do usuário
exports.findOrdersUser = (req, res) => {
    Ordem.findByUser(req.params.userId, (err, data) => {
        if (err) {
            if (err.kind === "Ordem não encontrada!") {
                res.status(404).send({
                    message: `Não foi possível encontrar a ordem com o id do usuário ${req.params.userId}!`
                });
            } else {
                res.status(500).send({
                    message: "Erro ao buscar a ordem com o id do usuário " + req.params.userId
                });
            }
        } else res.send(data);
    });
};
