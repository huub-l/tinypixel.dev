<!--Footer-->

<?php
$allowed_html_array = cocobasic_allowed_html();
?>
<footer class="footer">
    <div class="footer-content center-relative">

        <?php if (is_active_sidebar('footer-sidebar')) : ?>
            <ul id="footer-sidebar" class="content-1170 center-relative">
                <?php dynamic_sidebar('footer-sidebar'); ?>
            </ul>
        <?php endif; ?>              

        <?php if (get_option('cocobasic_footer_image') !== '' && get_option('cocobasic_footer_image') !== false): ?>
            <img class="footer-logo" src="<?php echo esc_url(get_option('cocobasic_footer_image', get_template_directory_uri() . '/images/icon_plus.png')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />
        <?php endif; ?>

        <?php if (get_theme_mod('cocobasic_footer_copyright_content') != ''): ?>
            <div class="copyright-holder content-1170 center-relative">
                <?php
                echo wp_kses(__(get_theme_mod('cocobasic_footer_copyright_content') ? get_theme_mod('cocobasic_footer_copyright_content') : '2018 WordPress Theme by CocoBasic.', 'kapena-wp'), $allowed_html_array);
                ?>
            </div>
        <?php endif; ?>
        <?php if (get_theme_mod('cocobasic_footer_social_content') != ''): ?>
            <div class="social-holder content-1170 center-relative">
                <?php
                echo wp_kses(__(get_theme_mod('cocobasic_footer_social_content') ? get_theme_mod('cocobasic_footer_social_content') : '<a href="#"><span class="fa fa-twitter"></span></a><a href="#"><span class="fa fa-facebook"></span></a><a href="#"><span class="fa fa-behance"></span></a><a href="#"><span class="fa fa-dribbble"></span></a>', 'kapena-wp'), $allowed_html_array);
                ?>
            </div>
        <?php endif; ?>
    </div>
</footer>
</div>

<?php wp_footer();
?>
</body>
</html>