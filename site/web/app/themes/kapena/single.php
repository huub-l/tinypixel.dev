<?php
get_header();
$allowed_html_array = cocobasic_allowed_html();
?>

<div id="content" class="site-content center-relative">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            ?>		

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if (get_post_meta($post->ID, "post_header_content", true) != ''): ?>                
                    <div class="single-post-header-content content-1170 center-relative">
                        <?php
                        echo do_shortcode(wp_kses(get_post_meta($post->ID, "post_header_content", true), $allowed_html_array));
                        ?>
                    </div>                        
                <?php endif; ?>
                <div class="post-wrapper center-relative">                                                        
                    <h1 class="entry-title"><?php the_title(); ?></h1>     

                    <?php if (has_post_thumbnail()): ?>
                        <div class="single-post-featured-image">
                            <?php the_post_thumbnail(); ?>
                        </div>                        
                    <?php endif; ?>

                    <div class="single-content-wrapper content-960 center-relative">      
                        <div class="post-info-wrapper">                                 
                            <div class="entry-info">
                                <div>
                                    <div class="text-holder"><?php echo esc_html__('AUTHOR', 'kapena-wp') ?></div>
                                    <div class="author-nickname">
                                        <?php the_author_posts_link(); ?>
                                    </div> 
                                </div> 
                                <div> 
                                    <div class="text-holder"><?php echo esc_html__('DATE', 'kapena-wp') ?></div>
                                    <div class="entry-date published"><?php echo get_the_date(); ?></div>
                                </div>
                                <div>
                                    <div class="text-holder"><?php echo esc_html__('CATEGORY', 'kapena-wp') ?></div>
                                        <div class="cat-links">
                                            <ul>
                                                <?php
                                                foreach ((get_the_category()) as $category) {
                                                    echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
                                                }
                                                ?>
                                            </ul>                                
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-holder"><?php echo esc_html__('COMMENTS', 'kapena-wp') ?></div>
                                        <div class="num-comments"><a href="<?php comments_link(); ?>"><?php comments_number('No Comments', '1 Comment', '% Comments'); ?></a></div>
                                    </div>
                                </div>
                            </div>

                            <div class="entry-content">                            
                                <?php
                                the_content();

                                $defaults = array(
                                    'before' => '<p class="wp-link-pages top-50"><span>' . esc_html__('Pages:', 'kapena-wp') . '</span>',
                                    'after' => '</p>'
                                );
                                wp_link_pages($defaults);

                                if (has_tag()):
                                    ?>	
                                    <div class="tags-holder">
                                        <?php the_tags('', ''); ?>
                                    </div>                              
                                    <?php
                                endif;
                                ?>                          
                            </div>
                            <div class="clear"></div>
                        </div>                                       
                    </div>                
            </article> 
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
<?php get_footer(); ?>  