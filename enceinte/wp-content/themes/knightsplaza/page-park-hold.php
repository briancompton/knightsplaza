<?php
/**
 * The main template file.
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

<article class="col-md-12 col-sm-12 page-header">
	<header class="entry-header">
		<h1 class="entry-title">Parking</h1>
	</header><!-- .entry-header -->
	<?php while ( have_posts() ) : the_post(); ?>	
		<?php the_content(); ?>
	<?php endwhile; // end of the loop. ?>
</article>

<div class="col-md-10 col-md-offset-1 map-holder">
	<img width="2000" alt="Knights Plaza Map" src="<?php echo get_template_directory_uri(); ?>/img/kp-illustrated-map.svg">
</div>

<?php get_footer(); ?>
