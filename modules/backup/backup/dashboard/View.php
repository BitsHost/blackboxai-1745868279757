<?php
namespace Dashboard;

use Common\Bmvc\BaseView;

class View extends BaseView {
    public function __construct() {
        parent::__construct();
    }

    public function render($template, $data = []) {
        // Extract data to make variables available in template
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include header template
        include __DIR__ . '/templates/layout/header.php';
        
        // Include the main template
        include __DIR__ . '/templates/' . $template . '.php';
        
        // Include footer template
        include __DIR__ . '/templates/layout/footer.php';
        
        // Get contents and clean buffer
        echo ob_get_clean();
    }
}
