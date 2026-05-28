<?php

class protegerInyeccionSQL
{
    public function limpiarCadena($cadena)
    {
        $palabrasProhibidas = [
            "SELECT",
            "INSERT",
            "UPDATE",
            "DELETE",
            "DROP",
            "TRUNCATE",
            "TABLE",
            "DATABASE",
            "UNION",
            "FROM",
            "WHERE",
            "GROUP BY",
            "ORDER BY",
            "HAVING",
            "LIMIT",
            "OR 1=1",
            "OR '1'='1'",
            "SLEEP",
            "BENCHMARK",
            "--",
            ";",
            "/*",
            "*/",
            "XP_"
        ];

        foreach ($palabrasProhibidas as $palabra) {
            $cadena = str_ireplace($palabra, '', $cadena);
        }

        $cadena = str_replace(["'", '"', "\\", ";"], '', $cadena);

        return $cadena;
    }
}
