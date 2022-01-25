<?php
/*
 * RC Post Rating
 * https://qreate.co.uk/projects/#rc-post-rating
 * Rick Curran
 * https://qreate.co.uk
 *
 * REST API
 */

add_action( 'rest_api_init', 'qr_post_rating_rest_endpoint' );
function qr_post_rating_rest_endpoint() {
    register_rest_route( 'qr-post-rating/v1', '/rate/(?P<mode>[a-z]+)/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'qr_post_rating_rest_func',
        'args' => array(
            'id' => array(
                'required' => true,
                'type' => 'integer',
                'validate_callback' => function( $param, $request, $key ) {
                    return is_numeric( $param );
                }
            ),
            'mode' => array(
                'required' => true,
                'type' => 'string',
                'validate_callback' => function( $param, $request, $key ) {
                    if ( $param == 'up' || $param == 'down' ) {
                        return $param;
                    } else {
                        return false;
                    }
                }
            ),
        ),
    ));
}

function qr_post_rating_rest_func( $data ) {
    $id = esc_attr( $data[ 'id' ] );
    $mode = esc_attr( $data[ 'mode' ] );
    $post_item = get_post( $id );
    $title = $post_item->post_title;
    $current_up_rating = get_post_meta( $id, 'qr_post_rating_up', true );
    $current_down_rating = get_post_meta( $id, 'qr_post_rating_down', true );
    
    if ( $mode == 'up' ) {
        $current_up_rating = $current_up_rating + 1;
        update_post_meta( $id, 'qr_post_rating_up', $current_up_rating );
    }
    
    if ( $mode == 'down' ) {
        $current_down_rating = $current_down_rating + 1;
        update_post_meta( $id, 'qr_post_rating_down', ( $current_down_rating ) );
    }
    
    return esc_attr( $title ) . ' - Up:' . $current_up_rating . ' - Down:' . $current_down_rating;
}

?>