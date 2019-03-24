<div <?php post_class('portfolio-item-wrapper'); ?>>
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            echo '<div class="portfolio-content center-relative content-1170">';
            the_content();
            echo '</div>';
            ?>
            <div class="nav-links">
                <div class="content-1170 center-relative">
                    <?php
                    $prev_post = get_previous_post();
                    if (is_a($prev_post, 'WP_Post')):
                        ?>
                        <div class="nav-previous">
                            <?php previous_post_link('%link'); ?>
                            <div class="arrow-holder">&#8592;</div>
                            <div class="clear"></div>
                        </div>
                    <?php endif; ?>
                    <?php
                    $next_post = get_next_post();
                    if (is_a($next_post, 'WP_Post')):
                        ?>
                        <div class="nav-next">
                            <?php next_post_link('%link'); ?>
                            <div class="arrow-holder">&#8594;</div>
                            <div class="clear"></div>
                        </div>
                    <?php endif; ?>
                    <div class="clear"></div>
                </div>
            </div>
            <?php
            comments_template();
        endwhile;
    endif;
    ?>
</div>
