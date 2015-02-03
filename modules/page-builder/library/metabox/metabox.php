<?php

/**
 * Metabox Loader
 */
 
$templates = glob( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . '*.php' );
if( $templates ){
	foreach( $templates as $template ) {
		if ( substr( basename( $include ), 0, 1 ) !== '_' AND 
			 substr(basename( $include ), 0, 5 ) !== 'index' ) {
			new VP_Metabox( $template );
		}
	}
}