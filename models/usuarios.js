const sql = require("./db");

const Usuarios = function (Usuario) {
    this.nome = Usuario.nome;
    this.senha = new Buffer(Usuario.senha).toString('base64'); // Faz criptografia da senha
    this.telefone = Usuario.telefone;
    this.endereco = Usuario.endereco;
}

Usuarios.create = (newUser, result) => {
    sql.query("INSERT INTO usuarios SET ?", newUser, (err, res) => {
        if (err) {
            console.log("Erro: ", err);
            result(err, null);
            return;
        }

        console.log("Usuario criado: ", {id: res.insertId, ...newUser});
        result(null, {id: res.insertId, ...newUser});
    });
};

Usuarios.realizalogin = (name, password, result) => {

    var senha = new Buffer(password).toString('base64'); // Faz criptografia da senha para validação no select

    sql.query('SELECT * FROM usuarios WHERE nome = ? AND senha = ?', [name, senha], (err, res) => {

        if (err) {
            console.log("Erro: ", err);
            result(err, null);
            return;
        }

        console.log("Usuario logado: ", res);
        result(null, res);
    });
};

module.exports = Usuarios;
