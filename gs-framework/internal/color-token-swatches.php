<?php
// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add Color Token swatches to GreenShift's color picker
if ( function_exists( 'greenshift_render_variables' ) ) {

	/**
	 * Resolve a CSS variable reference to its actual color value from theme.json
	 */
	function resolve_wp_preset_color( $variable_value ) {
		// Extract slug from var(--wp--preset--color--slug-name)
		if ( preg_match( '/var\(--wp--preset--color--([^)]+)\)/', $variable_value, $matches ) ) {
			$slug = $matches[1];

			// Get colors from theme.json via WordPress
			$settings = wp_get_global_settings();

			// Check all possible locations where colors might be stored (theme, custom, default)
			$palette_locations = array(
				isset( $settings['color']['palette']['theme'] ) ? $settings['color']['palette']['theme'] : array(),
				isset( $settings['color']['palette']['custom'] ) ? $settings['color']['palette']['custom'] : array(),
				isset( $settings['color']['palette']['default'] ) ? $settings['color']['palette']['default'] : array(),
			);

			foreach ( $palette_locations as $palette ) {
				foreach ( $palette as $color ) {
					if ( isset( $color['slug'] ) && $color['slug'] === $slug ) {
						return $color['color'];
					}
				}
			}
		}
		return '#000000'; // Fallback
	}

	function add_color_token_swatches() {
		// Get the registered variables and filter for color group only
		$all_variables = apply_filters( 'greenshift_global_variables', array() );
		$color_tokens = array_filter( $all_variables, function( $var ) {
			return isset( $var['group'] ) && $var['group'] === 'color';
		} );

		if ( empty( $color_tokens ) ) {
			return;
		}

		// Resolve actual color values for each token
		$tokens_with_colors = array();
		foreach ( $color_tokens as $token ) {
			$token['resolved_color'] = resolve_wp_preset_color( $token['variable_value'] );
			$tokens_with_colors[] = $token;
		}

		// Convert to JSON for JavaScript
		$tokens_json = wp_json_encode( array_values( $tokens_with_colors ) );
		?>
		<script>
			(function() {
				var colorTokens = <?php echo $tokens_json; ?>;

				function injectColorTokenSwatches() {
					var pickers = document.querySelectorAll('.gspb-custom-color-picker');
					pickers.forEach(function(picker) {
						// Skip if already injected
						if (picker.querySelector('[data-color-tokens-injected]')) {
							return;
						}

						// Find the first heading (Theme Palette) to insert after its color palette
						var themePaletteHeading = picker.querySelector('.gspb-custom-color-picker-globals');
						if (!themePaletteHeading) return;

						// Find the color palette after Theme Palette heading
						var themePalette = themePaletteHeading.nextElementSibling;
						if (!themePalette) return;

						// Create Color Tokens heading
						var heading = document.createElement('div');
						heading.className = 'gspb-custom-color-picker-globals';
						heading.textContent = 'Color Tokens';
						heading.setAttribute('data-color-tokens-injected', 'true');

						// Create swatches container matching GreenShift's structure
						var swatchesContainer = document.createElement('div');
						swatchesContainer.className = 'components-circular-option-picker';
						swatchesContainer.setAttribute('data-color-tokens-injected', 'true');

						var swatchesWrapper = document.createElement('div');
						swatchesWrapper.className = 'components-circular-option-picker__swatches';

						colorTokens.forEach(function(token) {
							var optionWrapper = document.createElement('div');
							optionWrapper.className = 'components-circular-option-picker__option-wrapper';

							var button = document.createElement('button');
							button.type = 'button';
							button.className = 'components-button components-circular-option-picker__option';
							button.setAttribute('aria-label', token.label);
							button.setAttribute('title', token.label);

							// Use the resolved color from PHP (supports hsl, rgb, hex from theme.json)
							// Use setProperty with 'important' to override any default button styles
							button.style.setProperty('background-color', token.resolved_color, 'important');
							button.style.width = '28px';
							button.style.height = '28px';
							button.style.borderRadius = '50%';
							button.style.border = '1px solid rgba(0,0,0,0.1)';
							button.style.cursor = 'pointer';
							button.style.padding = '0';

							// Click handler to set the color value
							button.addEventListener('click', function() {
								// Find the color input and trigger change
								var colorInput = picker.querySelector('input[type="text"]');
								if (colorInput) {
									// Set the value
									var nativeInputValueSetter = Object.getOwnPropertyDescriptor(window.HTMLInputElement.prototype, 'value').set;
									nativeInputValueSetter.call(colorInput, token.value);
									// Trigger input event for React
									colorInput.dispatchEvent(new Event('input', { bubbles: true }));
									colorInput.dispatchEvent(new Event('change', { bubbles: true }));
								}
							});

							optionWrapper.appendChild(button);
							swatchesWrapper.appendChild(optionWrapper);
						});

						swatchesContainer.appendChild(swatchesWrapper);

						// Insert after theme palette
						themePalette.parentNode.insertBefore(heading, themePalette.nextSibling);
						heading.parentNode.insertBefore(swatchesContainer, heading.nextSibling);
					});
				}

				// Run on load
				if (document.readyState === 'loading') {
					document.addEventListener('DOMContentLoaded', injectColorTokenSwatches);
				} else {
					injectColorTokenSwatches();
				}

				// Watch for dynamically added color pickers
				var observer = new MutationObserver(function(mutations) {
					mutations.forEach(function(mutation) {
						if (mutation.addedNodes.length) {
							injectColorTokenSwatches();
						}
					});
				});
				observer.observe(document.body, { childList: true, subtree: true });
			})();
		</script>
		<style>
			/* Style for Color Tokens swatches */
			.gspb-custom-color-picker [data-color-tokens-injected].components-circular-option-picker {
				margin: 8px 0;
			}
			.gspb-custom-color-picker [data-color-tokens-injected] .components-circular-option-picker__swatches {
				display: flex;
				flex-wrap: wrap;
				gap: 8px;
			}
			.gspb-custom-color-picker [data-color-tokens-injected] .components-circular-option-picker__option:hover {
				transform: scale(1.1);
				box-shadow: 0 0 0 2px #007cba;
			}
			.gspb-custom-color-picker [data-color-tokens-injected] .components-circular-option-picker__option:focus {
				outline: none;
				box-shadow: 0 0 0 2px #007cba;
			}
		</style>
		<?php
	}
	add_action( 'admin_head', 'add_color_token_swatches' );
	add_action( 'admin_footer', 'add_color_token_swatches' );
}
