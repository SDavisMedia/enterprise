<?php
/**
 * Enterprise functions and definitions
 *
 * @package Enterprise
 */

define( 'THEME_NAME', 'Enterprise' );
define( 'THEME_AUTHOR', 'Sean Davis' );
define( 'THEME_AUTHOR_URI', 'http://seandavis.co/' );
define( 'THEME_VERSION', '1.0.0' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 624; /* pixels */
}

if ( ! function_exists( 'enterprise_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function enterprise_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Enterprise, use a find and replace
	 * to change 'enterprise' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'enterprise', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'enterprise_custom_background_args', array(
		'default-color'	=> '323232',
		'default-image'	=> get_template_directory_uri() . '/assets/images/bg.png',
	) ) );

	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );	
	// add a hard cropped (for uniformity) image size for the product grid
	add_image_size( 'enterprise_featured_image', 738, 200, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'header' => __( 'Header Menu', 'enterprise' ),
	) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5',
		array( 'comment-list', 'search-form', 'comment-form', 'gallery', 'caption' )
	);
}
endif; // enterprise_setup
add_action( 'after_setup_theme', 'enterprise_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function enterprise_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Sidebar', 'enterprise' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	) );
	register_sidebar( array(
		'name'          => __( 'Feature Box Area 1', 'enterprise' ),
		'id'            => 'feature-box-1',
		'description'   => __( 'This is the leftmost widget area in the hidden feature box content. If no other feature box widget areas are used, this will span full-width.', 'enterprise' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	) );
	register_sidebar( array(
		'name'          => __( 'Feature Box Area 2', 'enterprise' ),
		'id'            => 'feature-box-2',
		'description'   => __( 'This is the middle widget area in the hidden feature box content. If no other feature box widget areas are used, this will span full-width.', 'enterprise' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	) );
	register_sidebar( array(
		'name'          => __( 'Feature Box Area 3', 'enterprise' ),
		'id'            => 'feature-box-3',
		'description'   => __( 'This is the rightmost widget area in the hidden feature box content. If no other feature box widget areas are used, this will span full-width.', 'enterprise' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	) );
}
add_action( 'widgets_init', 'enterprise_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function enterprise_scripts() {
	// main stylesheet
	wp_enqueue_style( 'enterprise-style', get_stylesheet_uri() );
	// Google fonts
	wp_enqueue_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:700' );
	// Font Awesome
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/fonts/font-awesome/css/font-awesome.min.css' );
	// responsive navigation script
	wp_enqueue_script( 'enterprise-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), THEME_VERSION, true );
	// feature box toggle
	wp_enqueue_script( 'enterprise-feature-box', get_template_directory_uri() . '/assets/js/feature-box.js', array(), THEME_VERSION, true );
	// parallax background
	if ( 1 == get_theme_mod( 'enterprise_parallax_bg' ) ) :
		wp_enqueue_script( 'enterprise-parallax', get_template_directory_uri() . '/assets/js/parallax.js', array( 'jquery' ), THEME_VERSION, true );
	endif;
	// skip link script
	wp_enqueue_script( 'enterprise-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), THEME_VERSION, true );
	// comments reply support
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) :
		wp_enqueue_script( 'comment-reply' );
	endif;
}
add_action( 'wp_enqueue_scripts', 'enterprise_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Replace excerpt ellipses with new ellipses and link to full article
 */
function enterprise_excerpt_more( $more ) {
	return '...</p> <p class="continue-reading"><a class="more-link" href="' . get_permalink( get_the_ID() ) . '">' . get_theme_mod( 'enterprise_read_more', __( 'Continue reading', 'enterprise' ) ) . '<i class="fa fa-caret-right"></i></a></p>';
}
add_filter( 'excerpt_more', 'enterprise_excerpt_more' );


/**
 * Only show regular posts in search results. Also account for the bbPress search form.
 */
function enterprise_search_filter( $query ) {
	if ( $query->is_search && ! is_admin() && ( class_exists( 'bbPress' ) && ! is_bbpress() ) )
		$query->set( 'post_type', 'post' );
		
	return $query;
}
add_filter( 'pre_get_posts','enterprise_search_filter' );


/**
 * stupid skip link thing with the more tag -- remove it -- NOW
 */
function enterprise_remove_more_tag_link_jump( $link ) {
    $offset = strpos( $link, '#more-' );
    
    if ( $offset ) :
        $end = strpos( $link, '"', $offset );
    endif;
    
    if ( $end ) :
        $link = substr_replace( $link, '', $offset, $end-$offset );
    endif;
    
    return $link;
} 
add_filter( 'the_content_more_link', 'enterprise_remove_more_tag_link_jump' );