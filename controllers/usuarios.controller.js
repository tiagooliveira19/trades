const Usuarios = require('../models/usuarios');

// Cria e Salva um novo cliente
exports.create = (req, res) => {
    // Valida a requisição
    if (!req.body) {
        res.status(400).send({
            message: "Os dados não podem ser vazios!"
        });
    }

    // Cria um novo usuario
    const usuario = new Usuarios({
        nome: req.body.nome,
        senha: req.body.senha,
        telefone: req.body.telefone,
        endereco: req.body.endereco
    });

    // Salva usuario criado no banco
    Usuarios.create(usuario, (err, data) => {
        if (err)
            res.status(500).send({
                message:
                    err.message || "Ocorreu algum erro durante a criação do usuario!"
            });
        else res.send(data);
    });
};

// Busca usuário pelos dados de login
exports.login = (req, res) => {
    Usuarios.realizalogin(req.body.nome, req.body.senha, (err, data) => {

        if (err) {
            if (err.kind === "Usuario não encontrado!") {
                res.status(404).send({
                    message: `Não foi possível encontrar o usuario com o login ${req.body.name}!`
                });
            } else {
                res.status(500).send({
                    message: "Erro ao buscar usuario com o login " + req.body.name
                });
            }
        } else res.send(data);
    });
};
