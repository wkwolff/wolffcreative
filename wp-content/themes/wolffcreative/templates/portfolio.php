<?php if($loop->have_posts()){ ?>
	<div class="front-thumb">
		<?php while($loop->have_posts()) : $loop->the_post(); ?>
			<div class="portfolio-item">
				<a href="<?php echo get_permalink(); ?>"><?php the_post_thumbnail('front-square'); ?></a>
			</div>
		<?php endwhile; ?>
	</div>
<?php } ?>
