<?php 
date_default_timezone_set('America/New_York');
$dayToday = date("w");

function phone_format($phone) { 
  if(!empty($phone)) {
	$areaCode = substr($phone,0,3);
	$exchange = substr($phone,3,3);
	$extension = substr($phone,-4);
	$phone = '(' . $areaCode . ') ' . $exchange . '-' . $extension; }
return $phone;

}
?>

<?php
$args = array( 'post_type' => 'see' );
$loop = new WP_Query( $args );
?>
<div class="row limited-width">

<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

<?php
$todayIs = strtolower( date( 'l' ) );

// Format the phone number
$phone = phone_format( get_field( 'phone' ) );

// Split up the tags field
$tags = explode( ',', get_field( 'tags' ) );
$number_tags = count( $tags );
?>


	<div class="col-md-6 col-sm-6 content-box-holder">
		<div class="content-box go">
			<div class="area">
				<div class="bubble">
					<p>
						<?php the_title(); ?>	
					</p>
				</div>
			</div>
		
				<div class="post">
					<div class="view-admat col-md-12">
						<img src="<?php the_field( 'featured_image' ); ?>" width="300" height="230" />
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
						</div>
						<div class="event-date event-time">
							<div class="time-holder">
								
								<div class="time-right">
									<div class="time-minutes"><p><?php echo date( 'i', strtotime ( get_sub_field( 'start_time' ) ) ); ?></p></div>
									<div class="time-meridiem"><p><?php echo date( 'A', strtotime ( get_sub_field( 'start_time' ) ) ); ?></p></div>	
								</div>	
								<div class="time-hour"><p><?php echo date( 'g', strtotime ( get_sub_field( 'start_time' ) ) ); ?></p></div>
							</div>
							
							
						</div>							
							<?php endwhile; ?>

							<img src="<?php get_template_directory_uri(); ?>/img/theme_location/<?php the_field( 'location' ); ?>.png" alt="">
							<a class="event-icons tipper col-lg-6" data-toggle="tooltip" title="TITLE GOES HERE"><i class="ss-symbolicons ss-<?php the_field( 'event_type' ); ?>"></i></a>
							<a class="event-icons tipper col-lg-6" data-toggle="tooltip" title="TITLE GOES HERE"><i class="ss-symbolicons ss-<?php the_field( 'access_type' ); ?>"></i></a>
							
					</div>
					
					<div class="event-details">
						<?php the_field( "published_description" ); ?>
					</div>
					
	
			
					<div class="row more-info">
						<a href="<?php the_field( 'event_link' ); ?>"><button class="btn btn-info">Check it Out</button></a>
					</div>
								
				</div>
			</div>
		</div> <!-- /content-box-holder -->
					
			
<?php endwhile; ?>	
			
</div> <!-- /.row -->