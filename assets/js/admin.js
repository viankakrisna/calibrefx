var calibrefx_toggles = {
    "content_archive":["#calibrefx-settings\\[content_archive\\]","#calibrefx_content_limit_setting","full"]
};
window['calibrefx'] = {

    update_character_count: function (event) {
        'use strict';
        //
        jQuery('#' + event.target.id + '_chars').html(jQuery(event.target).val().length.toString());
    },
    
    
    toggle_settings: function (event) {
        'use strict';

        // Cache selectors
        var $selector = jQuery(event.data.selector),
            $show_selector = jQuery(event.data.show_selector),
            check_value = event.data.check_value;

        if (
            (jQuery.isArray(check_value) && jQuery.inArray($selector.val(), check_value) > -1) ||
                (check_value === null && $selector.is(':checked')) ||
                (check_value !== null && $selector.val() === check_value)
        ) {
            jQuery($show_selector).slideDown('fast');
        } else {
            jQuery($show_selector).slideUp('fast');
        }
    },
    
    toggle_settings_init: function () {
        'use strict';

        jQuery.each(calibrefx_toggles, function (k, v) {
            // Prepare data
            var data = {selector: v[0], show_selector: v[1], check_value: v[2]};

            // Setup toggle binding
            jQuery('div.calibrefx-metaboxes').on('change.calibrefx.calibrefx_toggle', v[0], data, calibrefx.toggle_settings);

            jQuery(v[0]).trigger('change.calibrefx_toggle', data);
        });
    },
    
    layout_highlighter: function (event) {
        'use strict';

        // Cache class name
        var selected_class = 'selected';

        // Remove class from all labels
        jQuery('input[name="' + jQuery(event.target).attr('name') + '"]').parent('label').removeClass(selected_class);

        // Add class to selected layout
        jQuery(event.target).parent('label').addClass(selected_class);

    },
    
    ready: function () {
        'use strict';
        
        // Initialise settings that can toggle the display of other settings
        calibrefx.toggle_settings_init();

        jQuery('#calibrefx_title, #calibrefx_description').on('keyup.calibrefx.calibrefx_character_count', calibrefx.update_character_count);
        
        // Bind layout highlighter behaviour
        jQuery('.calibrefx-layout-selector').on('change.calibrefx.calibrefx_layout_selector', 'input[type="radio"]', calibrefx.layout_highlighter);
                
        jQuery('#calibrefx-admin-bar').sticky({
            topSpacing:0,
            center:true, 
            className: 'sticky'
        });
    }
};

jQuery(calibrefx.ready);


function calibrefx_confirm( text ) {
    var answer = confirm( text );

    if( answer ) {
        return true;
    }
    else {
        return false;
    }
}