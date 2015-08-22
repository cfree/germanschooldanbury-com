<?php
/**
 * German School Danbury functions and definitions
 *
 * @package gsd
 */

define( 'ASSETS_VERSION', '1.0.0' );

if ( ! function_exists( 'gsd_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function gsd_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _s, use a find and replace
	 * to change '_s' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'gsd', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'gsd' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );
}
endif; // _s_setup
add_action( 'after_setup_theme', 'gsd_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function gsd_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'gsd_content_width', 640 );
}
add_action( 'after_setup_theme', 'gsd_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function gsd_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'gsd' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'gsd_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function gsd_scripts() {
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/vendor/modernizr/modernizr.js', array(), '2.8.3', false );

	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		wp_enqueue_style( 'gsd-style-dev', get_stylesheet_directory_uri() . '/assets/build/styles.css', array(), ASSETS_VERSION );
		wp_enqueue_script( 'gsd-scripts-dev', get_template_directory_uri() . '/assets/build/scripts.js', array( 'modernizr', 'jquery' ), ASSETS_VERSION, true );
	} else {
		wp_enqueue_style( 'gsd-style', get_template_directory_uri() . '/assets/dist/styles-min.css', array(), ASSETS_VERSION );
		wp_enqueue_script( 'gsd-scripts', get_template_directory_uri() . '/assets/dist/scripts-min.js', array( 'modernizr', 'jquery' ), ASSETS_VERSION, true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
// add_action( 'wp_enqueue_scripts', 'gsd_scripts' );



// in your Child Theme's functions.php   
// Use the after_setup_theme hook with a priority of 11 to load after the
// parent theme, which will fire on the default priority of 10
 
// Remove meta generator (WP version) from site and feed
if ( ! function_exists( 'mywp_remove_version' ) ) {
	 
	function mywp_remove_version() {
			return '';
	}
	add_filter('the_generator', 'mywp_remove_version');
}
 
// Clean header from unneeded links
if ( ! function_exists( 'mywp_head_cleanup' ) ) {
 
	function mywp_head_cleanup() {
		remove_action('wp_head', 'feed_links', 2);  // Remove Post and Comment Feeds
		remove_action('wp_head', 'feed_links_extra', 3);  // Remove category feeds
		remove_action('wp_head', 'rsd_link'); // Disable link to Really Simple Discovery service
		remove_action('wp_head', 'wlwmanifest_link'); // Remove link to the Windows Live Writer manifest file.
		/*remove_action( 'wp_head', 'index_rel_link' ); */ // canonic link
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);  // Remove relation links for the posts adjacent to the current post.
		remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

		global $wp_widget_factory;
		remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
		add_filter('use_default_gallery_style', '__return_null');
	}

	add_action('init', 'mywp_head_cleanup');
}
 
// Add Header and Extra Widget Area 
if ( ! function_exists( 'custom_sidebar' ) ) {
 
	// Register Sidebar
	function custom_sidebar() {
	 
		$args = array(
			'id'            => 'sidebarheader',
			'name'          => __( 'Header Widget', 'twentythirteen' ),
			'description'   => __( 'Header widget area for my child theme.', 'twentythirteen' ),
			'class'         => 'sidebarheader',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
		);
		register_sidebar( $args );
	 
	        $args = array(
			'id'            => 'sidebarextra',
			'name'          => __( 'Extra Widget', 'twentythirteen' ),
			'description'   => __( 'Extra widget area for my child theme.', 'twentythirteen' ),
			'class'         => 'sidebarextra',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
		);
		register_sidebar( $args );
	 
	}
	 
	// Hook into the 'widgets_init' action
	add_action( 'widgets_init', 'custom_sidebar' );

}



