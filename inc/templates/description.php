<div class="bootstrap-iso rtl mdic-description-parent mdict">
    <div class="col-12 mdic-description">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="text-justify"><?php echo esc_html($word_item->Word) ?></h1>
            </div>
        </div>

        <div class="content text-justify">
            <?php
            $des = $word_item->Description;
            echo wp_kses(wpautop($des), 'post');
            ?>
        </div>

        <div class="m-t-2 text-left">
            <a class="btn print-btn btn-lg bg-purple mdict-print no-print" title="<?php _e('Print', 'mdict') ?>"></a>        
        </div>

    </div>
    <?php
    ?>
</div>