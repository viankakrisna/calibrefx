<?php
/**
 * Calibrefx Shortcode Button Class
 */

class CFX_Shortcode {

	/**
	 * Constructor - Initializes
	 */
	public function __construct() {

		add_action( 'media_buttons_context', array( __CLASS__, 'shortcode_button' ) );
		add_action( 'admin_footer', array( __CLASS__, 'content_display' ) );
	}

	public static function shortcode_button(){
		echo "<a data-effect='mfp-zoom-in' class='button calibrefx-sc-generator' href='#calibrefx-sc-generator'><span class='cfxicon-calibrefx'></span>Shortcodes</a>";
	}

	public static function content_display(){
		global $cfx_shortcodes;

		$html_options = null;
		$shortcode_html = '
		<div id="calibrefx-sc-heading" style="display: none;">
			<div id="calibrefx-sc-generator" class="mfp-hide mfp-with-anim">
				<div class="shortcode-content">
					<div id="calibrefx-sc-header">
						<div class="label"><strong>Calibrefx Shortcodes</strong></div>
							<div class="content"><select id="calibrefx-shortcodes" data-placeholder="' . __( 'Choose a shortcode', 'calibrefx' ) .'">
							<option></option>';
		foreach ( $cfx_shortcodes as $shortcode => $options ){

			//Only for header shortcodes type
			if ( false !== strpos( $shortcode,'header' ) ) {
				$shortcode_html .= '<optgroup label="' . $options['title'] . '">';
			}
			else {
				$shortcode_html .= '<option value="' . $shortcode . '">' . $options['title'] . '</option>';
				$html_options .= '<div class="shortcode-options" id="options-' . $shortcode . '" data-name="' . $shortcode . '" data-type="' . $options['type'] . '">';

				if ( ! empty( $options['attr'] ) ){
					foreach ( $options['attr'] as $name => $attr_option ){
						$html_options .= CFX_Shortcode::calibrefx_option_element( $name, $attr_option, $options['type'], $shortcode );
					}
				}
				$html_options .= '</div>';
			}
		}

		$shortcode_html .= '</select></div></div>';
		echo $shortcode_html . $html_options;
		?>
	
		<div id="shortcode-content">
		
			<div class="label"><label id="option-label" for="shortcode-content"><?php echo __( 'Content: ', 'calibrefx' ); ?> </label></div>
			<div class="content"><textarea id="shortcode_content"></textarea></div>
			<div class="hr"></div>
		</div>
	
		<code class="shortcode_storage"><span id="shortcode-storage-o" style=""></span><span id="shortcode-storage-d"></span><span id="shortcode-storage-c" style=""></span></code>
		<a class="button" id="add-shortcode"><i class="fa fa-angle-double-right"></i> <?php echo __( 'Add Shortcode', 'calibrefx' ); ?></a>
		</div></div></div>
	<?php
	}

