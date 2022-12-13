<?php

function mdict_pagination($items_count, $current_page, $per_page) {
    if (!class_exists('Pagination'))
    {
        require_once MDC_PLUGIN_DIR . 'inc/pagination/Pagination.class.php';
    }

    $temp = '<div class="ltr"><nav aria-label="navigation">';
    $pagination = new Pagination();
    $pagination->setCurrent($current_page); //
    $pagination->setTotal($items_count); // grab rendered/parsed pagination markup
    $pagination->setPrevious(__("&laquo;", 'mdict'));
    $pagination->setNext(__("&raquo;", 'mdict'));
    $pagination->setFirst(__("First", 'mdict'));
    $pagination->setLast(__("Last", 'mdict'));

    $pagination->setRPP($per_page);
    $markup = $pagination->parse();
    $temp .= $markup;
    $temp .= '</nav></div>';
    $html = $temp;
    return apply_filters('mdict_pagination', $html, $items_count, $current_page, $per_page);
}

/**
 * Load CSS and JS on the front end
 */
add_action('wp_enqueue_scripts', 'mdict_enqueue_scripts');

function mdict_enqueue_scripts() {

    $mdict_page_id = get_option('mdict_page');

    wp_enqueue_script('mdict-script', MDC_PLUGIN_URL . 'assets/scripts.js', array('jquery'), MDC_PLUGIN_VERSION, true);
    wp_localize_script('mdict-script', 'mdict_vars',
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'mdict_search_des' => __('Search for words in the dictionary', 'mdict'),
                'mean_search' => __('Meaning', 'mdict'),
                'mdict_page' => get_permalink($mdict_page_id),
                'mdict_current_page' => get_permalink(),
            )
    );
    wp_enqueue_script('jquery-print', MDC_PLUGIN_URL . 'assets/jquery.print.js', array('jquery'), MDC_PLUGIN_VERSION, true);

    $meaning_tooltip = mdict_get_option('meaning_tooltip');
    if ($meaning_tooltip == 1)
    {
        wp_enqueue_script('mdict-tooltip', MDC_PLUGIN_URL . 'assets/tooltip.js', array('jquery'), MDC_PLUGIN_VERSION, true);
    }




    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-autocomplete');
    wp_enqueue_style('jquery-ui-core', MDC_PLUGIN_URL . 'assets/jquery-ui.min.css', false);

    wp_enqueue_style('mdic-style', MDC_PLUGIN_URL . 'assets/style.css', false, MDC_PLUGIN_VERSION);
    $cs_css = MDict_Settings::custom_css();
    wp_add_inline_style('mdic-style', $cs_css);

    wp_enqueue_style('bootstrap-iso', MDC_PLUGIN_URL . 'assets/bootstrap-iso.min.css', false);
    wp_enqueue_style('mdic-print', MDC_PLUGIN_URL . 'assets/print.css', false, MDC_PLUGIN_VERSION, 'print');
}

/**
 * Load CSS and JS on admin panel
 */
add_action('admin_enqueue_scripts', 'mdict_admin_scripts');

function mdict_admin_scripts() {

    wp_enqueue_style("mdict-admin-style", MDC_PLUGIN_URL . "assets/admin-style.css", false, MDC_PLUGIN_VERSION);
    $cs_css = MDict_Settings::custom_css();
    wp_add_inline_style('mdict-admin-style', $cs_css);

    wp_enqueue_script('mdict-script-admin', MDC_PLUGIN_URL . 'assets/admin.js', array('jquery'), MDC_PLUGIN_VERSION, true);
    wp_localize_script('mdict-script-admin', 'mdict_admin_vars', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'installed' => __('Installed', 'mdict'),
        'installing' => __('Installing', 'mdict'),
        'install' => __('Install', 'mdict'),
        'lic_registrationSuccess' => __('Plugin license registration successful.', 'mdict'),
        'lic_failed_error' => __('Error: The request failed!', 'mdict'),
        'lic_errorString' => __('Error: ', 'mdict'),
        'lic_enter' => __("Please enter the activation code!", 'mdict')
            )
    );
}

function mdict_get_excerot($content, $limit = 40) {
    $words_in = explode(' ', $content);
    if (count($words_in) > $limit)
    {
        $detail = implode(' ', array_slice($words_in, 0, $limit)) . ' ...';
        return $detail;
    }
    else
    {
        return $content;
    }
}

function mdict_autoload($file) {
    if (is_array($file))
    {
        foreach ($file as $item)
        {
            $file_dir = MDC_PLUGIN_DIR . $item . ".php";
            if (file_exists($file_dir))
            {
                include_once($file_dir);
            }
        }
    }
    else
    {

        $file_dir = MDC_PLUGIN_DIR . $file . ".php";
        if (file_exists($file_dir))
        {
            include_once($file_dir);
        }
    }
}

/**
 * 
 * @param type $msg
 * @param type $title
 * @param type $type
 * @param type $bg_color
 * @return type
 */
function mdict_show_admin_message($msg = '', $title = '', $type = 'notice updated is-dismissible', $bg_color = '#F2F2F2') {
    $msg2 = '<div  class="' . $type . '"  style="background-color: ' . $bg_color . ';">';
    $msg2 .= '<p>
                    <strong>' . $title . '</strong> ' . $msg .
            '</p>'
            . '</div>';
    $msg2 = apply_filters('mdict_show_admin_message_filter', $msg2, $title, $type);
    return $msg2;
}

function mdict_get_option($key, $default = false) {
    $mdict_options = get_option('mdict_options', array());
    return $mdict_options[$key] ?? $default;
}
