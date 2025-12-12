The child theme registers GreenShift "framework groups" in `gs-framework/framework-groups.php`, which reference the CSS in `gs-framework/framework-groups.css`. If you add new selectors to `gs-framework/framework-groups.css`, you need to register them in `framework-groups.php` to surface them in GreenShift's Class System UI (registration is not required for classes to work in HTML).

Data attributes used as CUBE-style exceptions and modifiers are registered as data presets in `gs-framework/data-presets.php`.

The child theme includes a `theme.json` file following modern WordPress theming best practices. It publishes canonical tokens (colors, font sizes) as WordPress `--wp--preset--*` variables. Role-based, semantic variables that reference the canonical wp presets are then registered in GreenShift via `gs-framework/semantic-tokens.php`, following W3C Design Tokens guidance. The child theme also adds color swatches for the semantic tokens to the color picker UI in GreenShift's block settings.

We also remove GreenShift's Preset Class Groups and Preset Colors. GreenShift's presets are overly prescriptive and can clutter the editor UI, making it harder for clients to find the curated presets that are added to the child theme.

The child theme is developer-oriented but provides a baseline design-system architecture that reduces the learning curve and makes the system accessible to beginner developers.

The descriptive color variables in `theme.json` should be updated per project; those variables are referenced by the semantic variables in `gs-framework/semantic-tokens.php`. We encourage developers to follow W3C Design Token naming conventions. Developers may add data-attribute exceptions in `gs-framework/data-presets.php` and styling to `gs-framework/framework-groups.css` — remember to register any new selectors in `gs-framework/framework-groups.php` if you want them to appear in GreenShift's Class System UI.

Documentation will be added in the future that describes the classes and data attributes that we provide.
