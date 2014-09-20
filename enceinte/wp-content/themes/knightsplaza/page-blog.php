<?php
/**
 * The blog template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package kp
 */

get_header(); ?>



<?php while ( have_posts() ) : the_post(); ?>
	
	<article class="col-md-12 col-sm-12 page-header">
		<header class="entry-header">
			<h1 class="entry-title">Blog</h1>
		</header><!-- .entry-header -->	
		<?php the_content(); ?>
	</article>

	<?php endwhile; // end of the loop. ?>
					
		
	<div class="col-sm-md-10 col-sm-offset-1 section-header">
		<h3>Featured Posts</h3>
	</div>
		
	<?php	$args = array( 'post_type' => 'post', 'orderby' => $orderby, 'order' => $order, 'posts_per_page' => 3 );
				$loop = new WP_Query( $args ); 
	?>
				
	<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
	<div class="col-sm-10 col-sm-offset-1 blog post-featured-holder">
		<div class="col-sm-3 image-holder">
			<a href="<?php the_permalink(); ?>"><img src="<?php if( get_field( 'featured_image' ) ) { 
																the_field( 'featured_image' );
															} else {
																echo get_template_directory_uri() . '/img/placeholder-locations.jpg';
															}	
																; ?>" /></a>
			</div><!-- /.image-holder -->
			<div class="col-sm-9 excerpt-holder">
				<a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
				<?php 
				$content = get_the_content();
				echo '<p>' . substr($content, 0, 240) . '</p>';
				?>
			</div><!-- /.excerpt-holder -->
			<div class="col-sm-9 excerpt-footer pull-right">
				<?php
				$categories = get_the_category();
				$separator = ' ';
				$output = '';
				if($categories){
					foreach($categories as $category) {
						$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
					}
				echo trim($output, $separator);
				}
				?>
				
				<a class="excerpt-button-holder pull-right" href="<?php the_permalink(); ?>"><button class="btn btn-info"> Read More </button></a>
				
			</div>
	</div><!-- /.post-featured-holder -->
	
	<div class="clearfix"></div>
	<?php endwhile; ?>
	
	<div class="col-sm-md-10 col-sm-offset-1 section-header">
		<h3>Recent Posts</h3>
	</div>
	<?php	$args = array( 'post_type' => 'post', 'orderby' => $orderby, 'order' => $order, 'posts_per_page' => 6, 'offset' => 3 );
				$loop = new WP_Query( $args ); 
	?>
	<div class="col-sm-11 blog post-recents-holder">
		<div class="row">	
	<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<a href="<?php the_permalink(); ?>"><div class="col-sm-5 post-recents-subholder">			
				<div class="col-sm-4 image-holder">
					<img src="<?php if( get_field( 'featured_image' ) ) { 
																		the_field( 'featured_image' );
																	} else {
																		echo get_template_directory_uri() . '/img/placeholder-locations.jpg';
																	}	
																		; ?>" />
					</div><!-- /.image-holder -->
					<div class="col-sm-8 excerpt-holder">
						<h4><?php the_title(); ?></h4>
						<?php 
						$content = get_the_content();
						echo '<p>' . substr($content, 0, 100) . '</p>';
						?>
					</div><!-- /.excerpt-holder -->
				</div><!-- /.post-recents-subholder -->
			</a>
	<?php endwhile; ?>
			</div><!-- /.row -->
	</div><!-- /.post-recents-holder -->


	
	

<?php get_footer(); ?>
