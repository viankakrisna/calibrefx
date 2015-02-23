<?php
function section_ct_menu( $element, $element_key, $column_key, $section_key ){
    
    $data = $element[0];
    if( !is_array( $data ) ) return;
    
    $output = '<div id="element-' . $section_key . '-' . $column_key . '-' . $element_key . '" class="element element-menu navbar navbar-default">';
    
    $output .= '<div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="navbar-brand">MENU</span>                            
                            <span class="menu-toggle-icon">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </span>
                        </button>
                    </div>';

    $output .= '<div class="collapse navbar-collapse" role="navigation">';

    $output .= wp_nav_menu( array( 
                'menu' => $data['menu_id'], 
                'echo' => false,
                'menu_class' => 'nav navbar-nav menu-primary menu',
            ) );
    
    $output .= "</div></div>";
    return $output;
}
add_filter( 'section_content_type_menu', 'section_ct_menu', 10, 4 );