( function( $ ) {
	$( ".feature-box-toggle" ).on( "click", function(e){
		var postList = $( this ).siblings( ".feature-box-hidden" );
		if ( postList.css( "display" ) == "none" ) {
			postList.slideDown();
			$( ".feature-box-toggle" ).addClass( "feature-box-hidden-opened" );
		} else if (postList.css( "display" ) == "block" ) {
			postList.slideUp();
			$( ".feature-box-toggle" ).removeClass( "feature-box-hidden-opened" );
		}
		return false;
	});
})(jQuery);