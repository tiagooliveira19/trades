const sql = require("./db");

const Ordem = function (Ordem) {
    this.usuario = Ordem.usuario;
    this.ativo = Ordem.ativo;
    this.data = Ordem.data;
}

Ordem.create = (newOrder, result) => {
    sql.query("INSERT INTO ordem SET ?", newOrder, (err, res) => {
        if (err) {
            console.log("Erro: ", err);
            result(err, null);
            return;
        }

        console.log("Ordem criada: ", { id: res.insertId, ...newOrder });
        result(null, { id: res.insertId, ...newOrder });
    });
};

Ordem.findByUser = (userId, result) => {
    sql.query('SELECT o.*, a.empresa, a.codigo_ativo FROM ordem o ' +
        'JOIN ativos a ON o.ativo = a.id WHERE usuario = ?', [userId] , (err, res) => {
        if (err) {
            console.log("Erro: ", err);
            result(err, null);
            return;
        }

        if (res.length) {
            console.log("Ordem(s) encontrada(s): ", res);
            result(null, res);
            return;
        }

        // Ordem não encontrada com o id passado
        result({ kind: "Ordem(s) não encontrado!" }, null);
    });
};

module.exports = Ordem;
