<?php if( $_GET['bwc'] ) { ?>
	<div id="x_axis">X</div>
	<div id="y_axis">Y</div>
	<?php ;} ?>
	
	<div class="map-caption-upper">Knights Plaza</div>
		<div class="alert-location">
			<button type="button" class="close" aria-hidden="true">&times;</button>
			<div class="bar-title">RWC @ Knights Plaza</div>
			<p>RWC @ Knights plaza is an inviting new facility on the north end of the UCF Campus. Located at the corner of West Plaza Drive and Gemini Boulevard North near the UCF Arena.</p>
			<!-- <p><a href="<?php get_template_directory_uri();?>/directory#w4202" class="alert-link">Go</a></p> -->
			
			<div class="bar-footer">
				<a href="#location-w4202" class="alert-link"><button class="btn btn-info btn-sm"> Go </button></a>
			</div>
			
		</div>
	
	<div class="map-holder">
		<div class="key">
			<div class="location-key" id="location-1"><span>1</span>RWC @ Knights Plaza</div>
			<div class="location-key coming-soon" id="location-2"><span>2</span>Dunkin' Donuts</div>
			<div class="location-key" id="location-3"><span>3</span>Subway</div>
			<div class="location-key" id="location-4"><span>4</span>Available</div>
			<div class="location-key" id="location-5"><span>5</span>Princeton Review</div>
			<div class="location-key" id="location-6"><span>6</span>Domino's</div>
			<div class="location-key" id="location-7"><span>7</span>Kyoto Sushi & Grill</div>
			<div class="location-key" id="location-8"><span>8</span>West Plaza Mail Center</div>
			<div class="location-key" id="location-9"><span>9</span>Knight Aide Pharmacy</div>
			<div class="location-key" id="location-10"><span>10</span>All Knight Study</div>
			<div class="location-key" id="location-11"><span>11</span>Veteran's Affairs Resource Center</div>
			<div class="location-key" id="location-12"><span>12</span>Jimmy John's Gourmet Sandwiches</div>
			<div class="location-key coming-soon" id="location-13"><span>13</span>CFE Credit Union</div>
			<div class="location-key" id="location-14"><span>14</span>Available</div>
			<div class="location-key" id="location-15"><span>15</span>Cypress Room</div>
			<div class="location-key" id="location-16"><span>16</span>Knightro's</div>
			<div class="location-key" id="location-17"><span>17</span>Barnes & Noble @ UCF</div>
			<div class="location-key" id="location-18"><span>18</span>Available</div>
			<div class="location-key" id="location-19"><span>19</span>Available</div>
			<div class="location-key" id="location-20"><span>20</span>Burger U</div>
		</div><!-- /.key -->

	
		<?php include( 'map-canvas-1.html' ); ?>

		<div class="btn-group map-controls">
		  <button id="zoomIn" type="button" class="btn btn-default">&#x2b;</button>
		  <button id="zoomOut" type="button" class="btn btn-default">&#x2212;</button>
		  <button id="snow" type="button" class="btn btn-default">&#10052;</button>
		</div>
	
	</div><!-- /.map-holder -->
