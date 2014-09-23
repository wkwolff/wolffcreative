<?php
/**
 * @package wolffcreative
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php edit_post_link( __( 'Edit', 'wolffcreative' ), '<span class="edit-link">', '</span>' ); ?>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php 
		    if (has_post_thumbnail()) {
		        echo '<div class="single-post-thumbnail clear">';
		        echo the_post_thumbnail('large');
		        echo '</div>';
		    }
		?>
		<div class="entry-meta">
			<!-- <?php wolffcreative_posted_on(); ?> -->
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php //$data = get_post_meta(get_the_ID(), '', true); print_r($data); ?>
		<?php //echo $data['wpshed_textfield'][0] ?>
		<?php //echo apply_filters('wolfcre_test', 'Testing Filters', 'one', 'two'); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'wolffcreative' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'wolffcreative' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'wolffcreative' ) );

			if ( ! wolffcreative_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'Skills used: %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'wolffcreative' );
				} else {
					$meta_text = __( 'Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'wolffcreative' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( 'Skills used: %1$s', 'wolffcreative' );
				} else {
					$meta_text = __( 'Skills used: %1$s', 'wolffcreative' );
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink()
			);
		?>

	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
