( function( $ ) {
    
    var $post_content_main = $( '.post-content--main' ),
        $h1 = $post_content_main.find( 'h1' ),
        $h2 = $post_content_main.find( 'h2' ),
        $h3 = $post_content_main.find( 'h3' ),
        $h4 = $post_content_main.find( 'h4' ),
        $h5 = $post_content_main.find( 'h5' ),
        $h6 = $post_content_main.find( 'h6' ),
        slide_class = 'slide';
    
    
    // All heading elements
    $h1.segregate( {
        element: $h1,
        class: slide_class
    } );
    
    $h2.segregate( {
        element: $h2,
        class: slide_class
    } );
    
    $h3.segregate( {
        element: $h3,
        class: slide_class
    } );
    
    $h4.segregate( {
        element: $h4,
        class: slide_class
    } );
    
    $h5.segregate( {
        element: $h5,
        class: slide_class
    } );
    
    $h6.segregate( {
        element: $h6,
        class: slide_class
    } );
    
    
    // For all non-heading elements
    var $not_slide = '*:first-child:not( .slide )',
        $post_content_main_children = $post_content_main.children( $not_slide );
    
    $post_content_main_children
        .nextUntil( '.slide' )
        .andSelf()
        .wrapAll( $( '<div />', { 'class': slide_class } ) );
    
} )( jQuery );