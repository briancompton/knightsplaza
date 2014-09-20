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

<?php
$orderby = $_GET[ 'orderby' ];
$order = $_GET['order'];

if( !isset( $orderby )) {
	$orderby = "title";
} 

if( !isset( $order )) {
	$order = "asc";
} 
?>



<article class="col-md-12 col-sm-12 page-header">
	
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>		
	</header><!-- .entry-header -->

	<?php while ( have_posts() ) : the_post(); ?>	
		<?php the_content(); ?>
	<?php endwhile; // end of the loop. ?>
</article>

<?php require_once( 'inc/locations.php' ); ?>

<?php get_footer(); ?>
