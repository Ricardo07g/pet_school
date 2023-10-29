
$( document ).ready(function() {
    console.log( "ready!" );
    (function($) {

		"use strict";

		var fullHeight = function() {

			$('.js-fullheight').css('height', $(window).height());
			$(window).resize(function(){
				$('.js-fullheight').css('height', $(window).height());
			});

		};
		fullHeight();

		$('#sidebarCollapse').on('click', function () {
			console.log('#sidebarCollapse', 'foi');
	      $('#sidebar').toggleClass('active');
	  });

	})(jQuery);
});
