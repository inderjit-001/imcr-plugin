<?php

add_action('admin_menu', 'imcr_options_page');
function imcr_options_page()
{
    add_menu_page(
        'IMCR', // page title
        'IMCR Options', //menu title
        'manage_options', // capabilities
        'imcr', //slug
        'imcr_options_page_html', // callback
        'dashicons-superhero', // dashicon
        20
    );
}