jQuery(function ($) {

/* Home page blog slider */
$('.slider').cycle({
	delay: 		3000,
	fx:     	'scrollLeft', 
  timeout: 	6000,
	pause: 		1,
	pager:  '.indicator-more'
});

});

