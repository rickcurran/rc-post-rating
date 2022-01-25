<?php
/*
 * RC Post Rating
 * https://qreate.co.uk/projects/#rc-post-rating
 * Rick Curran
 * https://qreate.co.uk
 *
 * Custom Columns
 */

add_filter( 'manage_posts_columns', 'qr_post_rating_filter_posts_columns' );
function qr_post_rating_filter_posts_columns( $columns ) {
    
    // Check which post types are set to display the rating columns
    $options = get_option( 'qr_post_rating_settings' );
    $qr_post_rating_show_admin_columns_for_post_types = array();
    
    if ( isset( $options[ 'qr_post_rating_show_admin_columns_for_post_types' ] ) ) {
        $qr_post_rating_show_admin_columns_for_post_types = maybe_unserialize( $options[ 'qr_post_rating_show_admin_columns_for_post_types' ] );
        
        $post_type = get_post_type();

        if ( is_array($qr_post_rating_show_admin_columns_for_post_types) && in_array( $post_type, $qr_post_rating_show_admin_columns_for_post_types ) ) {
            if ( $post_type->name != 'attachment' ) { // Excluding attachment post types as it unlikely to be used for rating, plus it also doesn't use Admin columns in the same way as other posts
                $columns['qr_post_rating_up'] = __( 'Upvotes', 'qr_post_rating_plugin' );
                $columns['qr_post_rating_down'] = __( 'Downvotes', 'qr_post_rating_plugin' );
            }
        }
    }
    
    return $columns;
}

add_filter( 'manage_pages_columns', 'qr_post_rating_filter_pages_columns' );
function qr_post_rating_filter_pages_columns( $columns ) {
    
    // Check if `page` post type is set to display the rating columns
    $options = get_option( 'qr_post_rating_settings' );
    $qr_post_rating_show_admin_columns_for_post_types = array();
    
    if ( isset( $options[ 'qr_post_rating_show_admin_columns_for_post_types' ] ) ) {
        $qr_post_rating_show_admin_columns_for_post_types = maybe_unserialize( $options[ 'qr_post_rating_show_admin_columns_for_post_types' ] );
        
        if ( is_array($qr_post_rating_show_admin_columns_for_post_types) && in_array( 'page', $qr_post_rating_show_admin_columns_for_post_types ) ) {
            $columns['qr_post_rating_up'] = __( 'Upvotes', 'qr_post_rating_plugin' );
            $columns['qr_post_rating_down'] = __( 'Downvotes', 'qr_post_rating_plugin' );
        }
    }
    
    return $columns;
}

add_action( 'manage_posts_custom_column', function ($column_name, $post_id) {
	if ( $column_name == 'qr_post_rating_up' ) {
        echo get_post_meta( $post_id, 'qr_post_rating_up', true );
	}
	if ( $column_name == 'qr_post_rating_down' ) {
        echo get_post_meta( $post_id, 'qr_post_rating_down', true );
	}
}, 10, 2);

add_action( 'manage_page_posts_custom_column', function ($column_name, $post_id) {
	if ( $column_name == 'qr_post_rating_up' ) {
        echo get_post_meta( $post_id, 'qr_post_rating_up', true );
	}
	if ( $column_name == 'qr_post_rating_down' ) {
        echo get_post_meta( $post_id, 'qr_post_rating_down', true );
	}
}, 10, 2);

?>