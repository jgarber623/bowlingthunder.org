$().ready( function() {
	
	var navigater = function() {
		var content = $( "div#content" ), loader = $( "div#loader" ), wrap = $( "div#tweets" ), anchors = $( "ul.pagination a", content );
		
		anchors.each( function() {
			var anchor = $( this );

			anchor.click( function() {
				$.ajax({
					type: "get",
					dataType: "html",
					url: "lib/get_tweets.php?url=" + escape( anchor.attr( "href" ) ),
					beforeSend: function() {
						loader.slideDown( "fast" );
						$( "html, body" ).animate({ scrollTop: content.offset().top, duration: 0 });
						wrap.slideUp( "slow" );
					},
					success: function(rsp) {
						loader.slideUp( "fast" );
						wrap.html( rsp ).slideDown( "slow" );
						navigater();
					}
				});

				return false;
			});
		});
	};
	
	var emailer = function() {
		$( "span.email", "div#ft" ).each( function() {
			var span = $( this ), title = span.attr( "title" ), pieces = title.split( "|" ), email = pieces[0] + "@" + pieces[1] + "." + pieces[2];
			span.wrapInner( '<a href="mailto:' + email + '?subject=Bowling%20Thunder"></a>');
		});
	};
	
	navigater();
	emailer();
});