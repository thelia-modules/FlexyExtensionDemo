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
 * Two theme hooks on the home page: the callout's stylesheet in its head, where the theme
 * calls `theme_hook('layout.head.' ~ view)` with `index` as the view, and the callout itself
 * at its top, where it calls `theme_hook('home.top')`. Other pages get neither.
 */
final readonly class CalloutThemeHook implements ThemeHookInterface
{
    private const array TEMPLATES = [
        'layout.head.index' => '@FlexyExtensionDemoModule/theme-hook/head.html.twig',
        'home.top' => '@FlexyExtensionDemoModule/theme-hook/callout.html.twig',
    ];

    public function __construct(
        private Environment $twig,
    ) {
    }

    public function supports(string $hookName): bool
    {
        return isset(self::TEMPLATES[$hookName]);
    }

    public function render(string $hookName, array $parameters): string
    {
        return $this->twig->render(self::TEMPLATES[$hookName]);
    }
}
