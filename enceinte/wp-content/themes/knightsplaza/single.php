<?php
/**
 * The Template for displaying all single posts.
 *
 * @package kp
 */

get_header( 'single' ); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<div class="col-sm-8 left-single">

		<?php while ( have_posts() ) : the_post(); ?>
		
			<div class="image-holder-single">
				<img src="<?php if( get_field( 'featured_image' ) ) { 
																the_field( 'featured_image' );
															} else {
																echo get_template_directory_uri() . '/img/placeholder-locations.jpg';
															}	
																; ?>" />
			</div>
			

			<?php get_template_part( 'content', 'single' ); ?>

			<?php kp_content_nav( 'nav-below' ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
			?>

		<?php endwhile; // end of the loop. ?>
		</div><!-- /.left-single -->
		
		<div class="col-sm-3 sidebar-single">
			<?php get_sidebar(); ?>
		</div><!-- /.sidebar-single -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>