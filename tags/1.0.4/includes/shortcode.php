<?php
/*
 * RC Post Rating
 * https://qreate.co.uk/projects/#rc-post-rating
 * Rick Curran
 * https://qreate.co.uk
 *
 * Shortcode
 */

function qr_post_rating_shortcode( $atts ) {
    $atts = shortcode_atts( array(
		'id' => '',
		'classes' => '',
		'uptext' => '',
		'downtext' => '',
	), $atts, 'qr_post_rating' );
    
    
    // Get default up/down vote text, either from stored values or default to 'Up' or 'Down'
    $options = get_option( 'qr_post_rating_settings' );
    
    if ( $options[ 'qr_post_rating_up_text' ] ) {
        $uptext = $options[ 'qr_post_rating_up_text' ];
    } else {
        $uptext = __( 'Up', 'qr_post_rating_plugin' );
    }
    
    if ( $options[ 'qr_post_rating_down_text' ] ) {
        $downtext = $options[ 'qr_post_rating_down_text' ];
    } else {
        $downtext = __( 'Down', 'qr_post_rating_plugin' );
    }
    
    if ( $options[ 'qr_post_rating_button_classes' ] ) {
        $qr_post_rating_button_classes = $options[ 'qr_post_rating_button_classes' ];
    } else {
        $qr_post_rating_button_classes = '';
    }  
    
    
    if ( $atts[ 'classes' ] != '' ) {
        $classes = esc_attr( $atts[ 'classes' ] ) . ' ';
    } else {
        $classes = $qr_post_rating_button_classes;
    }
    
    if ( $atts[ 'id' ] != '' ) {
        $id = esc_attr( $atts[ 'id' ] );
    } else {
        global $post;
        $id = $post->ID;
    }
	
    if ( $atts[ 'uptext' ] != '' ) {
        $up = esc_attr( $atts[ 'uptext' ] );
    } else {
        $up = $uptext;
    }
	
    if ( $atts[ 'downtext' ] != '' ) {
        $down = esc_attr( $atts[ 'downtext' ] );
    } else {
        $down = $downtext;
    }
	
	$data = '<div class="post-rating-tool" data-post-rating-id="' . $id . '">
                <a class="' . $classes . ' rating-up">' . $up . '</a>
                <a class="' . $classes . ' rating-down">' . $down . '</a>
            </div>';
	
	return $data;
}

add_shortcode( 'qr_post_rating', 'qr_post_rating_shortcode' );

?>