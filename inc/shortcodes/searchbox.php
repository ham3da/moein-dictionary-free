<?php

add_shortcode('mdict_search', 'MDict_SearchBox::search_box');

class MDict_SearchBox
{

    public static function search_box($atts, $content) {

        if (is_admin())
        {
            return;
        }

        $attributes = shortcode_atts(array('perpage' => 20), $atts);
        $perpage = $attributes['perpage'];

        $wid = filter_input(INPUT_GET, 'wid');
        $wid = absint($wid);

        $word_w = filter_input(INPUT_GET, 'word');

        $sb = filter_input(INPUT_GET, 'sb');
        $sb = !empty($sb) ? $sb : 1;

        if ($wid > 0)
        {
            $word_item = MDict_SearchTools::get_by_id($wid);

            ob_start();
            include MDC_PLUGIN_DIR . 'inc/templates/description.php';
            return ob_get_clean();
        }
        else
        {

            $word_w = urldecode($word_w);
            MDict_SearchTools::set_perpage($perpage);
            $res = MDict_SearchTools::search($word_w, $sb);

            $total = $res['total'];
            $word_list = $res['data'];

            ob_start();
            include MDC_PLUGIN_DIR . 'inc/templates/searchbox.php';
            return ob_get_clean();
        }
    }

}
