<?php get_header(); ?>           
            <p class="center-text error-text-help-first"><strong><?php echo esc_html__('Oops!', 'kapena-wp');?></strong></p>            
            <p class="center-text error-text-help-second"><?php echo esc_html__('The page you were looking for could not be found.', 'kapena-wp');?></p>
            <p class="center-text error-text-404"><?php echo esc_html__('404', 'kapena-wp');?></p>
            <div class="center-text error-search-holder"><?php get_search_form(); ?></div>
            <p class="center-text error-text-home"><?php echo esc_html__('... or just go back to', 'kapena-wp');?> <a href="<?php echo esc_url(site_url('/')); ?>"><?php echo esc_html__('Home', 'kapena-wp');?></a> <?php echo esc_html__('page.', 'kapena-wp');?></p>            
<?php get_footer(); ?>