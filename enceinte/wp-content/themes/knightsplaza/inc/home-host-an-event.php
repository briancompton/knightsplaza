	<div class="col-sm-12 host-event">
	<?php	$towers_args = array( 'post_type' => 'home', 'name' => 'host-an-event', 'orderby' => 'date', 'order' => 'asc', 'posts_per_page' => 1 );
				$towers_loop = new WP_Query( $towers_args ); 
	?>
	
	<?php $i = 0; ?>			
	<?php while ( $towers_loop->have_posts() ) : $towers_loop->the_post(); ?>

	<?php the_content(); ?>

	<?php $i++; ?>
	<?php endwhile; ?>
	</div><!-- /.col-sm-10 .col-sm-offset-1 -->