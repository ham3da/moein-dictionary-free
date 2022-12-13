<?php

register_activation_hook(MDC_PLUGIN_FILE, function () {
    global $wpdb;
    $table = $wpdb->prefix . "pn_mdict";
    $sql = "CREATE TABLE IF NOT EXISTS $table(
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `Word` varchar(100) NOT NULL,
            `Description` text NULL,
            PRIMARY KEY ( `id` ),
            KEY `Word` (`Word`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;";
    $wpdb->query($sql);

    $mdict_page_arg = array(
        'comment_status' => 'closed',
        'ping_status' => 'closed',
        'post_name' => 'moein-dictionary',
        'post_status' => 'publish',
        'post_title' => __('Moein dictionary', 'mdict'),
        'post_type' => 'page',
        'post_content' => '[mdict_search]'
    );

    $mdict_page_id = get_option('mdict_page');
    if (!$mdict_page_id)
    {
        $args = array('name' => "moein-dictionary", 'post_type' => 'page', 'post_status' => 'publish', 'posts_per_page' => 1);
        $posts = get_posts($args);
        if (!$posts)
        {
            $page_id = wp_insert_post($mdict_page_arg);
            update_option('mdict_page', $page_id);
        }
    }
});
