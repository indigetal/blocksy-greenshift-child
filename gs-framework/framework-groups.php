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
				array( 'value' => 'equal-columns',           'label' => 'Equal Columns',          'type' => 'framework' ),
				array( 'value' => 'flow',					 'label' => 'Content Flow',           'type' => 'framework' ),
				array( 'value' => 'grid-flow',				 'label' => 'Grid Flow',			  'type' => 'framework' ),
				array( 'value' => 'grid-auto-fill',				 'label' => 'Section - Grid Auto Fill',			  'type' => 'framework' ),
				array( 'value' => 'flex-group',				 'label' => 'Flex Group',			  'type' => 'framework' ),
			),
		),
		array(
			'label'   => esc_html__( 'Components', 'blocksy-greenshift-child' ),
			'options' => array(
				array( 'value' => 'button',                 'label' => 'Button',                 'type' => 'framework' ),
				array( 'value' => 'hero',                 'label' => 'Hero',                 'type' => 'framework' ),
				array( 'value' => 'hero__title',                 'label' => 'Hero Title',                 'type' => 'framework' ),
				array( 'value' => 'card',                 'label' => 'Card',                 'type' => 'framework' ),
				array( 'value' => 'card__title',                 'label' => 'Card Title',                 'type' => 'framework' ),
				array( 'value' => 'tag-list',                 'label' => 'Card - Tag List',                 'type' => 'framework' ),
				array( 'value' => 'card__note',                 'label' => 'Card Note',                 'type' => 'framework' ),
				array( 'value' => 'faq-bento-grid',                 'label' => 'FAQ Bento Grid',                 'type' => 'framework' ),
			),
		),
		array(
			'label'   => esc_html__( 'Utilities', 'blocksy-greenshift-child' ),
			'options' => array(
				array( 'value' => 'text-center',            'label' => 'Text — Center',          'type' => 'framework' ),
				array( 'value' => 'text-brand',             'label' => 'Text — Brand',           'type' => 'framework' ),
				array( 'value' => 'text-high-contrast',     'label' => 'Text — High Contrast',   'type' => 'framework' ),
				array( 'value' => 'section-title',          'label' => 'Section Title',          'type' => 'framework' ),
				array( 'value' => 'background-main',        'label' => 'Background — Main',      'type' => 'framework' ),
				array( 'value' => 'background-light',       'label' => 'Background — Light',     'type' => 'framework' ),
				array( 'value' => 'background-extra-light', 'label' => 'Background — Extra Light','type' => 'framework' ),
				array( 'value' => 'background-dark',        'label' => 'Background — Dark',      'type' => 'framework' ),
				array( 'value' => 'background-extra-dark',  'label' => 'Background — Extra Dark','type' => 'framework' ),
				array( 'value' => 'background-accent',      'label' => 'Background — Accent',    'type' => 'framework' ),
				array( 'value' => 'font-size-heading-sm',   'label' => 'Font size — Heading Small', 'type' => 'framework' ),
				array( 'value' => 'font-size-heading-regular', 'label' => 'Font size — Heading Regular', 'type' => 'framework' ),
				array( 'value' => 'font-size-heading-lg',   'label' => 'Font size — Heading Large', 'type' => 'framework' ),
				array( 'value' => 'font-size-heading-xl',   'label' => 'Font size — Heading XL', 'type' => 'framework' ),
				array( 'value' => 'font-size-sm',          'label' => 'Font size — Small',      'type' => 'framework' ),
				array( 'value' => 'font-size-regular',     'label' => 'Font size — Regular',    'type' => 'framework' ),
				array( 'value' => 'font-size-md',          'label' => 'Font size — Medium',     'type' => 'framework' ),
				array( 'value' => 'font-size-lg',          'label' => 'Font size — Large',      'type' => 'framework' ),
				array( 'value' => 'visually-hidden',       'label' => 'Visually hidden',        'type' => 'framework' ),
			),
		),
	);
}
