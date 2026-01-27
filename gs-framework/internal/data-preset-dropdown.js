/**
 * GreenShift Data Preset Dropdown Enhancement
 *
 * Converts text inputs for data presets into dropdown menus
 * when the value contains comma-separated options (e.g., "wide,narrow").
 *
 * @package Blocksy_GreenShift_Child
 */

(function () {
	'use strict';

	/**
	 * Check if a value contains multiple comma-separated options.
	 *
	 * @param {string} value - The input value to check.
	 * @returns {boolean}
	 */
	function hasMultipleOptions(value) {
		if (!value || typeof value !== 'string') return false;
		const parts = value.split(',').map((s) => s.trim()).filter(Boolean);
		return parts.length > 1;
	}

	/**
	 * Parse comma-separated value into array of options.
	 *
	 * @param {string} value - The comma-separated value.
	 * @returns {string[]}
	 */
	function parseOptions(value) {
		return value.split(',').map((s) => s.trim()).filter(Boolean);
	}

	/**
	 * Create a select dropdown element.
	 *
	 * @param {string[]} options - Array of option values.
	 * @param {string} currentValue - Currently selected value.
	 * @param {HTMLInputElement} originalInput - The original text input.
	 * @returns {HTMLSelectElement}
	 */
	function createDropdown(options, currentValue, originalInput) {
		const select = document.createElement('select');
		select.className = 'components-select-control__input gs-data-preset-dropdown';
		select.style.cssText = 'width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #949494;';

		// Add placeholder option.
		const placeholder = document.createElement('option');
		placeholder.value = '';
		placeholder.textContent = '— Select a value —';
		placeholder.disabled = true;
		select.appendChild(placeholder);

		// Add each option.
		options.forEach((opt) => {
			const option = document.createElement('option');
			option.value = opt;
			option.textContent = opt;
			if (opt === currentValue || currentValue === options.join(',')) {
				// If current value matches an option or is still the full list, don't pre-select.
			}
			select.appendChild(option);
		});

		// If currentValue is one of the options, select it.
		if (options.includes(currentValue)) {
			select.value = currentValue;
		}

		// Handle selection change.
		select.addEventListener('change', function () {
			const selectedValue = this.value;

			// Update the original input value (triggers React's onChange via native event).
			const nativeInputValueSetter = Object.getOwnPropertyDescriptor(
				window.HTMLInputElement.prototype,
				'value'
			).set;
			nativeInputValueSetter.call(originalInput, selectedValue);

			// Dispatch input event to notify React.
			const inputEvent = new Event('input', { bubbles: true });
			originalInput.dispatchEvent(inputEvent);

			// Also dispatch change event.
			const changeEvent = new Event('change', { bubbles: true });
			originalInput.dispatchEvent(changeEvent);
		});

		return select;
	}

	/**
	 * Process a single data preset detail section.
	 *
	 * @param {HTMLElement} detailSection - The .gspb_class_selector_details element.
	 */
	function processDetailSection(detailSection) {
		// Skip if already processed.
		if (detailSection.dataset.gsDropdownProcessed === 'true') return;

		const input = detailSection.querySelector('input.components-text-control__input');
		if (!input) return;

		const value = input.value;
		if (!hasMultipleOptions(value)) return;

		// Mark as processed.
		detailSection.dataset.gsDropdownProcessed = 'true';

		const options = parseOptions(value);

		// Hide the original input.
		input.style.display = 'none';

		// Create and insert dropdown.
		const dropdown = createDropdown(options, '', input);
		input.parentElement.appendChild(dropdown);

		// Store reference for cleanup.
		input.dataset.gsDropdownId = 'gs-dropdown-' + Date.now();
		dropdown.dataset.gsDropdownId = input.dataset.gsDropdownId;
	}

	/**
	 * Process all visible data preset sections.
	 */
	function processAllSections() {
		const detailSections = document.querySelectorAll('.gspb_class_selector_details');
		detailSections.forEach(processDetailSection);
	}

	/**
	 * Clean up dropdowns for sections that no longer exist or have changed.
	 */
	function cleanupStaleDropdowns() {
		const dropdowns = document.querySelectorAll('.gs-data-preset-dropdown');
		dropdowns.forEach((dropdown) => {
			const parent = dropdown.closest('.gspb_class_selector_details');
			if (!parent || !document.body.contains(parent)) {
				dropdown.remove();
			}
		});
	}

	/**
	 * Reset processing state when a section is removed/changed.
	 */
	function resetProcessedState() {
		const detailSections = document.querySelectorAll('.gspb_class_selector_details');
		detailSections.forEach((section) => {
			const input = section.querySelector('input.components-text-control__input');
			const dropdown = section.querySelector('.gs-data-preset-dropdown');

			if (input && dropdown) {
				const currentInputValue = input.value;
				// If input is visible again or value changed, reset.
				if (input.style.display !== 'none') {
					dropdown.remove();
					delete section.dataset.gsDropdownProcessed;
				}
			}
		});
	}

	/**
	 * Initialize the enhancement.
	 */
	function init() {
		// Initial processing.
		processAllSections();

		// Watch for DOM changes (GreenShift dynamically updates the panel).
		const observer = new MutationObserver((mutations) => {
			let shouldProcess = false;

			mutations.forEach((mutation) => {
				if (mutation.type === 'childList' || mutation.type === 'subtree') {
					// Check if any added nodes are relevant.
					mutation.addedNodes.forEach((node) => {
						if (node.nodeType === Node.ELEMENT_NODE) {
							if (
								node.classList?.contains('gspb_class_selector_details') ||
								node.querySelector?.('.gspb_class_selector_details')
							) {
								shouldProcess = true;
							}
						}
					});
				}
			});

			if (shouldProcess) {
				// Debounce processing.
				clearTimeout(window.gsDropdownProcessTimeout);
				window.gsDropdownProcessTimeout = setTimeout(() => {
					cleanupStaleDropdowns();
					processAllSections();
				}, 100);
			}
		});

		// Observe the editor sidebar.
		const sidebar = document.querySelector('.interface-interface-skeleton__sidebar');
		if (sidebar) {
			observer.observe(sidebar, {
				childList: true,
				subtree: true,
			});
		}

		// Also observe the entire body as fallback.
		observer.observe(document.body, {
			childList: true,
			subtree: true,
		});

		// Reprocess on block selection change.
		if (wp?.data?.subscribe) {
			let lastSelectedId = null;
			wp.data.subscribe(() => {
				const selectedBlock = wp.data.select('core/block-editor')?.getSelectedBlock();
				const currentId = selectedBlock?.clientId;

				if (currentId !== lastSelectedId) {
					lastSelectedId = currentId;
					// Wait for DOM to update.
					setTimeout(() => {
						// Reset all processed states to allow re-evaluation.
						document.querySelectorAll('.gspb_class_selector_details').forEach((section) => {
							delete section.dataset.gsDropdownProcessed;
							const dropdown = section.querySelector('.gs-data-preset-dropdown');
							if (dropdown) dropdown.remove();
							const input = section.querySelector('input.components-text-control__input');
							if (input) input.style.display = '';
						});
						processAllSections();
					}, 200);
				}
			});
		}
	}

	// Wait for DOM ready.
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', () => setTimeout(init, 500));
	} else {
		setTimeout(init, 500);
	}
})();
