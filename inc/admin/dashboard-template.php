<?php
$w_count = MDict_SearchTools::get_wors_count();
?>

<div id="mdict-plugin-container" class="mdict">
    <div class="mdict-lower">
        <div class="mdict-alert mdict-critical mdict-text-center">
            <h3 class="mdict-key-status failed"><?php _e('Moein Persian dictionary', 'mdict'); ?></h3>
            <p class="mdict-description">

            </p>
        </div>
        <div class="mdict-boxes">
            <div class="mdict-box">
                <div class="">
                    <div class="mdict-text">
                        <h3><?php _e('About the plugin', 'mdict') ?></h3>
                    </div>

                    <ul>
                        <li>✔ <?php printf(__('Name: %s', 'mdict'), __('Moein Dictionary(free)', 'mdict')); ?></li>
                        <li>✔ <?php
                            printf(__('Number of available words: %s', 'mdict'), number_format($w_count));
                            if ($w_count < MDict_SearchTools::get_check_count())
                            {
                                ?>🔔 <a href="<?php echo esc_url(admin_url('admin.php?page=mdict-data-intall')) ?>"><?php _e('Install the data', 'mdict') ?></a><?php
                            }
                            ?>
                        </li>
                        <li>✔ <?php printf(__('Version: %s', 'mdict'), MDC_PLUGIN_VERSION . ' - ' . __('free version', 'mdict')); ?></li>

                    </ul>

                    <div class="mdict-text">
                        <h3><?php _e('User manual:', 'mdict') ?></h3>
                    </div>
                    <p>✔️ <?php _e('Use the <b>mdict_search</b> shortcode to display the dictionary search engine.', 'mdict') ?></p>
                    <h4><?php _e('Sample:', 'mdict') ?></h4>
                    <ul>

                        <li>
                            ▪ <?php _e('Using the shortcode in the content of the pages:', 'mdict') ?>
                            <pre style="padding: 10px"><code>[mdict_search]</code></pre>
                        </li>
                        <li>▪️ <?php _e('You can also use shortcode inside php codes:', 'mdict') ?>
                            <div style="padding: 10px"><code>echo do_shortcode('[mdict_search]'); </code>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
