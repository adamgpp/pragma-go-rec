<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\FeeCalculator;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use PragmaGoTech\Interview\FeeCalculator\Provider\FeeStructureProviderInterface;
use PragmaGoTech\Interview\FeeCalculator\Model\LoanProposal;
use PragmaGoTech\Interview\FeeCalculator\Model\LoanTerm;
use PragmaGoTech\Interview\FeeCalculator\InterpolatedFeeCalculator;
use PragmaGoTech\Interview\FeeCalculator\ValueObject\Amount;

final class InterpolatedFeeCalculatorTest extends TestCase
{
    private readonly InterpolatedFeeCalculator $calculator;

    private readonly FeeStructureProviderInterface&MockObject $feeStructureProvider;

    #[\Override]
    protected function setUp(): void
    {
        $this->feeStructureProvider = $this->createMock(FeeStructureProviderInterface::class);

        $this->calculator = new InterpolatedFeeCalculator($this->feeStructureProvider);
    }

    public static function provideLoanProposals(): \Generator
    {
        yield 'without interpolation - single structure' => [
            12,
            2_000,
            [
                2_000 => 20,
            ],
            20.0
        ];
        yield 'without interpolation - multiple structure - first amount found' => [
            12,
            2_000,
            [
                2_000 => 20,
                4_000 => 30,
            ],
            20.0
        ];
        yield 'without interpolation - multiple structure - second amount found' => [
            12,
            4_000,
            [
                2_000 => 20,
                4_000 => 30,
                7_000 => 35,
            ],
            30.0
        ];
        yield 'without interpolation - multiple structure - last amount found' => [
            12,
            7_000,
            [
                2_000 => 20,
                4_000 => 30,
                7_000 => 35,
            ],
            35.0
        ];
        yield 'with interpolation' => [
            12,
            3_000,
            [
                2_000 => 20,
                4_000 => 30,
            ],
            25.0
        ];
    }

    #[DataProvider('provideLoanProposals')]
    public function testShouldReturnProperlyCalculatedFee(int $term, float $amount, array $structure, float $expectedFee): void
    {
        $this->feeStructureProvider
            ->expects(self::once())
            ->method("getStructure")
            ->with(LoanTerm::from($term))
            ->willReturn($structure);

        $calculatedFee = $this->calculator->calculate(new LoanProposal(LoanTerm::from($term), new Amount($amount)));

        self::assertSame($expectedFee, $calculatedFee->value);
    }

    public function testShouldFailWhenLoanAmountIsLowerThanLowestLoanAmountInStructure(): void
    {
        $loanTerm = LoanTerm::MOTHNS_24;

        $this->feeStructureProvider
            ->expects(self::once())
            ->method("getStructure")
            ->with($loanTerm)
            ->willReturn([2_000 => 20]);

        $this->expectException(\OutOfBoundsException::class);

        $this->calculator->calculate(new LoanProposal($loanTerm, new Amount(1_000)));
    }

    public function testShouldFailWhenLoanAmountIsGreaterThanLowestLoanAmountInStructure(): void
    {
        $loanTerm = LoanTerm::MOTHNS_24;

        $this->feeStructureProvider
            ->expects(self::once())
            ->method("getStructure")
            ->with($loanTerm)
            ->willReturn([2_000 => 20]);

        $this->expectException(\OutOfBoundsException::class);

        $this->calculator->calculate(new LoanProposal($loanTerm, new Amount(3_000)));
    }

    public function testShouldFailWhenThereIsNoStructureForCalculating(): void
    {
        $loanTerm = LoanTerm::MOTHNS_24;

        $this->feeStructureProvider
            ->expects(self::once())
            ->method("getStructure")
            ->with($loanTerm)
            ->willReturn([]);

        $this->expectException(\OutOfBoundsException::class);

        $this->calculator->calculate(new LoanProposal($loanTerm, new Amount(3_000)));
    }
}
