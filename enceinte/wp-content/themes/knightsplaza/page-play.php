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
		<div class="sort-holder pull-right">	
			Sort Options &nbsp;
			<div class="btn-group">
			  <button class="btn btn-default btn-sorter btn-selected sort-<?php echo strtolower( $order ); ?>" id="alpha" type="button"><span class="direction"><?php if( $orderby == 'title' && $order == 'asc' ) { echo "A - Z ⬆"; }; if( $orderby == 'title' && $order == 'desc' ) { echo "Z - A ⬇"; }; ?></span></button>
			  <button class="btn btn-default btn-sorter" id="open-now" type="button">Open Now</button>
			  <button class="btn btn-default btn-sorter" id="delivery" type="button">Delivery</button>
			  <button class="btn btn-default btn-reset" type="button">Reset</button>
			</div>
		</div>
		<h1 class="entry-title"><?php the_title(); ?></h1>		
	</header><!-- .entry-header -->

	<?php while ( have_posts() ) : the_post(); ?>	
		<?php the_content(); ?>
	<?php endwhile; // end of the loop. ?>
</article>

<?php require_once( 'inc/play/view.php' ); ?>

<?php get_footer(); ?>
