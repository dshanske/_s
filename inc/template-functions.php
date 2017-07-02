<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package _s
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function _s_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'h-feed';
	} else {
		if ( 'page' !== get_post_type() ) {
				$classes[] = 'h-entry';
		}
	}
	return $classes;
}
add_filter( 'body_class', '_s_body_classes' );

/**  
 * Wraps the_content in e-content
 *
 */
function _s_the_content( $content ) {
	$wrap = '<div class="e-content">';
	if ($content!="") {
		return $wrap . $content . "\n" . '</div>';
	}
	return $content;
}

add_filter( 'the_content', '_s_the_content', 1 );

/**
 * Wraps the_excerpt in p-summary
 *
 */
function _s_the_excerpt( $content ) {
	$wrap = '<div class="p-summary">';				 }
	if ($content!="") {
		return $wrap . $content . '</div>';
	}
	return $content;
}

add_filter( 'the_excerpt', '_s_the_excerpt', 1 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function _s_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', '_s_pingback_header' );

/**
 * Adds custom classes to the array of post classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function _s_post_classes( $classes ) {
	$classes = array_diff( $classes, array( 'hentry' ) );
	if ( ! is_singular() ) {
		if ( 'page' !== get_post_type() ) {
			// Adds a class for microformats v2
			$classes[] = 'h-entry';
		}
	}
	return $classes;
}

add_filter( 'post_class', '_s_post_classes' );

/**
 * Adds mf2 to avatar
 *
 * @param array             $args Arguments passed to get_avatar_data(), after processing.
 * @param int|string|object $id_or_email A user ID, email address, or comment object
 * @return array $args
 */
function _s_get_avatar_data($args, $id_or_email) {
	if ( ! isset( $args['class'] ) ) {
		$args['class'] = array( 'u-photo' );
	} else {
		$args['class'][] = 'u-photo';
		$args['class'] = array_unique( $args['class'] );
	}
	return $args;
}

add_filter( 'get_avatar_data', '_s_get_avatar_data', 11, 2 );

/**
 * Adds custom classes to the array of comment classes.
 */
function _s_comment_class( $classes ) {
	$classes[] = 'u-comment';
	$classes[] = 'h-cite';
	return array_unique( $classes );
}

add_filter( 'comment_class', '_s_comment_class', 11 );
