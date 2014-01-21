<?php
/**
 * CalibreFx Framework
 *
 * WordPress Themes by CalibreFx Team
 *
 * @package		CalibreFx
 * @author		CalibreFx Team
 * @authorlink	http://www.calibrefx.com
 * @copyright	Copyright (c) 2012, Suntech Inti Perkasa.
 * @license		Commercial
 * @link		http://www.calibrefx.com
 * @since		Version 1.0
 * @filesource 
 *
 * CalibreFx 404 Page
 *
 * @package CalibreFx
 */
 
$cfxgenerator->replace('calibrefx_loop', 'calibrefx_do_loop', 'calibrefx_404');

/**
 * This function outputs a 404 "Not Found" error message
 *
 */
function calibrefx_404() { ?>

	<div class="post hentry">

		<h1 class="entry-title"><?php _e( 'Not Found, Error 404', 'calibrefx' ); ?></h1>
		<div class="entry-content">
			<p><?php printf( __( 'The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for. Or, you can try finding it with the information below.', 'calibrefx' ), home_url() ); ?></p>

			<div>
				<div class="archive-page">

					<h4><?php _e( 'Categories:', 'calibrefx' ); ?></h4>
					<ul>
						<?php wp_list_categories( 'sort_column=name&title_li=' ); ?>
					</ul>

				</div><!-- end .archive-page-->

				<div class="archive-page">

					<h4><?php _e( 'Authors:', 'calibrefx' ); ?></h4>
					<ul>
						<?php wp_list_authors( 'exclude_admin=0&optioncount=1' ); ?>
					</ul>

					<h4><?php _e( 'Monthly:', 'calibrefx' ); ?></h4>
					<ul>
						<?php wp_get_archives( 'type=monthly' ); ?>
					</ul>

					<h4><?php _e( 'Recent Posts:', 'calibrefx' ); ?></h4>
					<ul>
						<?php wp_get_archives( 'type=postbypost&limit=100' ); ?>
					</ul>

				</div><!-- end .archive-page-->

				<div class="clearfix"></div>
			</div>

		</div><!-- end .entry-content -->

	</div><!-- end .postclass -->

<?php
}

calibrefx();
