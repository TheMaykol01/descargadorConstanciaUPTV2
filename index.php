<?php

require_once 'config/server.php';
require_once 'autoload.php';

use app\models\mainModel;
use Dompdf\Dompdf;  

if (isset($_GET['descargar']) || isset($_GET['nac']) || isset($_GET['ced'])) {
    include_once 'app/views/includes/header.php';
    include_once 'app/views/content/404-view.php';
    include_once 'app/views/includes/footer.php';
    exit;
}

if (isset($_POST['descargar'])) {
    require_once 'config/app.php';
    require_once 'app/models/mainModel.php';
    require_once 'librerias/dompdf/autoload.inc.php';

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

    $nacionalidad = 'V';
    if (isset($_POST['nacionalidad'])) {
        $nacionalidad = $mainModel->limpiarPublic($_POST['nacionalidad']);
    }

    $nacionalidad = 'E';
    if (isset($_POST['nacionalidad'])) {
        $nacionalidad = $mainModel->limpiarPublic($_POST['nacionalidad']);
    }

    $cedula = '';
    if (isset($_POST['cedula'])) {
        $cedula = $mainModel->limpiarPublic($_POST['cedula']);
    }

    $empleado = null;

    if (!empty($cedula)) {
        try {
            $pdo = $mainModel->conectarPublic();
            if ($pdo) {
                $stmt = $pdo->prepare("SELECT * FROM empleados WHERE nacionalidad = :nac AND cedula = :ced LIMIT 1");
                $stmt->execute([':nac' => $nacionalidad, ':ced' => $cedula]);
                $empleado = $stmt->fetch();
            }
        } catch (Throwable $e) {
            $empleado = null;
        }
    }

    $nombreCompleto = 'N/A';
    if ($empleado) {
        $nombres = '';
        if (isset($empleado['nombres'])) {
            $nombres = $empleado['nombres'];
        }

        $apellidos = '';
        if (isset($empleado['apellidos'])) {
            $apellidos = $empleado['apellidos'];
        }

        $nombreCompleto = trim($nombres . ' ' . $apellidos);
    }

    $estadoRegistro = 'No Encontrado';
    if ($empleado) {
        $estadoRegistro = 'Activo / Verificado';
    }

    $cedulaCompleta = $nacionalidad . '-' . $cedula;
    $fechaActual = date('d/m/Y');

    $estilosCss = file_get_contents('css/style.css');

    ob_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Constancia de Trabajo</title>
    <style>
        <?php echo $estilosCss; ?>
    </style>
</head>
<body>
    <div class="pdf-container">
        <header class="pdf-header">
            <h1 class="pdf-header-title"><?php echo htmlspecialchars(APP_NAME); ?></h1>
            <p class="pdf-header-subtitle">Gestión de Documentos y Constancias Oficiales</p>
        </header>

        <section class="pdf-title-section">
            <h2 class="pdf-document-title">Constancia de Trabajo</h2>
        </section>

        <section class="pdf-body-text">
            <p>
                Por medio de la presente se hace constar que el/la ciudadano(a) 
                <strong><?php echo htmlspecialchars($nombreCompleto); ?></strong>, 
                titular de la cédula de identidad N° <strong><?php echo htmlspecialchars($cedulaCompleta); ?></strong>, 
                labora en nuestra institución desempeñando sus funciones de manera satisfactoria.
            </p>
        </section>

        <table class="pdf-data-table">
            <tr>
                <th>Nombres y Apellidos</th>
                <td><?php echo htmlspecialchars($nombreCompleto); ?></td>
            </tr>
            <tr>
                <th>Cédula de Identidad</th>
                <td><?php echo htmlspecialchars($cedulaCompleta); ?></td>
            </tr>
            <tr>
                <th>Estado de Registro</th>
                <td><?php echo $estadoRegistro; ?></td>
            </tr>
            <tr>
                <th>Fecha de Emisión</th>
                <td><?php echo htmlspecialchars($fechaActual); ?></td>
            </tr>
        </table>

        <section class="pdf-signatures-section">
            <div class="pdf-signature-box">
                <div class="pdf-signature-line"></div>
                <p class="pdf-signature-name">Departamento de Recursos Humanos</p>
                <p class="pdf-signature-title">Firma Autorizada</p>
            </div>

            <div class="pdf-signature-box-right">
                <div class="pdf-signature-line"></div>
                <p class="pdf-signature-name">Dirección General</p>
                <p class="pdf-signature-title">Sello y Validación</p>
            </div>
            <div class="clear-fix"></div>
        </section>

        <footer class="pdf-footer">
            <p>Documento generado digitalmente por <?php echo htmlspecialchars(APP_NAME); ?> - <?php echo $fechaActual; ?></p>
        </footer>
    </div>
</body>
</html>
<?php
    $html = ob_get_clean();

    $dompdf = new Dompdf();
    $options = $dompdf->getOptions();
    $options->setIsRemoteEnabled(true);
    $dompdf->setOptions($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $nombreArchivo = 'Constancia' . $cedulaCompleta . '.pdf';
    $dompdf->stream($nombreArchivo, ['Attachment' => false]);
    exit;
}

if (!empty($_POST['cedula'])) {
    $_POST['cedula'] = trim($_POST['cedula']);
}

if (!empty($_POST['nacionalidad'])) {
    $_POST['nacionalidad'] = trim($_POST['nacionalidad']);
}

include_once 'app/views/includes/header.php';

require_once 'app/controllers/viewsControllers.php';

$ruta = '';
if (!empty($_POST['views'])) {
    $ruta = trim($_POST['views'], '/');
} elseif (!empty($_POST['url'])) {
    $ruta = trim($_POST['url'], '/');
}

$viewController = new viewsControllers();
$vista = $viewController->obtenerVistascontrolador($ruta);

if ($ruta === '') {
?>
<form id="formDescarga" action="" method="POST" class="formulario">
  <div class="campo">
    <label for="cedula">Cédula de Identidad</label>
    <div class="input-combinado">
      <select name="nacionalidad" id="nacionalidad" class="selector-prefijo">
        <option value="V">V</option>
        <option value="E">E</option>
      </select>
      <input type="number" id="cedula" name="cedula" placeholder="Ej. 25123456" required>
    </div>
  </div>

  <input type="hidden" name="descargar" id="descargarHidden" value="">

  <div id="infoUsuario" class="contenedor-mensaje"></div>

  <div class="botones-container">
    <button type="submit" class="boton-enviar">
      Verificar Datos
    </button>

    <button type="button" id="btnDescargarPDF" class="boton-descargar" disabled>
      Descargar Constancia
    </button>
  </div>
</form>
<?php
} else {
    include_once 'app/views/content/404-view.php';
}
?>

<?php include_once 'app/views/includes/footer.php';
