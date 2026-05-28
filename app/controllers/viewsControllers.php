<?php
require_once 'app/models/viewsModels.php';

class viewsControllers extends viewsModels {
    public function obtenerVistascontrolador($vista) {
        if ($vista !== "") {
            $respuesta = $this->obtener_vistas_modelo($vista);
        } else {
            $respuesta = "app/views/content/dashboard-view.php";
        }
        return $respuesta;
    }
}
