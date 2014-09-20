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
	while ( has_sub_field('date') ) {
	$orderby = get_sub_field('start_date');
	}
} 

if( !isset( $order )) {
	$order = "asc";
} 

$args = array( 'post_type' => 'see'  );
$loop = new WP_Query( $args );

if( $_GET['view'] == 'calendar' ) {
 $isSelected = " btn-selected"; 
} else {
	$thisSelected = " btn-selected";
} 
?>

<!--
	<div class="col-md-4 col-sm-4 pull-right">	
		<div class="btn-group">
		  <button id="event-calendar" class="btn btn-default btn-sorter <?php echo $isSelected?>" type="button">Calendar</button>
		  <button id="event-full" class="btn btn-default btn-sorter <?php echo $thisSelected?>" type="button">Full View</button>
		</div>
	</div>
-->

	<article class="col-md-12 col-sm-12 see-header page-header">
		<header class="entry-header">
			<h1 class="entry-title">Events</h1>
		</header><!-- .entry-header -->
		<?php while ( have_posts() ) : the_post(); ?>	
			<?php the_content(); ?>
		<?php endwhile; // end of the loop. ?>
		<?php wp_reset_postdata(); ?>
	</article>

<?php // require_once( 'inc/see/view.php' ); ?>
<?php /*
if( $_GET['view'] == 'calendar' ) {
				require_once( 'inc/see/view-calendar.php' );
				} else {
				require_once( 'inc/see/view.php' );
				}
*/

//require_once( 'inc/see/view-calendar.php' ); ?>

<?php get_footer(); ?>
