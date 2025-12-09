<?php
// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only register when Greenshift is available.
if ( function_exists( 'greenshift_render_variables' ) ) {

	/**
	 * Register "Modifiers & Exceptions" preset group containing data-attribute presets.
	 *
	 * These are data presets: Greenshift will write the `data-*` attribute on the element.
	 * Per GreenShift documentation, return only the custom groups - GreenShift handles merging.
	 */
	add_filter( 'greenshift_preset_classes', 'register_modifiers_exceptions' );
	function register_modifiers_exceptions( $options ) {
		return array(
			array(
				'label'   => esc_html__( 'Modifiers / Exceptions', 'blocksy-greenshift-child' ),
				'options' => array(
					array(
						'value' => 'data-width',
						'label' => 'Wrapper - Wide',
						'type'  => 'data',
						'data'  => 'wide',
					),
					array(
						'value' => 'data-padding',
						'label' => 'Mobile Section - Vertical Spacing',
						'type'  => 'data',
						'data'  => 'compact',
					),
				),
			),
		);
	}
}


