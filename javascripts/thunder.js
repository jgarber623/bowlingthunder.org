$().ready( function() {

	var emailer = function() {
		$( "span.email", "div#ft" ).each( function() {
			var span = $( this ), title = span.attr( "title" ), pieces = title.split( "|" ), email = pieces[0] + "@" + pieces[1] + "." + pieces[2];
			span.wrapInner( '<a href="mailto:' + email + '?subject=Bowling%20Thunder"></a>');
		});
	};

	emailer();
});