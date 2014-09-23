<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package wolffcreative
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			&copy;<?php echo date(Y); ?> Wolff Creative
			<?php /* <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'wolffcreative' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'wolffcreative' ), 'WordPress' ); ?></a> */?>
			<span class="sep"> | </span>
			Proudly developed with: <a href="http://sass-lang.com/" target="_blank">sass</a>, <a href="http://compass-style.org/" target="_blank">compass</a>, &amp; <a href="http://wordpress.org/" target="_blank">wordpress</a>
			<?php /* printf( __( 'Theme: %1$s by %2$s.', 'wolffcreative' ), 'wolffcreative', '<a href="http://underscores.me/" rel="designer">Underscores.me</a>' ); */ ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
