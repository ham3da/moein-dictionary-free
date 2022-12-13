<div id="mdict-plugin-container" class="mdict">
    <div class="mdict-lower">

        <div class="mdict-alert mdict-critical mdict-text-center">
            <h3 class="mdict-key-status failed"><?php echo __('Moein Dictionary', 'mdict') . __(' » ', 'mdict') . __('Settings', 'mdict') ?></h3>
            <p class="mdict-description">

            </p>
        </div>

        <div class="mdict-boxes">
            <div class="mdict-box">


                <div class="wrap mdict-settings">
                    <form method="post">
                        <table class="form-table" role="presentation">
                            <?php
                            $font_options = ['inherit' => __('Inherit', 'mdict'),
                                'Vazirmatn' => __('Vazir', 'mdict'),
                                'Vazirmatn_fa' => __('Vazir(Persian number)', 'mdict'),
                            ];
                            $mdict_options = get_option('mdict_options', array('font_family' => 'Vazirmatn_fa'));
                            $font_saved = $mdict_options['font_family'] ?? 'inherit';
                            $font_size = $mdict_options['font_size'] ?? '14';
                            $show_mean_tool = $mdict_options['meaning_tooltip'] ?? '0';
                            
                            $mdict_page_id = get_option('mdict_page');
                            ?>
                            <tr>
                                <th scope="row"><label for="mdict_page_id"><?php _e('Dictionary page', 'mdict'); ?></label></th>
                                <td>
                                    <?php
                                    $dropdown_args = array(
                                        'post_type' => 'page',
                                        'selected' => $mdict_page_id,
                                        'name' => 'mdict_page_id',
                                    );
                                    wp_dropdown_pages($dropdown_args);
                                    ?>
                                </td>
                            </tr> 
                            <tr>
                                <th scope="row">
                                    <label><?php _e('Word meaning tooltip', 'mdict'); ?></label></th>
                                <td>
                                    <label><?php _e('Active', 'mdict'); ?>&nbsp;
                                        <input name="meaning_tooltip" id="meaning_tooltip" type="checkbox" <?php echo checked(1, $show_mean_tool) ?> value="1" />
                                    </label>
                                    <p class="description"><?php _e('By activating this option, the meaning tooltip will be displayed after selecting the word on the site.', 'mdict'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="font_family"><?php _e('Font', 'mdict'); ?></label></th>
                                <td>

                                    <select name="font_family" id="font_family">
                                        <?php
                                        foreach ($font_options as $key => $value)
                                        {
                                            ?>
                                            <option <?php selected($font_saved, $key) ?> value="<?php echo $key ?>" ><?php echo $value ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                </td>
                            </tr> 
                            <tr>
                                <th scope="row"><label for="font_size"><?php _e('Font size', 'mdict'); ?></label></th>

                                <td><input name="font_size" type="number" id="font_size" value="<?php echo $font_size ?>" class="small-text"> px</td>

                            </tr> 
                        </table>
                        <div style="display: block">
                            <button type="submit" class="button button-primary"><?php _e('Save', 'mdict') ?></button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>