<?php if($loop->have_posts()){ ?>
	<div class="front-thumb">
		<?php while($loop->have_posts()) : $loop->the_post(); ?>
			<div class="home-thumb">
				<figure class="portfolio-item">
					<?php the_post_thumbnail('front-square'); ?>
					<div class="fighover"><a href="<?php echo get_permalink(); ?>"><i class="fa fa-eye"></i></a></div>
				</figure>
			</div>
		<?php endwhile; ?>
	</div>
<?php } ?>
