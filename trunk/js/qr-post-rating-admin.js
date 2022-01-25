/* POST RATING ADMIN JS */

( function($) {
    
    if ( $( '#qr_post_rating_dashboard_widget_table' ).length > 0 ) { // If table HTML present, otherwise ignore
        
        const saveTableToCSVFile = ( content, filename ) => {
			const a = document.createElement( 'a' );
			const file = new Blob( [content], { type: 'text/csv' } );
			a.href = URL.createObjectURL( file );
			a.download = filename;
			a.click();
			URL.revokeObjectURL( a.href );
		};
		
		// Save table as CSV file
		$( 'body' ).on( 'click', '.save_table_as_csv', function( event ) {
			var csv = '';
			var thead1 = $( '#qr_post_rating_dashboard_widget_table_container thead tr' ).find( 'th:nth-child(1)' ).text();
			var thead2 = $( '#qr_post_rating_dashboard_widget_table_container thead tr' ).find( 'th:nth-child(2)' ).text();
			var thead3 = $( '#qr_post_rating_dashboard_widget_table_container thead tr' ).find( 'th:nth-child(3)' ).text();
			
			csv += thead1 + ',' + thead2 + ',' + thead3 + "\r\n";
			$( '#qr_post_rating_dashboard_widget_table_container tbody tr' ).each(function() {
				var col1 = $( this ).find( 'td:nth-child(1)' ).text();
				var col2 = $( this ).find( 'td:nth-child(2)' ).text();
				var col3 = $( this ).find( 'td:nth-child(3)' ).text();
				csv += col1 + ',' + col2 + ',' + col3 + "\r\n";
			});
			
			saveTableToCSVFile( csv, 'post-ratings.csv' );			
            event.preventDefault();
        });	
        
    }
	
} )( jQuery );