<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * @package Enterprise
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function enterprise_body_classes( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) :
		$classes[] = 'group-blog';
	endif;
	
	// Adds body class based on page template
	if ( is_page_template( 'templates/full-width.php' ) ) :		
		$classes[] = 'full-width';
	elseif ( is_page_template( 'templates/landing-page.php' ) ) :		
		$classes[] = 'landing-page';
	endif;
	
	// Adds body class based on column configuration
	if ( 'cs' == get_theme_mod( 'enterprise_columns_layout' ) ) :
		$classes[] = 'content-sidebar';
	endif;
	
	// Adds classes based on feature box widget configuration
	if ( ( is_active_sidebar( 'feature-box-1' ) && !is_active_sidebar( 'feature-box-2' ) && !is_active_sidebar( 'feature-box-3' ) ) ||
		( !is_active_sidebar( 'feature-box-1' ) && is_active_sidebar( 'feature-box-2' ) && !is_active_sidebar( 'feature-box-3' ) ) ||
		( !is_active_sidebar( 'feature-box-1' ) && !is_active_sidebar( 'feature-box-2' ) && is_active_sidebar( 'feature-box-3' ) ) ) :
		$classes[] = "one-fb-widget";
	elseif ( (is_active_sidebar( 'feature-box-1' ) && is_active_sidebar( 'feature-box-2' ) && !is_active_sidebar( 'feature-box-3' ) ) ||
		( is_active_sidebar( 'feature-box-1' ) && !is_active_sidebar( 'feature-box-2' ) && is_active_sidebar( 'feature-box-3' ) ) ||
		( !is_active_sidebar( 'feature-box-1' ) && is_active_sidebar( 'feature-box-2' ) && is_active_sidebar( 'feature-box-3' ) ) ) :
		$classes[] = "two-fb-widget";
	elseif ( ( is_active_sidebar( 'feature-box-1' ) && is_active_sidebar( 'feature-box-2' ) && is_active_sidebar( 'feature-box-3' ) ) ) :
		$classes[] = "three-fb-widget";
	endif;
	
	return $classes;
}
add_filter( 'body_class', 'enterprise_body_classes' );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function enterprise_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'enterprise_setup_author' );
