<?php

if (!defined('ABSPATH'))
{
    die("access denied!");
}

class MDict_Dashboard
{

    public function __construct() {
        add_action('admin_menu', [$this, 'admin_menu_func']);
    }

    function admin_menu_func() {

        add_menu_page(
                __('Moein Dictionary', 'mdict'),
                __('Moein Dictionary', 'mdict'),
                'edit_posts',
                'mdict',
                [$this, 'dashboard'],
                'dashicons-book',
                5
        );

        
    }

    function dashboard() {
        include MDC_PLUGIN_DIR . 'inc/admin/dashboard-template.php';
    }

}

new MDict_Dashboard();