	public static function calibrefx_option_element( $name, $attr_option, $type, $shortcode ){
		$option_element = null;

		( isset( $attr_option['desc'] ) AND ! empty( $attr_option['desc'] ) ) ? $desc = '<p class="description">' . $attr_option['desc'] . '</p>' : $desc = '';

		if ( isset( $attr_option['half_width'] ) AND 'true' == $attr_option['half_width'] ) { 
			$option_element .= '<div class="column-wrap"> <div class="half_width">'; 
		}
		if ( isset( $attr_option['second_half_width'] ) AND 'true' == $attr_option['second_half_width'] ) { 
			$option_element .= '<div class="second_half_width">'; 
		}

		switch ( $attr_option['type'] ){

			case 'radio':

				$option_element .= '<div class="label"><strong>' . $attr_option['title'] .' : </strong></div><div class="content">';
				foreach ( $attr_option['opt'] as $val => $title ){

					( isset( $attr_option['def'] ) AND ! empty( $attr_option['def'] ) ) ? $def = $attr_option['def'] : $def = '';

					$option_element .= '
				<label for="shortcode-option-' . $shortcode . '-' . $name . '-' . $val . '">' . $title . '</label>
				<input class="attr" type="radio" data-attrname="' . $name . '" name="' . $shortcode . '-' . $name . '" value="' . $val . '" id="shortcode-option-' . $shortcode . '-' . $name . '-' . $val . '"' . ( $val == $def ? ' checked="checked"' : '' ) . '>';
				}

				$option_element .= $desc . '</div>';

			break;

			case 'checkbox':

				$option_element .= '<div class="label"><label for="' . $name . '"><strong>' . $attr_option['title'] . ': </strong></label></div>    <div class="content"> <input type="checkbox" class="' . $name . '" id="' . $name . '" />' . $desc . '</div> ';

			break;

			case 'select':

				$option_element .= '
			<div class="label"><label for="' . $name . '"><strong>' . $attr_option['title'] . ': </strong></label></div>
		
			<div class="content"><select id="' . $name . '">';
				$values = $attr_option['values'];
				foreach ( $values as $value ){
					$option_element .= '<option value="'.$value.'">'.$value.'</option>';
				}
				$option_element .= '</select>' . $desc . '</div>';

			break;

			case 'regular-select':

				if ( $attr_option['title'] == 'Starting Category' ) { $option_element .= '<div class="starting_category">'; }

				$option_element .= '
			<div class="label"><label for="'.$name.'"><strong>'.$attr_option['title'].': </strong></label></div>
		
			<div class="content"><select id="'.$name.'">';
				$values = $attr_option['values'];
				foreach ( $values as $k => $v ){
					$option_element .= '<option value="'.$k.'">'.$v.'</option>';
				}
				$option_element .= '</select>' . $desc . '</div>';

				if ( $attr_option['title'] == 'Starting Category' ) { $option_element .= '</div>'; }

			break;

			case 'multi-select':

				$option_element .= '
			<div class="label"><label for="'.$name.'"><strong>'.$attr_option['title'].': </strong></label></div>
		
			<div class="content"><select multiple="multiple" id="'.$name.'">';
				$values = $attr_option['values'];
				foreach ( $values as $k => $v ){
					$option_element .= '<option value="'.$k.'">'.$v.'</option>';
				}
				$option_element .= '</select>' . $desc . '</div>';

			break;

			case 'icons':
				if ( $attr_option['title'] == 'Icon' ) {
					$first_select = '<div class="label"><label><strong>Font Set: </strong></label></div> <div class="content"><select name="icon-set-select" class="skip-processing"> <option value="icon">Font Awesome</option> <option value="calibrefx-icons">Calibrefx Icons</option> <option value="genericons">Genericons</option> </select></div> <div class="clear no-line"></div>';
				} else {
					$first_select = null;
				}

				$parsed_title = str_replace( ' ','-',$attr_option['title'] );

				$option_element .= $first_select.'
		
			<div class="icon-option '.strtolower( $parsed_title ).'">';
				$values = $attr_option['values'];
				foreach ( $values as $value ){
					$option_element .= '<i class="'.$value.'"></i>';
				}
				$option_element .= $desc . '</div>';

			break;

			case 'custom':

				if ( $name == 'tabs' ){
					$option_element .= '
				<div class="shortcode-dynamic-items" id="options-item" data-name="item">
				
					<div class="label"><label><strong>Background Color: </strong></label></div>
					<div class="content"><input type="text" value="" class="popup-colorpicker-bg" style="width: 70px;" data-default-color=""/></div>
					<div class="clear"></div>
				
					<div class="shortcode-dynamic-item">
						<div class="label"><label><strong>Title: </strong></label></div>
						<div class="content"><input class="shortcode-dynamic-item-input" type="text" name="" value="" /></div>
						<div class="label"><label><strong>Tab Content: </strong></label></div>
						<div class="content"><textarea class="shortcode-dynamic-item-text" type="text" name="" /></textarea></div>
					</div>
				</div>
				<a href="#" class="btn blue remove-list-item">'.__( 'Remove Tab', 'calibrefx' ). '</a> <a href="#" class="btn blue add-list-item">'.__( 'Add Tab', 'calibrefx' ).'</a>';

				}

				if ( $name == 'toggles' ){
					$option_element .= '
			
				<div class="shortcode-dynamic-items" id="options-item" data-name="item">
			
					<div class="label"><label><strong>Turn into accordion</strong>:</label></div>
					<div class="content">
						<input id="shortcode-option-carousel" class="accordion" type="checkbox" name="accordion">
					</div>
					<div class="clear"></div>
					<div class="label"><label><strong>Background Color: </strong></label></div>
					<div class="content"><input type="text" value="" class="popup-colorpicker-bg" style="width: 70px;" data-default-color=""/></div>
					<div class="clear"></div>

					<div class="shortcode-dynamic-item">
						<div class="label"><label><strong>Title: </strong></label></div>
						<div class="content"><input class="shortcode-dynamic-item-input" type="text" name="" value="" /></div>
						<div class="label"><label><strong>Tab Content: </strong></label></div>
						<div class="content"><textarea class="shortcode-dynamic-item-text" type="text" name="" /></textarea></div>
					</div>
				</div>
				<a href="#" class="btn blue remove-list-item">'.__( 'Remove Toggle', 'calibrefx' ). '</a> <a href="#" class="btn blue add-list-item">'.__( 'Add Toggle', 'calibrefx' ).'</a>';

				}

				elseif ( $name == 'bar_graph' ){
					$option_element .= '
				<div class="shortcode-dynamic-items" id="options-item" data-name="item">
					<div class="label"><label><strong>Color: </strong></label></div>
					<div class="content"><input type="text" value="" class="popup-colorpicker-bg" style="width: 70px;" data-default-color=""/></div>
					<div class="clear"></div>
					
					<div class="shortcode-dynamic-item">
						<div class="label"><label><strong>Title: </strong></label></div>
						<div class="content"><input class="shortcode-dynamic-item-input" type="text" name="" value="" /></div>
						<div class="label"><label><strong>Bar Percent: </strong></label></div>
						<div class="content dd-percent"><input class="shortcode-dynamic-item-input percent" data-slider="true"  data-slider-range="1,100" data-slider-step="1" type="text" name=""  value="" /></div><div class="clear no-border"></div>
					</div>
				</div>
				<a href="#" class="btn blue remove-list-item">'.__( 'Remove Bar', 'calibrefx' ). '</a> <a href="#" class="btn blue add-list-item">'.__( 'Add Bar', 'calibrefx' ).'</a>';

				}

				elseif ( $name == 'circular_graph' ){
					$option_element .= '
				<div class="shortcode-dynamic-items" id="options-item" data-name="item">
					<div class="label"><label><strong>Color: </strong></label></div>
					<div class="content"><input type="text" value="" class="popup-colorpicker-bg" style="width: 70px;" data-default-color=""/></div>
					<div class="clear"></div>
					
					<div class="shortcode-dynamic-item">
						<div class="label"><label><strong>Title: </strong></label></div>
						<div class="content"><input class="shortcode-dynamic-item-input" type="text" name="" value="" /></div>
						<div class="label"><label><strong>Circular Percent: </strong></label></div>
						<div class="content dd-percent"><input class="shortcode-dynamic-item-input percent" data-slider="true"  data-slider-range="1,100" data-slider-step="1" type="text" name=""  value="" /></div><div class="clear no-border"></div>
					</div>
				</div>
				<a href="#" class="btn blue remove-list-item">'.__( 'Remove Circular', 'calibrefx' ). '</a> <a href="#" class="btn blue add-list-item">'.__( 'Add Circular', 'calibrefx' ).'</a>';

				}

				elseif ( $name == 'testimonials' ){
					$option_element .= '
			
				<div class="label"><label for="shortcode-option-autorotate"><strong>Autorotate: </strong></label></div>
				<div class="content"><input class="attr" type="text" data-attrname="autorotate" value="" />If you would like this to autorotate, enter the rotation speed in <b>miliseconds</b> here. i.e 5000.</div>
			
				<div class="clear"></div>
			
				<div class="shortcode-dynamic-items testimonials" id="options-item" data-name="testimonial">
					<div class="shortcode-dynamic-item">
						<div class="label"><label><strong>Name: </strong></label></div>
						<div class="content"><input class="shortcode-dynamic-item-input" type="text" name="" value="" /></div>
						<div class="label"><label><strong>Quote: </strong></label></div>
						<div class="content"><textarea class="quote" name="quote"></textarea></div>
					</div>
				</div>

				<a href="#" class="btn blue remove-list-item">'.__( 'Remove Testimonial', 'calibrefx' ). '</a> <a href="#" class="btn blue add-list-item">'.__( 'Add Testimonial', 'calibrefx' ).'</a>';

				}

				elseif ( $name == 'image' ){
					$option_element .= '
					<div class="shortcode-dynamic-item" id="options-item" data-name="image-upload">
						<div class="label"><label><strong> '.$attr_option['title'].' </strong></label></div>
						<div class="content">
					
						 <input type="hidden" id="options-item"  />
						 <img class="redux-opts-screenshot" id="image_url" src="" />
						 <a data-update="Select File" data-choose="Choose a File" href="javascript:void(0);"class="redux-opts-upload button-secondary" rel-id="">' . __( 'Upload', 'calibrefx' ) . '</a>
						 <a href="javascript:void(0);" class="redux-opts-upload-remove" style="display: none;">' . __( 'Remove Upload', 'calibrefx' ) . '</a>';

					if ( ! empty($desc) ) { $option_element .= $desc; }

						$option_element .= '
						</div>
					</div>';
				}

				elseif ( $name == 'poster' ){
					$option_element .= '
					<div class="shortcode-dynamic-item" id="options-item" data-name="image-upload">
						<div class="label"><label><strong> '.$attr_option['title'].' </strong></label></div>
						<div class="content">
					
						 <input type="hidden" id="options-item"  />
						 <img class="redux-opts-screenshot" id="poster" src="" />
						 <a data-update="Select File" data-choose="Choose a File" href="javascript:void(0);"class="redux-opts-upload button-secondary" rel-id="">' . __( 'Upload', 'calibrefx' ) . '</a>
						 <a href="javascript:void(0);" class="redux-opts-upload-remove" style="display: none;">' . __( 'Remove Upload', 'calibrefx' ) . '</a>';

					if ( ! empty($desc) ) { $option_element .= $desc; }

						$option_element .= '
						</div>
					</div>';
				}

				elseif ( $name == 'color' ){

					if ( get_bloginfo( 'version' ) >= '3.5' ) {
						$option_element .= '
				   <div class="label"><label><strong>Background Color: </strong></label></div>
				   <div class="content"><input type="text" value="" class="popup-colorpicker-bg" style="width: 70px;" data-default-color=""/></div>';
					} else {
						$option_element .= 'You\'re using an outdated version of WordPress. Please update to use this feature.';
					}
				}

				elseif ( $name == 'text_color' ){

					if ( get_bloginfo( 'version' ) >= '3.5' ) {
						$option_element .= '
				   <div class="label"><label><strong>Text Color: </strong></label></div>
				   <div class="content"><input type="text" value="" class="popup-colorpicker-text" style="width: 70px;" data-default-text-color=""/></div>';
					} else {
						$option_element .= 'You\'re using an outdated version of WordPress. Please update to use this feature.';
					}
				}

				elseif ( $name == 'shadow_color' ){

					if ( get_bloginfo( 'version' ) >= '3.5' ) {
						$option_element .= '
				   <div class="label"><label><strong>Shadow Color: </strong></label></div>
				   <div class="content"><input type="text" value="" class="popup-colorpicker-shadow" style="width: 70px;" data-default-text-color=""/></div>';
					} else {
						$option_element .= 'You\'re using an outdated version of WordPress. Please update to use this feature.';
					}
				}

				elseif ( $type == 'checkbox' ){
					$option_element .= '<div class="label"><label for="' . $name . '"><strong>' . $attr_option['title'] . ': </strong></label></div>    <div class="content"> <input type="checkbox" class="' . $name . '" id="' . $name . '" />' . $desc . '</div> ';
				}

			break;

			case 'textarea':
				$option_element .= '
			<div class="label"><label for="shortcode-option-'.$name.'"><strong>'.$attr_option['title'].': </strong></label></div>
			<div class="content"><textarea data-attrname="'.$name.'"></textarea> ' . $desc . '</div>';
			break;

			case 'text':
			default:
				$option_element .= '
			<div class="label"><label for="shortcode-option-'.$name.'"><strong>'.$attr_option['title'].': </strong></label></div>
			<div class="content"><input class="attr" type="text" data-attrname="'.$name.'" value="" />' . $desc . '</div>';
			break;
		}

		$option_element .= '<div class="clear"></div>';

		if ( isset($attr_option['half_width']) && $attr_option['half_width'] == 'true' || isset($attr_option['second_half_width']) && $attr_option['second_half_width'] == 'true' ) { $option_element .= '</div>'; }
		if ( isset($attr_option['second_half_width']) && $attr_option['second_half_width'] == 'true' ) { $option_element .= '<div class="clear no-line"></div> </div>'; }

		return $option_element;
	}
}