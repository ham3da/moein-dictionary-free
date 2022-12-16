<div class="bootstrap-iso rtl mdict">
    <div class="col-12">
        <div class="grid-view">
            <div class="card mb-2">
                <div class="card-body pb-0">
                    <div class="card-title text-center border-bottom"><?php _e('Word search', 'mdict'); ?></div> 
                    <form method="get" class="pt-1 pb-1 mb-1">
                        <div class="form-row centered">
                            <div class="form-group col-md-6">
                                <div class=" ui-autocomplete-wrapper dictionary-search">
                                    <input utocomplete="off" id="mdict-word" name="word" type="text" placeholder="<?php _e('Enter a word', 'mdict'); ?>" value="<?php echo $word_w ?>" class="form-control">
                                </div>
                            </div> 
                            <div class="form-group col-md-3">
                                <select id="search_by" name="sb" class="form-control">
                                    <option <?php echo selected(1, $sb, false) ?> value="1"><?php _e('Search in words', 'mdict'); ?></option> 
                                    <option <?php echo selected(2, $sb, false) ?> value="2"><?php _e('Search in the meaning of words', 'mdict'); ?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <button type="submit" class="btn btn-primary pr-4 pl-4"><?php _e('Search', 'mdict'); ?></button>
                            </div>
                        </div> 

                    </form>
                </div>
            </div>

            <div class="card mb-2">
                <h1 class="card-header h6">
                    <?php $word_w ? printf(__('Searching for the meaning of %s', 'mdict'), '<b>' . $word_w . '</b>') : _e('List of words', 'mdict'); ?> <span class="float-left">(<?php _e('Total:', 'mdict'); ?> <?php echo number_format_i18n($total) ?>)</span>
                </h1> 
                <div class="card-body p-4 words-items">
                    <?php
                    if ($word_list)
                    {
                        $current_page_url = get_permalink();
                        $index = 0;
                        foreach ($word_list as $word_item)
                        {
                            $index++;
                            $calc_index = (MDict_SearchTools::get_pagenum() - 1) * MDict_SearchTools::get_perpage() + $index;
                            $word_url = add_query_arg(array('wid' => $word_item->id), $current_page_url);
                            ?>
                            <div class="border-bottom p-2">
                                <h2 class="font-weight-bold h6"><a class="mdict-word-link" href="<?php echo esc_url($word_url) ?>"><?php echo esc_html($word_item->Word) ?></a></h2> 
                                <div class="detail">
                                    <?php
                                    $des = mdict_get_excerot($word_item->Description);
                                    echo wp_kses( wpautop($des), 'post');
                                    ?>
                                </div> 
                            </div>
                            <?php
                        }
                        ?>
                        <br>
                        <?php
                        $pg = mdict_pagination($total, MDict_SearchTools::get_pagenum(), MDict_SearchTools::get_perpage());
                        echo wp_kses($pg, 'post');
                    }
                    else
                    {
                        ?>
                        <p><?php _e('Nothing found!', 'mdict'); ?></p>
                        <?php
                    }
                    ?>
                </div>
            </div>   
        </div>
    </div>
</div>