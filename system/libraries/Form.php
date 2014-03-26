<?php
/**
 * CalibreFx Lib
 *
 * CalibreFx Plugin Libraries
 *
 * @package		calibrefxlib
 * @author		CalibreFx Dev Team
 * @copyright	Copyright (c) 2012, CalibreWorks. (http://www.calibreworks.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://www.CalibreFx.com
 * @since		Version 1.0
 * @filesource
 */
 
/**
 * Forms Libraries
 *
 * CalibreFx Forms Library
 *
 * @package		calibrefxlib
 * @subpackage	Library
 * @category	Form Library
 * @author		CalibreFx Dev Team
 * @link		http://www.CalibreFx.com
 */
// ------------------------------------------------------------------------

class CFX_Form {

    private $form_open = '';
    private $form_close = '</form>';
    private $form_fields = '';

    function __construct() {}

    /**
     * Open form
     */
    function open($id = "", $action = "", $method = 'post', $enctype = true) {
        if($enctype) $this->form_open = '<form action=" ' . $action . '" method=" ' .$method . '" id="' . $id . '" class="form-horizontal" enctype="multipart/form-data" role="form">';
        else $this->form_open = '<form action="' . $action . '" method="' . $method . '" id="' . $id . '" class="form-horizontal" role="form">';
        return $this;
    }

    /**
     * Create a label field
     */
    function label($id = "", $text = "", $class = "control-label col-sm-2") {
        return '<label for="' . $id . '"' . ($class ? ' class="' . $class . '"' : '') . '>' . $text . '</label>';
    }

    /**
     * Create a hidden input field
     */
    function hidden($id = "", $value = "", $atts = array()) {
        $attr = '';
        foreach($atts as $key => $val){
            $attr .= ' ' . $key . '="' . $val .'"';
        }

        return '<input type="hidden" id="' . $id . '" name="' . $id . '" value="' . $value . '"' . $attr . ' />';
    }

    /**
     * Create a Checkbox input field
     */
    function checkbox($id = "", $value = "", $checked = "", $text = "", $atts = array()) {
        $attr = '';
        foreach($atts as $key => $val){
            $attr .= ' ' . $key . '="' . $val .'"';
        }

        return '<div class="checkbox"><label><input type="checkbox" id="' . $id . '" name="' . $id . '" value="' . $value . '"' . checked( $value, $checked, false ) . $attr . ' />' . $text . '</label></div>';
    }

    function mass_checkboxes($id = "", $array_data = array(), $checked = array(), $maxrow = 20) {
        $output = "";
        $totalcol = ceil(count($array_data) / $maxrow); 

        $data = array();
        for ($col = 0; $col < $totalcol; $col++) {
            $output .= '<div class="divider">';
            for ($i = ($col * $maxrow); $i < ($col + 1) * $maxrow; $i++) {
                if (($i + 1) > count($array_data))
                    break;
                $data = $array_data[$i];
				
				if(array_key_exists($data['id'], $checked)){
					$output .= $this->checkbox( $id, $data['id'], $checked[$data['id']], $data['name'] );
				}else{
					$output .= $this->checkbox( $id, $data['id'], '', $data['name'] );
				}
                
            }
            $output .= '</div>';
        }

        return $output;
    }

    /**
     * Create a Checkbox input field
     */
    function radio($id = "", $value = "", $checked = "", $text = "", $atts = array()) {
        $attr = '';
        foreach($atts as $key => $val){
            $attr .= ' ' . $key . '="' . $val .'"';
        }

        return '<div class="radio"><label for="' . $id . '"><input type="radio" id="' . $id . '" name="' . $name . '" value="' . $value . '"' . checked( $value, $checked, false ) . $attr . '/>' . $text . '</label></div>';
    }

    /**
     * Create a Text input field
     */
    function textinput($id = "", $value = "", $class = "", $atts = array()) {
        $attr = '';
        foreach($atts as $key => $val){
            $attr .= ' ' . $key . '="' . $val .'"';
        }

		return '<input type="text" id="' . $id . '" name="' . $id . '" value="' . stripslashes( $value ) . '" class="form-control' . ( $class ? ' '.$class : '' ) . '"' . $attr . ' />';
    }
	
	/**
     * Create a Text input field
     */
    function password($id = "", $value = "", $class = "", $atts = array()) {
        $attr = '';
        foreach($atts as $key => $val){
            $attr .= ' ' . $key . '="' . $val .'"';
        }

		return '<input type="password" id="' . $id . '" name="' . $id . '" value="' . stripslashes( $value ) . '" class="form-control ' . ( $class ? ' '.$class : '' ) . '"' . $attr . ' />';
    }

    /**
     * Create a Text title
     */
    function title($text = "", $class = "") {
        return '<h2 class="' . $class . '">' . $text . '</h2>';
    }

    /**
     * Create a Text area field
     */
    function textarea($id = "", $value = "", $class = "", $atts = array()) {
		$attr = '';
        foreach($atts as $key => $val){
            $attr .= ' ' . $key . '="' . $val .'"';
        }

		return '<textarea id="' . $id . '" name="' . $id . '" class="form-control ' . ( $class ? ' ' . $class : '' ) . '"' . $attr . '>' . stripslashes( $value ) . '</textarea>';
    }
	
	function texteditor($id = "", $content = ""){
		ob_start(); //Start buffering
		wp_editor( $content, $id, "", false, 2, false ); //print the result
		$output = ob_get_contents(); //get the result from buffer
		ob_end_clean(); //close buffer
	   
	   return $output;
	}

