<?php
require_once 'config/app.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Constancias - OTIC</title>
  <link rel="stylesheet" href="<?php echo APP_URL; ?>css/style.css">
  <link rel="stylesheet" href="<?php echo APP_URL; ?>css/sweetalert2.min.css">
  <script src="<?php echo APP_URL; ?>js/sweetalert2.min.js"></script>
</head>

<body>

  <main class="contenedor-principal">
    <section class="tarjeta-formulario">
      <header class="encabezado-form">
        <h1>Descargar Constancia</h1>
        <p>Ingrese sus datos para generar el documento</p>
      </header>