<?php

$whitelisted_func = array(
	// 'vp_dep_is_autoresponder',
	'vp_dep_is_image',
	'vp_dep_is_mailventure',
    'vp_dep_is_not_mailventure',
	'vp_dep_is_google_map',
	'vp_dep_is_heading',
    'vp_dep_is_html_editor',
    'vp_dep_is_left',
    'vp_dep_is_raw_html',
    'vp_dep_is_slider',
    'vp_dep_is_slider_revolution',
    'vp_dep_custom',
);

foreach( $whitelisted_func as $include ){
    VP_Security::instance()->whitelist_function( $include );
}

// Whitelist Functions

function vp_dep_custom($value, $target_field = ''){
   
    switch ( $target_field ) {
        //Mailventure
        case 'autoresponder':
            if( $value === 'autoresponder' ) return true;
            break;
        case 'api_url':
            if( $value === 'mailventure' ) return true;
            break;
        case 'api_key':
            if( $value === 'mailventure' ) return true;
            break;
        case 'campaign_name':
            if( $value === 'mailventure' ) return true;
            break;
        case 'form_id':
            if( $value === 'mailventure' ) return true;
            break;
        case 'form_code':
            if( $value !== 'mailventure' ) return true;
            break;

        //Formidable
        case 'formidable':
            if( $value === 'formidable' ) return true;
            break;

        //Google Map
        case 'google_map':
            if( $value === 'google_map' ) return true;
            break;

        //Heading
        case 'heading':
            if( $value === 'heading' ) return true;
            break;
        case 'heading_icon':
            if( $value === 'left' ) return true;
            break;

        //Image
        case 'image':
            if( $value === 'image' ) return true;
            break;

        //Html Editor
        case 'html_editor':
            if( $value === 'html_editor' ) return true;
            break;

        //Html Editor
        case 'menu':
            if( $value === 'menu' ) return true;
            break;

        //Post Archive
        case 'archive':
            if( $value === 'archive' ) return true;
            break;
        case 'read_more':
            if( $value === 'list' ) return true;
            break;
        case 'excerpt_length':
            if( $value === 'list' ) return true;
            break;
        case 'columns_per_row':
            if( $value === 'grid' ) return true;
            break;

        //Html Editor
        case 'raw_html_group':
            if( $value === 'raw_html' ) return true;
            break;

        //Simple Text
        case 'simple_text':
            if( $value === 'simple_text' ) return true;
            break;

        //Simple Text
        case 'slider':
            if( $value === 'slider' ) return true;
            break;

        //Simple Text
        case 'slider_revolution':
            if( $value === 'slider_revolution' ) return true;
            break;
    }

    return false;
}

function vp_dep_is_autoresponder( $value ){
    if( $value === 'autoresponder' ) return true;
    return false;
}

function vp_dep_is_image( $value ){
    if( $value === 'image' ) return true;
    return false;
}

function vp_dep_is_google_map( $value ){
    if( $value === 'google_map' ) return true;
    return false;
}
function vp_dep_is_mailventure( $value ){
    if( $value === 'mailventure' ) return true;
    return false;
}
function vp_dep_is_not_mailventure( $value ){
    if( $value !== 'mailventure' ) return true;
    return false;
}

function vp_dep_is_heading( $value ){
    if( $value === 'heading' ) return true;
    return false;
}
function vp_dep_is_html_editor( $value ){
    if( $value === 'html_editor' ) return true;
    return false;
}

function vp_dep_is_left( $value ){
    if( $value === 'left' ) return true;
    return false;
}

function vp_dep_is_raw_html( $value ){
    if( $value === 'raw_html' ) return true;
    return false;
}
function vp_dep_is_slider( $value ){
    if( $value === 'slider' ) return true;
    return false;
}
function vp_dep_is_slider_revolution($value){
    if($value === 'slider_revolution') return true;
    return false;
}