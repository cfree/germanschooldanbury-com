<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>

		</div><!-- #main -->
		<footer id="colophon" class="site-footer" role="contentinfo">
			<?php get_sidebar( 'main' ); ?>

			<div class="site-info">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/GermanSchoolLogo-footer.jpg" alt="<?php _e( 'German Language School of Danbury', 'twentythirteen' ); ?>">
				<p><?php printf( __( 'Copyright %s German Language School Danbury', 'twentythirteen' ), date( 'Y' ) ); ?></a></p>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>