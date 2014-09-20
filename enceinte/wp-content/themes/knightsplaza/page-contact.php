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
		
		
		
		
		<div class="col-md-5 col-md-offset-1 col-sm-12">
			<?php require_once( 'inc/form-contact-main.php' ); ?>
		</div>
		
		<div class="col-md-4 col-md-offset-1 well contact-info">
			<div class="inner-holder">
				<h1 alt="Contact Knights Plaza" data-icon="" class="kp-icon"></h1>
	
			<p>4000 Central Florida Blvd.<br>
			   Orlando, FL 32816<br>
			   (407) 882-8600</p>
			</div><!-- /inner-holder -->
			<div class="inner-holder tizon">
			 	<h5>Storefront Leasing Information:</h5>
					<p>Tizon Commercial, LLC</p>
					<p>Phone: (407) 375-7637</p>
					<p>Website: <a href="http://www.tizon.us" target="_blank" alt="Contact Tizon Commercial for Knights Plaza Leasing Information" title="Contact Tizon Commercial for Knights Plaza Leasing Information">www.Tizon.us</a></p>
			 </div><!-- /inner-holder -->
			 <div class="inner-holder tizon">
			 	<h5>CFE Arena Events &amp; Information:</h5>
					<p>CFE Arena</p>
					<p>Phone: (407) 823-3070</p>
					<p>Website: <a href="http://www.cfearena.com" target="_blank" alt="Contact CFE Arena" title="Contact CFE Arena">www.cfearena.com</a></p>
			 </div><!-- /inner-holder -->
			 <div class="inner-holder tizon">
			 	<h5>Retailer &amp; Restaurant Information:</h5>
					<p>Contact the individual location</p>
					<p> or visit the <a href="<?php echo home_url() . '/directory'; ?>">Knights Plaza Directory</a></p>
			 </div><!-- /inner-holder -->
			   
			   
			   
		</div>

	<?php endwhile; // end of the loop. ?>
	
	

<?php get_footer(); ?>
