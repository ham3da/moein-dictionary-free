<?php
/*
  Plugin Name: Moein Dictionary(free)
  Description: Moein Persian dictionary(free version)
  Version: 1.4.2
  Author: ham3da
  Plugin URI: https://wordpress.org/plugins/moein-dictionary-free
  Author URI: https://ham3da.ir
  Text Domain: mdict
  Domain Path: /lang
  Requires PHP: 7.2
  Code: 3a0b1eec81400c2c0730578392ca53f6
 */

if (!defined('ABSPATH'))
{
    die("Access denied!");
}

define('MDC_PLUGIN_VERSION', '1.4.2');
define('MDC_PLUGIN_FILE', __FILE__);
define('MDC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MDC_PLUGIN_URL', plugin_dir_url(__FILE__));
define('MDC_HAM3DA', 0);

add_action('plugins_loaded', function () {
    load_plugin_textdomain('mdict', false, basename(dirname(__FILE__)) . '/lang');
});

require_once MDC_PLUGIN_DIR . 'inc/functions.php';
require_once MDC_PLUGIN_DIR . 'inc/install.php';

$args = array(
    'inc/search-tool',
    'inc/ajax',
    'inc/shortcodes/searchbox',
    'inc/admin/dashboard',
    'inc/admin/words-list',
    'inc/admin/add-word',
    'inc/admin/settings',
    'inc/admin/import-data',
    
);

mdict_autoload($args);