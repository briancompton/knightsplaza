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

	<?php while ( have_posts() ) : the_post(); ?>
					
		<?php get_template_part( 'content', 'page' ); ?>
		
		

	<?php endwhile; // end of the loop. ?>
	
	<?php

$slug = array( 'eat', 'mix', 'do', 'shop' ); 
$orderby = "title";
$order = "ASC";

$args = array( 	'post_type' => 'locations',
								'tax_query' => array(
									array(
										'taxonomy' => 'category',
										'field' => 'slug',
										'terms' => $slug
									)
									),
									'orderby' => $orderby,
									'order' => $order,
									'nopaging' => true
								);

$loop = new WP_Query( $args );
?>

<div class="row limited-width">
	<form action="">
		<select name="locationList" id="locationList">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<option value="<?php the_title(); ?>"><?php the_title(); ?></option>
		<?php endwhile; ?>
		</select>
	</form>
	

<?php get_footer(); ?>
