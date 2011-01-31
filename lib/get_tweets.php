<?php
	include( "date.php" );
	include( "get_url_contents.php" );
	
	function get_tweets( $url = "http://search.twitter.com/search.atom?q=%40bowlingthunder&rpp=10" ) {
		$out = "";
		$previous = false;
		$next = false;
		
		$atom = get_url_contents( $url );
		
		if ( strlen( $atom ) > 0 ) {
			$dom = new DomDocument();
			$dom->loadXML( $atom );

			$links = $dom->getElementsByTagName( "link" );
			$tweets = $dom->getElementsByTagName( "entry" );
			
			if ( count( $links ) > 0 ) {
				foreach( $links as $link ) {
					if ( $link->getAttribute( "rel" ) == "next" ) $next = htmlentities( $link->getAttribute( "href" ) );
					if ( $link->getAttribute( "rel" ) == "previous" ) $previous = htmlentities( $link->getAttribute( "href" ) );
				}
			}
			
			if ( count( $tweets ) > 0 ) {
				$out .= '<ol class="hfeed">';
				
				foreach( $tweets as $tweet ) {
					$content = $tweet->getElementsByTagName( "content" )->item(0)->nodeValue;
					$published = $tweet->getElementsByTagName( "published" )->item(0)->nodeValue;
					$fancy_published = time_ago_in_words( strtotime( $published ) );
					$author = explode( " (", $tweet->getElementsByTagName( "author" )->item(0)->getElementsByTagName( "name" )->item(0)->nodeValue );
					$author_url = $tweet->getElementsByTagName( "author" )->item(0)->getElementsByTagName( "uri" )->item(0)->nodeValue;
					$permalink = $tweet->getElementsByTagName( "link" )->item(0)->getAttribute( "href" );

					$out .= '<li class="hentry">';
					$out .= '<p class="entry-title entry-content">' . $content . '</p>';
					$out .= '<p class="vcard"><a href="' . $author_url . '" class="fn url">' . $author[0] . '</a> <abbr class="published" title="' . $published . '">' . $fancy_published . ' ago</abbr> <a href="' . $permalink . '" rel="bookmark">(#)</a></p>';
					$out .='</li>';
				}
				
				$out .= '</ol>';
				
				if ( $previous || $next ) {
					$out .= '<ul class="pagination clear">';
					if ( $next ) $out .= '<li class="next"><a href="' . $next . '" rel="next">Next</a></li>';
					if ( $previous ) $out .= '<li class="previous"><a href="' . $previous . '" rel="previous">Previous</a></li>';
					$out .= '</ul>';
				}
			}
		}
		
		return $out;
	}
	
	if ( isset( $_GET["url"] ) && $_GET["url"] != "" ) {
		echo get_tweets( $_GET["url"] );
	}
?>