<?php
			$args = array( 'post_type' => 'footer_upper',
																		'posts_per_page' => 10,
																		'meta_key'=>'position',
																		'orderby' => 'meta_value',
																		'order' => 'ASC' );
			$loop = new WP_Query( $args );
				
			while ( $loop->have_posts() ) : $loop->the_post();

			$i = 1;
			$theRow = get_field('row');
			$thePosition = get_field('position');
			$theWidth = get_field('width');
			$title = get_the_title();
			$title = strtolower( str_replace(' ', '-',$title) );
			
		?>

	<div class="col-sm-<?php echo $theWidth; ?> col-sm-<?php echo $theWidth; ?> <?php echo $title; ?>">
					<div class="box box-<?php echo $theRow; ?>">
					
						<?php
							$filename = get_template_directory() . '/inc/home-' . 'blog' . '.php';
							
							echo "<div class='hidden'>" . $filename . "</div>";
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
								<?php require_once( 'home-' . $title . '.php' ); ?>
							</div>
							
							<?php	} else { ?>
								
								<a href="../<?php echo $title; ?>" alt="<?php echo the_title(); ?>">
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
