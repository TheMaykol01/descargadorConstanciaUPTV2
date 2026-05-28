<?php

require_once 'config/server.php';
require_once 'config/ProtectorSQL.php';
require_once 'autoload.php';

$db = new ConexionDB();
$pdo = $db->conexionDB();

include_once 'app/views/includes/header.php';

require_once 'app/controllers/viewsControllers.php';

$ruta = '';
if (!empty($_GET['views'])) {
    $ruta = trim($_GET['views'], '/');
} elseif (!empty($_GET['url'])) {
    $ruta = trim($_GET['url'], '/');
}

if ($ruta === '') {
    $isHome = true;
} else {
    $isHome = false;
}
$viewController = new viewsControllers();
$vista = $viewController->obtenerVistascontrolador($ruta);

if ($isHome) {
?>
<form id="formDescarga" action="" method="GET" class="formulario">
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
}

if (!$isHome) {
    if (!is_file($vista)) {
        include_once 'app/views/content/404-view.php';
    } else {
        include_once $vista;
    }
}
?>

<?php include_once 'app/views/includes/footer.php';
