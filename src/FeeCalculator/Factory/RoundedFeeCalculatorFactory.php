<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\FeeCalculator\Factory;

use PragmaGoTech\Interview\FeeCalculator\InterpolatedFeeCalculator;
use PragmaGoTech\Interview\FeeCalculator\Provider\PhpFileFeeStructureProvider;
use PragmaGoTech\Interview\FeeCalculator\RoundedFeeCalculator;
use PragmaGoTech\Interview\FeeCalculator\Service\UpToNearestFiveFeeRoundingService;

final class RoundedFeeCalculatorFactory
{
    public static function create(): RoundedFeeCalculator
    {
        return new RoundedFeeCalculator(
            new InterpolatedFeeCalculator(new PhpFileFeeStructureProvider()),
            new UpToNearestFiveFeeRoundingService()
        );
    }
}
