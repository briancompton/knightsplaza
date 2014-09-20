<main id="main" class="site-main" role="main">
<div class="row">
		<?php
			$args = array( 'post_type' => 'home', 'posts_per_page' => 10, 'orderby' => 'position', 'order' => 'ASC' );
			$loop = new WP_Query( $args );
			
/*
			$rows = count( get_fields('row') );
			
			echo $rows;
*/
			
			while ( $loop->have_posts() ) : $loop->the_post();
			
			
			
			$i = 1;
			$theRow = get_field('row');
			$thePosition = get_field('position');
			$theWidth = get_field('width');
			$title = get_the_title();
			$title = strtolower( str_replace(' ', '-',$title) );
			
		?>
				
				<div class="col-md-<?php echo $theWidth; ?> col-sm-<?php echo $theWidth; ?>">
					<div class="box box-<?php echo $theRow; ?>">
						<a href="<?php echo $title; ?>" alt="<?php echo the_title(); ?>">
							<div class="bar-title"><?php echo the_title(); ?></div>
						</a>
						<div class="box-content">
							<?php echo the_content(); ?>
						</div>
						<div class="bar-footer">More...</div>
					</div><!-- /box -->
				</div>

			<?php endwhile; ?>
			</div><!-- /.row -->		
</main><!-- #main -->