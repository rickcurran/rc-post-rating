<?php
/*
Plugin Name: RC Post Rating
Plugin URI: https://qreate.co.uk/projects/#rc-post-rating
Description: This plugin adds the ability for users to provide feedback on pages / posts via a up / down rating buttons.
Version: 1.0.4
Author: Rick Curran
Author URI: https://qreate.co.uk
*/

/*
 * SETTINGS
 */
include( 'includes/settings.php' );

/*
 * POST RATING SHORTCODE
 */
include( 'includes/shortcode.php' );

/*
 * ADD CUSTOM COLUMNS TO POST / PAGE LISTINGS
 */
include( 'includes/columns.php' );

/*
 * ADD CUSTOM REST API ENDPOINT
 */
include( 'includes/rest.php' );

/*
 * ADD STATISTICS DASHBOARD WIDGET
 */
include( 'includes/stats.php' );

/*
 * BLOCK EDITOR
 */
include( 'includes/block.php' );

/*
 * JAVASCRIPT
 */
add_action( 'wp_enqueue_scripts', 'qr_post_rating_js' );
function qr_post_rating_js() {
    wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'qr_post_rating', plugin_dir_url( __FILE__ ) . 'js/qr-post-rating.js', array( 'jquery' ), '1.04', true );
    wp_localize_script( 'qr_post_rating', 'wpApiSettings', array( 'root' => esc_url_raw( rest_url() ), 'nonce' => wp_create_nonce( 'wp_rest' ) ) );
}

add_action( 'admin_enqueue_scripts', 'qr_post_rating_admin_js' );
function qr_post_rating_admin_js() {
    wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'qr_post_rating_admin', plugin_dir_url( __FILE__ ) . 'js/qr-post-rating-admin.js', array( 'jquery' ), '1.04', true );
    
    wp_register_style( 'qr_post_rating_admin_css', plugin_dir_url( __FILE__ ) . 'css/qr-post-rating-admin.css', false, '1.0.4' );
    wp_enqueue_style( 'qr_post_rating_admin_css' );
}

/*
 * ADDITIONAL LINKS ON PLUGIN LIST PAGE
 */
add_filter( 'plugin_row_meta', 'qr_post_rating_row_meta', 10, 4 );
function qr_post_rating_row_meta( $links_array, $plugin_file_name, $plugin_data, $status ) {
    
    if ( strpos( $plugin_file_name, basename( __FILE__ ) ) ) {
        if ( ! is_network_admin() ) {
            $links_array[] = '<a href="options-general.php?page=qr_post_rating_settings_screen">' . __( 'Settings', 'qr_post_rating_plugin' ) . '</a>';
        }
        $links_array[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QZEXMAMCYDS3G">' . __( 'Donate', 'qr_post_rating_plugin' ) . '</a>';
    }
    return $links_array;
}

/*
 * REDIRECT TO SETTINGS PAGE ON PLUGIN ACTIVATION
 */
add_action( 'activated_plugin', 'qr_post_rating_activate' );
function qr_post_rating_activate( $plugin ) {
    if ( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url( 'options-general.php?page=qr_post_rating_settings_screen' ) ) );
    }
}

?>