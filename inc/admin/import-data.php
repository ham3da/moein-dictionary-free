<?php

if (!defined('ABSPATH'))
{
    die("access denied!");
}

class MDict_Import_Data
{

    public function __construct() {
        add_action('admin_menu', [$this, 'admin_menu_func']);
        add_action('admin_notices', [$this, 'check_data_installed']);
    }

    function check_data_installed() {
        
        $page = filter_input(INPUT_GET, 'page'); 
        if ($page != 'mdict-data-intall')
        {
            $w_count = MDict_SearchTools::get_wors_count();
            if ($w_count < MDict_SearchTools::get_check_count())
            {
                $class = 'notice notice-error';
                $message = __('Moein Dictionary data is not fully installed.', 'mdict') . ' 🔔 <a href="' . esc_url(admin_url('admin.php?page=mdict-data-intall')) . '">' . __('Install the data', 'mdict') . '</a>';
                printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
            }
        }
    }

    function admin_menu_func() {

        add_submenu_page(
                'mdict',
                __('Data installation', 'mdict'),
                __('Data installation', 'mdict'),
                'edit_posts',
                'mdict-data-intall',
                [$this, 'data_intall']
        );
        global $submenu;
        if (isset($submenu['mdict'][0][0]))
        {
            $submenu['mdict'][0][0] = __('Dashboard', 'mdict');
        }
    }

    function data_intall() {

        include MDC_PLUGIN_DIR . 'inc/admin/data-template.php';
    }

    public static function is_installed($file_name) {

        $all_data = [
            'data_1' => '174,5281', 
            'data_2' => '5282,10000',
            'data_3' => '10001,15483', 
            'data_4' => '15484,20000',
            'data_5' => '20001,25183', 
            'data_6' => '25184,30000',
            'data_7' => '30001,33006',
            'data_8' => '33007,36271'
            ];

        global $wpdb;
        $table = $wpdb->prefix . "pn_mdict";

        $ids = $all_data[$file_name] ?? null;
        if ($ids)
        {
            $query_res = "SELECT COUNT(*) FROM $table WHERE `id` IN($ids)";
            $res = $wpdb->get_var($query_res);
            return $res == 2;
        }
        else
        {
            return false;
        }
    }

    public static function import($file_name) {
        $data_file_path = MDC_PLUGIN_DIR . "data/$file_name.sql";
        if (file_exists($data_file_path))
        {
            global $wpdb;
            $table = $wpdb->prefix . "pn_mdict";

            if (self::is_installed($file_name))
            {
                return ['result' => 0, 'last_index' => 0, 'error' => __('It is already installed.', 'mdict')];
            }


            $sql_content = file_get_contents(MDC_PLUGIN_DIR . "data/$file_name.sql");

            $sql_queries = str_replace('pn_mdict', $table, $sql_content);

            set_time_limit(0);
            if (WP_DEBUG)
            {
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            }

            $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            if (mysqli_connect_errno())
            {
                die( "Failed to connect to MySQL: " . mysqli_connect_error());
            }

            $utf8 = mysqli_set_charset($con, "utf8");
            $last_index = 0;

            // Run the SQL
            if (mysqli_multi_query($con, $sql_queries))
            {
                do
                {
                    mysqli_next_result($con);
                    $last_index++;
                }
                while (mysqli_more_results($con));
            }

            $error = "";
            $result = 1;
            if (mysqli_errno($con))
            {
                $error = mysqli_error($con);
                $result = 0;
            }

            return ['result' => $result, 'last_index' => $last_index, 'error' => $error];
        }
        else
        {
            $error = __('Data not found!', 'mdict');
            return ['result' => false, 'last_index' => 0, 'error' => $error];
        }
    }

}

new MDict_Import_Data();
