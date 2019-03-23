<?php get_header(); ?>
<div id="content" class="site-content">
    <div class="header-content center-relative block archive-title">
        <h1 class="entry-title"><?php echo esc_html(cocobasic_archive_title($title)); ?></h1>
    </div>

    <div class="blog-holder block center-relative">
        <?php while (have_posts()) : the_post(); ?>

            <article <?php post_class('animate relative blog-item-holder'); ?> >        
                <div class="entry-holder">
                    <div class="entry-info">                
                        <div class="entry-date published"><?php echo get_the_date(); ?></div>                                                             
                    </div>                        
                    <h2 class="entry-title"><a href="<?php the_permalink($post->ID); ?>"><?php the_title(); ?></a></h2>             
                </div>
                <?php if (has_post_thumbnail($post->ID) || get_post_meta($post->ID, "post_blog_featured_image", true) !== '') : ?>        
                    <div class="post-thumbnail">
                        <?php
                        if (get_post_meta($post->ID, "post_blog_featured_image", true) !== ''):
                            echo '<a href="' . get_the_permalink($post->ID) . '"><img src="' . esc_url(get_post_meta($post->ID, "post_blog_featured_image", true)) . '" alt="' . get_the_title() . '" /></a>';
                        else:
                            echo '<a href="' . get_the_permalink($post->ID) . '">' . get_the_post_thumbnail() . '</a>';
                        endif;
                        ?>
                    </div>
                <?php endif; ?>
                <div class="clear"></div>
            </article>   
            <?php
        endwhile;
        echo '<div class="clear"></div>';
        echo '<div class="pagination-holder">';
        the_posts_pagination();
        echo '</div>';
        ?>
    </div>
</div>

<?php get_footer(); ?>