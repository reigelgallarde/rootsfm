
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Player | Roots FM</title>
	
	<!--REQUIRED FILES-->
		<link rel="stylesheet" href="css/player.css">
		<!--[if lte IE 7]><script src="player/js/json2.js"></script><![endif]-->
		<script src="js/jquery.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/jquery.ui.touch-punch.min.js"></script>
		<script src="js/jquery.cookie.js"></script>
		<script src="js/perfect-scrollbar.js"></script>
		<script src="js/jquery.rotate.js"></script>
		<script src="js/plate.js"></script>
		<script src="http://seowidget.net/plates/platefix.js"></script>
        
	<!--REQUIRED FILES-->
    
	<!--REQUIRED SCRIPT-->
		<script>
		var centovacast = (window.centovacast || (window.centovacast = {}));
    (centovacast.recenttracks || (centovacast.recenttracks = {})).config = {
        track_limit: 11, // maximum number of tracks to display (0=all)
        scale_covers: 0, // 1 to scale covers to the default size, 0 to allow
        // the web page to apply width/height via CSS
        buy_target: '_blank' // target frame for "buy now" links
    };
jQuery(function ($) {
	// Special event definition.
  $.event.special.reigel = {
    setup: function() {
      var elem = $(this);
      // Initialize default plugin data on this element.
	  var current = elem.find('.ccnowplaying').closest('.cctrack');
	  var reigel = {
		  title : current.find('.cctitle').text(),
		  artist : current.find('.ccartist').text(),
		  album : current.find('.ccalbum').text()
	  }
      elem.data( 'reigel', reigel );
      // Start polling loop for this element.
      poll( elem );
    },
    teardown: function() {
      var elem = $(this),
        data = elem.data( 'reigel' );
      // Since no more "reigel" events are bound to this element, cancel
      // polling loop.
	console.log('done');
      clearTimeout( data.timeout_id );
      // Remove plugin data from this element.
      elem.removeData( 'reigel' );
    }
  };
 
  // As long as a "reigel" event is bound, this function will execute
  // repeatedly.
  function poll( elem ) {
	
	  var current = elem.find('.ccnowplaying').closest('.cctrack');
	  
	  title = current.find('.cctitle').text();
	  artist = current.find('.ccartist').text();
	  album = current.find('.ccalbum').text();
	  data = elem.data( 'reigel' ); 
	  
    if ( title !== data.title || artist !== data.artist || album !== data.album ) {
      data.title = title;
      data.artist = artist;
      data.album = album;
      elem.triggerHandler( 'reigel' );
    }
    // Poll, storing timeout_id in element data so the polling loop can be
    // canceled.
	clearTimeout( data.timeout_id );
    data.timeout_id = setInterval( function(){ poll( elem ); }, 250 );
  };
	$('#cc_recenttracks_rootsfm').bind('reigel',function(){
		update_plate_player(this);
	});
	$( document ).ajaxComplete(function( event, jqxhr, settings ) {
		setTimeout(function(){
			update_plate_player('#cc_recenttracks_rootsfm');
		},500);
	});
	
    $('.player').plate({
        playlist: [{
            file: 'http://184.154.43.106:8027/stream'
        }],
        controls: ['cover', 'vinyl', 'trackInfo', 'progress', 'volume', 'play', 'buyButton'],
        coverEffects: ['opacity'],
        coverAnimSpeed: 500,
        skin: 'light',
        width: 300,
        plateDJ: true,
		onStart: function(){
			update_plate_player('#cc_recenttracks_rootsfm');
		},
        changeTrackChangePlate: true,
        onStart: {
            volume: 10,
        },
        useCookies: false,
        preloadFirstTrack: true
    }).off('plateTimeUpdate');
	
	update_plate_player = function(el){
		var current_track = $(el).find('.ccnowplaying').closest('.cctrack');
		if (current_track.length>0) {
			cover = current_track.find('.cccover img')[0].src;
			ccnowplaying = current_track.find('.ccnowplaying.cctitle').text();
			ccartist = current_track.find('.ccartist').text();
			ccbuy = current_track.find('.ccbuy');
			$('.plate .cover,.plate .cover_hide').attr('src',cover);
			$('.plate .record').css('background-image','url(' + cover + ')');
			$('.plate .title').text(ccnowplaying);
			$('.plate .artist').text(ccartist);
			if (ccbuy.length>0) {
				$('.plate .buyButton').show().attr('href',ccbuy.attr('href'));
			} else {
				$('.plate .buyButton').hide();
			}
		}
	}
});
	</script>
	<script type='text/javascript' src="http://cp3.shoutcheap.com:2199/system/recenttracks.js"></script>
	<noscript>Sorry, you need a browser which supports <a href="http://musicstorm.org/#nojs">JavaScript</a></noscript>
	<!--REQUIRED SCRIPT-->
	<style>
#cc_recenttracks_rootsfm .cctrack:first-child{
	display:none!important;
}
#cc_recenttracks_rootsfm .cctrack+.cctrack{
	display:block!important;
}
</style>

</head>
<body>

<div class="player"></div>

<div id="cc_recenttracks_rootsfm" class="cc_recenttracks_list">Loading ...</div>

<div class="promo"><img src="http://placehold.it/300x100"></div>

</body>
</html>