    /**
     * Create a dropdown field
     */
    function select($id = "", $options = array(), $value = "", $class = "", $atts = array()) {
        $attr = '';
        foreach($atts as $key => $val){
            $attr .= ' ' . $key . '="' . $val .'"';
        }

        $output = '<select name="' . $id . '" id="' . $id . '" class="form-control' . ( $class ? ' ' . $class : '' ) . '"' . $attr . '>';
        foreach ($options as $val => $name) {
            $output .= '<option value="' . $val . '"' . selected( $val, $value, false ) . '>' . stripslashes( $name ) . '</option>';
        }

        $output .= '</select>';
        return $output;
    }

    /**
     * Create a legend text
     */
    function legend($text = "") {
        return '<legend>'.stripslashes($text).'</legend>';
    }

    function build($rows = array(), $form_open = TRUE, $form_close = TRUE) {
        $this->form_fields = $this->form_table($rows);

		$output = '';
		if($form_open) $output .= $this->form_open;

        $output .= $this->form_fields;
		if($form_close) $output .= $this->form_close;

        return $output;
    }
    
    /**
     * The upload form
     *
     * @param array $args 'action' URL for form action, 'post_id' ID for preset parent ID
     */
    function upload_form($id = "", $class = "", $atts = array()) {
        $attr = '';
        foreach($atts as $key => $val){
            $attr .= ' ' . $key . '="' . $val .'"';
        }

        $output = '<input type="file" name="' . $id . '" id="' . $id . '" class="form-control' . ( $class ? ' ' . $class : '' ) . '"' . $attr . '/>';
    
        return $output;
    }

    /**
     * Create a save button
     */
    function save_button($id = "", $text = "", $class = "", $atts = array()) {
        $attr = '';
        foreach($atts as $key => $val){
            $attr .= ' ' . $key . '="' . $val .'"';
        }

        if ($text == '')
            $text = "Update Options &raquo;"; 
        
        return '<button type="submit" id="' . $id . '" class="btn' . ( $class ? ' ' . $class : '' ) . '"' . $attr . '>' . $text . '</button>';
    }

    /**
     * Create a button
     */
    function button($id = "", $type = "button", $text = "", $class = "", $atts = array()) {
        $attr = '';
        foreach($atts as $key => $val){
            $attr .= ' ' . $key . '="' . $val .'"';
        }
        
        return '<button type="' . $type . '" id="' . $id . '" class="btn' . ( $class ? ' ' . $class : '' ) . '"' . $attr . '>' . $text . '</button>';
    }

    /**
     * Create a input submit button
     */
    function input_submit_button($id = "", $text = "", $class = "", $atts = array()) {
        $attr = '';
        foreach($atts as $key => $val){
            $attr .= ' ' . $key . '="' . $val .'"';
        }
        
        return '<input type="submit" id="' . $id . '" name="' . $id . '" value="' . $text . '" class="btn' . ( $class ? ' ' . $class : '' ) . '"' . $attr . ' />';
    }

    /**
     * Create a input button
     */
    function input_button($id = "", $type = "button", $text = "", $class = "", $atts = array()) {
        $attr = '';
        foreach($atts as $key => $val){
            $attr .= ' ' . $key . '="' . $val .'"';
        }
        
        return '<input type="'. $type .'" id="' . $id . '" name="' . $id . '" value="' . $text . '" class="btn' . ( $class ? ' ' . $class : '' ) . '"' . $attr . ' />';
    }

    /**
     * Create a form table from an array of rows
     */
    function form_table($rows) {

        $content = '';
        $i = 1;
        foreach ($rows as $row) {
            $class = '';
            if (!empty($row['label'])) {

                $content .= '<div class="form-group">';

                $tooltip = '';
				$tooltip_class = '';
                if(isset($row['tooltip']) && $row['tooltip'] != ''){
                    $tooltip .= ' data-toggle="tooltip" data-original-title="'.stripslashes($row['tooltip']).'" data-placement="right"';
                    $tooltip_class = ' form-tooltip';    
                }

                if(!isset($row['label_column']) && $row['label_column'] == '') $row['label_column'] = 'col-sm-2';

                if (isset($row['id']) && $row['id'] != '')
                    $content .= '<label class="control-label ' . $row['label_column'] . ' ' . $tooltip_class . '" for="' . $row['id'] . '"' . $tooltip . '>' . $row['label'] . ':</label>';
                else
                    $content .= '<label class="control-label ' . $row['label_column'] . ' ' . $tooltip_class . '"' . $tooltip . '>' . $row['label'] . ':</label>';


                if(!isset($row['input_column']) && $row['input_column'] == '') $row['input_column'] = 'col-sm-10';
                $content .= '<div class="' . $row['input_column'] . '">';

                if(isset($row['before_content']) && !empty($row['before_content'])) $content .= $row['before_content'];
                $content .= $row['content'];
                if(isset($row['after_content']) && !empty($row['after_content'])) $content .= $row['after_content'];

                if (isset($row['desc']) && !empty($row['desc'])) {
                    $content .= '<span class="help-block">' . $row['desc'] . '</span>';
                }
                $content .= '</div>';

                $content .= '</div>';
            } else {
                if(isset($row['input_wrapper']) && $row['input_wrapper'] == 'no'){
                    $content .= $row['content'];
                }else{
                    $content .= '<div class="form-group">';                

                    $content .= '<div class="col-sm-12">';
                    $content .= $row['content'];                
                    $content .= '</div>';

                    $content .= '</div>';
                }   
            }

            $i++;
        }
        
        return $content;
    }
}