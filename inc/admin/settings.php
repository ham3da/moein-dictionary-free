<?php

class MDict_Settings
{

    public function __construct() {
        add_action('admin_menu', [$this, 'admin_menu_func']);
        add_action('admin_init', [$this, 'save_func']);
       

    }

   public static function  custom_css() {
        $font = self::get_font();
        $font_size = self::get_option('font_size', 14);
        
        $font_family = 'Vazirmatn_fa';
        switch ($font)
        {
            case 'Vazirmatn':
                $font_family = 'Vazirmatn';
                break;
            case 'Vazirmatn_fa':
                $font_family = 'Vazirmatn';
                break;
            case 'inherit':
                $font_family = 'inherit';
                break;
            default:
                $font_family = 'inherit';
                break;
        }
         ob_start();
        ?>
            .mdict, .mdict h1,
            .mdict h2, .mdict h3, .mdict h4,
            .ui-menu .ui-menu-item-wrapper
            {
                font-family: <?php echo $font_family == 'inherit'? 'inherit': "'$font_family'"; ?>;
                <?php
                if ($font == 'Vazirmatn_fa')
                {
                    ?>
                    font-feature-settings: "ss01";
                    <?php
                }
                ?>
            }
            .mdict, .mdict input.form-control, 
            .mdict select.form-control, 
            .mdict button.btn,
            .mdict a.mdict-word-link,
            .mdict h1.card-header
            {
            font-size: <?php echo sanitize_text_field($font_size)  ?>px;
            }
        <?php
         return ob_get_clean();
    }

    public static function get_option($key, $default = false) {

        $mdict_options = get_option('mdict_options', array('font_family' => 'Vazirmatn_fa'));
        return $mdict_options[$key] ?? $default;
    }

    public static function get_font() {

        return self::get_option('font_family', 'Vazirmatn_fa');
    }

    function admin_menu_func() {

        add_submenu_page(
                'mdict',
                __('Settings', 'mdict'),
                __('Settings', 'mdict'),
                'edit_posts',
                'mdict-settings',
                [$this, 'settings']
        );
    }

    function settings() {

        include MDC_PLUGIN_DIR . 'inc/admin/settings-template.php';
    }

    function wcpl_admin_notice__success() {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('Settings saved successfully.', 'mdict'); ?></p>
        </div>
        <?php
    }

    function save_func() {

        $page = filter_input(INPUT_GET, 'page'); 
        if ('POST' != sanitize_text_field($_SERVER['REQUEST_METHOD']) || $page != 'mdict-settings')
        {
            return;
        }
        if (!current_user_can('administrator') && !current_user_can('edit_posts'))
        {
            wp_die(__('You do not have permission to access this section!', 'mdict'), __('Error!', 'mdict'));
        }

        $mdict_options = get_option('mdict_options', array());
        $mdict_options['font_family'] = filter_input(INPUT_POST, 'font_family');
        $mdict_options['font_size'] = filter_input(INPUT_POST, 'font_size');
        $mdict_options['meaning_tooltip'] = filter_input(INPUT_POST, 'meaning_tooltip');
        
        
        $mdict_page_id = filter_input(INPUT_POST, 'mdict_page_id');
         

        update_option('mdict_options', $mdict_options);

        update_option('mdict_page', $mdict_page_id);
         
        add_action('admin_notices', [$this, 'wcpl_admin_notice__success']);
    }

}

new MDict_Settings();
