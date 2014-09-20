<?php
$slug = getLastPathSegment( get_permalink() );
$cat = ucfirst( $slug );
?>

<?php 
date_default_timezone_set('America/New_York');
$dayToday = date("w");

function phone_format($phone) { 
  if(!empty($phone)) {

	$phone = preg_replace('/[^0-9]*/','', $phone);
  
	$areaCode = substr($phone,0,3);
	$exchange = substr($phone,3,3);
	$extension = substr($phone,-4);
	$phone = '(' . $areaCode . ') ' . $exchange . '-' . $extension; }
return $phone;

}
?>

<?php
$theDateIs = date("m-d-Y");

/* Temporary until can dates into database */
$breakDates = array( "10-28-2013" , "11-11-2013" , "11-28-2013", "11-29-2013" );
$breakMessage = "Hours may vary during the semester break, it is recommended that you call ahead.";

$specialDates = array( "11-21-2013" );
$specialDatesMessage = "Campus closes at 3 p.m. today for UCF v. Rutgers (Football)";

?>

<div class="sort-holder">
	<?php if( in_array( $theDateIs, $breakDates ) ) { ?>
	<div class="alert alert-danger semester-break pull-left"><?php echo $breakMessage; ?></div>
	<?php };?>
	<?php if( in_array( $theDateIs, $specialDates ) ) { ?>
	<div class="alert alert-danger semester-break pull-left"><?php echo $specialDatesMessage; ?></div>
	<?php };?>
	<div class="btn-group pull-right">
		<button class="btn btn-default btn-sorter" id="open-now" type="button">Open Now</button>
		<?php if( $slug == 'eat' ) { ?> 
		<button class="btn btn-default btn-sorter" id="delivery" type="button">Delivery</button>
		<?php ;} ?>
		 <button class="btn btn-default btn-reset" type="button">Reset</button>
	</div>
</div>

<?php

if( $slug == 'directory' ) { $slug = array( 'eat', 'mix', 'do', 'shop', 'available' ); };

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
<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

<?php
$todayIs = strtolower( date( 'l' ) );
$nowTime = strtotime( date('H:i') );

// Format the phone number
$phone = phone_format( get_field( 'phone' ) );

// Split up the tags field
$tags = explode( ',', get_field( 'tags' ) );
$number_tags = count( $tags );
?>

<?php
/* Add tags as class to the location box for filtering with JS */
$theTags = get_field( 'tags' );
$tagClasses = strtolower( preg_replace('/[\s]/','', $theTags) );
$tagClasses = preg_replace('[,]',' ', $tagClasses);

$status = get_field( 'status' );
/*
Possible Statuses:
cool : Cool
opening-soon : Opening Soon
closed-for-break : Closed for Break
closed-extended : Closed for Renovation or other long term
*/

/* Set the Google Maps and anchor tags */
$add_num = get_field( 'address_number' );
$add_street = get_field( 'address_street' );

if( $add_street == "East Plaza Dr." ) {
	$google_add_street = "E+Plaza+Dr";	
	$anchor = "e" . $add_num;
}
if( $add_street == "West Plaza Dr." ) {
	$google_add_street = "W+Plaza+Dr";
	$anchor = "w" . $add_num;
}
if( $add_street == "Gemini Blvd. N." ) {
	$google_add_street = "Gemini+Blvd+N";
	$anchor = "gb" . $add_num;
}

?>

<?php 

/* If the location is open, add "Open Now" tag */
	while( has_sub_field('hours') ): 
		if( get_sub_field( $todayIs ) ):
			while( has_sub_field( $todayIs ) ): 
				if( get_sub_field( 'open' ) != "Closed" ): 
					$openTime = get_sub_field( 'open' ); 
					$closeTime = get_sub_field( 'close' );
					$schedType = get_sub_field( 'schedule_type' ); 
					
					if ( $schedType == 'open24' ) {
						$tagClasses .= " open-now";
					}
					
				endif;
			endwhile;
		endif;
	endwhile;

	
	// If the location hours indicate it is open now but doesn't have a special status
	if ( $status == 'cool' && $nowTime  > strtotime( $openTime ) &&  $nowTime  < strtotime( $closeTime )  ) { // || $closeTime < $openTime
			$tagClasses .= " open-now";	// Add "Open Now" tag
		}		
