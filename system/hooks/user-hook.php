<?php
/**
 * Calibrefx User Hooks
 *
 */

function calibrefx_user_another_social_fields( $methods ) {
	$methods['facebook_url'] = __( 'Facebook Profile', 'calibrefx' );
	$methods['twitter_url'] = __( 'Twitter Account', 'calibrefx' );
	$methods['youtube_channel'] = __( 'Youtube Channel', 'calibrefx' );
	$methods['linkedin_profile'] = __( 'Linkedin Profile', 'calibrefx' );

	return $methods;
}
add_filter( 'user_contactmethods', 'calibrefx_user_another_social_fields', 10, 1 );

/**
 * Adds fields for author archives contents to the user edit screen.
 *
 * Input / Textarea fields are:
 * - Custom Archive Headline
 * - Custom Description Text
 *
 * Checkbox fields are:
 * - Enable Author Box on the User's Posts?
 * - Enable Author Box on this User's Archives?
 *
 */
function calibrefx_user_archive_fields( $user ) {

	if ( ! current_user_can( 'edit_users', $user->ID ) ) {
		return false;
	}
	?>
    <h3><?php _e( 'Author Archive Settings', 'calibrefx' ); ?></h3>
    <p><span class="description"><?php _e( 'These settings apply to this author\'s archive pages.', 'calibrefx' ); ?></span></p>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row" valign="top"><label for="headline"><?php _e( 'Custom Archive Headline', 'calibrefx' ); ?></label></th>
                <td>
                    <input name="meta[author_headline]" id="headline" type="text" value="<?php echo esc_attr( get_the_author_meta( 'author_headline', $user->ID ) ); ?>" class="regular-text" /><br />
                    <span class="description"><?php printf( __( 'Will display in the %s tag at the top of the first page', 'calibrefx' ), '<code>&lt;h1&gt;&lt;/h1&gt;</code>' ); ?></span>
                </td>
            </tr>

            <tr>
                <th scope="row" valign="top"><label for="intro_text"><?php _e( 'Custom Description Text', 'calibrefx' ); ?></label></th>
                <td>
                    <textarea name="meta[author_intro_text]" id="intro_text" rows="5" cols="30"><?php echo esc_textarea( get_the_author_meta( 'author_intro_text', $user->ID ) ); ?></textarea><br />
                    <span class="description"><?php _e( 'This text will be the first paragraph, and display on the first page', 'calibrefx' ); ?></span>
                </td>
            </tr>

            <tr>
                <th scope="row" valign="top"><?php _e( 'Author Box', 'calibrefx' ); ?></th>
                <td>
                    <input id="meta[calibrefx_author_box_single]" name="meta[calibrefx_author_box_single]" type="checkbox" value="1" <?php checked( get_the_author_meta( 'calibrefx_author_box_single', $user->ID ) ); ?> />
                    <label for="meta[calibrefx_author_box_single]"><?php _e( 'Enable Author Box on this User\'s Posts?', 'calibrefx' ); ?></label><br />
                    <input id="meta[calibrefx_author_box_archive]" name="meta[calibrefx_author_box_archive]" type="checkbox" value="1" <?php checked( get_the_author_meta( 'calibrefx_author_box_archive', $user->ID ) ); ?> />
                    <label for="meta[calibrefx_author_box_archive]"><?php _e( 'Enable Author Box on this User\'s Archives?', 'calibrefx' ); ?></label>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}
add_action( 'show_user_profile', 'calibrefx_user_archive_fields' );
add_action( 'edit_user_profile', 'calibrefx_user_archive_fields' );


/**
 * Adds / updates user meta when user edit page is saved.
 */
function calibrefx_user_meta_save( $user_id ) {

	if ( ! current_user_can( 'edit_users', $user_id ) ) {
		return;
	}

	if ( ! isset( $_POST['meta'] ) || ! is_array( $_POST['meta'] ) ) {
		return;
	}

	$meta = wp_parse_args(
		$_POST['meta'], array(
				'calibrefx_author_box_single' => '',
				'calibrefx_author_box_archive' => '',
			)
	);

	foreach ( $meta as $key => $value ) {
		update_user_meta( $user_id, $key, $value );
	}
}
add_action( 'personal_options_update', 'calibrefx_user_meta_save' );
add_action( 'edit_user_profile_update', 'calibrefx_user_meta_save' );