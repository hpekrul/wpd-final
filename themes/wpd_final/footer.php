<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package My_final_wpd_theme
 */

?>
</div> <!-- closing row -->
</div> <!-- closing container tag -->
	<footer id="colophon" class="site-footer pt-5 mt-4">
            <div class="row">
                <div class="col">
                    <?php dynamic_sidebar('footer-1'); ?>
                </div>
            </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
