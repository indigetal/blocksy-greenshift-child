The child theme registers GreenShift "framework groups" in `gs-framework/framework-groups.php`, which reference the CSS in `gs-framework/framework-groups.css`. If you add new selectors to `gs-framework/framework-groups.css`, register them in `gs-framework/framework-groups.php` to surface them in GreenShift's Styles/Class System UI (registration is not required for classes to work in HTML).

Data attributes used as CUBE-style exceptions and modifiers are registered as data presets in `gs-framework/data-presets.php`.

The child theme removes GreenShift's Preset Class Groups and Preset Colors because those presets are often overly prescriptive and can clutter the editor UI, making it harder for clients to find the curated presets we provide.

The theme uses `theme.json` to publish canonical presets (colors, font sizes) as WordPress `--wp--preset--*` variables. It then registers readable, semantic variables in GreenShift via `gs-framework/semantic-tokens.php` that reference those canonical vars, following W3C Design Tokens guidance. The theme also adds color swatches for the semantic tokens to the color picker in GreenShift's block settings.

The child theme is developer-oriented but provides a baseline design-system architecture that reduces the learning curve and makes the system accessible to beginner developers.

The descriptive color variables in `theme.json` should be updated per project; those variables are referenced by the semantic tokens in `gs-framework/semantic-tokens.php`. Developers should follow W3C Design Token naming conventions. Developers may add data-attribute exceptions in `gs-framework/data-presets.php` and add styling to `gs-framework/framework-groups.css` — remember to register any new selectors in `gs-framework/framework-groups.php` so they appear in GreenShift.

Documentation will be added in the future that describes the classes and data attributes that we provide.
