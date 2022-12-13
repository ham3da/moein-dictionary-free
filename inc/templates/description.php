<div class="bootstrap-iso rtl mdic-description-parent mdict">
    <div class="col-12 mdic-description">
        <div class="row">
            <div class="col-sm-11">
                <h1 class="text-justify"><?php echo $word_item->Word ?></h1>
            </div>
            <div class="col-sm-1 m-t-2 pull-left">
                <a class="btn print-btn btn-lg bg-purple mdict-print no-print" title="<?php _e('Print', 'mdict') ?>"></a>        
            </div>
        </div>

        <div class="content text-justify">
            <?php
            $des = ($word_item->Description);
            echo wpautop($des);
            ?>
        </div>

    </div>
    <?php
    ?>
</div>