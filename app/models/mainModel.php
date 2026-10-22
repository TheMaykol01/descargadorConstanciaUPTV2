<?php

namespace app\models;

use PDO;

if (file_exists(__DIR__ . "/../../config/server.php")) {
    require_once __DIR__ . "/../../config/server.php";
}

class mainModel
{
    protected function conectar()
    {
        $dsn = "mysql:host=" . DB_SERVER . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

        return new PDO($dsn, DB_USER, DB_PASS);
    }

    public function limpiarCadena($cadena)
    {
        $palabras = [
            "<script>",
            "</script>",
            "<script src",
            "<script type",
            "SELECT * FROM",
            "DELETE FROM",
            "INSERT INTO",
            "DROP TABLE",
            "DROP DATABASE",
            "TRUNCATE TABLE",
            "SHOW TABLES;",
            "SHOW DATABASES;",
            "<?php",
            "?>",
            "--",
            "^",
            "<",
            ">",
            "[",
            "]",
            "\\",
            "=",
            ";"
        ];

        $cadena = str_ireplace($palabras, "", trim(stripslashes($cadena)));

        return trim(stripslashes($cadena));
    }

    public function verificarDatos($filtro, $cadena)
    {
        if ($cadena === null) {
            return false;
        } else {
            if (preg_match('/^' . $filtro . '$/', $cadena)) {
                return true;
            } else {
                return false;
            }
        }
    }
}
