<?php
// $args = array( 'post_type' => 'see', 'orderby' => 'meta_value', 'order' => 'desc', 'meta_key' => $theSub  );
$args = array( 'post_type' => 'see', 'orderby' => $startDate, 'order' => 'asc'  );
$loop = new WP_Query( $args );
?>
<div class="row limited-width">

<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

<?php 

$todayIs = strtolower( date( 'l' ) );
?>

	<div class="col-md-6 col-sm-6">
		<div class="box box-events">
			<a href="#">
				<div class="bar-title bar-title-double">
					<div class="title-holder">
						<div class="centerer-v">
							<?php the_title(); ?>
						</div>	
					</div>
					
				</div>
			</a>
			<div class="box-content">
				<div class="event-details">
					<div class="event-image">

					<?php 
						$attachments = get_children( array( 'post_parent' => $id,
																								'post_type' => 'attachment',
																								'post_mime_type' => 'image')
																								);
						
						if ( !empty($attachments)) {																		
							foreach( $attachments as $att_id => $attachment );
							echo wp_get_attachment_image( $att_id, array(460,230) );
						} else {
							echo '<img src="' . get_template_directory_uri() . '/img/placeholder-events.jpg" />'; 
						}
					?>

					</div><!-- /event-image -->
					<?php the_field( "published_description" ); ?>
				</div>
				
				<?php while( has_sub_field('date') ): ?>
					<div class="event-at-glance">
						<div class="event-date">
							<div class="month">
								<?php echo date( 'M', strtotime( get_sub_field( 'start_date' ) ) ); ?>		
							</div>
							<div class="day">
								<?php echo date( 'j', strtotime( get_sub_field( 'start_date' ) ) ); ?>
							</div>
						</div><!-- /event-date -->
						<div class="event-date event-time">
							<div class="time-holder">
								
								<div class="time-hour"><p><?php echo date( 'g', strtotime ( get_sub_field( 'start_time' ) ) ); ?></p></div>
								
								<div class="time-right">
									<div class="time-minutes"><p><?php echo date( 'i', strtotime ( get_sub_field( 'start_time' ) ) ); ?></p></div>
									<div class="time-meridiem"><p><?php echo date( 'A', strtotime ( get_sub_field( 'start_time' ) ) ); ?></p></div>	
								</div>	
								
							</div><!-- /time-holder -->	
						</div><!-- /event-date event-time -->							
							<?php endwhile; ?>

							<!-- <img src="<?php get_template_directory_uri(); ?>/img/theme_location/<?php the_field( 'location' ); ?>.png" alt=""> -->
						<div class="event-venue">
							<a class="event-icons tipper col-lg-12" data-toggle="tooltip" title="TITLE GOES HERE"><span aria-hidden="true" class="kp-font kp-cfe"></span></i></a>
						</div>
						<div class="event-admission">
							<a class="event-icons tipper col-lg-6" data-toggle="tooltip" title="TITLE GOES HERE"><span class="kp-font kp-<?php the_field( 'event_type' ); ?>"></span></a>
							<a class="event-icons tipper col-lg-6" data-toggle="tooltip" title="TITLE GOES HERE"><span class="kp-font kp-<?php the_field( 'access_type' ); ?>"></span></a>
						</div>	
							
							
					</div><!-- /event-at-glance -->
				
			</div><!-- /box-content -->
			<div class="bar-footer">
				<?php // if ( !empty( get_field( 'event_link' ) ) ) { ?>
					<a href="<?php the_field( 'event_link' ); ?>"><button class="btn btn-info">Check it Out</button></a>
				<?php // ;} ?>
			</div><!-- /bar-footer -->
		</div><!-- /box box-events -->
	</div><!-- /col-md-6 col-sm-6 -->					
			
<?php endwhile; ?>	
			
</div> <!-- /.row -->