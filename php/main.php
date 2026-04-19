<?php

class ConexionDB
{
  function conexionDB()
  {
    $host = "localhost";
    $dbname = "Descargador";
    $username = "postgres";
    $password = "Th3Sup3rUs3r$$";

    try {
      $conn = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $username, $password);

      return $conn;

    } catch (PDOException $e) {
      echo "Error de conexión: " . $e->getMessage();
      return null;
    }
  }
}

class protegerInyeccionSQL
{
  function limpiarCadena($cadena)
  {
    $palabra_prohibidas = [
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

    foreach ($palabra_prohibidas as $palabra) {
      $cadena = str_ireplace($palabra, "", $cadena);
    }
    $cadena = str_replace(["'", "\"", "\\", ";"], "", $cadena);

    return $cadena;
  }
}