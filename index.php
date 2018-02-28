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





// ------------------------------------ Class Name via Custom Fields – Inserted into the Body Class
function applicator_class_name_cf_body_class( $classes )
{
    $class_name_post_meta = get_post_meta( get_the_ID(), 'Applicator: Class Name', true );
    
    if ( $class_name_post_meta )
    {
        $classes[] = sanitize_title( $class_name_post_meta );
    }
    return $classes;
}
add_filter( 'body_class', 'applicator_class_name_cf_body_class' );





// ------------------------------------ Post Banner Visual via Custom Fields
function applicator_post_banner_visual_cf()
{
    $post_banner_visual_obj = '';
    $featured_image_post_meta = get_post_meta( get_the_ID(), 'Applicator: Featured Image', true );
    $post_banner_visual_a_MU = '<a class="post-banner-visual---a" href="'. get_the_permalink(). '"></a>';

    if ( $featured_image_post_meta )
    {
        $post_banner_visual_obj = applicator_htmlok( array(
            'name'      => 'Post Banner Visual',
            'structure' => array(
                'type'      => 'object',
            ),
            'title'     => esc_html( get_the_title() ),
            'content'   => array(
                'object'    => array(
                    $post_banner_visual_a_MU,
                    $featured_image_post_meta,
                ),
            ),
        ) );
    }
    
    return $post_banner_visual_obj;
}


// Remove the Featured Image via Meta Box if Featured Image via Custom Fields is present 
function applicator_post_banner_visual_hooked_remove()
{
    if ( '' !== get_the_post_thumbnail() && get_post_meta( get_the_ID(), 'Applicator: Featured Image', true ) )
    {
        remove_action( 'applicator_hook_after_post_meta_header_aside', 'applicator_post_banner_visual_hooked' );
    }
}
add_action( 'wp_head', 'applicator_post_banner_visual_hooked_remove' );


// Post Banner Visual Inserted via Hook
function applicator_post_banner_visual_cf_hooked()
{
    echo applicator_post_banner_visual_cf();
}
add_action( 'applicator_hook_after_post_meta_header_aside', 'applicator_post_banner_visual_cf_hooked' );


// Post Banner Visual via Custom Fields - HTML Class
function applicator_post_banner_visual_cf_body_class( $classes )
{
    if ( is_single() && get_post_meta( get_the_ID(), 'Applicator: Featured Image', true ) )
    {   
        $classes[] = 'post-banner-visual-custom-field--enabled';
    }
    return $classes;
}
add_action( 'body_class', 'applicator_post_banner_visual_cf_body_class');


// Post Class
function applicator_post_banner_visual_cf_post_class( $classes )
{
	if ( get_post_meta( get_the_ID(), 'Applicator: Featured Image', true ) )
    {
        $classes[] = 'post-banner-visual-custom-field--enabled';
    }
    return $classes;
}
add_filter( 'post_class', 'applicator_post_banner_visual_cf_post_class' );





// ------------------------------------ Applicator Shortcode - Output
// http://wpsnipp.com/index.php/functions-php/get-custom-field-value-with-shortcode/
// Usage: [applicator_o "[custom field name]"]
// Custom Field Name: [custom field name]
// Custom Field Value: anything entered here will show in the content where the shortcode is inserted

function applicator_ouput_shortcode( $atts )
{
    extract( shortcode_atts( array(
        'post_id' => NULL,
    ), $atts ) );
    
    if ( !isset( $atts[0] ) )
    {
        return;
    }
    
    $field = esc_attr( $atts[0] );
    
    global $post;
    
    $post_id = ( NULL === $post_id ) ? $post->ID : $post_id;
    
    return get_post_meta( $post_id, $field, true );
}








// ------------------------------------ Applicator HTML_OK Shortcode
// [applicator_htmlok_cp name="Name"]Content[/applicator_htmlok_cp]
// https://developer.wordpress.org/plugins/shortcodes/shortcodes-with-parameters/#complete-example

function applicator_htmlok_shortcode( $atts = [], $content = null, $tag = '' )
{
    $atts = array_change_key_case( ( array ) $atts, CASE_LOWER );
 
    $htmlok_atts = shortcode_atts( [
        'name' => 'HTML_OK',
    ], $atts, $tag );
 
    $o = '';
 
    $o .= '<div id="'. sanitize_title( $htmlok_atts['name'] ). '" class="cp'. ' '. sanitize_title( $htmlok_atts['name'] ). ' '. 'applicator-html-ok-shortcode'. '" data-name="'. esc_html( $htmlok_atts['name'] ). ' CP">';
        $o .= '<div class="cr'. ' '. sanitize_title( $htmlok_atts['name'] ). '---cr">';
            $o .= '<div class="h">' . esc_html__( $htmlok_atts['name'], 'applicator' ). '</div>';
            $o .= '<div class="ct'. ' '. sanitize_title( $htmlok_atts['name'] ). '---ct">';

            if ( ! is_null( $content ) )
            {
                $o .= do_shortcode( $content );
            }

            $o .= '</div>';
        $o .= '</div>';
    $o .= '</div>';
 
    return $o;
}



function applicator_shortcodes_init()
{
    add_shortcode( 'applicator_o', 'applicator_ouput_shortcode' );
    add_shortcode('applicator_htmlok_cp', 'applicator_htmlok_shortcode');
}
add_action('init', 'applicator_shortcodes_init');


/**
 * Remove empty paragraphs created by wpautop()
 * @author Ryan Hamilton
 * @link https://gist.github.com/Fantikerz/5557617
 */
function remove_empty_p( $content )
{
	$content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
	$content = preg_replace( '~\s?<p>(\s| )+</p>\s?~', '', $content );
	$content = preg_replace( '/\s\s+/', ' ', $content );
	return $content;
}
add_filter('the_content', 'remove_empty_p' );

/**
 * Remove <p> and <br> around [shortcode]
 * @author Borek
 * @link https://wordpress.stackexchange.com/a/130185/59838
 */
function the_content_filter( $content )
{
    $shortcode = join( '|', array(
        'applicator_htmlok_cp',
        'applicator_o',
    ) );
    
    $clean_shortcode = preg_replace( "/(<p>)?\[($shortcode)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content );
		
	$clean_shortcode = preg_replace( "/(<p>)?\[\/($shortcode)](<\/p>|<br \/>)?/", "[/$2]", $clean_shortcode );
	
    return $clean_shortcode;
}
add_filter( 'the_content', 'the_content_filter' );