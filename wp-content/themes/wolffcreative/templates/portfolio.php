<?php if($loop->have_posts()){ ?>
	<div class="portfolio">
		<?php while($loop->have_posts()) : $loop->the_post(); ?>
			<div class="portfolio-item">
				<a href="<?php echo get_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
			</div>
		<?php endwhile; ?>
	</div>
<?php } ?>
