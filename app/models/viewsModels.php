<?php

class viewsModels {
    protected function obtener_vistas_modelo($vista) {
        // Lista blanca de vistas permitidas
        $listaBlanca = [
            'dashboard'
        ];

        // Normalizar y sanitizar entrada
        $vista = trim((string) $vista);
        $vista = strtolower($vista);
        $vista = preg_replace('/[^a-z0-9_\-]/', '', $vista);

        // Vista por defecto
        if ($vista === '') {
            return 'app/views/content/dashboard-view.php';
        }

        // Comprobar lista blanca y existencia del archivo
        if (in_array($vista, $listaBlanca, true)) {
            $viewFile = 'app/views/content/' . $vista . '-view.php';
            if (is_file($viewFile)) {
                return $viewFile;
            }
        }

        // Si no está permitida o no existe, devolver 404
        return 'app/views/content/404-view.php';
    }
}