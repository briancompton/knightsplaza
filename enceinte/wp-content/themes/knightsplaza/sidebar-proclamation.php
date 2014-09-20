<?php
/**
 * The Sidebar containing the main "Tower" area.
 *
 * @package kp
 */
 
?>

<div class="proclamation-preamble">There's Always Something Happening</div>
<div class="proclamation-published">The Place to</div>
	<ul class="points"></ul>

<script>
	
	/* Let's shuffle the array up */
	function Shuffle(o) {
		for(var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
		return o;
	};

	var testArray = ["Explore", "Discover", "Mingle", "Celebrate", "Create", "Play"];
	Shuffle(testArray);


	jQuery(function ($) {
	
		var k = 0;
		var $it = testArray.length;

		while ( k < $it ) {
			$('.points').append( '<li>' + testArray[k] + '</li>');
			k++;
		};
		
	 var j = 0;
	 var delay = 5000; //millisecond delay between cycles
	 function cycleThru(){
	         var jmax = $("ul.points li").length -1;
	         /* $('.proclamation-published').animate({ "opacity" : "1" }); */
	     //    $('.proclamation-published').animate({ "opacity" : "1" });
	         $("ul.points li:eq(" + j + ")")
             			.animate({"top" : "0"} ,4000, function() { $('.proclamation-published').animate({ "opacity" : "1" }); })
             			.delay(2000)
             			.animate({"top" : "0"}, 100, function() { $('.proclamation-published').animate({ "opacity" : "0" }); })
             	//		.animate({"opacity" : "1.0"} ,400)
	            //     .animate({"top" : "0","opacity" : "1.0"}, delay)
	            //     .animate({"top" : "0","opacity" : "0"} ,400)
	                 .animate({"top" : "9999px"}, 1000)
	                 .animate({"top" : "-9999px"}, 100,
          function(){
	                         (j == jmax) ? j=0 : j++;
	                         cycleThru();
	                 });
	         };

		cycleThru();
	
	});	

</script>


