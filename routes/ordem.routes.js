module.exports = app => {
    const ordem = require('../controllers/ordem.controller');

    // Cria uma nova ordem
    app.post("/ordem", ordem.create);

    // Busca todos as ordem(s) do usuario
    app.get("/ordem/:userId", ordem.findOrdersUser);
}
