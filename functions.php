<?php
if (! defined('WP_DEBUG')) {
	die( 'Direct access forbidden.' );
}
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
});

// load Greenshift Framework files
$gs_framework_dir = get_stylesheet_directory() . '/gs-framework';
$gs_framework_uri = get_stylesheet_directory_uri() . '/gs-framework';

if ( function_exists( 'greenshift_render_variables' ) ) {
    
	/* If you want to remove GreenShift's presets for a project, uncomment the below block of code:
    if ( file_exists( $gs_framework_dir . '/internal/remove-presets.php' ) ) {
		require_once $gs_framework_dir . '/internal/remove-presets.php';
	} */
	
	if ( file_exists( $gs_framework_dir . '/framework-groups.php' ) ) {
		require_once $gs_framework_dir . '/framework-groups.php';
	}
	
	if ( file_exists( $gs_framework_dir . '/data-presets.php' ) ) {
		require_once $gs_framework_dir . '/data-presets.php';
	}
	
	if ( file_exists( $gs_framework_dir . '/semantic-tokens.php' ) ) {
		require_once $gs_framework_dir . '/semantic-tokens.php';
	}
	
	if ( file_exists( $gs_framework_dir . '/internal/color-token-swatches.php' ) ) {
		require_once $gs_framework_dir . '/internal/color-token-swatches.php';
	}
	
	if ( file_exists( $gs_framework_dir . '/block-variations.php' ) ) {
		require_once $gs_framework_dir . '/block-variations.php';
	}

	// enqueue framework CSS if present
	// Priority 999 ensures it loads after Blocksy's dynamic styles
	if ( file_exists( $gs_framework_dir . '/framework-groups.css' ) ) {
		add_action( 'wp_enqueue_scripts', function () use ( $gs_framework_uri, $gs_framework_dir ) {
			wp_enqueue_style(
				'blocksy-framework-groups',
				$gs_framework_uri . '/framework-groups.css',
				array( 'parent-style' ),
				filemtime( $gs_framework_dir . '/framework-groups.css' ),
				'all'
			);
		}, 999 );
	}

	// Enqueue data preset dropdown enhancement in the block editor.
	// Converts comma-separated data preset values into dropdown menus.
	if ( file_exists( $gs_framework_dir . '/internal/data-preset-dropdown.js' ) ) {
		add_action( 'enqueue_block_editor_assets', function () use ( $gs_framework_uri, $gs_framework_dir ) {
			wp_enqueue_script(
				'gs-data-preset-dropdown',
				$gs_framework_uri . '/internal/data-preset-dropdown.js',
				array( 'wp-data', 'wp-block-editor' ),
				filemtime( $gs_framework_dir . '/internal/data-preset-dropdown.js' ),
				true
			);
		} );
	}
}
