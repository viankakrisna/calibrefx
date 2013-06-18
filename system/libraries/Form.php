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
    function open($id, $action, $method='post') {
        $this->form_open = '<form action="'.$action.'" method="'.$method.'" id="'.$id.'" class="form-horizontal">';
        return $this;
    }

    /**
     * Create a label field
     */
    function label($id, $value = "") {
        return '<label for="' . $id . '">' . $value . '</label>';
    }

    /**
     * Create a hidden input field
     */
    function hidden($id, $value = "", $class = "", $attr = "") {
        return '<input class="hidden ' . $class . '" type="hidden" id="' . $id . '" name="' . $id . '" value="' . $value . '" ' . $attr . ' />';
    }

    /**
     * Create a Checkbox input field
     */
    function checkbox($id, $value = "", $checked = "", $text = "") {
        $id2 = str_replace(array('[', ']'), '', $id);
        return '<input type="checkbox" id="' . $id . '" name="' . $id . '" value="' . $value . '"' . checked($value, $checked, false) . ' class="' . $id2 . '" />' . $text;
    }

    function mass_checkboxes($id, $array_data = array(), $checked = array(), $maxrow = 15) {
        $output = "";
        $totalcol = ceil(count($array_data) / $maxrow);

        for ($col = 0; $col < $totalcol; $col++) {
            $output .= '<div class="divider">';
            for ($i = ($col * $maxrow); $i < ($col + 1) * $maxrow; $i++) {
                if (($i + 1) > count($array_data))
                    break;
                $data = $array_data[$i];
                $output .= $this->checkbox($id, $data['id'], $checked[$data['id']], $data['name']) . '<br/>';
            }
            $output .= '</div>';
        }

        return $output;
    }

    /**
     * Create a Checkbox input field
     */
    function radio($id, $value = "", $checked = "", $text = "") {
        return '<input type="radio" id="' . $id . '" name="' . $id . '" value="' . $value . '"' . checked($value, $checked, false) . '/>' . $text;
    }

    /**
     * Create a Text input field
     */
    function textinput($id, $value = "", $readonly = "", $class = "", $attr = "") {
		return '<input class="text '.$class.'" type="text" id="' . $id . '" name="' . $id . '" size="30" value="' . stripslashes($value) . '" ' . $attr . ' ' . $readonly . '/>';
    }
	
	/**
     * Create a Text input field
     */
    function password($id, $value = "", $readonly = "", $class = "", $attr = "") {
		return '<input class="text ' . $class . '" type="password" id="' . $id . '" name="' . $id . '" size="30" value="' . stripslashes($value) . '" ' . $attr . ' ' . $readonly . '/>';
    }

    /**
     * Create a Text title
     */
    function title($text, $class = "") {
        return '<h2 class="' . $class . '">' . $text . '</h2>';
    }

    /**
     * Create a Text area field
     */
    function textarea($id, $value = "", $disabled = "", $class = "", $attr = "") {
		if($disabled){
			return '<textarea class="textarea ' . $class . '" id="' . $id . '" rows="6" cols="70" name="' . $id . '" disabled="' . $disabled. '" ' . $attr . '>' . stripslashes($value) . '</textarea>';
		}else{
			return '<textarea class="textarea ' . $class . '" id="' . $id . '" rows="6" cols="70" name="' . $id . '" ' . $attr . '>' . stripslashes($value) . '</textarea>';
		}
    }
	
	function texteditor($id, $content){
		ob_start(); //Start buffering
		the_editor($content, $id, "", false, 2, false); //print the result
		$output = ob_get_contents(); //get the result from buffer
		ob_end_clean(); //close buffer
	   
	   return $output;
	}

    /**
     * Create a dropdown field
     */
    function select($id, $options = "", $value = "", $multiple = false, $class = "", $attr = "") {
        $output = '<select class="select ' . $class . '" name="' . $id . '" id="' . $id . '" ' . $attr . '>';
        foreach ($options as $val => $name) {
            $sel = '';
            if ($value == $val)
                $sel = ' selected="selected"';
            if ($name == '')
                $name = $val;
            $output .= '<option value="' . $val . '"' . $sel . '>' . stripslashes($name) . '</option>';
        }
        $output .= '</select>';
        return $output;
    }

    /**
     * Create a potbox widget
     */
    function postbox($id, $title, $content) {
        echo <<<end
		<div id="{$id}" class="postbox">
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3 class="hndle"><span>{$title}</span></h3>
			<div class="inside">
				{$content}
			</div>
		</div>
end;
    }

    function postbox_nopadding($id, $title, $content) {
        echo <<<end
		<div id="{$id}" class="postbox">
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3 class="hndle"><span>{$title}</span></h3>
			<div class="inside nopadding">
				{$content}
			</div>
		</div>
end;
    }

    /**
     * Create a legend text
     */
    function legend($text) {
        return '<legend>'.stripslashes($text).'</legend>';
    }

    function build($rows) {
        $this->form_fields = $this->form_table($rows);
        $output = $this->form_open . $this->form_fields  . $this->form_close;
        return $output;
    }
    
    /**
     * The upload form
     *
     * @param array $args 'action' URL for form action, 'post_id' ID for preset parent ID
     */
    function upload_form($id) {
        $output = '<p><input type="file" name="'.$id.'" id="'.$id.'" size="50" /></p>';
    
        return $output;
    }

    /**
     * Create a save button
     */
    function save_button($text = '') {
        if ($text == '')
            $text = "Update Options &raquo;"; 
        
        return '<button type="submit" class="btn">' . $text . '</button>';
    }

    /**
     * Create a form table from an array of rows
     */
    function form_table($rows) {

        $content = '';
        $i = 1;
        foreach ($rows as $row) {
            $class = '';
            // if ($i > 1) {
            //     $class .= 'bws_row';
            // }
            // if ($i % 2 == 0) {
            //     $class .= ' even';
            // }

            if (!empty($row['label'])) {

                $content .= '<div class="control-group">';

                if (isset($row['id']) && $row['id'] != '')
                    $content .= '<label class="control-label" for="' . $row['id'] . '">' . $row['label'] . ':</label>';
                else
                    $content .= '<label class="control-label">' . $row['label'] . ':</label>';

                $content .= '   <div class="controls">';
                $content .= $row['content'];
                if (isset($row['desc']) && !empty($row['desc'])) {
                    $content .= '       <span class="help-block">' . $row['desc'] . '</span>';
                }
                $content .= '   </div>';

                $content .= '</div>';
            } else {
                if(isset($row['input_wrapper']) && $row['input_wrapper'] == 'no'){
                    $content .= $row['content'];
                }else{
                    $content .= '<div class="control-group">';                

                    $content .= '   <div class="controls">';
                    $content .= $row['content'];                
                    $content .= '   </div>';

                    $content .= '</div>';
                }   
            }

            $i++;
        }
        
        return $content;
    }

    function news($title = '', $feedurl = '', $limit=10) {
        include_once(ABSPATH . WPINC . '/feed.php');
        if (empty($feedurl)) {
            $feedurl = 'http://www.calibrefx.com/feed';
        }
		
		if(empty($title)){
			$title = 'Latest from CalibreFx.com';
		}
		
        $rss = fetch_feed($feedurl);
        $rss_items = $rss->get_items(0, $rss->get_item_quantity($limit));
        $content = '<ul>';
        if (!$rss_items) {
            $content .= '<li>no news items, feed might be broken...</li>';
        } else {
            foreach ($rss_items as $item) {
                $content .= '<li>';
                $content .= '<a class="rssitems" href="' . esc_url($item->get_permalink(), $protocolls = null, 'display') . '">' . htmlentities($item->get_title()) . '</a> ';
                $content .= '</li>';
            }
        }
        $content .= '<li class="rss"><a href="' . $feedurl . '">Subscribe with RSS</a></li>';
        $content .= '</ul>';
		
		
        $this->postbox('latestnews', $title, $content);
    }

    function text_limit($text, $limit, $finish = ' [&hellip;]') {
        if (strlen($text) > $limit) {
            $text = substr($text, 0, $limit);
            $text = substr($text, 0, - ( strlen(strrchr($text, ' ')) ));
            $text .= $finish;
        }
        return $text;
    }
}