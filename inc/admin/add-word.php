<?php
if (!defined('ABSPATH'))
{
    die("access denied!");
}

class MDict_Word_Add
{

    public function __construct() {
        add_action('admin_menu', [$this, 'admin_menu_func']);
        add_action('admin_init', [$this, 'save_func']);
    }

    function admin_menu_func() {

        add_submenu_page(
                'mdict',
                __('Add/Edit Word', 'mdict'),
                __('Add Word', 'mdict'),
                'edit_posts', 'mdict-add',
                [$this, 'mdict_add']
        );
    }

    function mdict_add() {


        $item_id = filter_input(INPUT_GET, 'item_id');

        $id = absint($item_id);

        $word = null;
        $des = null;

        if ($item_id)
        {
            $title = __('Edit Word', 'mdict');
            $item = MDict_SearchTools::get_by_id($id);
            $word = $item->Word;
            $des = $item->Description;
        }
        else
        {
            $title = __('Add Word', 'mdict');
        }
        ?>

        <div id="mdict-plugin-container" class="mdict">
            <div class="mdict-lower">

                <div class="mdict-alert mdict-critical mdict-text-center">
                    <h3 class="mdict-key-status failed"><?php
                        _e('Moein Dictionary', 'mdict');
                        _e(' » ', 'mdict');
                        echo esc_html($title)
                        ?></h3>
                    <p class="mdict-description">

                    </p>
                </div>

                <div class="mdict-boxes">
                    <div class="mdict-box">
                        <form method="post">
                            <input type="hidden" name="item_id" value="<?php echo esc_attr($item_id) ?>">
                            <div class="wrap">
                                <table class="form-table" role="presentation">
                                    <tr>
                                        <th scope="row"><label for="word"><?php _e('Word', 'mdict'); ?></label></th>
                                        <td><input name="word" type="text" id="word" value="<?php echo sanitize_text_field($word) ?>" class="regular-text"></td>
                                    </tr> 
                                    <tr>
                                        <th scope="row"><label for="description"><?php _e('Description', 'mdict'); ?></label></th>
                                        <td>
                                            <textarea class="regular-text" id="description" name="description" rows="5" cols="10"><?php echo esc_textarea($des) ?></textarea>
                                        </td>
                                    </tr> 
                                </table>
                                <p>
                                    <button type="submit" class="button button-primary"><?php _e('Save', 'mdict') ?></button>
                                </p>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    function admin_notice__error() {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><?php _e('The word must not be empty!', 'mdict'); ?></p>
        </div>
        <?php
    }

    function save_func() {

        $page = filter_input(INPUT_GET, 'page');
        $item_id = filter_input(INPUT_GET, 'item_id');

        if ($page != 'mdict-add' || 'POST' != sanitize_text_field($_SERVER['REQUEST_METHOD']))
        {
            return;
        }


        if (!current_user_can('administrator') && !current_user_can('edit_posts'))
        {
            wp_die(__('You do not have permission to access this section!', 'mdict'), __('Error!', 'mdict'));
        }

        global $wpdb;
        $table = $wpdb->prefix . "pn_mdict";

        $id = absint($item_id);
        $data_id = 0;
        $data = null;
        if ($id)
        {
            $data = MDict_SearchTools::get_by_id($id);
        }

        $data_array = array();

        $data_array['Word'] = filter_input(INPUT_POST, 'word');
        $data_array['Description'] = filter_input(INPUT_POST, 'description');

        if (empty(trim($data_array['Word'])))
        {
            add_action('admin_notices', [$this, 'admin_notice__error']);
            return;
        }

        if (isset($data->id))
        {
            $data_id = $data->id;
            $wpdb->update($table, $data_array, array('id' => $data_id));
            do_action('mdict_word_edit', $data_id, $data_array);
        }
        else
        {
            $wpdb->insert($table, $data_array);
            $data_id = $wpdb->insert_id;
            do_action('mdict_word_add', $data_id, $data_array);

            $url = add_query_arg(array('page' => 'mdict-add', 'item_id' => $data_id,), admin_url('admin.php'));
            wp_redirect(esc_url_raw($url));
            exit();
        }
    }

}

new MDict_Word_Add();
