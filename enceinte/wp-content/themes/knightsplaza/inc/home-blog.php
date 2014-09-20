<?php
$Path=$_SERVER['REQUEST_URI'];
$URI='http://www.example.com'.$Path;

/*
echo "<h1>" . $URI . "</h1>";
echo "Pagename: " . get_page_template_slug();
*/

/*
if( is_front_page() ) { echo "this is home";};
if( !is_front_page( 'home' ) ) { echo "this isn't home";};
*/

?>

<div class="col-sm-12 pull-left slider">
<?php	$sub_args = array( 'post_type' => 'post', 'orderby' => $orderby, 'order' => $order, 'posts_per_page' => 3 );
				$sub_loop = new WP_Query( $sub_args ); 
	?>
	
	<?php $i = 0; ?>			
	<?php while ( $sub_loop->have_posts() ) : $sub_loop->the_post(); ?>
	
	<div class="pull-left blog home-featured-holder <?php if( $i == 0 ) { echo 'show' ;} ?>">
		<div class="col-sm-5 image-holder">
			<a href="<?php the_permalink(); ?>"><img src="<?php if( get_field( 'featured_image' ) ) { 
																the_field( 'featured_image' );
															} else {
																echo get_template_directory_uri() . '/img/placeholder-locations.jpg';
															}	
																; ?>" /></a>
			</div><!-- /.image-holder -->
			<div class="col-sm-7 excerpt-holder">
				<a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4>
				<?php 
				$content = get_the_content();
				if( is_front_page( 'home' ) ) {
					$content_excerpt = substr($content, 0, 110);
				} else {
					$content_excerpt = substr($content, 0, 70);					
				};
				echo '<p>' . $content_excerpt . '...</a></p>';
				?>
			</div><!-- /.excerpt-holder -->
		</div><!-- /.post-featured-holder -->
		<?php $i++; ?>
		<?php endwhile; ?>
</div><!-- /.slider -->

		<div class="indicator-more">
			<?php $i = 0; ?>	
			<?php
				$category_args = array( 'post_type' => 'post', 'orderby' => 'date', 'order' => 'desc', 'posts_per_page' => 3 );
				$category_posts = new WP_Query( $category_args ); //new WP_Query('cat=post&showposts=y');
				while ($category_posts ->have_posts()) : $category_posts->the_post();
			?>
				<a class="theDots<?php // if( $i == 0 ) { echo 'current' ;} ?>" href="<?php the_permalink(); ?>"><span class="dot">●</span></a>
			<?php $i++; ?>
			<?php endwhile; ?>
		</div>



