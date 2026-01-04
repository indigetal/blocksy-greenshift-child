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
	 * Note: Arrays with one item cause a GreenShift rendering bug.
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
						'label' => 'Wrapper - Width',
						'type'  => 'data',
						// Provide multiple selectable data values as an array.
						'data'  => array( 'wide', 'narrow' ),

					),
					array(
						'value' => 'data-padding',
						'label' => 'Section - Vertical Padding',
						'type'  => 'data',
						'data'  => 'compact',
					),
					array(
						'value' => 'data-gap',
						'label' => 'Equal Columns - Gap',
						'type'  => 'data',
						'data'  => 'large',
					),
					array(
						'value' => 'data-vertical-alignment',
						'label' => 'Equal Columns - Vertical Alignment',
						'type'  => 'data',
						'data'  => array( 'centered', 'bottom' ),
					),
					array(
						'value' => 'data-justify',
						'label' => 'Flex Group - Justify',
						'type'  => 'data',
						'data'  => 'center',
					),
					array(
						'value' => 'data-button',
						'label' => 'Button - Type',
						'type'  => 'data',
						'data'  => 'secondary',
					),
				),
			),
		);
	}
}


