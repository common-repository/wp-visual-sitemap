jQuery( document ).ready( function($) {
    
	// Update icon
	$( '.iconpicker-item' ).on( 'click', function() {
		
		var chosen_icon =  $( this ).children( 'i' ).attr( 'class' );

		$( '#wpvs_fa_chosen_icon' ).attr( 'class', chosen_icon );
		$( '#wpvs_fa_chosen_icon' ).hide().fadeIn();

	});

	// Initiate the colorpicker
    $( '.wpvs_icon_background_colour, .wpvs_text_colour, .wpvs_hover_icon_background_colour, .wpvs_hover_text_colour, .wpvs_line_colour' ).wpColorPicker();


    // Update preview styles, when user moves mouse over the color picker

    // Background colour
    $( '.wpvs_icon_background_colour' ).parent( '.wp-picker-input-wrap') .siblings( '.wp-picker-holder' ).mousemove( function() {
    	
    	var new_colour = $( '.wpvs_icon_background_colour' ).val();

    	$( 'ul.wpvs_wrapper li > a' ).css( 'background-color' , new_colour );

        $( 'body' ).addClass( 'changing_background' );

    });

    $( '.wpvs_icon_background_colour' ).siblings( '.wp-picker-default' ).on( 'click' , function() {

        var new_colour = $( '.wpvs_icon_background_colour' ).val();

        $( 'ul.wpvs_wrapper li > a' ).css( 'background-color' , new_colour );

        $( 'body' ).addClass( 'changing_background' );
    
    });

    // Text colour
    $( '.wpvs_text_colour' ).parent( '.wp-picker-input-wrap' ).siblings( '.wp-picker-holder' ).mousemove( function() {
        
        var new_colour = $( '.wpvs_text_colour' ).val();

        $( 'ul.wpvs_wrapper li > a' ).css( 'color' , new_colour );

        $( 'body' ).addClass( 'changing_background' );

    });

    $( '.wpvs_text_colour' ).siblings( '.wp-picker-default' ).on( 'click' , function() {

        var new_colour = $( '.wpvs_text_colour' ).val();

        $( 'ul.wpvs_wrapper li > a' ).css( 'color' , new_colour );

        $( 'body' ).addClass( 'changing_background' );
    
    });

    $( '.wpvs_text_colour, .wpvs_icon_background_colour' ).parent( '.wp-picker-input-wrap' ).siblings( '.wp-picker-holder' ).mouseout( function() {

        $( 'body' ).removeClass( 'changing_background' );

    });

    // Hover background and text colours
    $( '.wpvs_hover_icon_background_colour, .wpvs_hover_text_colour' ).parent( '.wp-picker-input-wrap' ).siblings( '.wp-picker-holder' ).mousemove( function() {
    	
    	$( 'ul.wpvs_wrapper li > a' ).hover(

    		// handlerIn
    		function() {		
	    		var background_colour = $( '.wpvs_hover_icon_background_colour' ).val();
	    		var text_colour = $( '.wpvs_hover_text_colour' ).val();
	    		$( this ).css({
	    			'color' : text_colour,
	    			'background-color' : background_colour
	    		});
    		} ,

    		// handlerOut
    		function() {
    		
	    		var background_colour = $( '.wpvs_icon_background_colour' ).val();
	    		var text_colour = $( '.wpvs_text_colour' ).val();
	    		$( this ).css({
	    			'color' : text_colour,
	    			'background-color' : background_colour
	    		});

    		}

		);

	});

	// Line colour
    $( '.wpvs_line_colour' ).parent( '.wp-picker-input-wrap' ).siblings( '.wp-picker-holder' ).mousemove( function() {
    	
    	var new_colour = $( '.wpvs_line_colour' ).val();

    	$( 'ul.wpvs_wrapper li > a, ul.wpvs_wrapper > li ul li' ).css( 'border-color' , new_colour );

    });

    // Font size colour
    $( '.wpvs_font_size' ).change( function() {
    	
    	var new_text_size = $( '.wpvs_font_size' ).val();

    	$( 'ul.wpvs_wrapper li > a' ).css( 'font-size' , new_text_size );

    });

    // Hide icons if not selected
    if ( $( '.wpvs_use_icons:checked' ).length < 1 ) {
        $( '.wpvs_menu_icon' ).hide();
        $( '.wpvs_preview_wrapper ul.wpvs_wrapper li > a span' ).addClass( 'no_icons' );
    }

    $( '.wpvs_use_icons' ).change( function() {
    	
    	$( '.wpvs_menu_icon' ).toggle();
    	$( '.wpvs_preview_wrapper ul.wpvs_wrapper li > a span' ).toggleClass( 'no_icons' );

    });

});