module.exports = app => {
    const ativos = require('../controllers/ativos.controller');

    // Busca todos os ativos
    app.get("/ativos", ativos.findAll);
}
