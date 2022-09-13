module.exports = app => {
    const usuarios = require('../controllers/usuarios.controller');

    // Cria um novo usuario
    app.post("/usuarios", usuarios.create);

    // Busca usuario pelos dados passados
    app.post("/login", usuarios.login);
}
