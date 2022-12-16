<div id="mdict-plugin-container" class="mdict">
    <div class="mdict-lower">
        <div class="mdict-alert mdict-critical mdict-text-center">
            <h3 class="mdict-key-status failed"><?php _e('Moein Dictionary', 'mdict'); _e(' » ', 'mdict') ; _e('Data installation', 'mdict') ?></h3>
            <p class="mdict-description">

            </p>
        </div>

        <div class="mdict-boxes">
            <div class="mdict-box">
                <div class="wrap">
                    <table class="form-table" role="presentation">
                        <?php
                        for ($index = 1; $index <= 8; $index++)
                        {
                            $file_name = 'data_' . $index;
                            $is_installed = MDict_Import_Data::is_installed($file_name);
                            ?>
                            <tr>
                                <th scope="row"><label for="data_<?php echo esc_attr($index) ?>"><?php printf(__('Part %d', 'mdict'), $index); ?></label></th>
                                <td>
                                    <?php
                                    if ($index <= 4)
                                    {
                                        ?>
                                    <button <?php echo ($is_installed ? 'disabled="disabled"' : '') ?> name="data_<?php echo esc_attr($index) ?>" type="button" id="data_<?php echo esc_attr($index) ?>" data-file_name="<?php echo 'data_' . esc_attr($index) ?>" class="button button-primary mdict-install"><?php ($is_installed ? _e('Installed', 'mdict') : _e('Install', 'mdict')) ?></button>
                                        &nbsp;
                                        <progress class="progress_loading" style="display: none"
                                                  indeterminate 
                                                  role="progressbar" 
                                                  aria-describedby="loading-zone"
                                                  tabindex="-1"></progress>
                                        <p style="display: none; padding: 0" class="install-note"><?php _e('Please be patient. This may take a minute or more.', 'mdict') ?></p>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p>
                                           <?php
                                           $pro_link = '<br><a href="https://www.zhaket.com/web/moien-farhang-plugin">'.__('Go to commercial version', 'mdict').'</a>';
                                           printf(__('This part is only available on the commercial version. %s', 'mdict'), $pro_link);
                                           ?> 
                                        </p>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr> 
                            <?php
                        }
                        ?>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>