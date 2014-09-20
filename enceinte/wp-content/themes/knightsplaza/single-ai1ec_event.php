<?php
/**
 * The Template for displaying all single posts.
 *
 * @package kp
 */

get_header( 'events' ); ?>

<h1>single-ai1ec_event.php</h1>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<div class="col-sm-11 left-single">

		<?php while ( have_posts() ) : the_post(); ?>

			

			<?php get_template_part( 'content', 'single' ); ?>

			<?php kp_content_nav( 'nav-below' ); ?>


		<?php endwhile; // end of the loop. ?>
		</div><!-- /.left-single -->
		
		<!-- <div class="col-sm-3 sidebar-single"> -->
			<?php // get_sidebar(); ?>
		<!-- </div> --><!-- /.sidebar-single -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>