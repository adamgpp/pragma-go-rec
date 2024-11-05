<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\FeeCalculator\Service;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\FeeCalculator\Service\UpToNearestFiveFeeRoundingService;
use PragmaGoTech\Interview\FeeCalculator\ValueObject\Amount;

final class UpToNearestFiveFeeRoundingServiceTest extends TestCase
{
    private readonly UpToNearestFiveFeeRoundingService $service;

    #[\Override]
    protected function setUp(): void
    {
        $this->service = new UpToNearestFiveFeeRoundingService();
    }

    public static function provideRawFees(): \Generator
    {
        yield 'without roundng' => [1234, 1, 1];
        yield 'with rounding' => [1235, 1, 5];
        yield 'with rounding and one decimal point' => [1235.1, 1.1, 4.9];
        yield 'with rounding and two decimal points' => [1235.99, 1.01, 4.01];
    }

    #[DataProvider('provideRawFees')]
    public function testRoundFeeShouldReturnProperlyRoundedFee(float $loanAmount, float $rawFee, float $expectedFee): void
    {
        $roundedFee = $this->service->roundFee(new Amount($loanAmount), new Amount($rawFee));

        self::assertEquals($expectedFee, $roundedFee->value);
    }
}
