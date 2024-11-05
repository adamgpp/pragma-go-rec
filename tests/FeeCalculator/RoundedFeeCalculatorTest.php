<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\FeeCalculator;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\FeeCalculator\RoundedFeeCalculator;
use PragmaGoTech\Interview\FeeCalculator\Model\LoanProposal;
use PragmaGoTech\Interview\FeeCalculator\Model\LoanTerm;
use PragmaGoTech\Interview\FeeCalculator\Provider\PhpFileFeeStructureProvider;
use PragmaGoTech\Interview\FeeCalculator\Service\UpToNearestFiveFeeRoundingService;
use PragmaGoTech\Interview\FeeCalculator\InterpolatedFeeCalculator;
use PragmaGoTech\Interview\FeeCalculator\ValueObject\Amount;

final class RoundedFeeCalculatorTest extends TestCase
{
    private readonly RoundedFeeCalculator $calculator;

    private readonly InterpolatedFeeCalculator $interpolatedFeeCalculator;
    private readonly UpToNearestFiveFeeRoundingService $roundingService;

    #[\Override]
    protected function setUp(): void
    {
        $this->interpolatedFeeCalculator = new InterpolatedFeeCalculator(new PhpFileFeeStructureProvider());
        $this->roundingService = new UpToNearestFiveFeeRoundingService();

        $this->calculator = new RoundedFeeCalculator($this->interpolatedFeeCalculator, $this->roundingService);
    }

    public static function provideLoanProposals(): array
    {
        return [
            [24, 11_500, 460.0],
            [12, 19_250, 385.0],
        ];
    }

    #[DataProvider('provideLoanProposals')]
    public function testShouldReturnProperlyCalculatedFee(int $term, float $amount, float $expectedFee): void
    {
        $calculatedFee = $this->calculator->calculate(new LoanProposal(LoanTerm::from($term), new Amount($amount)));

        self::assertSame($expectedFee, $calculatedFee->value);
    }
}
