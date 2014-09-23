<?php if($loop->have_posts()){ ?>
	<div class="portfolio">
		<?php while($loop->have_posts()) : $loop->the_post(); ?>
			<div class="portfolio-item">
				<?php the_title(); ?>
			</div>
		<?php endwhile; ?>
	</div>
<?php } ?>
