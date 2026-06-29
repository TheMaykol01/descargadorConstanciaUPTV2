<?php

class viewsModels {
    protected function obtener_vistas_modelo($vista) {
        $vista = trim((string) $vista);
        $vista = strtolower($vista);
        $vista = preg_replace('/[^a-z0-9_\-]/', '', $vista);

        if ($vista === '') {
            return 'app/views/content/404-view.php';
        }

        $viewFile = 'app/views/content/' . $vista . '-view.php';
        if (is_file($viewFile)) {
            return $viewFile;
        }

        return 'app/views/content/404-view.php';
    }
}