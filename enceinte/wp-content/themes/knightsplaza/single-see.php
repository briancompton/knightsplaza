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
		
		<!--
<article class="col-md-12 col-sm-12 page-header">
			<header class="entry-header">
				<h1 class="entry-title">Events</h1>
			</header>
		</article>
-->

		<?php while ( have_posts() ) : the_post(); ?>
		
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


<h1>single-see.php</h1>

<?php get_footer(); ?>