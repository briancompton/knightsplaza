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
	
	<div class="map-thumb-holder">
		<div class="map-thumb">
			<a href="<?php echo get_template_directory_uri(); ?>/directory" title="View Knights Plaza Map">
				<img src="<?php echo get_template_directory_uri(); ?>/img/map-thumb-kp.jpg" alt="map-thumb-kp" width="240" height="240" />
				<div class="caption">View Knights Plaza Map</div>
			</a>
			
		</div>
		<div class="map-thumb">
			<a href="http://map.ucf.edu/?show=137" title="View on Campus Map" target="_blank">
				<img src="<?php echo get_template_directory_uri(); ?>/img/map-thumb-campus.jpg" alt="map-thumb-campus" width="240" height="240" />
				<div class="caption">View Campus Map</div>
			</a>
			
		</div>
		<div class="map-thumb">
			<a href="https://maps.google.com/maps?ll=28.608525,-81.19626&z=17&t=m&hl=en-US&mapclient=apiv3" title="View on Google Maps" target="_blank">
				<img src="<?php echo get_template_directory_uri(); ?>/img/map-thumb-google.jpg" alt="map-thumb-google" width="240" height="240" />
				<div class="caption">View Google Map</div>
			</a>
			
		</div>
	</div>
	
	
</article>


	<!--
<div class="col-md-10 col-md-offset-1 map-key">
		MAP KEY
		<table>
			<tr>
				<td class="parking-meter" width="40"></td><td>Parking, Metered</td>
			</tr>
			<tr>
				<td class="parking-garage"></td><td>Parking Garage</td>
			</tr>
			<tr>
				<td class="cfe-arena"></td><td>CFE Arena</td>
			</tr>
			<tr>
				<td class="east-plaza"></td><td>East Plaza Dr Retail</td>
			</tr>
			<tr>
				<td class="west-plaza"></td><td>West Plaza Dr Retail</td>
			</tr>
		</table>
	</div>
-->
<?php // include( 'inc/map.php' ); ?>	
<?php get_footer(); ?>
