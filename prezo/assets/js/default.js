( function( $ ) {
    
    var prezoFn,
        $postContentMain = $( '.post-content--main' ),
        $h1 = $postContentMain.find( 'h1' ),
        $h2 = $postContentMain.find( 'h2' ),
        $h3 = $postContentMain.find( 'h3' ),
        $h4 = $postContentMain.find( 'h4' ),
        $h5 = $postContentMain.find( 'h5' ),
        $h6 = $postContentMain.find( 'h6' );
    
    
    prezoFn = {
        
        slide: function( $e ) {
            $e.each( function() {
                var $this = $( this );
                $this
                    .nextUntil( $e )
                    .addBack()
                    .wrapAll('<div class="slide" />');
            } );
        }
    };
    prezoFn.slide( $h1 );
    prezoFn.slide( $h2 );
    prezoFn.slide( $h3 );
    prezoFn.slide( $h4 );
    prezoFn.slide( $h5 );
    prezoFn.slide( $h6 );
    
} )( jQuery );