# Flexy extension demo

Shows the ways a module brings a component to the Flexy front office.

| What | Where | How to see it |
|---|---|---|
| A Twig component, called by hand | `Twig/Callout.php`, `templates/components/Callout.html.twig` | `<twig:FlexyExtensionDemo:Callout id="..." title="..." text="..." href="..." label="..." />` in any template |
| The same component placed by a theme hook | `Hook/Theme/CalloutThemeHook.php`, `templates/theme-hook/callout.html.twig` | top of the home page (`theme_hook('home.top')`) |
| A stylesheet loaded with the page | `Hook/Theme/CalloutThemeHook.php`, `templates/theme-hook/head.html.twig`, `assets/styles/callout.css` | `<link>` in the head of every shop page (`theme_hook('layout.head.bottom')`), there before the first paint |
| Its story in the toolkit | `Toolkit/CalloutStoryProvider.php`, `templates/toolkit/Callout.html.twig` | `/toolkit/modules-flexy-extension-demo-callout`, in debug only |
| A Stimulus controller of the module's own, with the stylesheet it needs | `FlexyExtensionDemo::loadConfiguration()`, `assets/controllers/flexy-extension-demo/callout_controller.js`, `assets/styles/callout-dismiss.css` | the close button of the callout; `debug:config stimulus` and `debug:asset-map` list the module's paths |

## Requirements

- Thelia 3.1 with the Flexy theme carrying `FlexyBundle\Toolkit\StoryProviderInterface` (branch `feat/toolkit-module-stories`, not in 1.1.0). Without it the module fails to load.

## Install

```bash
php bin/console module:refresh
php bin/console module:activate FlexyExtensionDemo
php bin/console cache:clear
```

## Assets

After adding or moving an asset path or a controller path, remove `var/cache/<env>/asset_mapper/` (or run `composer cache-clear`, which empties `var/cache/`): `bin/console cache:clear` leaves the compiled `controllers.js` there, and the page keeps serving the old registry without the module's controller.

`FlexyExtensionDemo::loadConfiguration()` registers `assets/` as an AssetMapper path under the `flexy-extension-demo/` prefix and `assets/controllers/` in `stimulus.controller_paths`. Both keys are lists, so the module adds to what the theme declares. The controller file `assets/controllers/flexy-extension-demo/callout_controller.js` is registered as `flexy-extension-demo--callout`: the `flexy-extension-demo/` directory keeps the name clear of the theme's controllers.

The module ships two stylesheets, one per way of reaching the page:

- `assets/styles/callout.css`, the callout's look, is linked from the page head: the theme hook answers `layout.head.bottom` with `<link rel="stylesheet" href="{{ asset('flexy-extension-demo/styles/callout.css') }}">`, and `asset()` resolves the logical path to the versioned URL. It is there before the first paint, with or without JavaScript. The toolkit renders no theme hook, so the story links it itself.
- `assets/styles/callout-dismiss.css`, the close button and the closing transition, is imported by the controller (`import "../../styles/callout-dismiss.css"`), the way the theme's `ProductGallery` controller imports the Splide stylesheet. AssetMapper puts it in the importmap and loads it with the controller, which is lazy: it reaches the page once a callout with the controller is on it.

Neither is compiled by Tailwind: the theme's `app.css` scans the theme's files alone. They are plain CSS on the theme's variables (`--color-lighter`, `--text-sm`...), which the compiled stylesheet puts on `:root`. The wrapper still uses the theme's container classes, which the theme compiles.
