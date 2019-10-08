<?php declare(strict_types=1);

namespace MyParcelNL\Sdk\Tests\Concerns;

use MyParcelNL\Sdk\src\Support\Collection;

trait HasDebugLabels
{
    /**
     * @param $myParcelCollection
     * @param $message
     *
     * @return void
     */
    public function debugLinkOfLabels(Collection $myParcelCollection, string $message): void
    {
        if (!getenv('CI')) {
            echo "\033[32mGenerated " . $message . ": \033[0m";
            print_r($myParcelCollection->getLinkOfLabels());
            echo "\n\033[0m";
        }

        return;
    }
}
