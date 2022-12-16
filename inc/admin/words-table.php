<?php

class MDict_Words_Table extends WP_List_Table
{

    function __construct() {

        parent::__construct(array(
            'singular' => __('Word', 'mdict'), //singular name of the listed records
            'plural' => __('Words', 'mdict'), //plural name of the listed records
            'ajax' => false
        ));

        global $wpdb;
        $table = $wpdb->prefix . "pn_mdict";

        $action = filter_input(INPUT_POST, 'action');
        $action2 = filter_input(INPUT_POST, 'action2');

        if (($action == 'delete') || ( $action2 == 'delete'))
        {


            $posted_data = filter_input_array(INPUT_POST);

            if (isset($posted_data['id']))
            {
                $ids = implode(',', $posted_data['id']);

                $wpdb->query($wpdb->prepare("DELETE FROM `$table` WHERE `id` IN(%s)", $ids));

                $count = count($posted_data['id']);
                add_action('admin_notices', function () use ($count) {
                    $class = 'notice notice-success is-dismissible';

                    $message = sprintf(__('%d item(s) were removed.', 'mdict'), $count);
                    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
                });
            }
            else
            {
                add_action('admin_notices', function () {
                    $class = 'notice notice-error is-dismissible';
                    $message = __('Please select one or more.', 'mdict');
                    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
                });
            }
        }
    }

    protected function column_default($item, $column_name) {
        parent::column_default($item, $column_name);
    }

    function no_items() {
        _e('Nothing found!', 'mdict');
    }

    function get_columns() {
        return $columns = array(
            'cb' => '<input type="checkbox" />',
            'Word' => __('Word', 'mdict'),
            'Description' => __('Description', 'mdict'),
            'id' => __('ID', 'mdict'),
        );
    }

    public function get_sortable_columns() {
        return $sortable = array(
            'id' => 'id',
            'Word' => 'Word',
        );
    }

    function get_bulk_actions() {
        $actions = array(
            'delete' => __('Delete', 'mdict'),
        );
        return $actions;
    }

    function prepare_items() {
        global $wpdb;

        $this->_column_headers = $this->get_column_info();
        $per_page = $this->get_items_per_page('mdict_wl_per_page', 20);
        $current_page = $this->get_pagenum();

        $offset = ($current_page - 1) * $per_page;

        $table_name = $wpdb->prefix . "pn_mdict";

        $s = isset($_REQUEST["s"]) ? sanitize_text_field($_REQUEST["s"]) : '';

        $orderby = filter_input(INPUT_GET, 'orderby');
        $orderby = !empty($orderby) ? esc_sql($orderby) : 'id';

        $order = filter_input(INPUT_GET, 'order');
        $order = !empty($order) ? esc_sql($order) : 'ASC';

        if (!empty($s))
        {
            $s = esc_sql($s);

            $totalitems = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM `$table_name` Where `Word` LIKE '%s'", $s));
            $totalpages = ceil($totalitems / $per_page);

            if (!empty($orderby) & !empty($order))
            {
                $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM `$table_name` Where `Word` LIKE '%s' ORDER BY $orderby $order LIMIT $offset, $per_page", $s));
            }
            else
            {
                $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM `$table_name` Where `Word` LIKE '%s' LIMIT $offset, $per_page", $s));
            }
        }
        else
        {
            $totalitems = $wpdb->get_var("SELECT COUNT(*) FROM `$table_name`");
            $totalpages = ceil($totalitems / $per_page);
            
            if (!empty($orderby) & !empty($order))
            {
                $this->items = $wpdb->get_results("SELECT * FROM `$table_name` ORDER BY $orderby $order LIMIT $offset, $per_page");
            }
            else
            {
                $this->items = $wpdb->get_results("SELECT * FROM `$table_name` LIMIT $offset, $per_page");
            }
        }


        $this->set_pagination_args(array(
            "total_items" => $totalitems,
            "total_pages" => $totalpages,
            "per_page" => $per_page,
        ));
    }

    function column_Word($item) {

        $actions = array(
            'edit' => '<a href="' . esc_url(admin_url('admin.php?page=mdict-add&item_id=' . $item->id)) . '">' . __('Edit', 'mdict') . '</a>',
        );
        $link = '<a href="' . esc_url(admin_url('admin.php?page=mdict-add&item_id=' . $item->id)) . '">' . esc_html($item->Word) . '</a>';
        return sprintf('%1$s %2$s', '<strong>' . $link . '</strong>', $this->row_actions($actions));
    }

    protected function get_primary_column_name() {
        return 'Word';
    }

    function column_Description($item) {
        return mdict_get_excerot($item->Description, 10);
    }

    function column_id($item) {

        return'<strong>' . $item->id . '</strong>';
    }

    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="id[]" value="%s" />', $item->id
        );
    }

}
