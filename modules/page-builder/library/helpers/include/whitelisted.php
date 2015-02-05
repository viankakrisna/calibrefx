<?php

$whitelisted_func = array(
	'vp_dep_is_autoresponder',
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
);

foreach( $whitelisted_func as $include ){
    VP_Security::instance()->whitelist_function( $include );
}

// Whitelist Functions

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