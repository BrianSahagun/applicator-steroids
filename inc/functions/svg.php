<?php

/**
 * Allow SVG in Media Upload
 * @author Chris Coyier
 * @link https://codepen.io/chriscoyier/post/wordpress-4-7-1-svg-upload
 */





add_filter( 'wp_check_filetype_and_ext', function( $data, $file, $filename, $mimes )
{
    global $wp_version;
    
    if( $wp_version == '4.7-alpha' || ( (float) $wp_version < '4.7-alpha' ) )
    {
        return $data;
    }
    
    if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '==' ) || version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) )
    {
        return $data;
    }
    
    $filetype = wp_check_filetype( $filename, $mimes );
    
    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];

}, 10, 4 );





function applicator_svg_mime_type( $mimes )
{
    $mimes['svg'] = 'image/svg+xml';
    
    return $mimes;
}
add_filter( 'upload_mimes', 'applicator_svg_mime_type' );





function applicator_fix_css_svg_admin()
{
    echo '
    
    <style>
        .attachment-266x266, .thumbnail img
        {
             width: 100% !important;
             height: auto !important;
        }
    </style>
    
    ';
}
add_action( 'admin_head', 'applicator_fix_css_svg_admin' );