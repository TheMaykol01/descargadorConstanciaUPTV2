<?php

namespace app\models;

use PDO;

if (file_exists(__DIR__ . "/../../config/server.php")) {
    require_once __DIR__ . "/../../config/server.php";
}

class mainModel
{
    private $DB_SERVER = DB_SERVER;
    private $dbname = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;

    protected function conectar()
    {
        $conexion = new PDO("pgsql:host=" . $this->DB_SERVER . ";port=" . DB_PORT . ";dbname=" . $this->dbname, $this->username, $this->password);
        $conexion->exec("SET NAMES 'utf8'");
        return $conexion;
    }

    public function limpiarCadena($cadena)
    {
        $palabra = [
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

        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);

        foreach ($palabra as $valor) {
            $cadena = str_ireplace($valor, "", $cadena);
        }

        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);

        return $cadena;
    }

    public function verificarDatos($filtro, $cadena)
    {
        if ($cadena === null) {
            return false;
        }

        return preg_match('/^' . $filtro . '$/', $cadena) === 1;
    }
}