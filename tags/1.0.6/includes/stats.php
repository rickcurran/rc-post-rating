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
function rcpr_post_rating_dashboard_widget() {
    // Check if widget is enabled
    $options = get_option( 'rcpr_post_rating_settings' );
    if ( $options[ 'rcpr_post_rating_dashboard_widget_status' ] == 'enabled' ) {
    
        if ( current_user_can( 'administrator' ) ) {
            wp_add_dashboard_widget(
                'rcpr_post_rating_dashboard_widget',
                __( 'Post Rating Statistics', 'rc-post-rating' ),
                'rcpr_post_rating_dashboard_widget_render',
                null,
                null,
                'normal',
                'high'
            ); 
        }
        
	}
}
add_action( 'wp_dashboard_setup', 'rcpr_post_rating_dashboard_widget' );
 

function rcpr_post_rating_dashboard_widget_render() {
	
	$i = 0;
	echo '<div id="rcpr_post_rating_dashboard_widget_table_container">';
	echo '<table id="rcpr_post_rating_dashboard_widget_table" style="width: 100%; border-collapse: collapse; font-family: Helvetica, sans-serif;">';
	echo '<thead>';
	echo '<tr>';
	echo '<th style="text-align:left;">' . esc_attr__( 'Page/Post name', 'rc-post-rating' ) . '</th>';
	echo '<th style="text-align:center;">' . esc_attr__( 'Upvotes', 'rc-post-rating' ) . '</th>';
	echo '<th style="text-align:center;">' . esc_attr__( 'Downvotes', 'rc-post-rating' ) . '</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody style="border-bottom: 1px solid #eee;">';
    
    $args = array(
        'post_type'      => 'any',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_query' => array(
            'relation' => 'OR',
            'up' => array(
                'key'     => 'rcpr_post_rating_up',
                'compare' => 'EXISTS',
            ),
            'down' => array(
                'key'     => 'rcpr_post_rating_down',
                'compare' => 'EXISTS',
            ),
        ),
        'orderby' => array( 'title' => 'ASC' ),
    );
    
    $rcpr_post_rating_query = new WP_Query( $args );
    if ( $rcpr_post_rating_query->have_posts() ) {
        while ( $rcpr_post_rating_query->have_posts() ) {
            $rcpr_post_rating_query->the_post();
            
            $title = sanitize_text_field( strip_tags( get_the_title( $rcpr_post_rating_query->post->ID ) ) );
            $up = sanitize_text_field( strip_tags( get_post_meta( $rcpr_post_rating_query->post->ID, 'rcpr_post_rating_up', true ) ) );
            $down = sanitize_text_field( strip_tags( get_post_meta( $rcpr_post_rating_query->post->ID, 'rcpr_post_rating_down', true ) ) );
                
            $rowcolour = $i % 2 === 0 ? 'background-color: #f7f7f7;' : 'background-color: #eee;';
			echo '<tr style="border-left: 1px solid #eee; border-right: 1px solid #eee; ' . esc_attr( $rowcolour ) . '"><td style="padding:3px;"><a href="' . get_permalink( $rcpr_post_rating_query->post->ID ) . '" target="_blank">' . esc_attr( $title ) . '</a></td><td style="padding:3px;text-align:center;">' . esc_attr( $up ) . '</td><td style="padding:3px;text-align:center;">' . esc_attr( $down ) . '</td></tr>';
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
	echo '<td style="padding:3px;"><button class="button save_table_as_csv" style="margin-top: 1rem;">' . esc_attr__( 'Save as CSV file', 'rc-post-rating' ) . '</button></td>';
	echo '</tr>';
	echo '</tbody>';
	echo '</table>';
}

?>