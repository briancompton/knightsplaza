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



$args = array( 'post_type' => array( 'eat', 'play', 'do', 'shop' ), 'orderby' => $orderby, 'order' => $order, 'posts_per_page' => 20 );
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

<?php
/* Add tags as class to the location box for filtering with JS */
$theTags = get_field( 'tags' );
$tagClasses = strtolower( preg_replace('/[\s]/','', $theTags) );
$tagClasses = preg_replace('[,]',' ', $tagClasses);

?>


	<div class="location col-sm-6 content-box-holder eateries <?php echo $tagClasses; ?>">
			<div class="content-box">
				<a href="#"><div class="bar-title"><?php the_title(); ?></div></a>
				<div class="post">
					<div class="view-admat col-sm-12">
						<?php // if( in_array('opening-soon', get_field( 'status' ) ) ) { ?>
							<!-- <div class="opening-soon"></div> -->
						<?php // ;} ?>
						<div class="col-sm-7">
							<div class="row logo-area">
								<img src="<?php the_field( 'tenant_logo' ); ?>" />	
							</div>
								
						</div>
						
						<div class="col-sm-5 eatery-at-glance">
							
							<?php while( has_sub_field('hours') ): ?>
								<?php if( get_sub_field( $todayIs ) ): ?>
									<?php while( has_sub_field( $todayIs ) ): ?>
									<?php // if( get_sub_field('open') ){  ?>
							
										<?php if( get_sub_field( 'open' ) == "Closed") { ?>
							<div class="eatery-closed">CLOSED</div>
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
												<?php $openHours = get_sub_field( 'open' ); 
															$closeHours = get_sub_field( 'close' ); ?>
												<?php if( $openHours != "Closed" ){  ?>
													<li class="tipper<?php echo ($todayIs == $value) ? ' today' : '';?>" data-toggle="tooltip" title="
										 <?php echo date( 'g:i A', strtotime( $openHours ) ); ?> - <?php echo date( 'g:i A', strtotime( $closeHours ) ) ; ?>">
											 <?php echo strtoupper( $value[0] ); ?>
										 </li>
										 		<?php } else { ?>
										 			<li class="tipper<?php echo ($todayIs == $value) ? ' today' : '';?>" data-toggle="tooltip" title="
										 Closed"><?php echo strtoupper( $value[0] ); ?></li>
										 		<?php ;} ?>
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
									<li class="tenant-address"><a href="map?num=<?php the_field( 'address_number' ); ?>&str=<?php the_field( 'address_street' ); ?>"><?php the_field( 'address_number' );?> <?php the_field( 'address_street' ); ?></a></li>
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
							<?php // echo $number_tags; ?>
							<span class="label label-success"><?php echo "Open Now"; ?></span>
							<!-- <span class="label label-success"><?php echo "Deal$"; ?></span> -->
							<?php if( get_field( 'tags' ) ) { 
								$i = $number_tags;
								while ( $i > 0 ) { 
									--$i;
								?>
									<span class="label label-info"><?php echo $tags[ $i ]; ?></span>
								<?php
								
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