<?php

class MDict_Ajax
{

    public static function init() {
        self::add_ajax_events();
    }

    public static function add_ajax_events() {
        $ajax_events = array(
            'search_word' => true,
            'import_data' => false,
            'check_register'=> false,
        );


        foreach ($ajax_events as $ajax_event => $nopriv)
        {
            add_action('wp_ajax_mdict_' . $ajax_event, array(__CLASS__, $ajax_event));

            if ($nopriv)
            {
                add_action('wp_ajax_nopriv_mdict_' . $ajax_event, array(__CLASS__, $ajax_event));
            }
        }
    }

    public static function check_register() 
    {
    }
    
    public static function import_data() {
        $data_file = $_POST['data_file'] ?? null;
        if (!$data_file)
        {
            return false;
        }

        $res = MDict_Import_Data::import($data_file);
        echo wp_send_json($res);
        wp_die();
    }

    public static function search_word() {

        $word = $_POST['word'] ?? null;
        if (!$word)
        {
            return false;
        }
        $result = MDict_SearchTools::search_ajax($word);
        echo wp_send_json(array('res' => 1, 'data' => $result));
        wp_die();
    }

}

MDict_Ajax::init();
