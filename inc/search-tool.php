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

        if (!empty($word))
        {
            if ($sb == 1)
            {
                $where .= "Where `Word` LIKE '%$word%'";
                $order_by = "LOCATE('$word', Word), `Word` ASC";
            }
            else
            {
                if (!empty($where))
                {
                    $where .= " AND";
                }
                else
                {
                    $where .= "Where";
                }
                $where .= " `Description` LIKE '%$word%'";
                $order_by = "`Word` ASC";
            }
        }


        $query_total = "SELECT COUNT(*) FROM `$table` $where";
        $query_res = "SELECT * FROM `$table` $where ORDER BY $order_by LIMIT $offset , $per_page";

        $total_items = $wpdb->get_var($query_total);
        $data = $wpdb->get_results($query_res);

        return ['total' => $total_items, 'data' => $data];
    }

    public static function search_ajax($word) {
        global $wpdb;
        $word = esc_sql($word);
        $table = $wpdb->prefix . "pn_mdict";
        $query_res = "SELECT `id`, `Word` FROM `$table` WHERE `Word` LIKE '%$word%' ORDER BY LOCATE('$word', Word), `Word` ASC LIMIT 20";
        $data = $wpdb->get_results($query_res, ARRAY_A);
        return $data;
    }

}
