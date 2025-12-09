<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Register W3C-aligned semantic tokens with Greenshift
if ( ! function_exists( 'base_semantic_tokens' ) ) {
    add_filter( 'greenshift_global_variables', 'base_semantic_tokens' );

    function base_semantic_tokens( $variables ) {
    if ( empty( $variables ) ) {
        $variables = array();
    }

    // Colors
    $variables[] = array(
        'label' => 'Text — Main',
        'value' => 'var(--text-main)',
        'variable' => '--text-main',
        'variable_value' => 'var(--wp--preset--color--gray-100)',
        'group' => 'color'
    );
    $variables[] = array(
        'label' => 'Text — High Contrast',
        'value' => 'var(--text-high-contrast)',
        'variable' => '--text-high-contrast',
        'variable_value' => 'var(--wp--preset--color--white)',
        'group' => 'color'
    );
    $variables[] = array(
        'label' => 'Text — Brand',
        'value' => 'var(--text-brand)',
        'variable' => '--text-brand',
        'variable_value' => 'var(--wp--preset--color--brand-500)',
        'group' => 'color'
    );
    $variables[] = array(
        'label' => 'Text — Brand Light',
        'value' => 'var(--text-brand-light)',
        'variable' => '--text-brand-light',
        'variable_value' => 'var(--wp--preset--color--brand-400)',
        'group' => 'color'
    );

    // Background accent
    $variables[] = array(
        'label' => 'Background — Accent Light',
        'value' => 'var(--background-accent-light)',
        'variable' => '--background-accent-light',
        'variable_value' => 'var(--wp--preset--color--green-400)',
        'group' => 'color'
    );
    $variables[] = array(
        'label' => 'Background — Accent Main',
        'value' => 'var(--background-accent-main)',
        'variable' => '--background-accent-main',
        'variable_value' => 'var(--wp--preset--color--green-500)',
        'group' => 'color'
    );
    $variables[] = array(
        'label' => 'Background — Accent Dark',
        'value' => 'var(--background-accent-dark)',
        'variable' => '--background-accent-dark',
        'variable_value' => 'var(--wp--preset--color--green-600)',
        'group' => 'color'
    );

    // Background neutrals
    $variables[] = array(
        'label' => 'Background — Extra Light',
        'value' => 'var(--background-extra-light)',
        'variable' => '--background-extra-light',
        'variable_value' => 'var(--wp--preset--color--brown-500)',
        'group' => 'color'
    );
    $variables[] = array(
        'label' => 'Background — Light',
        'value' => 'var(--background-light)',
        'variable' => '--background-light',
        'variable_value' => 'var(--wp--preset--color--brown-600)',
        'group' => 'color'
    );
    $variables[] = array(
        'label' => 'Background — Main',
        'value' => 'var(--background-main)',
        'variable' => '--background-main',
        'variable_value' => 'var(--wp--preset--color--brown-700)',
        'group' => 'color'
    );
    $variables[] = array(
        'label' => 'Background — Dark',
        'value' => 'var(--background-dark)',
        'variable' => '--background-dark',
        'variable_value' => 'var(--wp--preset--color--brown-800)',
        'group' => 'color'
    );
    $variables[] = array(
        'label' => 'Background — Extra Dark',
        'value' => 'var(--background-extra-dark)',
        'variable' => '--background-extra-dark',
        'variable_value' => 'var(--wp--preset--color--brown-900)',
        'group' => 'color'
    );

    // Font-size semantic aliases
    $variables[] = array(
        'label' => 'Font size — Heading small',
        'value' => 'var(--font-size-heading-sm)',
        'variable' => '--font-size-heading-sm',
        'variable_value' => 'var(--wp--preset--font-size--fs-700)',
        'group' => 'size'
    );
    $variables[] = array(
        'label' => 'Font size — Heading regular',
        'value' => 'var(--font-size-heading-regular)',
        'variable' => '--font-size-heading-regular',
        'variable_value' => 'var(--wp--preset--font-size--fs-800)',
        'group' => 'size'
    );
    $variables[] = array(
        'label' => 'Font size — Heading large',
        'value' => 'var(--font-size-heading-lg)',
        'variable' => '--font-size-heading-lg',
        'variable_value' => 'var(--wp--preset--font-size--fs-900)',
        'group' => 'size'
    );
    $variables[] = array(
        'label' => 'Font size — Heading XL',
        'value' => 'var(--font-size-heading-xl)',
        'variable' => '--font-size-heading-xl',
        'variable_value' => 'var(--wp--preset--font-size--fs-1000)',
        'group' => 'size'
    );

    // Body font sizes
    $variables[] = array(
        'label' => 'Font size — Small',
        'value' => 'var(--font-size-sm)',
        'variable' => '--font-size-sm',
        'variable_value' => 'var(--wp--preset--font-size--fs-300)',
        'group' => 'size'
    );
    $variables[] = array(
        'label' => 'Font size — Regular',
        'value' => 'var(--font-size-regular)',
        'variable' => '--font-size-regular',
        'variable_value' => 'var(--wp--preset--font-size--fs-400)',
        'group' => 'size'
    );
    $variables[] = array(
        'label' => 'Font size — Medium',
        'value' => 'var(--font-size-md)',
        'variable' => '--font-size-md',
        'variable_value' => 'var(--wp--preset--font-size--fs-500)',
        'group' => 'size'
    );
    $variables[] = array(
        'label' => 'Font size — Large',
        'value' => 'var(--font-size-lg)',
        'variable' => '--font-size-lg',
        'variable_value' => 'var(--wp--preset--font-size--fs-600)',
        'group' => 'size'
    );

    // Border radius
    $variables[] = array(
        'label' => 'Radius — Small',
        'value' => 'var(--border-radius-1)',
        'variable' => '--border-radius-1',
        'variable_value' => 'var(--border-radius-1)',
        'group' => 'radius'
    );
    $variables[] = array(
        'label' => 'Radius — Medium',
        'value' => 'var(--border-radius-2)',
        'variable' => '--border-radius-2',
        'variable_value' => 'var(--border-radius-2)',
        'group' => 'radius'
    );
    $variables[] = array(
        'label' => 'Radius — Large',
        'value' => 'var(--border-radius-3)',
        'variable' => '--border-radius-3',
        'variable_value' => 'var(--border-radius-3)',
        'group' => 'radius'
    );

    return $variables;
}
}