?>

	<div class="location col-sm-6 content-box-holder eateries <?php echo $tagClasses; ?>">
			<div class="content-box">
				<div id="location-<?php echo $anchor;?>"><div class="bar-title"><?php the_title(); ?></div></div>
				<div class="post">
					<div class="view-admat col-sm-12">
					<?php if( $status == 'opening-soon' ) { ?>
						<div class="opening-soon"></div>
					<?php ;} ?>
					<?php if( $status == 'closed-for-break' ) { ?>
						<div class="closed-for-break"></div>
					<?php ;} ?>
						<div class="col-sm-7">
							<div class="row logo-area">
								<img src="<?php if( get_field( 'tenant_logo' ) ) { 
																	the_field( 'tenant_logo' );
																} else {
																	echo get_template_directory_uri() . '/img/placeholder-locations.jpg';
																}	
																	; ?>" />	
							</div>						
						</div>
						
						<div class="col-sm-5 eatery-at-glance">
							
							<?php while( has_sub_field('hours') ): ?>
								<?php if( get_sub_field( $todayIs ) ): ?>
									<?php while( has_sub_field( $todayIs ) ): ?>
									<?php // if( get_sub_field('open') ){  ?>
							
										<?php if( get_sub_field( 'schedule_type' ) == "closed") { ?>
											<div class="eatery-closed">CLOSED</div>
										<?php } else if( get_sub_field( 'schedule_type' ) == "open24") { ?>
											<div class="eatery-closed">Open 24 Hours</div>
										<?php } else { ?>
							<div class="row eatery-timekeeper">
								<div class="col-sm-6 event-date event-time opener">
									<?php $openTime = get_sub_field( 'open' ); ?>
									<?php $closeTime = get_sub_field( 'close' ); ?>

									<div class="time-holder">
										
										<div class="time-hour"><p><?php echo date( 'g', strtotime ( $openTime ) ); ?></p></div>
										
										<div class="time-right">
											<div class="time-minutes"><p><?php echo date( 'i', strtotime (  $openTime ) ); ?></p></div>
											<div class="time-meridiem"><p><?php echo date( 'A', strtotime (  $openTime ) ); ?></p></div>	
										</div>	
										
									</div><!-- /time-holder -->	

								</div>
								<div class="col-sm-6 event-date event-time">

								<div class="time-holder">
										
									<div class="time-hour"><p><?php echo date( 'g', strtotime ( $closeTime ) ); ?></p></div>
									
									<div class="time-right">
										<div class="time-minutes"><p><?php echo date( 'i', strtotime ( $closeTime ) ); ?></p></div>
										<div class="time-meridiem"><p><?php echo date( 'A', strtotime ( $closeTime ) ); ?></p></div>	
									</div>	
									
								</div><!-- /time-holder -->		
																	
								</div>
							</div> <!-- /.eatery-timekeeper -->
							<?php } ?>
									<?php endwhile; ?>
								<?php endif; //if( get_sub_field('items') ): ?>				
							<?php endwhile; // while( has_sub_field('to-do_lists') ): ?>
				
							<div class="row eatery-days">
								<?php if( get_field('hours') ): ?>
								<ul>
									<?php while( has_sub_field('hours') ): ?>
									
									
									<?php /* LOOP THROUGH DAYS OF THE WEEK to get daily hours*/
									$arr = array('sunday','monday','tuesday','wednesday','thursday','friday','saturday');
									foreach ($arr as &$value) {
									?>
									
			<!-- Get the Weekly Hours for each day -->
										<?php if( get_sub_field( $value ) ): ?>
											<?php while( has_sub_field( $value ) ): ?>
												<?php if( get_sub_field( 'schedule_type' ) == "closed") { ?>
													<li class="tipper<?php echo ($todayIs == $value) ? ' today' : '';?>" data-toggle="tooltip" title="
										 Closed"><?php echo strtoupper( $value[0] ); ?></li>
												<?php } else if( get_sub_field( 'schedule_type' ) == "open24") { ?>
													<li class="tipper<?php echo ($todayIs == $value) ? ' today' : '';?>" data-toggle="tooltip" title="
										 Open 24 Hours"><?php echo strtoupper( $value[0] ); ?></li>
												<?php } else { ?>
											
												<?php $openHours = get_sub_field( 'open' ); 
															$closeHours = get_sub_field( 'close' ); ?>
												<?php // if( $openHours != "Closed" ){  ?>
													<li class="tipper<?php echo ($todayIs == $value) ? ' today' : '';?>" data-toggle="tooltip" title="
										 <?php echo date( 'g:i A', strtotime( $openHours ) ); ?> - <?php echo date( 'g:i A', strtotime( $closeHours ) ) ; ?>">
											 <?php echo strtoupper( $value[0] ); ?>
										 </li>
										 		<?php ;} // else { ?>

										 		<?php // ;} ?>
									<?php endwhile; ?>
								<?php endif; //if( get_sub_field('items') ): ?>
			<!-- Weekly Hours END -->
			
			<?php     ;}
				unset($value); // break the reference with the last element ?>
						

									<?php endwhile; // while( has_sub_field('hours') ): ?>
								</ul>
								<?php endif; // if( get_field('hours') ): ?>
							</div>
				
							<div class="eatery-contact">
								<ul>
									<li class="tenant-address"><a href="https://www.google.com/maps?q=<?php echo $add_num; ?>+<?php echo $google_add_street; ?>+University+of+Central+Florida,+Orlando,+FL+32816" target="_blank"><?php echo $add_num; ?> <?php echo $add_street; ?></a></li>
									<li><?php echo $phone; ?></li>
								</ul>
							</div>
							
							<div class="smedia-holderer">
								<ul class="eatery-smedia smedia horiz-ul">
									<?php if( get_field( 'website') ) { ?>
									<li>
										<a href="<?php the_field( 'website' ); ?>" class="tipper" data-toggle="tooltip" title="<?php the_title(); ?> Website">
											<span class="kp-web" aria-hidden="true"></span>
										</a>	
									</li>
									<?php } ?>
									<?php if( get_field( 'social_media_1') ) { ?>
									<li>
										<a href="<?php the_field( 'social_media_1'); ?>" class="tipper" data-toggle="tooltip" title="<?php the_title(); ?> Facebook Page">
											<span class="kp-facebook" aria-hidden="true"></span>
										</a>
									</li>
									<?php } ?>
									<?php if( get_field( 'social_media_2') ) { ?>
									<li>
										<a href="<?php the_field( 'social_media_2'); ?>" class="tipper" data-toggle="tooltip" title="<?php the_title(); ?> Twitter Page">
											<span class="kp-twitter" aria-hidden="true"></span>
										</a>
									</li>
									<?php } ?>
								</ul>
							</div>
							
						</div>		
					</div>
					
					<p><?php the_field( "published_description" ); ?></p>
			
					<div class="row eatery-pills-holder">
						<div class="eatery-pills">
							<?php if ( $schedType == 'open24' || $status != 'opening-soon' && $nowTime >= strtotime( $openTime ) &&  $nowTime  <= strtotime( $closeTime ) ) { // || $closeTime < $openTime ?>
							<span class="label label-success">Open Now</span>
							<?php  } ?>

							<?php 
							$n = 0;
							if( get_field( 'tags' ) ) { 
								$i = $number_tags;
								while ( $i > $n ) { 
								?>
									<span class="label label-info"><?php echo $tags[ $n ]; ?></span>
								<?php
								$n++;
								};
								}
						  ?>
						</div>
					</div>
								
				</div>
			</div>
		</div> <!-- /content-box-holder -->	
			
<?php endwhile; ?>	
			
</div> <!-- /.row -->