<?php
require_once 'app/models/viewsModels.php';

class viewsControllers extends viewsModels {
    public function obtenerVistascontrolador($vista) {
        return $this->obtener_vistas_modelo($vista);
    }
}
