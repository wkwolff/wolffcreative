<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package wolffcreative
 */

if ( ! is_active_sidebar( 'callouts' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'callouts' ); ?>
</div><!-- #secondary -->
