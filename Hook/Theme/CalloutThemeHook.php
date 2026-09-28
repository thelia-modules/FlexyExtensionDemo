<?php

declare(strict_types=1);

/*
 * This file is part of the Thelia package.
 * http://www.thelia.net
 *
 * (c) OpenStudio <info@thelia.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FlexyExtensionDemo\Hook\Theme;

use Thelia\Core\Hook\Theme\ThemeHookInterface;
use Twig\Environment;

/**
 * Places the callout at the top of the home page, where the theme calls `theme_hook('home.top')`.
 */
final readonly class CalloutThemeHook implements ThemeHookInterface
{
    public function __construct(
        private Environment $twig,
    ) {
    }

    public function supports(string $hookName): bool
    {
        return 'home.top' === $hookName;
    }

    public function render(string $hookName, array $parameters): string
    {
        return $this->twig->render('@FlexyExtensionDemoModule/theme-hook/callout.html.twig');
    }
}
