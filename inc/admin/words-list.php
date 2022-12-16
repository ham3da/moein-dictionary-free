<?php

if (!defined('ABSPATH'))
{
    die("access denied!");
}

class MDict_Words_List
{

    public function __construct() {
        add_action('admin_menu', [$this, 'admin_menu_func']);
        add_action('admin_init', [$this, 'save_func']);
    }

    function admin_menu_func() {

        $hook = add_submenu_page(
                'mdict',
                __('Words List', 'mdict'),
                __('Words List', 'mdict'),
                'edit_posts',
                'mdict-words',
                [$this, 'words_list']
        );
        add_action("load-$hook", [$this, 'add_options']);
    }

    function add_options() {
        require_once MDC_PLUGIN_DIR . 'inc/admin/words-table.php';
        
        global $word_list_table;
        $option = 'per_page';
        $args = array(
            'label' => __('Words', 'mdict'),
            'default' => 20,
            'option' => 'mdict_wl_per_page'
        );
        add_screen_option($option, $args);

        $word_list_table = new MDict_Words_Table();
    }

    function words_list() {
        global $word_list_table;

        $word_list_table->prepare_items();
        ?>
        <div class="wrap mdict">
            <h1 class="wp-heading-inline"><?php _e('List of words', 'mdict'); ?></h1>
            <a href="<?php echo esc_url(admin_url('admin.php?page=mdict-add')) ?>" class="page-title-action"><?php _e('Add Word', 'mdict') ?></a>
            <hr class="wp-header-end">
            <form method="post" action="">
                <?php
                $word_list_table->search_box(__('Search word', 'mdict'), 'search_id');
                $word_list_table->display();
                ?>
            </form>
        </div>
        <?php
    }

    function save_func() {
        
    }

}

new MDict_Words_List();
