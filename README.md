The child theme registers GreenShift "framework groups" in `gs-framework/framework-groups.php`, which reference the CSS in `gs-framework/framework-groups.css`. If you add new selectors to `gs-framework/framework-groups.css`, you need to register them in `framework-groups.php` to surface them in GreenShift's Class System UI (registration is not required for classes to work in HTML).

Data attributes used as CUBE-style exceptions and modifiers are registered as data presets in `gs-framework/data-presets.php`.

The child theme includes a `theme.json` file following modern WordPress theming best practices. It publishes canonical tokens (colors, font sizes) as WordPress `--wp--preset--*` variables. Role-based, semantic variables that reference the canonical wp presets are then registered in GreenShift via `gs-framework/semantic-tokens.php`, following W3C Design Tokens guidance. The child theme also adds color swatches for the semantic tokens to the color picker UI in GreenShift's block settings.

A "Page Section" block variation is registered in `gs-framework/block-variations.php`. It’s a variation of GreenLight’s "Section tag" block that adds a class and includes a nested "Div element" block with a .wrapper class — a simple convenience to reduce setup for high‑level, generic section structure used throughout the sample project.

We also remove GreenShift's Preset Class Groups and Preset Colors. GreenShift's presets are overly prescriptive and can clutter the editor UI, making it harder for clients to find the curated presets that are added to the child theme.
NOTE: The `require` statement in `functions.php` that includes the script `gs-framework/internal/remove-presets.php` is commented out by default — uncomment it to enable removal of GreenShift's presets.

The child theme is developer-oriented but provides a baseline design-system architecture that reduces the learning curve and makes the system accessible to beginner developers.

The descriptive color variables in `theme.json` should be updated per project; those variables are referenced by the semantic variables in `gs-framework/semantic-tokens.php`. We encourage developers to follow W3C Design Token naming conventions. Developers may add data-attribute exceptions in `gs-framework/data-presets.php` and styling to `gs-framework/framework-groups.css` — remember to register any new selectors in `gs-framework/framework-groups.php` if you want them to appear in GreenShift's Class System UI.

This child theme is preconfigured for the two-page project from Kevin Powell’s "Professional CSS" course on Frontend Masters (https://frontendmasters.com/courses/pro-css/). The two pages can be imported from `pro-css-project-pages.xml` in the root of the child theme, and includes the main content HTML as GreenLight blocks. To learn how to use and adapt the project CSS, or to access the project's header, footer, and JavaScript code, we recommend taking the course. For WordPress, Blocksy, and GreenShift guidance, see https://indigetal.com.
