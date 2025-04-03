<?php
    require_once __DIR__ . '/../../common/core/BaseController.php';

    class ImportController extends BaseController {
        public function index() {
            // Gọi view tương ứng với action index
            $this->render('import/index', [
                'title' => 'Import Management',
                'message' => 'Welcome to the Import Management page!'
            ]);
        }
    }
?>