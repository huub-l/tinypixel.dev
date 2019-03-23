<?php get_header(); ?>

<div id="content" class="site-content">
    <?php
    $allowed_html_array = cocobasic_allowed_html();
    if (have_posts()) :
        while (have_posts()) : the_post();
            ?>

            <div <?php post_class(); ?>>                   
                <div class="section-wrapper">                                                                   
                    <?php if (get_post_meta($post->ID, "page_show_title", true) != 'no'): ?>
                        <h1 class="entry-title page-title block content-1170 center-relative">
                            <?php
                            if (get_post_meta($post->ID, "page_custom_title", true) != '') {
                                echo do_shortcode(wp_kses(get_post_meta($post->ID, "page_custom_title", true), $allowed_html_array));
                            } else {
                                echo get_the_title();
                            }
                            ?>
                        </h1>

                        <?php if (get_option('cocobasic_title_image') !== '' && get_option('cocobasic_title_image') !== false): ?>
                            <img class="title-logo center-relative block" src="<?php echo esc_url(get_option('cocobasic_title_image', get_template_directory_uri() . '/images/icon_plus.png')); ?>" alt="<?php the_title_attribute(); ?>" />
                        <?php endif; ?>

                    <?php endif; ?>                        

                    <div class="content-wrapper block content-1170 center-relative">    
                        <?php
                        the_content();

                        $defaults = array(
                            'before' => '<p class="wp-link-pages top-50"><span>' . esc_html__('Pages:', 'kapena-wp') . '</span>',
                            'after' => '</p>'
                        );
                        wp_link_pages($defaults);
                        ?>
                        <div class="clear"></div>
                    </div>                    
                </div>
            </div> 
            <?php
            comments_template();
        endwhile;
    endif;
    ?>    
</div>

<?php get_footer(); ?>