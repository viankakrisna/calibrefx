<?php
/**
 * Calibrefx Meta Helper
 *
 */

/**
 * Output the locale, doing some conversions to make sure the proper Facebook locale is outputted.
 *
 * Results: 1 new locale added, found 32 in the below list which are not in the FB list (not removed), 76 OK.
 * @see http://www.facebook.com/translations/FacebookLocales.xml for the list of supported locales
 *
 * @return string $locale
 */
function calibrefx_meta_locale(){
	$locale = get_locale();

	// catch some weird locales served out by WP that are not easily doubled up.
	$fix_locales = array(
		'ca' => 'ca_ES',
		'en' => 'en_US',
		'el' => 'el_GR',
		'et' => 'et_EE',
		'ja' => 'ja_JP',
		'sq' => 'sq_AL',
		'uk' => 'uk_UA',
		'vi' => 'vi_VN',
		'zh' => 'zh_CN'
	);

	if ( isset( $fix_locales[$locale] ) ) {
		$locale = $fix_locales[$locale]; }

	// convert locales like "es" to "es_ES", in case that works for the given locale (sometimes it does)
	if ( strlen( $locale ) == 2 ) {
		$locale = strtolower( $locale ) . '_' . strtoupper( $locale ); }

	// These are the locales FB supports
	$fb_valid_fb_locales = array(
		'ca_ES', 'cs_CZ', 'cy_GB', 'da_DK', 'de_DE', 'eu_ES', 'en_PI', 'en_UD', 'ck_US', 'en_US', 'es_LA', 'es_CL', 'es_CO', 'es_ES', 'es_MX',
		'es_VE', 'fb_FI', 'fi_FI', 'fr_FR', 'gl_ES', 'hu_HU', 'it_IT', 'ja_JP', 'ko_KR', 'nb_NO', 'nn_NO', 'nl_NL', 'pl_PL', 'pt_BR', 'pt_PT',
		'ro_RO', 'ru_RU', 'sk_SK', 'sl_SI', 'sv_SE', 'th_TH', 'tr_TR', 'ku_TR', 'zh_CN', 'zh_HK', 'zh_TW', 'fb_LT', 'af_ZA', 'sq_AL', 'hy_AM',
		'az_AZ', 'be_BY', 'bn_IN', 'bs_BA', 'bg_BG', 'hr_HR', 'nl_BE', 'en_GB', 'eo_EO', 'et_EE', 'fo_FO', 'fr_CA', 'ka_GE', 'el_GR', 'gu_IN',
		'hi_IN', 'is_IS', 'id_ID', 'ga_IE', 'jv_ID', 'kn_IN', 'kk_KZ', 'la_VA', 'lv_LV', 'li_NL', 'lt_LT', 'mk_MK', 'mg_MG', 'ms_MY', 'mt_MT',
		'mr_IN', 'mn_MN', 'ne_NP', 'pa_IN', 'rm_CH', 'sa_IN', 'sr_RS', 'so_SO', 'sw_KE', 'tl_PH', 'ta_IN', 'tt_RU', 'te_IN', 'ml_IN', 'uk_UA',
		'uz_UZ', 'vi_VN', 'xh_ZA', 'zu_ZA', 'km_KH', 'tg_TJ', 'ar_AR', 'he_IL', 'ur_PK', 'fa_IR', 'sy_SY', 'yi_DE', 'gn_PY', 'qu_PE', 'ay_BO',
		'se_NO', 'ps_AF', 'tl_ST', 'fy_NL',
	);

	// check to see if the locale is a valid FB one, if not, use en_US as a fallback
	if ( ! in_array( $locale, $fb_valid_fb_locales ) ) {
		$locale = 'en_US'; }

	return apply_filters( 'calibrefx_meta_locale', $locale );
}

/**
 * Output the title
 *
 * @return string $title
 */
function calibrefx_meta_title( ){
	$title = wp_title( '|', false, 'right' );

	return apply_filters( 'calibrefx_meta_title', $title );
}

/**
 * Output the url
 *
 * @return string $url
 */
function calibrefx_meta_url(){
	return apply_filters( 'calibrefx_meta_url', get_current_url() );
}

/**
 * Output description
 *
 * @return string $description
 */
function calibrefx_meta_description(){
	global $post, $wp_query, $wp_locale;

	$desc = '';

	if ( is_home() || is_front_page() ){
		$desc = get_bloginfo( 'description' );
	} elseif ( is_singular() ){
		$desc = calibrefx_truncate_phrase( $post->post_content, calibrefx_get_option( 'content_archive_limit' ) );
	} elseif ( is_archive() ){
		if ( is_category() ){
			$desc = category_description( get_query_var( 'cat' ) );
		} elseif ( is_tax() ){
			$term = $wp_query->get_queried_object();
			$desc = term_description( $term->term_id, $term->taxonomy );
		} elseif ( is_year() ){
			$desc = __( 'All posts in ', 'calibrefx' ) . get_query_var( 'year' );
		} elseif ( is_month() ){
			$desc = __( 'All Posts in ', 'calibrefx' ) . $wp_locale->get_month( get_query_var( 'monthnum' ) ) . ' ' . get_query_var( 'year' );
		} elseif ( is_day() ){
			$desc = __( 'All Posts in ', 'calibrefx' ) . get_query_var( 'day' ) . ' ' . $wp_locale->get_month( get_query_var( 'monthnum' ) ) . ' ' . get_query_var( 'year' );
		} elseif ( is_author() ){
			$desc = get_user_meta( $wp_query->queried_object->ID, 'intro_text', true );
		} elseif ( is_post_type_archive() ){
			$post_type = $wp_query->get_queried_object();
			$desc = $post_type->description;
		}
	} elseif ( is_404() ){
		$desc = __( 'Page not found ', 'calibrefx' );
	}

	$desc = str_replace( array( '<p>','</p>' ), array( '','' ), $desc );
	$desc = htmlentities( $desc );

	return apply_filters( 'calibrefx_meta_description', $desc );
}

/**
 * Get feature image to show on meta tag
 *
 * @return string image url
 */
function calibrefx_meta_image(){
	$image = calibrefx_get_image( array( 'format' => 'url' ) );

	return apply_filters( 'calibrefx_meta_image', $image );
}