<?php
/**
 * Register GreenShift Framework Groups:
 * - Layout (wrapper, section, width modifiers)
 * - Utilities (text, background, font-size, visually-hidden)
 *
 * These are "framework" classes: Greenshift will show them in the Styles dropdown
 * but the CSS for them should live in the theme stylesheet.
 *
 * See: https://greenshiftwp.com/documentation/for-developers/how-to-register-own-css-framework-or-enable-core-framework-addon-with-greenshift/
 */

add_filter( 'greenshift_framework_classes', 'register_framework_groups' );
function register_framework_groups( $options ) {
	// Return only the custom groups - GreenShift handles the merging
	return array(
		array(
			'label'   => esc_html__( 'Layout', 'blocksy-greenshift-child' ),
			'options' => array(
				array( 'value' => 'wrapper',                 'label' => 'Wrapper',                 'type' => 'framework' ),
				array( 'value' => 'section',                 'label' => 'Section',                'type' => 'framework' ),
			),
		),
		array(
			'label'   => esc_html__( 'Utilities', 'blocksy-greenshift-child' ),
			'options' => array(
				array( 'value' => 'text-center',            'label' => 'Text — Center',          'type' => 'framework' ),
				array( 'value' => 'text-brand',             'label' => 'Text — Brand',           'type' => 'framework' ),
				array( 'value' => 'text-high-contrast',     'label' => 'Text — High Contrast',   'type' => 'framework' ),
				array( 'value' => 'section-title',          'label' => 'Section Title',          'type' => 'framework' ),
				array( 'value' => 'background-base',        'label' => 'Background — Base',      'type' => 'framework' ),
				array( 'value' => 'background-light',       'label' => 'Background — Light',     'type' => 'framework' ),
				array( 'value' => 'background-extra-light', 'label' => 'Background — Extra Light','type' => 'framework' ),
				array( 'value' => 'background-dark',        'label' => 'Background — Dark',      'type' => 'framework' ),
				array( 'value' => 'background-extra-dark',  'label' => 'Background — Extra Dark','type' => 'framework' ),
				array( 'value' => 'background-accent',      'label' => 'Background — Accent',    'type' => 'framework' ),
				array( 'value' => 'font-size-sm',          'label' => 'Font size — Small',      'type' => 'framework' ),
				array( 'value' => 'font-size-regular',     'label' => 'Font size — Regular',    'type' => 'framework' ),
				array( 'value' => 'font-size-md',          'label' => 'Font size — Medium',     'type' => 'framework' ),
				array( 'value' => 'font-size-lg',          'label' => 'Font size — Large',      'type' => 'framework' ),
				array( 'value' => 'visually-hidden',       'label' => 'Visually hidden',        'type' => 'framework' ),
			),
		),
	);
}
