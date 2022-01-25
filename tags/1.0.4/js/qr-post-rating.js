/* POST RATING JS */

( function($) {

	if ( $( '.post-rating-tool' ).length > 0 ) { // If `post-rating-tool` HTML present, otherwise ignore
		
        
        $( 'body' ).on( 'click', '.post-rating-tool a', function( event ) {
            // ID from data attribute
            var id = $( this ).parent().attr( 'data-post-rating-id' );
            // Initial mode set to empty
            var mode = '';
            
            // If `id` exists then the rating process can begin...
            if ( id != '' ) {
                if ( $( this ).hasClass( 'rating-up' ) ) {
                    mode = 'up';
                } else if ( $( this ).hasClass( 'rating-down' ) ) {
                    mode = 'down';
                }
                
                if ( mode != '' && qr_post_check_if_user_has_rated( id, mode ) ) {
                    qr_post_rating_update( mode, id );
                    $( '.post-rating-tool a' ).removeClass( 'active' ).addClass( 'disabled' );
                    $( '.post-rating-tool .rating-' + mode ).addClass( 'active' ).removeClass( 'disabled' );
                }
            }

        });
        
        // Check for existence of previous ratings in local storage on page load
        // Get current page's ID from the data-attribute of the rating tool containing element
        var qr_post_rating_current_post_id = $( '.post-rating-tool' ).attr( 'data-post-rating-id' );
        //console.log( 'qr_post_rating_current_post_id:' + qr_post_rating_current_post_id );
        if ( localStorage.getItem( 'data-post-rating-id-' + qr_post_rating_current_post_id ) ) {
            //console.log( 'localstorage item exists:' );
            var id = localStorage.getItem( 'data-post-rating-id-' + qr_post_rating_current_post_id );
            var mode = localStorage.getItem( 'data-post-rating-mode-' + qr_post_rating_current_post_id );
            //console.log( 'id:' + id );
            //console.log( 'mode:' + mode );
            if ( mode == 'up' ) {
                $( '.post-rating-tool .rating-up' ).addClass( 'active' ).removeClass( 'disabled' );
                $( '.post-rating-tool .rating-down' ).removeClass( 'active' ).addClass( 'disabled' );
            } else if ( mode == 'down' ) {
                $( '.post-rating-tool .rating-up' ).removeClass( 'active' ).addClass( 'disabled' );
                $( '.post-rating-tool .rating-down' ).addClass( 'active' ).removeClass( 'disabled' );
            }
        }
            
        // Check if user has rated
        function qr_post_check_if_user_has_rated( id, mode ) {
            if ( !localStorage.getItem( 'data-post-rating-id-' + id ) ) {
	
                // Save ID to localstorage
                localStorage.setItem( qr_post_clean_string( 'data-post-rating-id-' + id ), id );
                
                // Save MODE to localstorage
                localStorage.setItem( qr_post_clean_string( 'data-post-rating-mode-' + id ), mode );
                
                return true;
                
            } else {
                return false;
            }
        }
        
        // Update rating via REST API call
        function qr_post_rating_update( mode, id ) {
            // Check parameters are clean first before trying to submit
            if ( ( mode == 'up' || mode == 'down' ) && qr_post_is_numeric( id ) ) {
            
                //console.log( 'Updating via REST API...' );
                jQuery.ajax({
                    url: wpApiSettings.root + 'qr-post-rating/v1/rate/' + mode + '/' + id,
                    method: 'POST',
                    beforeSend: function ( xhr ) {
                        xhr.setRequestHeader( 'X-WP-Nonce', wpApiSettings.nonce );
                    },
                    data: {
                        'mode' : qr_post_clean_string( mode ),
                        'id' : qr_post_clean_string( id )
                    }
                }).done( function ( response ) { // SAVE SUCCESS...
                    //console.log( 'Done Response: ' );
                    //console.log( response );

                }).fail( function( response ) { // SAVE FAILURE...
                    //console.log( 'Submission Failed – Response: ' );
                    //console.log( response );
                    $( '.post-rating-tool a' ).removeClass( 'active' ).removeClass( 'disabled' ); // Clear classes on buttons so that click attempts can be attempted again

                });
                
            } else {
                // parameters invalid
                console.log( 'Sorry, parameters invalid.' );
                $( '.post-rating-tool a' ).removeClass( 'active' ).removeClass( 'disabled' ); // Clear classes on buttons so that click attempts can be attempted again
            }
        }
 
        function qr_post_is_numeric( num ) {  
            return !isNaN( num * 1 );  
        } 
		
        // A little cleanup on any data submitted just as an extra precaution
        function qr_post_clean_string( str ) {
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }
        
	}
	
} )( jQuery );