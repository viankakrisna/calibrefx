<?php 
/**
 * Calibrefx Shortcode Button Class
 */

class CFX_Shortcode {
	
	/**
     * Constructor - Initializes
     */
    function __construct() {
    	
    	add_action( 'media_buttons_context', array( __CLASS__, 'shortcode_button' ) );
    	add_action( 'admin_footer', array( __CLASS__, 'content_display' ) );
    }

    public static function shortcode_button(){
    	echo "<a data-effect='mfp-zoom-in' class='button calibrefx-sc-generator' href='#calibrefx-sc-generator'><span class='icon-calibrefx'></span>Shortcodes</a>";
    }

    public static function content_display(){

    	$html_options = null;
    	$shortcode_html = '
		<div id="calibrefx-sc-heading" style="display: none;">
			<div id="calibrefx-sc-generator" class="mfp-hide mfp-with-anim">
				<div class="shortcode-content">
					<div id="calibrefx-sc-header">
						<div class="label"><strong>Calibrefx Shortcodes</strong></div>
							<div class="content"><select id="calibrefx-shortcodes" data-placeholder="' . __("Choose a shortcode", "calibrefx") .'">
							<option></option>';

		$shortcode_html .= '</select></div></div>';
		echo $shortcode_html . $html_options; 
		?>
	
		<div id="shortcode-content">
		
			<div class="label"><label id="option-label" for="shortcode-content"><?php echo __( 'Content: ', 'calibrefx' ); ?> </label></div>
			<div class="content"><textarea id="shortcode_content"></textarea></div>
			<div class="hr"></div>
		</div>
	
		<code class="shortcode_storage"><span id="shortcode-storage-o" style=""></span><span id="shortcode-storage-d"></span><span id="shortcode-storage-c" style=""></span></code>
		<a class="btn" id="add-shortcode"><?php echo __( 'Add Shortcode', 'calibrefx' ); ?></a>
		</div></div></div>
	<?php
    }
}