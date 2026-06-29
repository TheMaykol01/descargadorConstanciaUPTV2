<?php

require_once 'config/server.php';
require_once 'autoload.php';

if (!empty($_GET['cedula'])) {
    $_GET['cedula'] = trim($_GET['cedula']);
}

if (!empty($_GET['nacionalidad'])) {
    $_GET['nacionalidad'] = trim($_GET['nacionalidad']);
}

include_once 'app/views/includes/header.php';

require_once 'app/controllers/viewsControllers.php';

$ruta = '';
if (!empty($_GET['views'])) {
    $ruta = trim($_GET['views'], '/');
} elseif (!empty($_GET['url'])) {
    $ruta = trim($_GET['url'], '/');
}

$viewController = new viewsControllers();
$vista = $viewController->obtenerVistascontrolador($ruta);

if ($ruta === '') {
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
} else {
    include_once 'app/views/content/404-view.php';
}
?>

<?php include_once 'app/views/includes/footer.php';
