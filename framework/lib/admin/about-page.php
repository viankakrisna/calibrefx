<?php
/**
 * CalibreFx
 *
 * WordPress Themes Framework by CalibreWorks Team
 *
 * @package		CalibreFx
 * @author		CalibreWorks Team
 * @copyright	Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://calibreworks.com
 * @since		Version 1.0
 * @filesource 
 *
 * WARNING: This file is part of the core CalibreFx framework. DO NOT edit
 * this file under any circumstances. 
 *
 * Handle framework about page
 *
 * @package CalibreFx
 */
 
add_action('admin_menu', 'calibrefx_about_init');
/**
 * This is a necessary go-between to get our scripts and boxes loaded
 * on the theme settings page only, and not the rest of the admin
 */
function calibrefx_about_init() {
	global $_calibrefx_about_pagehook;

	add_action('load-'.$_calibrefx_about_pagehook, 'calibrefx_theme_settings_scripts');
	add_action('load-'.$_calibrefx_about_pagehook, 'calibrefx_theme_settings_styles');
	add_action('load-'.$_calibrefx_about_pagehook, 'calibrefx_about_boxes');
}

/**
 * This function load meta boxes
 */
function calibrefx_about_boxes() {
	global $_calibrefx_about_pagehook;
	
	add_meta_box('calibrefx-about-version', __('Information', 'calibrefx'), 'calibrefx_about_info_box', $_calibrefx_about_pagehook, 'main', 'high');
}


/**
 * Show Framework Information
 */
function calibrefx_about_page(){
	global $_calibrefx_about_pagehook, $wp_meta_boxes;
?>
	<div id="calibrefx-about-page" class="wrap calibrefx-metaboxes">
		<?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false ); ?>
		<?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>
		<?php settings_fields(CALIBREFX_SETTINGS_FIELD); // important! ?>
		
		<?php screen_icon('options-general'); ?>
		<h2>
			<?php _e('CalibreFx - About Framework', 'calibrefx'); ?>
		</h2>
		
		<div class="calibrefx-submit-button">
			<input type="submit" class="button-primary calibrefx-h2-button" value="<?php _e('Save Settings', 'calibrefx') ?>" />
			<input type="submit" class="button-highlighted calibrefx-h2-button" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[reset]" value="<?php _e('Reset Settings', 'calibrefx'); ?>" onclick="return calibrefx_confirm('<?php echo __('Are you sure you want to reset?', 'calibrefx'); ?>');" />
		</div>
		
		<div class="metabox-holder">
			<div class="postbox-container" style="width: 99%;">
				<?php
				do_meta_boxes($_calibrefx_about_pagehook, 'main', null);
				?>
			</div>
		</div>
		
		<div class="calibrefx-submit-button">
			<input type="submit" class="button-primary calibrefx-h2-button" value="<?php _e('Save Settings', 'calibrefx') ?>" />
			<input type="submit" class="button-highlighted calibrefx-h2-button" name="<?php echo CALIBREFX_SETTINGS_FIELD; ?>[reset]" value="<?php _e('Reset Settings', 'calibrefx'); ?>" onclick="return calibrefx_confirm('<?php echo __('Are you sure you want to reset?', 'calibrefx'); ?>');" />
		</div>
	</div>
	<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) {
			// close postboxes that should be closed
			$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			// postboxes setup
			postboxes.add_postbox_toggles('<?php echo $_calibrefx_about_pagehook; ?>');
		});
		//]]>
	</script>
<?php
}

function calibrefx_about_info_box(){ ?>
	<p><strong><?php _e('Framework Name: ', 'calibrefx'); ?></strong><?php echo FRAMEWORK_NAME; ?> (<?php _e('Codename: ', 'calibrefx'); echo FRAMEWORK_CODENAME; ?>)</p>
	<p><strong><?php _e('Version:', 'calibrefx'); ?></strong> <?php calibrefx_option('theme_version'); ?> <?php echo '&middot;'; ?> <strong><?php _e('Released:', 'calibrefx'); ?></strong> <?php echo FRAMEWORK_RELEASE_DATE; ?></p>
	<p><strong><?php _e('DB Version: ', 'calibrefx'); ?></strong><?php echo FRAMEWORK_DB_VERSION; ?></p>
<?php
}