var calibrefx_toggles = {
    "content_archive":["#calibrefx-settings\\[content_archive\\]",".calibrefx_content_limit_setting","full"],
    "layout_type":["#calibrefx-settings\\[layout_type\\]",".calibrefx_layout_width","static"],
    "email_protocol":["#calibrefx-settings\\[email_protocol\\]","#email_setting_box_content","smtp"]
};

window['calibrefx'] = {
    update_character_count: function (event) {
        'use strict';
        //
        jQuery( '#' + event.target.id + '_chars' ).html(jQuery(event.target).val().length.toString() );
    },
    
    toggle_settings: function (event) {
        'use strict';

        // Cache selectors
        var $selector = jQuery(event.data.selector),
        $show_selector = jQuery(event.data.show_selector),
        check_value = event.data.check_value;
        
        if (
            (jQuery.isArray(check_value) && jQuery.inArray( $selector.val(), check_value) > -1) ||
            (check_value === null && $selector.is( ':checked' ) ) ||
            (check_value !== null && $selector.val() === check_value)
            ) {
            jQuery( $show_selector).slideDown( 'fast' );
        } else {
            jQuery( $show_selector).slideUp( 'fast' );
        }
    },
    
    toggle_settings_init: function () {
        'use strict';

        jQuery.each(calibrefx_toggles, function (k, v) {
            // Prepare data
            var data = {
                selector: v[0], 
                show_selector: v[1], 
                check_value: v[2]
                };
            
            // Setup toggle binding
            jQuery( 'div.calibrefx-metaboxes' ).on( 'change.calibrefx.calibrefx_toggle', v[0], data, calibrefx.toggle_settings);

            jQuery(v[0]).trigger( 'change.calibrefx_toggle', data);
        });
    },
    
    layout_highlighter: function (event) {
        'use strict';

        // Cache class name
        var selected_class = 'selected';

        // Remove class from all labels
        jQuery( 'input[name="' + jQuery(event.target).attr( 'name' ) + '"]' ).parent( 'label' ).removeClass(selected_class);

        // Add class to selected layout
        jQuery(event.target).parent( 'label' ).addClass(selected_class);

    },
    
    ready: function () {
        'use strict';
        
        // Initialise settings that can toggle the display of other settings
        calibrefx.toggle_settings_init();

        jQuery( '#calibrefx_title, #calibrefx_description' ).on( 'keyup.calibrefx.calibrefx_character_count', calibrefx.update_character_count);
        
        // Bind layout highlighter behaviour
        jQuery( '.calibrefx-layout-selector' ).on( 'change.calibrefx.calibrefx_layout_selector', 'input[type="radio"]', calibrefx.layout_highlighter);
                
        jQuery( '#calibrefx-admin-bar' ).sticky({
            topSpacing: 0,
           
            className: 'sticky'
        });
    }
};

jQuery(calibrefx.ready);

jQuery(document).ready(function( $) {
	$( 'input.calibrefx-settings-checkbox' ).click(function() {
		var id = $(this).attr( 'target' );
		
		if( $(this).is( ':checked' ) ) {
			$( '#' + id).val( '1' );
		}else{
			$( '#' + id).val( '0' );
		}
	});

    $( '.show_advanced' ).live( 'click', function() {
        var parent = $(this).parents( '.widget' );

        if( $(this).is( ':checked' ) ) {
            parent.find( '.advanced-widget-options' ).slideDown();
        }else{
            parent.find( '.advanced-widget-options' ).slideUp();
        }
    });

    var imageFrame;
    $( '.upload_image_button' ).click( function( event ) {
        event.preventDefault();
        
        var options, attachment;
        
        $self = $( event.target );
        $div = $self.parents( 'div.option-item' );
        
        // if the frame already exists, open it
        if ( imageFrame ) {
            imageFrame.open();
            return;
        }
        
        // set our settings
        imageFrame = wp.media({
            title: 'Choose Image',
            multiple: false,
            library: {
                type: 'image'
            },
            button: {
                text: 'Use This Image'
            }
        });
        
        // set up our select handler
        imageFrame.on( 'select', function() {
            selection = imageFrame.state().get( 'selection' );
            
            if ( ! selection )
            return;
            
            var i = 0;
            // loop through the selected files
            selection.each( function( attachment ) {
                var src = attachment.attributes.sizes.full.url;
                var id = attachment.id;
                
                var img = $( '<img>' );
                img.attr( 'src', src );

                $div.find( '.preview_image' ).html( img );
                $div.find( '.image_id' ).val( id );
                $div.find( '.form-control' ).val( src ); i++;
            } );
        });
        
        // open the frame
        imageFrame.open();
    });

    $( '.image_reset_button' ).click( function(){
        $div = $( this ).parents( 'div.option-item' );

        $div.find( '.preview_image' ).html( '' );
        $div.find( '.image_id' ).val( '' );
        $div.find( '.form-control' ).val( '' );
    } );

    $('body').on('click','.calibrefx-sc-generator',function(){
        //Fire magnific popup
        $.magnificPopup.open({
                mainClass: 'mfp-zoom-in',
                items: {
                    src: '#calibrefx-sc-generator'
                },
                type: 'inline',
                removalDelay: 500
        }, 0);
    }); 
});

function calibrefx_confirm( text ) {
    var answer = confirm( text );

    if( answer ) {
        return true;
    } else {
        return false;
    }
}

function tos_bind_events() {
    (function( $) {
        $( '.button-ajax' ).click( function() {
            var button = this;
            $.post( ajaxurl, {
                'action': $(button).attr( 'data-action' ),
                '_ajax_nonce': $(button).attr( 'data-nonce' ),
                'param': $(button).attr( 'data-param' ),
                'name': $( '#name' ).val,
                'url': $( '#url' ).val,
                'info': $( '#info' ).val,
            })
            .success( function( result ) {
                if ( '1' === result ) {
                    // $( button )
                    //     .html( a8c_developer_i18n.installed )
                    //     .nextAll( '.a8c-developer-action-result' )
                    //     .remove();

                    $(button).unbind( 'click' ).prop( 'disabled', true);
                } else {
                    alert( result );

                    // $( button )
                    //     .html( a8c_developer_i18n.ERROR )
                    //     .nextAll( '.a8c-developer-action-result' )
                    //     .remove();

                    $( button ).after( '<span class="a8c-developer-action-result error">' + result + '</span>' );
                }
            })
            .error( function( response ) {
                // $( button )
                //     .html( a8c_developer_i18n.ERROR )
                //     .nextAll( '.a8c-developer-action-result' )
                //     .remove();

                $( button ).after( '<span class="a8c-developer-action-result error">' + response.statusText + ': ' + response.responseText + '</span>' );
            });

            return false;
        }); 
    })(jQuery);
}