<?php

class ConexionDB
{
    public function conexionDB()
    {
        $host = 'localhost';
        $dbname = 'Descargador';
        $username = 'postgres';
        $password = 'Th3Sup3rUs3r$$';

        try {
            $conn = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo 'Error de conexión: ' . $e->getMessage();
            return null;
        }
    }
}
