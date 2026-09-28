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

namespace FlexyExtensionDemo\Twig;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * A titled notice with an optional button, closable by the visitor:
 * `<twig:FlexyExtensionDemo:Callout id="..." title="..." text="..." />`.
 *
 * The `id` is what the controller remembers a dismissed callout by, for the session; two
 * callouts with the same id close together. The name is given in full because a module has
 * no name prefix of its own; the theme's components get theirs from their namespace.
 */
#[AsTwigComponent(name: 'FlexyExtensionDemo:Callout', template: '@FlexyExtensionDemoModule/components/Callout.html.twig')]
final class Callout
{
    public string $id;

    public string $title;

    public string $text;

    public ?string $href = null;

    public ?string $label = null;

    public bool $dismissible = true;
}
