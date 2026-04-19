<?php
require_once 'main.php';

$nacionalidad = $_GET['nacionalidad'] ?? '';
$cedula = $_GET['cedula'] ?? '';

$protector = new protegerInyeccionSQL();
$nacLimpia = $protector->limpiarCadena($nacionalidad);
$cedLimpia = $protector->limpiarCadena($cedula);

$response = ['existe' => false, 'nombre' => ''];

if (!empty($cedLimpia)) {

    $db = new ConexionDB();
    $pdo = $db->conexionDB();

    if ($pdo) {

        $stmt = $pdo->prepare("SELECT nombres, apellidos FROM empleados WHERE nacionalidad = :nac AND cedula = :ced LIMIT 1");
        $stmt->execute([':nac' => $nacLimpia, ':ced' => $cedLimpia]);
        $empleado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($empleado) {
            $response['existe'] = true;
            $response['nombre'] = $empleado['nombres'] . " " . $empleado['apellidos'];
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);