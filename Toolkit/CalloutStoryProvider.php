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

namespace FlexyExtensionDemo\Toolkit;

use FlexyBundle\Toolkit\ComponentStatus;
use FlexyBundle\Toolkit\Story;
use FlexyBundle\Toolkit\StoryProviderInterface;

/**
 * Lists the callout in the toolkit, under a `Modules` group of its own.
 */
final readonly class CalloutStoryProvider implements StoryProviderInterface
{
    public function stories(): array
    {
        return [
            new Story(
                category: 'Modules',
                name: 'Flexy extension demo / Callout',
                twigPath: '@FlexyExtensionDemoModule/toolkit/Callout.html.twig',
                sourcePath: __DIR__.'/../templates/toolkit/Callout.html.twig',
                status: ComponentStatus::READY,
            ),
        ];
    }
}
