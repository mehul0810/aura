<?php
/**
 * Functions file for AuraKit Theme.
 *
 * @package AuraKit\Theme
 */

namespace AuraKit\Theme;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup theme supports.
 */
function setup() {

	// Add support for dynamic title tag.
	add_theme_support( 'title-tag' );

	// Add support for post thumbnails.
	add_theme_support( 'post-thumbnails' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );
	add_editor_style( 'styles/main.css' );

	// Add support for wide align images and blocks.
	add_theme_support( 'align-wide' );

	add_theme_support( 'block-templates' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\setup' );

/**
 * Enqueue theme styles.
 */
function enqueue_styles() {

	wp_enqueue_style(
		'aurakit-style',
		get_template_directory_uri() . '/assets/build/css/main.build.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_styles' );

/**
 * Register custom pattern categories and patterns.
 */
function register_block_patterns() {

	// Register custom pattern categories.
	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category( 'aurakit-call-to-action', array( 'label' => __( 'Call to Action', 'aurakit' ) ) );
		register_block_pattern_category( 'aurakit-featured', array( 'label' => __( 'Featured', 'aurakit' ) ) );
		register_block_pattern_category( 'aurakit-columns', array( 'label' => __( 'Columns', 'aurakit' ) ) );
		register_block_pattern_category( 'aurakit-text', array( 'label' => __( 'Text', 'aurakit' ) ) );
	}

	// Auto-register all patterns from the /patterns/ directory.
	$pattern_files = glob( get_theme_file_path( '/patterns/*.php' ) );

	foreach ( $pattern_files as $pattern_file ) {
		register_block_pattern(
			'aurakit/' . basename( $pattern_file, '.html' ),
			require $pattern_file
		);
	}
}
add_action( 'init', __NAMESPACE__ . '\\register_block_patterns' );
