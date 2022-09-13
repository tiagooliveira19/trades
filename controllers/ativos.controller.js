const Ativos = require('../models/ativos');

// Busca todos os ativos
exports.findAll = (req, res) => {
    Ativos.getAll((err, data) => {
        if (err)
            res.status(500).send({
                message:
                    err.message || "Ocorreu algum erro durante a busca dos ativos!"
            });
        else res.send(data);
    });
};
