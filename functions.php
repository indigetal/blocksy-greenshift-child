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
    
    if ( file_exists( $gs_framework_dir . '/internal/remove-presets.php' ) ) {
		require_once $gs_framework_dir . '/internal/remove-presets.php';
	}
	
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
}
