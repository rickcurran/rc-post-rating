<?php
/*
 * RC Post Rating
 * https://qreate.co.uk/projects/#rc-post-rating
 * Rick Curran
 * https://qreate.co.uk
 *
 * Custom Columns
 */

add_filter( 'manage_posts_columns', 'rcpr_post_rating_filter_posts_columns' );
function rcpr_post_rating_filter_posts_columns( $columns ) {
    
    // Check which post types are set to display the rating columns
    $options = get_option( 'rcpr_post_rating_settings' );
    $rcpr_post_rating_show_admin_columns_for_post_types = array();
    
    if ( isset( $options[ 'rcpr_post_rating_show_admin_columns_for_post_types' ] ) ) {
        $rcpr_post_rating_show_admin_columns_for_post_types = maybe_unserialize( $options[ 'rcpr_post_rating_show_admin_columns_for_post_types' ] );
        
        $post_type = get_post_type();

        if ( is_array($rcpr_post_rating_show_admin_columns_for_post_types) && in_array( $post_type, $rcpr_post_rating_show_admin_columns_for_post_types ) ) {
            if ( $post_type->name != 'attachment' ) { // Excluding attachment post types as it unlikely to be used for rating, plus it also doesn't use Admin columns in the same way as other posts
                $columns['rcpr_post_rating_up'] = esc_attr__( 'Upvotes', 'rc-post-rating' );
                $columns['rcpr_post_rating_down'] = esc_attr__( 'Downvotes', 'rc-post-rating' );
            }
        }
    }
    
    return $columns;
}

add_filter( 'manage_pages_columns', 'rcpr_post_rating_filter_pages_columns' );
function rcpr_post_rating_filter_pages_columns( $columns ) {
    
    // Check if `page` post type is set to display the rating columns
    $options = get_option( 'rcpr_post_rating_settings' );
    $rcpr_post_rating_show_admin_columns_for_post_types = array();
    
    if ( isset( $options[ 'rcpr_post_rating_show_admin_columns_for_post_types' ] ) ) {
        $rcpr_post_rating_show_admin_columns_for_post_types = maybe_unserialize( $options[ 'rcpr_post_rating_show_admin_columns_for_post_types' ] );
        
        if ( is_array($rcpr_post_rating_show_admin_columns_for_post_types) && in_array( 'page', $rcpr_post_rating_show_admin_columns_for_post_types ) ) {
            $columns['rcpr_post_rating_up'] = esc_attr__( 'Upvotes', 'rc-post-rating' );
            $columns['rcpr_post_rating_down'] = esc_attr__( 'Downvotes', 'rc-post-rating' );
        }
    }
    
    return $columns;
}

add_action( 'manage_posts_custom_column', function ($column_name, $post_id) {
	if ( $column_name == 'rcpr_post_rating_up' ) {
        echo esc_attr( get_post_meta( $post_id, 'rcpr_post_rating_up', true ) );
	}
	if ( $column_name == 'rcpr_post_rating_down' ) {
        echo esc_attr( get_post_meta( $post_id, 'rcpr_post_rating_down', true ) );
	}
}, 10, 2);

add_action( 'manage_page_posts_custom_column', function ($column_name, $post_id) {
	if ( $column_name == 'rcpr_post_rating_up' ) {
        echo esc_attr( get_post_meta( $post_id, 'rcpr_post_rating_up', true ) );
	}
	if ( $column_name == 'rcpr_post_rating_down' ) {
        echo esc_attr( get_post_meta( $post_id, 'rcpr_post_rating_down', true ) );
	}
}, 10, 2);

?>