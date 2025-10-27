<?php

class imcr {
    public function  __construct()
    {
        $this->dependencies();
        add_action('wp_enqueue_scripts', [$this, 'load_scripts']);
    }

    public function dependencies()
    {
        /**
         * 
         * Includes admin page files
         * 
         * */ 
        require_once IMCR_PATH . 'includes/admin-page/admin-page-settings.php';
        require_once IMCR_PATH . 'includes/admin-page/admin-menu-page.php';
        require_once IMCR_PATH . 'includes/admin-page/admin-page-fields.php';
        require_once IMCR_PATH . 'includes/frontend/display.php';
    }

    public function load_scripts()
    {
        //styles
        wp_enqueue_style('imcr-frontend-style', IMCR_URL . 'assets/css/frontend.css');

        //scripts
        wp_enqueue_script('imcr-frontend-script', IMCR_URL . 'assets/js/frontend.js');
    }
    
}

new imcr();