<?php
// total page count calculation
$pages = ((int) ceil($total / $rpp));

// if it's an invalid page request
if ($current < 1)
{
    return;
}
elseif ($current > $pages)
{
    return;
}

// if there are pages to be shown
if ($pages > 1 || $alwaysShowPagination === true)
{
    ?>
    <ul class="<?php echo esc_attr(implode(' ', $classes)) ?>">
        <?php
        /**
         * Previous Link
         */
        // anchor classes and target

        $params = $get;
        $classes = array('first');
        $params2 = $params;
        $params2[$key] = '1';
        $href_first = ($target) . '?' . http_build_query($params2);
        $href_first = preg_replace(
                array('/=$/', '/=&/'),
                array('', '&'),
                $href_first
        );
        if ($current === 1)
        {
            $href = '#';
            array_push($classes, 'disabled');
        }
        ?>
        <li class="page-item <?php echo esc_attr(implode(' ', $classes)) ?>"><a class="page-link" href="<?php echo esc_url($href_first) ?>"><?php echo esc_html($first) ?></a></li>
        <?php
        $classes = array('copy', 'previous');

        $params[$key] = ($current - 1);

        $href = ($target) . '?' . http_build_query($params);
        $href = preg_replace(
                array('/=$/', '/=&/'),
                array('', '&'),
                $href
        );
        if ($current === 1)
        {
            $href = '#';
            array_push($classes, 'disabled');
        }
        ?>

        <li class="page-item <?php echo esc_attr( implode(' ', $classes)) ?>"><a class="page-link" href="<?php echo esc_url($href) ?>"><?php echo esc_html($previous) ?></a></li>
        <?php
        /**
         * if this isn't a clean output for pagination (eg. show numerical
         * links)
         */
        if (!$clean)
        {

            /**
             * Calculates the number of leading page crumbs based on the minimum
             *     and maximum possible leading pages.
             */
            $max = min($pages, $crumbs);
            $limit = ((int) floor($max / 2));
            $leading = $limit;
            for ($x = 0; $x < $limit; ++$x)
            {
                if ($current === ($x + 1))
                {
                    $leading = $x;
                    break;
                }
            }
            for ($x = $pages - $limit; $x < $pages; ++$x)
            {
                if ($current === ($x + 1))
                {
                    $leading = $max - ($pages - $x);
                    break;
                }
            }

            // calculate trailing crumb count based on inverse of leading
            $trailing = $max - $leading - 1;

            // generate/render leading crumbs
            for ($x = 0; $x < $leading; ++$x)
            {

                // class/href setup
                $params = $get;
                $params[$key] = ($current + $x - $leading);
                $href = ($target) . '?' . http_build_query($params);
                $href = preg_replace(
                        array('/=$/', '/=&/'),
                        array('', '&'),
                        $href
                );
                ?>
        <li class="page-item"><a class="page-link" data-pagenumber="<?php echo esc_attr($current + $x - $leading) ?>" href="<?php echo esc_url($href) ?>"><?php echo esc_html($current + $x - $leading) ?></a></li>
                <?php
            }

            // print current page
            ?>
        <li class="page-item active"><a class="page-link" data-pagenumber="<?php echo esc_attr($current) ?>" href="#"><?php echo esc_html($current) ?></a></li>
            <?php
            // generate/render trailing crumbs
            for ($x = 0; $x < $trailing; ++$x)
            {

                // class/href setup
                $params = $get;
                $params[$key] = ($current + $x + 1);
                $href = ($target) . '?' . http_build_query($params);
                $href = preg_replace(
                        array('/=$/', '/=&/'),
                        array('', '&'),
                        $href
                );
                ?>
        <li class="page-item"><a class="page-link" data-pagenumber="<?php echo esc_attr($current + $x + 1) ?>" href="<?php echo esc_url($href) ?>"><?php echo esc_html($current + $x + 1) ?></a></li>
                <?php
            }
        }

        /**
         * Next Link
         */
        // anchor classes and target
        $classes = array('copy', 'next');
        $params = $get;
        $params[$key] = ($current + 1);
        $href = ($target) . '?' . http_build_query($params);
        $href = preg_replace(
                array('/=$/', '/=&/'),
                array('', '&'),
                $href
        );
        if ($current === $pages)
        {
            $href = '#';
            array_push($classes, 'disabled');
        }

        $params2 = $params;
        $params2[$key] = $pages;
        $href_last = ($target) . '?' . http_build_query($params2);
        $href_last = preg_replace(
                array('/=$/', '/=&/'),
                array('', '&'),
                $href_last
        );
        ?>
        <li class="page-item <?php echo esc_attr(implode(' ', $classes)) ?>"><a class="page-link" href="<?php echo esc_url($href) ?>"><?php echo esc_html($next) ?></a></li>

        <li class="page-item <?php echo esc_attr(implode(' ', $classes)) ?>"><a class="page-link" href="<?php echo esc_url($href_last) ?>"><?php echo esc_html($last) ?></a></li>

    </ul>
    <?php
}
