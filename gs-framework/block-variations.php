<?php
/**
 * Block Variations Registration
 * 
 * Register block variations for generic, high-level patterns used throughout the project.
 * This file is editable on a project-by-project basis.
 */

if ( ! defined( 'WP_DEBUG' ) ) {
	die( 'Direct access forbidden.' );
}

/**
 * Register "Page Section" variation for greenshift-blocks/element.
 * 
 * Creates a section.section container with a nested div.wrapper for consistent
 * page structure following CUBE CSS methodology.
 */
add_filter( 'get_block_type_variations', 'gs_framework_block_variations', 10, 2 );

function gs_framework_block_variations( $variations, $block_type ) {
	
	// Only target the GreenShift element block
	if ( 'greenshift-blocks/element' !== $block_type->name ) {
		return $variations;
	}

	$variations[] = array(
		'name'        => 'gs-page-section',
		'title'       => __( 'Page Section', 'blocksy-greenshift-child' ),
		'description' => __( 'Section element with an inner .wrapper div for page-level content layout', 'blocksy-greenshift-child' ),
		'icon'        => 'excerpt-view',
		'attributes'  => array(
			'tag'         => 'section',
			'type'        => 'inner',
			'className'   => 'section',
			'isVariation' => 'section',
		),
		'innerBlocks' => array(
			array(
				'greenshift-blocks/element',
				array(
					'tag'       => 'div',
					'type'      => 'inner',
					'className' => 'wrapper',
				),
				array(), // innerBlocks for wrapper (empty, editors add content)
			),
		),
		'scope'       => array( 'inserter' ),
		'isDefault'   => false,
		'isActive'    => array( 'tag', 'className' ),
	);

	return $variations;
}
