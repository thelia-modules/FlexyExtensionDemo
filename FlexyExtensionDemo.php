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

namespace FlexyExtensionDemo;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Thelia\Module\BaseModule;

/**
 * Shows the ways a module brings a component to the Flexy front: a Twig component any
 * template can call, a theme hook that places it on the home page, a story that lists it
 * in the toolkit, and a stylesheet and a Stimulus controller of the module's own.
 */
final class FlexyExtensionDemo extends BaseModule
{
    public const string DOMAIN_NAME = 'flexyextensiondemo';

    public static function configureServices(ServicesConfigurator $servicesConfigurator): void
    {
        $servicesConfigurator->load(self::getModuleCode().'\\', __DIR__)
            ->exclude([__DIR__.'/Config/**/*.php', __DIR__.'/FlexyExtensionDemo.php'])
            ->autowire(true)
            ->autoconfigure(true);
    }

    /**
     * The module's assets under the `demo/` logical prefix, and its controllers in the
     * application's Stimulus registry. Both keys are lists, so this adds to what the theme
     * declares rather than replacing it.
     */
    public static function loadConfiguration(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->prependExtensionConfig('framework', [
            'asset_mapper' => [
                'paths' => [
                    __DIR__.'/assets' => 'flexy-extension-demo',
                ],
            ],
        ]);

        if (!$containerBuilder->hasExtension('stimulus')) {
            return;
        }

        $containerBuilder->prependExtensionConfig('stimulus', [
            'controller_paths' => [
                __DIR__.'/assets/controllers',
            ],
        ]);
    }
}
