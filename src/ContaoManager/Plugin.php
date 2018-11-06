<?php

namespace Sioweb\CCEventsExample\ContaoManager;

use Sioweb\ApplyEnvironment\SiowebCCEventsExampleBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;

/**
 * Plugin for the Contao Manager.
 *
 * @author Sascha Weidner <https://www.sioweb.de>
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(SiowebCCEventsExampleBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
