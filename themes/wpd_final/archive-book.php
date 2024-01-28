<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package My_final_wpd_theme
 */

get_header();
?>

	<main id="primary" class="site-main col-12 col-md-9">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
                <h1>Books</h1>
<!--				--><?php
//				the_archive_description( '<div class="archive-description">', '</div>' );
//				?>
			</header><!-- .page-header -->
            <div class="container-column">
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content-excerpt', get_post_type() );
			endwhile;
            ?>
                </div>
    <?php
            wp_reset_postdata();

            echo paginate_links(array(
            ));



		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>






	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
