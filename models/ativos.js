const sql = require("./db");

const Ativos = function (Ativo) {
    this.empresa = Ativo.empresa;
    this.codigo_ativo = Ativo.codigo_ativo;
}

Ativos.getAll = result => {
    sql.query("SELECT * FROM ativos", (err, res) => {
        if (err) {
            console.log("Erro: ", err);
            result(err, null);
            return;
        }

        console.log("Ativos: ", res);
        result(null, res);
    });
};

module.exports = Ativos;
