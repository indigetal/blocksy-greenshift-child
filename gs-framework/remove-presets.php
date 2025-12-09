<?php
// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only run when Greenshift is available.
if ( function_exists( 'greenshift_render_variables' ) ) {

	// Empty all built-in preset category filters to remove their options
	add_filter( 'greenshift_style_preset_classes', '__return_empty_array', 100 );
	add_filter( 'greenshift_hover_preset_classes', '__return_empty_array', 100 );
	add_filter( 'greenshift_spacing_preset_classes', '__return_empty_array', 100 );
	add_filter( 'greenshift_shadow_preset_classes', '__return_empty_array', 100 );
	add_filter( 'greenshift_border_preset_classes', '__return_empty_array', 100 );
	add_filter( 'greenshift_background_preset_classes', '__return_empty_array', 100 );
	add_filter( 'greenshift_data_preset_classes', '__return_empty_array', 100 );
	add_filter( 'greenshift_interaction_preset_classes', '__return_empty_array', 100 );
	add_filter( 'greenshift_opacity_preset_classes', '__return_empty_array', 100 );

	// Enqueue script to remove empty preset groups and Global Color Presets in the editor
	// (GreenShift doesn't provide PHP filters for preset_classes, colours, or gradients)
	// IMPORTANT: Must use 'before' position so it runs after wp_localize_script defines
	// greenShift_params but before gspbLibrary.js reads and caches the values.
	function remove_greenshift_presets_js() {
		$script = "
		(function() {
			if (typeof greenShift_params !== 'undefined') {
				// Remove empty preset class groups
				if (greenShift_params.preset_classes) {
					greenShift_params.preset_classes = greenShift_params.preset_classes.filter(function(group) {
						return group.options && Array.isArray(group.options) && group.options.length > 0;
					});
				}
				// Remove Global Color Presets (colour swatches in block color picker)
				greenShift_params.colours = '';
				// Remove Global Gradient Presets
				greenShift_params.gradients = '';
			}
		})();
		";
		wp_add_inline_script( 'greenShift-library-script', $script, 'before' );
	}
	add_action( 'enqueue_block_editor_assets', 'remove_greenshift_presets_js', 999 );

	// Dequeue GreenShift's global color/gradient CSS from frontend (not needed since we use theme.json)
	function dequeue_greenshift_color_styles() {
		wp_dequeue_style( 'greenshift-global-colors' );
		wp_dequeue_style( 'greenshift-global-night-colors' );
		wp_dequeue_style( 'greenshift-global-gradients' );
	}
	add_action( 'wp_enqueue_scripts', 'dequeue_greenshift_color_styles', 999 );
	add_action( 'enqueue_block_editor_assets', 'dequeue_greenshift_color_styles', 999 );

	// Hide GreenShift's hardcoded "Preset Colors" and "Custom Colors" sections in color picker
	function hide_greenshift_preset_colors_js() {
		?>
		<style>
			/* Hidden attribute for JS to apply */
			[data-gs-hide-preset] {
				display: none !important;
			}
		</style>
		<script>
			(function() {
				// Function to hide Preset Colors and Custom Colors sections
				function hideGreenShiftColorPresets() {
					var pickers = document.querySelectorAll('.gspb-custom-color-picker');
					pickers.forEach(function(picker) {
						var headings = picker.querySelectorAll('.gspb-custom-color-picker-globals');
						headings.forEach(function(heading) {
							var text = heading.textContent.trim();
							// Hide "Preset Colors" and "Custom Colors" sections
							if (text === 'Preset Colors' || text === 'Custom Colors') {
								heading.setAttribute('data-gs-hide-preset', 'true');
								// Hide the next sibling (the color palette) - check multiple siblings
								var sibling = heading.nextElementSibling;
								while (sibling) {
									// Stop if we hit another heading
									if (sibling.classList && sibling.classList.contains('gspb-custom-color-picker-globals')) {
										break;
									}
									// Hide this sibling
									sibling.setAttribute('data-gs-hide-preset', 'true');
									sibling = sibling.nextElementSibling;
								}
							}
						});
					});
				}

				// Run on load and watch for new color pickers
				if (document.readyState === 'loading') {
					document.addEventListener('DOMContentLoaded', hideGreenShiftColorPresets);
				} else {
					hideGreenShiftColorPresets();
				}

				// Watch for dynamically added color pickers
				var observer = new MutationObserver(function(mutations) {
					mutations.forEach(function(mutation) {
						if (mutation.addedNodes.length) {
							hideGreenShiftColorPresets();
						}
					});
				});
				observer.observe(document.body, { childList: true, subtree: true });
			})();
		</script>
		<?php
	}
	add_action( 'admin_head', 'hide_greenshift_preset_colors_js' );
	add_action( 'admin_footer', 'hide_greenshift_preset_colors_js' );

	// Hide the "Colors" tab in GreenShift Stylebook
	function hide_stylebook_colors_tab() {
		$screen = get_current_screen();
		if ( $screen && 'gspbstylebook' === $screen->post_type ) {
			?>
			<style>
				/* Hide Colors tab button and its content panel in Stylebook */
				.stylebook-tab-buttons .stylebook-tab-button[data-gs-hide-colors],
				.stylebook-colors-panel[data-gs-hide-colors] {
					display: none !important;
				}
			</style>
			<script>
				document.addEventListener('DOMContentLoaded', function() {
					// Wait for Stylebook to render
					var observer = new MutationObserver(function(mutations, obs) {
						var tabButtons = document.querySelectorAll('.stylebook-tab-buttons .stylebook-tab-button');
						tabButtons.forEach(function(btn) {
							if (btn.textContent.trim() === 'Colors') {
								btn.setAttribute('data-gs-hide-colors', 'true');
								btn.style.display = 'none';
							}
						});
					});
					observer.observe(document.body, { childList: true, subtree: true });
				});
			</script>
			<?php
		}
	}
	add_action( 'admin_head', 'hide_stylebook_colors_tab' );
}


