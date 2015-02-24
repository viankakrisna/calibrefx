<?php
/**
 * Default comment template
 */

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) AND 'comments.php' == basename( sanitize_text_field( $_SERVER['SCRIPT_FILENAME'] ) ) ){
	echo 'Please do not load this page directly. Thanks!';
	exit;
}

if ( post_password_required() ) {
	echo '<p class="alert">This post is password protected. Enter the password to view comments.</p>';
	return;
}

do_action( 'calibrefx_before_comments' );
do_action( 'calibrefx_comments' );
do_action( 'calibrefx_after_comments' );

do_action( 'calibrefx_before_pings' );
do_action( 'calibrefx_pings' );
do_action( 'calibrefx_after_pings' );

do_action( 'calibrefx_before_comment_form' );
do_action( 'calibrefx_comment_form' );
do_action( 'calibrefx_after_comment_form' );
