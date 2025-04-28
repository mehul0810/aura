<?php
/**
 * Functions file for Aura Theme.
 *
 * @package Aura\Theme
 */

namespace Aura\Theme;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup theme supports.
 */
function aura_setup() {

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
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\aura_setup' );

/**
 * Enqueue theme styles.
 */
function aura_enqueue_styles() {

	wp_enqueue_style(
		'aura-style',
		get_template_directory_uri() . '/styles/main.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\aura_enqueue_styles' );

/**
 * Register custom pattern categories and patterns.
 */
function aura_register_block_patterns() {

	// Register custom pattern categories.
	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category( 'aura-call-to-action', array( 'label' => __( 'Call to Action', 'aura' ) ) );
		register_block_pattern_category( 'aura-featured', array( 'label' => __( 'Featured', 'aura' ) ) );
		register_block_pattern_category( 'aura-columns', array( 'label' => __( 'Columns', 'aura' ) ) );
		register_block_pattern_category( 'aura-text', array( 'label' => __( 'Text', 'aura' ) ) );
	}

	// Auto-register all patterns from the /patterns/ directory.
	$pattern_files = glob( get_theme_file_path( '/patterns/*.php' ) );

	foreach ( $pattern_files as $pattern_file ) {
		register_block_pattern(
			'aura/' . basename( $pattern_file, '.php' ),
			require $pattern_file
		);
	}
}
add_action( 'init', __NAMESPACE__ . '\\aura_register_block_patterns' );
