<?php

namespace Sioweb\CCEventsTest\Composer;

use Composer\Package\Dumper\ArrayDumper;
use Sioweb\CCEvent\Composer\Installer\PackageEvent as Event;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

class TestComposerScript
{

    public static function getInitDefinition()
    {
        $InputDefinition = new InputDefinition;
        $InputDefinition->setDefinition([
            new InputOption('repository', 'r', InputOption::VALUE_REQUIRED, 'url to git repo'),
            new InputOption('xyz', 'x', InputOption::VALUE_OPTIONAL, 'url to git repo'),
        ]);

        return $InputDefinition;
    }

    public static function init(Event $event): void
    {
        $operation = $event->getOperation();

        $package = method_exists($operation, 'getPackage')
        ? $operation->getPackage()
        : $operation->getInitialPackage();

        $Input = new StringInput(implode(' ', $event->getArguments()));
        $Input->bind(self::getInitDefinition());

        echo "\n\t\tArguments: " . print_r($Input->getOptions(), 1);
        echo "\n\t\tGIT Init: " . $event->getName() . "\n";

        $Dumper = new ArrayDumper;
        $EventDispatcher = $event->getComposer()->getEventDispatcher();

        echo "\t\t- root: " . $event->getComposer()->getPackage() . "\n";
        echo "\t\t- getTargetDir: " . $package->getTargetDir() . "\n";
        echo "\t\t- getSourceType: " . $package->getSourceType() . "\n";
        echo "\t\t- getSourceUrl: " . $package->getSourceUrl() . "\n";
        echo "\t\t- getVersion: " . $package->getVersion() . "\n";
        echo "\t\t- getVendorPath: " . $event->getComposer()->getConfig()->get('vendor-dir') . "\n";
        echo "\t\t- getUrls: " . print_r($package->getSourceUrls(), 1) . "\n";
        echo "\t\t- ArrayDump: " . print_r($Dumper->dump($package), 1) . "\n";
    }
}
