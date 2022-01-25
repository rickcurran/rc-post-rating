<?php
/*
 * RC Post Rating
 * https://qreate.co.uk/projects/#rc-post-rating
 * Rick Curran
 * https://qreate.co.uk
 *
 * Statistics Dashboard Widget
 */

// GET RATING VALUES FROM DATABASE AND ADD TO DASHBOARD WIDGET
function qr_post_rating_dashboard_widget() {
    // Check if widget is enabled
    $options = get_option( 'qr_post_rating_settings' );
    if ( $options[ 'qr_post_rating_dashboard_widget_status' ] == 'enabled' ) {
    
        if ( current_user_can( 'administrator' ) ) {
            wp_add_dashboard_widget(
                'qr_post_rating_dashboard_widget',
                __( 'Post Rating Statistics', 'qr_post_rating_plugin' ),
                'qr_post_rating_dashboard_widget_render',
                null,
                null,
                'normal',
                'high'
            ); 
        }
        
	}
}
add_action( 'wp_dashboard_setup', 'qr_post_rating_dashboard_widget' );
 

function qr_post_rating_dashboard_widget_render() {
	
	$i = 0;
	echo '<div id="qr_post_rating_dashboard_widget_table_container">';
	echo '<table id="qr_post_rating_dashboard_widget_table" style="width: 100%; border-collapse: collapse; font-family: Helvetica, sans-serif;">';
	echo '<thead>';
	echo '<tr>';
	echo '<th style="text-align:left;">' . __( 'Page/Post name', 'qr_post_rating_plugin' ) . '</th>';
	echo '<th style="text-align:center;">' . __( 'Upvotes', 'qr_post_rating_plugin' ) . '</th>';
	echo '<th style="text-align:center;">' . __( 'Downvotes', 'qr_post_rating_plugin' ) . '</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody style="border-bottom: 1px solid #eee;">';
    
    $args = array(
        'post_type'      => array( 'post','page' ),
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_query' => array(
            'relation' => 'OR',
            'up' => array(
                'key'     => 'qr_post_rating_up',
                'compare' => 'EXISTS',
            ),
            'down' => array(
                'key'     => 'qr_post_rating_down',
                'compare' => 'EXISTS',
            ),
        ),
        'orderby' => array( 'title' => 'ASC' ),
    );
    
    $qr_post_rating_query = new WP_Query( $args );
    if ( $qr_post_rating_query->have_posts() ) {
        while ( $qr_post_rating_query->have_posts() ) {
            $qr_post_rating_query->the_post();
            
            $title = wp_kses_post( get_the_title( $qr_post_rating_query->post->ID ) );
            $up = get_post_meta( $qr_post_rating_query->post->ID, 'qr_post_rating_up', true );
            $down = get_post_meta( $qr_post_rating_query->post->ID, 'qr_post_rating_down', true );
                
            $rowcolour = $i % 2 === 0 ? 'background-color: #f7f7f7;' : 'background-color: #eee;';
			echo '<tr style="border-left: 1px solid #eee; border-right: 1px solid #eee; ' . $rowcolour . '"><td style="padding:3px;"><a href="' . get_permalink( $qr_post_rating_query->post->ID ) . '" target="_blank">' . $title . '</a></td><td style="padding:3px;text-align:center;">' . $up . '</td><td style="padding:3px;text-align:center;">' . $down . '</td></tr>';
            $i++;
        }
    } else {
        // no posts found
    }
    wp_reset_postdata();    
    
	echo '</tbody>';
	echo '</table>';
	echo '</div>';
	
	echo '<table style="width: 100%; border-collapse: collapse;">';
	echo '<tbody>';
	echo '<tr>';
	echo '<td style="padding:3px;"><button class="button save_table_as_csv" style="margin-top: 1rem;">' . __( 'Save as CSV file', 'qr_post_rating_plugin' ) . '</button></td>';
	echo '</tr>';
	echo '</tbody>';
	echo '</table>';
}

?>