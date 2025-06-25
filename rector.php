<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;

return RectorConfig::configure()
    ->withSkip([ClosureToArrowFunctionRector::class])
    ->withPaths([__DIR__ . '/index.php'])
    // uncomment to reach your current PHP version
    ->withPhpSets()
    ->withAttributesSets()
    ->withTypeCoverageLevel(0)
    ->withDeadCodeLevel(0)
    ->withCodeQualityLevel(0);
