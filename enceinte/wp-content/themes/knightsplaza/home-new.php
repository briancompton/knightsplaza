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

get_header( 'home' ); ?>

<main id="main" class="site-main" role="main">
<div class="row">
		<?php
			$args = array( 'post_type' => 'home', 'posts_per_page' => 10, 'orderby' => 'position', 'order' => 'ASC' );
			$loop = new WP_Query( $args );
			
/*
			$rows = count( get_fields('row') );
			
			echo $rows;
*/
			
			while ( $loop->have_posts() ) : $loop->the_post();
			
			
			
			$i = 1;
			$theRow = get_field('row');
			$thePosition = get_field('position');
			$theWidth = get_field('width');
			$title = get_the_title();
			$title = strtolower( str_replace(' ', '-',$title) );
			
		?>
				
				<div class="col-md-<?php echo $theWidth; ?> col-sm-<?php echo $theWidth; ?> <?php echo $title; ?>">
					<div class="box box-<?php echo $theRow; ?>">
					
						<?php
							$filename = 'inc/home-' . $title . '.php';
							if (file_exists($filename)) { ?>
							
							<a href="<?php echo $title; ?>" alt="<?php echo the_title(); ?>">
								<div class="bar-title"><?php echo the_title(); ?></div>
							</a>
							<div class="box-content">
								<?php require_once( 'inc/home-' . $title . '.php' ); ?>
							</div>
							<a href="<?php echo $title; ?>" alt="<?php echo the_title(); ?>"><div class="bar-footer"><button class="btn btn-info btn-sm"> Read More </button></div></a>
							
							<?php	
								} else {
								
								echo "The file $filename does not exist";
								
								}
								?>
					
						<?php if( $title == 'connect' ) { ?>
						<a data-toggle="modal" href="#connectModal" alt="Connect"><div class="bar-title">Connect</div></a>
						<?php } else { ?>
						<a href="<?php echo $title; ?>" alt="<?php echo the_title(); ?>">
							<div class="bar-title"><?php echo the_title(); ?></div>
						</a>
						<?php ;} ?>
						<div class="box-content">
							<?php require_once( 'inc/home-' . $title . '.php' ); ?>
						</div>
						<?php if( $title == 'connect' ) { ?>
						<a data-toggle="modal" href="#connectModal" alt="Connect"><div class="bar-footer"><button class="btn btn-info btn-sm"> Connect </button></div></a>	
						<?php } else { ?>
						<a href="<?php echo $title; ?>" alt="<?php echo the_title(); ?>"><div class="bar-footer"><button class="btn btn-info btn-sm"> Read More </button></div></a>
						<?php ;} ?>
						
					</div><!-- /box -->
				</div>

			<?php endwhile; ?>
			</div><!-- /.row -->		
</main><!-- #main -->
						
<?php get_footer(); ?>
