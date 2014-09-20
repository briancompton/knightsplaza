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
			$args = array( 'post_type' => 'home',
										 'posts_per_page' => 10,
										 'orderby' => 'position',
										 'order' => 'ASC' );
/*
			$args = array( 'post_type' => 'home',
										 'posts_per_page' => 6,
										 'meta_key'=>'position',
										 'orderby' => 'meta_value',
										 'order' => 'ASC' );
*/	 
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
							$filename = get_template_directory() . '/inc/home-' . $title . '.php';
							
							if (file_exists($filename)) { ?>
							
						
							
							<?php if( $title == 'connect' ) { ?>
								<a data-toggle="modal" href="#<?php echo $title; ?>Modal" alt="<?php echo the_title(); ?>">
									<div class="bar-title"><?php echo the_title(); ?></div>
								</a>
								<?php } else if( $title == 'kp-events' ) { ?>
								<a href="<?php bloginfo('url');?>/see" alt="<?php echo the_title(); ?>">
									<div class="bar-title"><?php echo the_title(); ?></div>
								</a>
								<?php } else { ?>
								<a href="<?php echo $title; ?>" alt="<?php echo the_title(); ?>">
									<div class="bar-title"><?php echo the_title(); ?></div>
								</a>
								<?php ;} ?>
							
							<div class="box-content">
								<?php require_once( 'inc/home-' . $title . '.php' ); ?>
							</div>
							<?php if( $title == 'kp-events' ) { ?>
								<a href="<?php bloginfo('url');?>/see" alt="<?php echo the_title(); ?>">
									<div class="bar-footer"><button class="btn btn-info btn-sm"> Go </button></div>
								</a>
							<?php } else { ?>
							<a href="<?php echo $title; ?>" alt="<?php echo the_title(); ?>"><div class="bar-footer"><button class="btn btn-info btn-sm"> Go </button></div></a>
							<?php ;} ?>
							
							<?php	} else { ?>
								
								<a href="<?php echo $title; ?>" alt="<?php echo the_title(); ?>">
								<div class="bar-title"><?php echo the_title(); ?></div>
							</a>
								
							<div class="box-content">
								
							<div class="col-sm-12 generic-home-box <?php echo $title; ?>">
								<?php	$towers_args = array( 'post_type' => 'home', 'name' => $title, 'orderby' => 'date', 'order' => 'desc', 'posts_per_page' => 1 );
												$towers_loop = new WP_Query( $towers_args ); 
									?>
									
									<?php $i = 0; ?>			
									<?php while ( $towers_loop->have_posts() ) : $towers_loop->the_post(); ?>
								
									<?php the_content(); ?>
								
									<?php $i++; ?>
									<?php endwhile; ?>
								</div><!-- /.col-sm-10 .col-sm-offset-1 -->
								
							</div>
																
								<?php ;} ?>
											
					</div><!-- /box -->
				</div>

			<?php endwhile; ?>
			</div><!-- /.row -->		
</main><!-- #main -->
						
<?php get_footer(); ?>
