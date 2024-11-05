<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\FeeCalculator\Factory;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\FeeCalculator\Factory\RoundedFeeCalculatorFactory;
use PragmaGoTech\Interview\FeeCalculator\RoundedFeeCalculator;

final class RoundedFeeCalculatorFactoryTest extends TestCase
{
    public function testCreateShouldCreateProperCalculatorInstance(): void
    {
        $calculator = RoundedFeeCalculatorFactory::create();

        self::assertInstanceOf(RoundedFeeCalculator::class, $calculator);
    }
}
