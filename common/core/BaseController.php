<?php
// common/core/BaseController.php

class BaseController {
    public function render($view, $data = []) {
        extract($data);

        ob_start();
        $viewPath = __DIR__ . '/../../admin/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "View not found: " . $viewPath;
        }
        $content = ob_get_clean();

        $layoutPath = __DIR__ . '/../../admin/views/layouts/main_layout.php';
        if (file_exists($layoutPath)) {
            include $layoutPath;
        } 
        else {
            echo "Layout not found: " . $layoutPath;
        }
    }
}