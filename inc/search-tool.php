<?php

class MDict_SearchTools
{

    private static $perpage = 20;

    public static function get_perpage() {
        return self::$perpage;
    }

    public static function set_perpage($perpage) {
        self::$perpage = $perpage;
    }

    public static function get_pagenum() {
        $num = filter_input(INPUT_GET, 'num');
        $pagenum = isset($num) ? absint($num) : 0;
        return max(1, $pagenum);
    }

    public static function get_by_id($id) {
        global $wpdb;
        $table = $wpdb->prefix . "pn_mdict";
        $query = $wpdb->prepare("SELECT * FROM `$table` WHERE `id`=%d", $id);
        return $wpdb->get_row($query);
    }

    public static function get_check_count() {
        return 36000;
    }

    public static function get_wors_count() {
        global $wpdb;
        $table = $wpdb->prefix . "pn_mdict";
        $query = "SELECT COUNT(*) FROM `$table`";
        return $wpdb->get_var($query);
    }

    public static function search($word, $sb = 1) {
        global $wpdb;
        $table = $wpdb->prefix . "pn_mdict";
        $current_page = self::get_pagenum();
        $per_page = self::$perpage;
        $offset = ($current_page - 1) * $per_page;
        $where = "";
        $order_by = "`Word` ASC";
        $query_total = 0;
        $query_res = null;
        
        if (!empty($word))
        {
            if ($sb == 1)
            {
                $where .= "Where `Word` LIKE '%s'";
                $order_by = "LOCATE('%s', Word), `Word` ASC";

                $query_total = $wpdb->prepare("SELECT COUNT(*) FROM `$table` $where", "%$word%");
                $query_res = $wpdb->prepare("SELECT * FROM `$table` $where ORDER BY $order_by LIMIT $offset , $per_page", "%$word%", $word);
            }
            else
            {

                $where .= "Where `Description` LIKE '%s'";
                $order_by = "`Word` ASC";

                $query_total = $wpdb->prepare("SELECT COUNT(*) FROM `$table` $where", "%$word%");
                $query_res = $wpdb->prepare("SELECT * FROM `$table` $where ORDER BY $order_by LIMIT $offset , $per_page", "%$word%");
            }
        }
        else
        {
            $query_total = "SELECT COUNT(*) FROM `$table`";
            $query_res = "SELECT * FROM `$table` ORDER BY $order_by LIMIT $offset , $per_page";
        }


        $total_items = $wpdb->get_var($query_total);
        $data = $wpdb->get_results($query_res);

        return ['total' => $total_items, 'data' => $data];
    }

    public static function search_ajax($word) {
        global $wpdb;
        $word = esc_sql($word);
        $table = $wpdb->prefix . "pn_mdict";
        $query_res = $wpdb->prepare("SELECT `id`, `Word` FROM `$table` WHERE `Word` LIKE '%s' ORDER BY LOCATE('%s', Word), `Word` ASC LIMIT 20", "%$word%", $word);
        $data = $wpdb->get_results($query_res, ARRAY_A);
        return $data;
    }

}
