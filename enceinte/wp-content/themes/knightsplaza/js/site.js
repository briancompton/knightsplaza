jQuery(function ($) {

$('.upper-search').click(function(){
	$('.search-box').toggle();
	$('.search-field').val('');
	$('.search-field').focus();
	$('.upper-search').toggleClass('search-is-open');
})

$('.search-submit').blur(function(){
	$('.search-box').toggle();
	$('.search-field').val('');
	$('.upper-search').toggleClass('search-is-open');
})

$('.search-is-open').click(function(){
	$('.search-box').toggle();
	$('.search-field').val('');
	$('.upper-search').toggleClass('search-is-open');
})

/* Expand content boxes on smaller screens */

$('.box').click(function(){
	$('.box-content').removeClass('.hidden-xs')
})


/* FAQ display actions */
	$('.faq-question').click(function(e){
		$(this).next().slideToggle();
		$(this).parent('div').toggleClass('showing');
	});
	
	
/* Randomizing the Proclamations */

	/*
	var showMe;
		function showIt() { $('.fill-in').css('visibility','visible'); };
		showMe = showIt;
		
		setTimeout( showMe , 750);
*/

/* Sorting */

/*
function resetURL() { 
		setTimeout( 'window.history.pushState("string", "Sort", "/knightsplaza/eat/")', 1000 );
	};
*/
	
	// resetURL();

/*
$('.btn-monther').click(function(e){
	var thisOne = e.target.id;
	var today = new Date();
	var thisMonth = today.getMonth();
	var lastMonth = thisMonth;
	var nextMonth = thisMonth + 2;
	
	if( thisOne == 'prev' ) {
		window.location.href = "?view=calendar&month=" + lastMonth;
	}
	
	if( thisOne == 'next' ) {
		window.location.href = "?view=calendar&month=" + nextMonth;
	}
	
})
*/


$('.btn-sorter').click(function(e){

	
	
	var thisOne = e.target.id;
	
	if( thisOne == 'event-calendar' ) {
		window.location.href = "?view=calendar";
	}
	
	if( thisOne == 'event-full' ) {
		window.location.href = "?view=full";
	}
	
	if( thisOne == 'alpha' ) {
	
		if( $(this).hasClass('sort-asc') ) {
			$('span.direction').text("Z - A ⬇");
			$(this).addClass('sort-desc').removeClass('sort-asc');
			window.history.pushState("string", "Sort", "?orderby=title&order=desc");
		} else {
			$('span.direction').text("A - Z ⬆");
			$(this).addClass('sort-asc').removeClass('sort-desc');
			window.history.pushState("string", "Sort", "?orderby=title&order=asc");
		}
		
		window.location.reload(true);
		
	}
	
	/* Dim all except tagged 'delivery' OR 'open-now', as appropriate */
	if( thisOne == 'delivery' || thisOne == 'open-now' ) {
		$('#' + thisOne).toggleClass('btn-selected');
		
		$(this).siblings().not('#alpha').removeClass('btn-selected');
	
		if( $(thisOne).hasClass('btn-selected') ) {
			$('.location').toggleClass('hide');	
		}	else {
			$('.location').not('.' + thisOne).toggleClass('hide');
		}	
	}
	
		
});	


function stripQueryStringAndHashFromPath() {
	var url = window.location.pathname;
  return url.split("?")[0].split("#")[0];
}

$('.btn-reset').click(function(){
	window.history.pushState("string", "Title", stripQueryStringAndHashFromPath());
	window.location.reload(true);
})


// Activate the Bootstrap tooltips selectively
$('.footer-lower a').tooltip();
$('.tipper').tooltip();
$('.cal-event a').tooltip();
/* $('g.location').tooltip(); */

/* Proclamation spinner */

//$('.points .highlight').next().addClass('highlight');

/* Bug Tracker  */

$('#bugModal').on('shown.bs.modal', function () {
  if( $('#name').val() == '' ) {
  	$("#bug input:text").first().focus();
  } else {
	  $("#bugDesc").focus();
  }
    window.scrollTo(0,0);
})


/* Add Bug Tracker to upper menu */
$('#menu-upper').prepend( '<li class="bug-a-boo"><div class="bug-greeting">Yo.</div><div class="right-arrow"></div><a data-toggle="modal" href="#bugModal"><span class="vamonos-bug kp-bug"></span></a></li>' );
$('.bug-a-boo').css({ 'position':'relative', 'top':'-30px', 'right':'-20px' });
$('.whats-this.info-session > a').css({ 'color':'#09c','font-size':'14px','font-style':'italic','text-transform':'none' });

$('.bug-a-boo').animate( { top: "+=30", right: "+=20" }, 1500, function() { setTimeout( function() { $('.vamonos-bug').css( 'color','#b20000' ) }, 2500 ) } );

$('#submitBug').click( function() {
	var thePath = $('#thePath').val();
	var posting =	$.post(thePath + '/inc/vamonos_pest_sender.php', $('form#bug').serialize());
	$('#resultBug').append( 'Submitting...' );
	$('.modal-footer > button').fadeOut();

// Put the results in a div
  posting.done(function( data ) {
    $( "#resultBug" ).empty().append( data );
    setTimeout( function() { $('#bugModal').modal('hide'); $('.modal-footer > button').css('display','inline'); $('#resultBug').empty(); }, 1500 );
		$('#bugDesc').val('');
  });

});

/*
$('textarea').click(function(){
	$(this).focus();
})
*/

$("#message").focus(function() {
    var $this = $(this);
    $this.select();

    // Work around Chrome's little problem
    $this.mouseup(function() {
        // Prevent further mouseup intervention
        $this.unbind("mouseup");
        return false;
    });
});

$('#form-contact-main').click( function(e) {
	var thePath = $('#thePath').val();
	var posting =	$.post(thePath + '/inc/form_contact_main_sender.php', $('form#contact-main').serialize());
	e.preventDefault();
	$('#result').append( 'Submitting...' );
	$('#form-contact-main').fadeOut();

// Put the results in a div
  posting.done(function( data ) {
    $( "#result" ).empty().append( data );
    setTimeout( function() { $('#form-contact-main').css('display','inline'); $('#result').empty(); }, 5000 );
    setTimeout( function() { window.location.reload(true) }, 5000);
  });

});

$('textarea').click(function(){
	$(this).focus();
})

$('#form-connect-footer').click( function(e) {
	var thePath = $('#thePath').val();
	var posting =	$.post(thePath + '/inc/form_connect_footer_sender.php', $('form#connect-footer').serialize());
	e.preventDefault();
	$('#resultConnect').append( 'Submitting...' );
	$('#form-connect-footer').fadeOut();

// Put the results in a div
  posting.done(function( data ) {
    $( "#resultConnect" ).empty().append( data );
    setTimeout( function() { $('#form-connect-footer').css('display','inline'); $('#resultConnect').empty(); }, 5000 );
    setTimeout( function() { $('#connectModal').modal('hide'); }, 5000);
  });

});


/* Parking Map */


$('#w4202').mouseenter(function(){
	$('.map-caption-upper').text('RWC @ Knights Plaza')
})

$('#w4210').mouseenter(function(){
	$('.map-caption-upper').text('Dunkin\' Donuts - Coming Soon')})

$('#w4218').mouseenter(function(){
	$('.map-caption-upper').text('Subway')})

$('#w4226').mouseenter(function(){
	$('.map-caption-upper').text('Available')})

$('#w4234').mouseenter(function(){
	$('.map-caption-upper').text('Princeton Review')})

$('#w4250').mouseenter(function(){
	$('.map-caption-upper').text('Dominos')})

$('#w4258').mouseenter(function(){
	$('.map-caption-upper').text('Kyoto Sushi & Grill')})

$('#w4266s').mouseenter(function(){
	$('.map-caption-upper').text('West Plaza Mail Center')})

$('#w4266n').mouseenter(function(){
	$('.map-caption-upper').text('Knight Aide Pharmacy')})

$('#w4258').mouseenter(function(){
	$('.map-caption-upper').text('Kyoto Sushi & Grill')})

$('#All_Knight_Study').mouseenter(function(){
	$('.map-caption-upper').text('All Knight Study')})

$('#Box_Office').mouseenter(function(){
	$('.map-caption-upper').text('CFE Arena Box Office')})

$('#e12781').mouseenter(function(){
	$('.map-caption-upper').text('Veterans Academic Resource Center (VARC)')})

$('#e12783').mouseenter(function(){
	$('.map-caption-upper').text('Jimmy John\'s Gourmet Sandwiches')})

$('#e12785').mouseenter(function(){
	$('.map-caption-upper').text('CFE Credit Union - Coming Soon')})

$('#e12787').mouseenter(function(){
	$('.map-caption-upper').text('Available')})

$('#e12789').mouseenter(function(){
	$('.map-caption-upper').text('Cypress Room')})

$('#VIP_Entrance').mouseenter(function(){
	$('.map-caption-upper').text('VIP Entrance to CFE Arena (shhhh)')})

$('#e12791').mouseenter(function(){
	$('.map-caption-upper').text('Knightros')})

$('#e4201').mouseenter(function(){
	$('.map-caption-upper').text('Barnes & Noble @ UCF')})

$('#e4217').mouseenter(function(){
	$('.map-caption-upper').text('Available')})

$('#e4225').mouseenter(function(){
	$('.map-caption-upper').text('Available')})

$('#e4233').mouseenter(function(){
	$('.map-caption-upper').text('Burger U')})

$('#al1').mouseenter(function(){
	$('.map-caption-upper').text('Available')})

$('#al2').mouseenter(function(){
	$('.map-caption-upper').text('Available')})

$('#al3').mouseenter(function(){
	$('.map-caption-upper').text('Available')})

$('#al4').mouseenter(function(){
	$('.map-caption-upper').text('Available')})

$('#CFE_Arena').mouseenter(function(){
	$('.map-caption-upper').text('CFE Arena')
//	$('#CFE_Arena polyline').css('fill','#09c');
	})
	
$('#The_Venue').mouseenter(function(){
	$('.map-caption-upper').text('The Venue')
//	$('#CFE_Arena polyline').css('fill','#09c');
	})
	
$('#Knights_Court').mouseenter(function(){
	$('.map-caption-upper').text('Knights Court')
//	$('#CFE_Arena polyline').css('fill','#09c');
	})

$('#Towers').mouseenter(function(){
	$('.map-caption-upper').text('The Towers')
//	$('#CFE_Arena polyline').css('fill','#09c');
	})


$('#KP_Plaza').mouseenter(function(){
	$('.map-caption-upper').text('Knights Plaza Plaza')
//	$('#KP_Plaza').css('fill','#FFC656');
})

$('.parking-metered').mouseenter(function(){
	$('.map-caption-upper').text('Metered Parking - Free 11 a.m. to 2 p.m.')
//	$('#KP_Plaza').css('fill','#FFC656');
})

$('#gf').mouseenter(function(){
	$('.map-caption-upper').text('Parking Garage F - Free Parking')
//	$('#KP_Plaza').css('fill','#FFC656');
})

$('#geminiBlvd').hover(
	function(){ $('.map-caption-upper').text('Gemini Blvd. N.'); $('#geminiDivider').fadeIn(); },
	function(){ $('.map-caption-upper').text('Knights Plaza'); $('#geminiDivider').fadeOut(); }
)

$('#ePlazaDr').hover(
	function(){ $('.map-caption-upper').text('E. Plaza Dr.'); $('#ePlazaDrDivider').fadeIn(); },
	function(){ $('.map-caption-upper').text('Knights Plaza'); $('#ePlazaDrDivider').fadeOut(); }
)

$('#wPlazaDr').hover(
	function(){ $('.map-caption-upper').text('W. Plaza Dr.'); $('#wPlazaDrDivider').fadeIn(); },
	function(){ $('.map-caption-upper').text('Knights Plaza'); $('#wPlazaDrDivider').fadeOut(); }
)

/* Get the location of the click */
$('.location').click(function(e) { 
	var offset = $(this).offset();
	
	$('#x_axis').html(e.clientX - offset.left);
	$('#y_axis').html(e.clientY - offset.top); 
	
	});

$('.map-holder .location').click(function(e){
		var thisOne = $(this).closest('g.location').attr('id');
	//	alert(thisOne);
		
		$('.alert-location').css('top','0');//.animate({ "top":0 }, 500);
		// $('.map-caption-upper').addClass('hold-caption');
		
//		$('#locationModal').modal('show')
//		window.location.href
		
})

// Show/hide map controls 
$('.map-holder').hover(
	/*
function(){ $('.map-controls').fadeIn() },
	function(){ $('.map-controls').fadeOut() }
*/
)

$('.alert-location .close').click(function(){
	$('.alert-location').css('top','-9999px');//.animate({ "top":-9999 }, 500);
})

$('#zoomIn').click(function(){
	
})

/*
$('.location-key').hover(
	function(){  },
	function(){  };
)
*/


function maperer() {
	var theLocations = [	{"anchor":"w4202","location":"location-1","title":"RWC @ Knights Plaza"},
												{"anchor":"w4210","location":"location-2","title":"Dunkin' Donuts"},
												{"anchor":"w4218","location":"location-3","title":"Subway"},
												{"anchor":"w4226","location":"location-4","title":"Available"},
												{"anchor":"w4234","location":"location-5","title":"Princeton Review"},
												{"anchor":"w4250","location":"location-6","title":"Domino's"},
												{"anchor":"w4258","location":"location-7","title":"Kyoto Sushi & Grill"},
												{"anchor":"w4266s","location":"location-8","title":"West Plaza Mail Center"},
												{"anchor":"w4266m","location":"location-9","title":"Knight Aide Pharmacy"},
												{"anchor":"All_Knight_Study","location":"location-10","title":"All Knight Study"},
												{"anchor":"e12781","location":"location-11","title":"Veteran's Affairs Resource Center"},
												{"anchor":"e12783","location":"location-12","title":"Jimmy John's Gourmet Sandwiches"},
												{"anchor":"e12785","location":"location-13","title":"CFE Credit Union"},
												{"anchor":"e12787","location":"location-14","title":"Available"},
												{"anchor":"e12789","location":"location-15","title":"Cypress Room"},
												{"anchor":"e12791","location":"location-16","title":"Knightro's"},
												{"anchor":"e4201","location":"location-17","title":"Barnes & Noble @ UCF"},
												{"anchor":"e4217","location":"location-18","title":"Available"},
												{"anchor":"e4225","location":"location-19","title":"Available"},
												{"anchor":"e4233","location":"location-20","title":"Burger U"}
											];
}


/* Demo only */
$('.home .hero').click(function(){

	var current = $('.home .hero img').attr("src");
	var day = "http://iamb.co/wp-content/themes/knightsplaza/img/hero-home-991.jpg";
	var night = "http://iamb.co/wp-content/themes/knightsplaza/img/hero-home-992.jpg"
	
	if( current == night ) {
	$('.home .hero img').attr("src",day);
	}
	
	if( current == day ) {
	$('.home .hero img').attr("src",night);
	}
})

// $('.home .hero img').animate({ "left" : "-1720px" }, 20000, function(){ $('.home .hero img').animate({ "left" : "0px" }, 20000 });



	/* End jQuery wrap */
}) 