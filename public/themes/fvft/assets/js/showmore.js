(function($) {
    "use strict";
	$('#container').showmore({
		closedHeight: 250,
		buttonTextMore: 'Show more',
		buttonTextLess: 'Close',
		buttonCssClass: 'showmore-button',
		animationSpeed: 0.5
	});
	$('#container1').showmore({
		closedHeight: 315,
		buttonTextMore: 'Show more',
		buttonTextLess: 'Close',
		buttonCssClass: 'showmore-button',
		animationSpeed: 0.5
	});
	$('#container2').showmore({
		closedHeight: 280,
		buttonTextMore: 'Show more',
		buttonTextLess: 'Close',
		buttonCssClass: 'showmore-button',
		animationSpeed: 0.5
	});
	$('.hide-details').showmore({
		closedHeight: 137,
		buttonTextMore: 'Show more',
		buttonTextLess: 'Close',
		buttonCssClass: 'showmore-button1',
		animationSpeed: 0.5
	});
	if (document.documentElement.clientWidth < 900) {
		$('#container1').showmore({
			closedHeight: 450,
			buttonTextMore: 'Show more',
			buttonTextLess: 'Close',
			buttonCssClass: 'showmore-button',
			animationSpeed: 0.5
		});
	}
	let salary_from =$("#salary_from").val();
	let salary_to =$("#salary_to").val();
	if($("#salary_from").val()==""){
		salary_from=19999;
		$("#salary_from").val(salary_from);
	}
	if($("#salary_to").val()==""){
		salary_to=49999;
		$("#salary_to").val(salary_to);
	}
	
	$( "#mySlider" ).slider({
		range: true,
		min: 5000,
		max: 500000,
		values: [ salary_from, salary_to],
		slide: function( event, ui ) {
			 $("#salary_from").val(ui.values[ 0 ]);
			 $("#salary_to").val(ui.values[ 1 ]);
			$( "#price" ).val( "Rs." + ui.values[ 0 ] + " - Rs." + ui.values[ 1 ] );
		}
	});

	$( "#price" ).val("Rs."+$( "#mySlider" ).slider( "values", 0 ) +
			   "- Rs."+ $( "#mySlider" ).slider( "values", 1 ) );
})(jQuery);