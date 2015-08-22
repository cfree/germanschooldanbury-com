<?php
/**
 * German School Danbury functions and definitions
 *
 * @package gsd
 */

define( 'ASSETS_VERSION', '1.0.0' );

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