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
 * Register theme.
 */
function register_theme() {
	// Register custom block patterns.
	register_block_patterns();

	// Register custom block styles.
	register_block_styles();
}
add_action( 'init', __NAMESPACE__ . '\\register_theme' );

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

/**
 * Add block style variations.
 */
function register_block_styles() {

	$block_styles = array(
		'core/list'         => array(
			'list-check'        => __( 'Check', 'ollie' ),
			'list-check-circle' => __( 'Check Circle', 'ollie' ),
			'list-boxed'        => __( 'Boxed', 'ollie' ),
		),
		'core/code'         => array(
			'dark-code' => __( 'Dark', 'ollie' ),
		),
		'core/cover'        => array(
			'blur-image-less' => __( 'Blur Image Less', 'ollie' ),
			'blur-image-more' => __( 'Blur Image More', 'ollie' ),
			'rounded-cover'   => __( 'Rounded', 'ollie' ),
		),
		'core/column'       => array(
			'column-box-shadow' => __( 'Box Shadow', 'ollie' ),
		),
		'core/post-excerpt' => array(
			'excerpt-truncate-2' => __( 'Truncate 2 Lines', 'ollie' ),
			'excerpt-truncate-3' => __( 'Truncate 3 Lines', 'ollie' ),
			'excerpt-truncate-4' => __( 'Truncate 4 Lines', 'ollie' ),
		),
		'core/group'        => array(
			'column-box-shadow' => __( 'Box Shadow', 'ollie' ),
			'background-blur'   => __( 'Background Blur', 'ollie' ),
		),
		'core/separator'    => array(
			'separator-dotted' => __( 'Dotted', 'ollie' ),
			'separator-thin'   => __( 'Thin', 'ollie' ),
		),
		'core/image'        => array(
			'rounded-full' => __( 'Rounded Full', 'ollie' ),
			'media-boxed'  => __( 'Boxed', 'ollie' ),
		),
		'core/preformatted' => array(
			'preformatted-dark' => __( 'Dark Style', 'ollie' ),
		),
		'core/post-terms'   => array(
			'term-button' => __( 'Button Style', 'ollie' ),
		),
		'core/video'        => array(
			'media-boxed' => __( 'Boxed', 'ollie' ),
		),
	);

	foreach ( $block_styles as $block => $styles ) {
		foreach ( $styles as $style_name => $style_label ) {
			register_block_style(
				$block,
				array(
					'name'  => $style_name,
					'label' => $style_label,
				)
			);
		}
	}
}