
<div class="row">
<?php

     $dateComponents = getdate();
     $month = $dateComponents['mon']; 

		 if( !empty( $_GET['month'] ) ) {
			$month = $_GET['month'] ;
		 }
		 		     
     $year = $dateComponents['year'];

     echo build_calendar($month,$year,$dateArray);

?>
</div> <!-- /.row -->
		


<?php

function build_calendar($month,$year,$dateArray) {

     // Create array containing abbreviations of days of week.
     $daysOfWeek = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

     // What is the first day of the month in question?
     $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

     // How many days does this month contain?
     $numberDays = date('t',$firstDayOfMonth);

     // Retrieve some information about the first day of the
     // month in question.
     $dateComponents = getdate($firstDayOfMonth);

     // What is the name of the month in question?
     $monthName = $dateComponents['month'];

     // What is the index value (0-6) of the first day of the
     // month in question.
     $dayOfWeek = $dateComponents['wday'];

     // Create the table tag opener and day headers

     $calendar = "<div class='col-sm-10 col-sm-offset-1 cal-holder'>";
     $calendar .= "<div class='cal-title-holder'><button class='btn btn-default btn-monther' id='prev'> < </button><div class='cal-title'>$monthName $year</div><button class='btn btn-default btn-monther' id='next'> > </button></div>";
     

     // Create the calendar headers

     foreach($daysOfWeek as $day) {
          $calendar .= "<div class='cal-day-header'>$day</div>";
     } 

     // Create the rest of the calendar

     // Initiate the day counter, starting with the 1st.

     $currentDay = 1;

     // The variable $dayOfWeek is used to
     // ensure that the calendar
     // display consists of exactly 7 columns.

     if ($dayOfWeek > 0) { 
          $calendar .= "<div class='$dayOfWeek'>&nbsp;</div>"; 
     }
     
     $month = str_pad($month, 2, "0", STR_PAD_LEFT);
     
       
     while ($currentDay <= $numberDays) {

          // Seventh column (Saturday) reached. Start a new row.

          if ($dayOfWeek == 7) {
               $dayOfWeek = 0;
          }
          
          $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
          
          $date = "$year-$month-$currentDayRel";

					if( $date == date('Y-m-j') ) {
						$calendar .= "<div class='cal-day cal-today' rel='$date'>";
						} else {
	          $calendar .= "<div class='cal-day' rel='$date'>";
	          }
          	$calendar .= "<div class='cal-date'>$currentDay</div>";
          								
          // Get posted events	
          
      			$args = array( 'post_type' => 'see', 'order' => 'asc' );
						$loop = new WP_Query( $args );	
          
						while ( $loop->have_posts() ) : $loop->the_post(); 
						
							while( has_sub_field('date') ):
						
								$eventDate = date( 'Y-m-j', strtotime( get_sub_field( 'start_date' ) ) );
								
								// $calendar .= the_sub_field( 'start_date' );
								$calendar .= the_field( 'date' );
						    
						    if( $date == $eventDate ) { 
											$theFullTitle = get_the_title();
											$theShortTitle = (strlen($theFullTitle) > 27) ? substr($theFullTitle,0,24).'...' : $theFullTitle;
											$theLink = get_the_title();
											$theLink = strtolower( preg_replace('/[\s]/','-', $theLink) );
											$calendar .= '<div class="cal-event">';														
											$calendar .= '<a href="' . $theLink . '" data-toggle="tooltip" title="' . $theFullTitle . '" >' . $theShortTitle. '</a>';
											$calendar .= '</div>'; // /cal-event
								};
							endwhile;     					 
						endwhile;
						wp_reset_postdata();
			
						$calendar .= "</div>"; // /cal-day
					
          // Increment counters
 
          $currentDay++;
          $dayOfWeek++;

     } 

     // Complete the row of the last week in month, if necessary

     if ($dayOfWeek != 7) { 
     
          $remainingDays = 7 - $dayOfWeek;
          while ( $remainingDays > 0 ) {
          $calendar .= "<div class='cal-day'>&nbsp;</div>"; 
          $remainingDays--;
          }

     }
     
     $calendar .= "</div>"; // /cal-holder 

     return $calendar;

}

?>



