<?php

require_once '../../config/server.php';
require_once '../../autoload.php';
require_once '../../app/models/mainModel.php';

use app\models\mainModel;

$nacionalidad = $_POST['nacionalidad'];
$cedula = $_POST['cedula'];

$mainModel = new class extends mainModel {
    public function conectarPublic()
    {
        return $this->conectar();
    }

    public function limpiarPublic($cadena)
    {
        return $this->limpiarCadena($cadena);
    }
};

$nacLimpia = $mainModel->limpiarPublic($nacionalidad);
$cedLimpia = $mainModel->limpiarPublic($cedula);

$response = ['existe' => false, 'nombre' => ''];

if (!empty($cedLimpia)) {
    try {
        $pdo = $mainModel->conectarPublic();

        if ($pdo) {
            $stmt = $pdo->prepare("SELECT nombres, apellidos FROM empleados WHERE nacionalidad = :nac AND cedula = :ced LIMIT 1");
            $stmt->execute([':nac' => $nacLimpia, ':ced' => $cedLimpia]);
            $empleado = $stmt->fetch();

            if ($empleado) {
                $response['existe'] = true;
                $response['nombre'] = $empleado['nombres'] . ' ' . $empleado['apellidos'];
            }
        }
    } catch (Throwable $e) {
        $response['nombre'] = 'Error en la consulta: ' . $e->getMessage();
    }
}

$pdo = null;

if (!headers_sent()) {
    header('Content-Type: application/json');
}

echo json_encode($response);
