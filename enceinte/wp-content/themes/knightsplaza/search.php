<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package kp
 */

get_header(); ?>
	
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<div class="col-sm-8 left-single">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="entry-title">Search</h1>
			</header><!-- .page-header -->

			<h4><?php printf( __( 'Search Results for: %s', 'kp' ), '<span>' . get_search_query() . '</span>' ); ?></h4>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'search' ); ?>

			<?php endwhile; ?>

			<?php kp_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'search' ); ?>

		<?php endif; ?>
		
		</div><!-- /.left-single -->
		
		<div class="col-sm-3 sidebar-single">
			<?php get_sidebar(); ?>
		</div><!-- /.sidebar-single -->

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>