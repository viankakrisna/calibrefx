<?php 
/**
 * CalibreFx Replacer Class
 *
 * Tags Replacer by CalibreFX
 *
 * @author		Ivan Kristianto
 * @version		1.0
 */
class CFX_Replacer {
    
    function __construct( $arr=array() ) {
        
    }
    
    public function set_replace_tag( $arr=array() ) {
        $this->arr=$arr;
        
        return $this;
    }

    private function replaceCallback( $m) {
        return isset( $this->arr[$m[1]]) ? $this->arr[$m[1]] : '';
    }

    function get( $s ) {
        return preg_replace_callback( '/%(.*?)%/',array(&$this,'replaceCallback' ),$s);
    }

}

