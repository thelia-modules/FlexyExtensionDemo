# Flexy extension demo

Shows the ways a module brings a component to the Flexy front office.

| What | Where | How to see it |
|---|---|---|
| A Twig component, called by hand | `Twig/Callout.php`, `templates/components/Callout.html.twig` | `<twig:FlexyExtensionDemo:Callout id="..." title="..." text="..." href="..." label="..." />` in any template |
| The same component placed by a theme hook | `Hook/Theme/CalloutThemeHook.php`, `templates/theme-hook/callout.html.twig` | top of the home page (`theme_hook('home.top')`) |
| Its story in the toolkit | `Toolkit/CalloutStoryProvider.php`, `templates/toolkit/Callout.html.twig` | `/toolkit/modules-flexy-extension-demo-callout`, in debug only |
| A stylesheet and a Stimulus controller of the module's own | `FlexyExtensionDemo::loadConfiguration()`, `assets/controllers/flexy-extension-demo/callout_controller.js`, `assets/styles/callout.css` | the close button of the callout; `debug:config stimulus` and `debug:asset-map` list the module's paths |

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

`FlexyExtensionDemo::loadConfiguration()` registers `assets/` as an AssetMapper path under the `flexy-extension-demo/` prefix and `assets/controllers/` in `stimulus.controller_paths`. Both keys are lists, so the module adds to what the theme declares. The controller file `assets/controllers/flexy-extension-demo/callout_controller.js` is registered as `flexy-extension-demo--callout`: the `demo/` directory keeps the name clear of the theme's controllers.

The stylesheet is imported by the controller (`import "../../styles/callout.css"`), the way the theme's own `ProductGallery` controller imports the Splide stylesheet. AssetMapper puts it in the importmap and loads it with the controller. The controller is lazy, so the stylesheet reaches the page after the first paint of the callout; a stylesheet that has to be there before any paint would go through a `layout.head.bottom` theme hook instead.

The module's CSS is not compiled by Tailwind: the theme's `app.css` scans the theme's files alone. It is plain CSS on the theme's variables (`--color-lighter`, `--text-sm`...), which the compiled stylesheet puts on `:root`. The wrapper still uses the theme's container classes, which the theme compiles.
